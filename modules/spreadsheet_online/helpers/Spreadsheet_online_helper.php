<?php
defined('BASEPATH') or exit('No direct script access allowed');
hooks()->add_action('after_email_templates', 'add_spreadsheet_share_email_templates');

/**
 * Get all staff by department
 * @param  string $departmentid Optional
 * @return array
 */
function get_all_staff_by_department($departmentid)
{
    $CI = & get_instance();
    if ($departmentid) {
        $CI->db->where('departmentid', $departmentid);
        $staffids = $CI->db->select('staffid')->from(db_prefix() . 'staff_departments')->get()->result_array();
    }else{
    	$staffids = [];
    }

    return $staffids;
}

/**
 * Get all client by group
 * @param  string $groupid Optional
 * @return array
 */
function get_all_client_by_group($groupid)
{
    $CI = & get_instance();
    if ($groupid) {
        $CI->db->where('groupid', $groupid);
        $clientids = $CI->db->get(db_prefix() . 'customer_groups')->result_array();
    }else{
    	$clientids = [];
    }
    return $clientids;
}


if (!function_exists('add_spreadsheet_share_email_templates')) {
    /**
     * Init appointly email templates and assign languages
     * @return void
     */
    function add_spreadsheet_share_email_templates() {
        $CI = &get_instance();

        $data['spreadsheet_share'] = $CI->emails_model->get(['type' => 'spreadsheet_online', 'language' => 'english']);

        $CI->load->view('spreadsheet_online/email_templates', $data);
    }
}


/**
 * { email staff }
 *
 * @param        $staffid  The staffid
 *
 * @return      ( description_of_the_return_value )
 */
function spreadsheet_email_staff($staffid){
    $CI = & get_instance();
    $CI->db->where('staffid', $staffid);
    return $CI->db->get(db_prefix().'staff')->row()->email;
}

/**
 * replace spreadsheet value
 * @param  $string 
 * @return string     
 */
function replace_spreadsheet_value($string){

    $findme   = 'images';
    $pos = strpos($string, $findme);
    $data_string = "";
    if($pos){
      $data_string = str_replace('""', '"', $string); 
  }else{
      $data_string = $string; 
  }

  $data_string = str_replace('"color":",', '"color":"",', $data_string); 
  $data_string = str_replace('"value2":",', '"value2":"",', $data_string); 
  $data_string = str_replace('":",', '":"",', $data_string); 
  $data_string = str_replace('":"},', '":""},', $data_string); 
  $data_string = str_replace('":"}},', '":""}},', $data_string); 
  $data_string = str_replace('"\'', '"\\\'', $data_string);   
  $data_string = str_replace(':"\"', ':"', $data_string);
  $data_string = str_replace('\","fc', '","fc', $data_string);  
  $data_string = str_replace('"fa":"$\"#,', '"fa":"$#,', $data_string);  
  $data_string = str_replace(':"}}},{"', ':""}}},{"', $data_string);  

  $data_string = str_replace('\","', '","', $data_string);  
  $data_string = str_replace(')\","', ')","', $data_string);  
  $data_string = str_replace('":"}}}]', '":""}}}]', $data_string);
  $data_string = str_replace('":"}}]', '":""}}]', $data_string);

  return $data_string;
}
/**
 * file force contents
* @param string $filename <p>file name including folder.
* example :: /path/to/file/filename.ext or filename.ext</p>
* @param string $data <p> The data to write.
* </p>
* @param int $flags same flags used for file_put_contents.
* @return bool <b>TRUE</b> file created succesfully <br> <b>FALSE</b> failed to create file.
*/
function file_force_contents($filename, $data, $flags = 0){
    if(!is_dir(dirname($filename)))
        mkdir(dirname($filename).'/', 0777, TRUE);
    return file_put_contents($filename, $data,$flags);
}

function process_file($id){
    $CI = & get_instance();
    $CI->load->model('spreadsheet_online/spreadsheet_online_model');
    $file_excel = $CI->spreadsheet_online_model->get_file_sheet($id);
    $path = SPREAD_ONLINE_MODULE_UPLOAD_FOLDER . '/spreadsheet_online/' . $id . '-'.$file_excel->name.'.txt';
    $realpath_data = '/spreadsheet_online/' . $id . '-'.$file_excel->name.'.txt';
    $data = [];
    if(!file_exists(SPREAD_ONLINE_MODULE_UPLOAD_FOLDER.$file_excel->realpath_data) && $file_excel->data_form != NULL && $file_excel->data_form != ''){
        file_force_contents($path, $file_excel->data_form);
        $CI->db->where('id', $id);
        $CI->db->update(db_prefix() . 'spreadsheet_online_my_folder', ['realpath_data' => $realpath_data]);
        $mystring = file_get_contents($path, true);
        return ['data_form' => replace_spreadsheet_value($mystring), 'name' => $file_excel->name];        
    }
    elseif(file_exists(SPREAD_ONLINE_MODULE_UPLOAD_FOLDER.$file_excel->realpath_data)){
        $mystring = file_get_contents(SPREAD_ONLINE_MODULE_UPLOAD_FOLDER.$file_excel->realpath_data, true);
        
        return ['data_form' => replace_spreadsheet_value($mystring), 'name' => $file_excel->name];        
    }else{
        echo json_encode(['message' => _l('physical_file_have_been_deleted')]);
        exit;
    }

    return [];
}