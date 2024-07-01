<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Check whether column exists in a table
 * Custom function because Codeigniter is caching the tables and this is causing issues in migrations
 * @param  string $column column name to check
 * @param  string $table table name to check
 * @return boolean
 */


/**
 * get taxes
 * @param  integer $id
 * @return array or row
 */
function get_taxes($id =''){
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id',$id);

        return $CI->db->get(db_prefix().'taxes')->row();
    }
    $CI->db->order_by('taxrate', 'ASC');
    return $CI->db->get(db_prefix().'taxes')->result_array();

}

/**
 * get unit type
 * @param  integer $id
 * @return array or row
 */
function get_unit_type($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('unit_type_id', $id);

        return $CI->db->get(db_prefix() . 'ware_unit_type')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblware_unit_type')->result_array();
    }

}

/**
 * get tax rate
 * @param  integer $id
 * @return array or row
 */
function get_tax_rate($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'taxes')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tbltaxes')->result_array();
    }

}


/**
 * get group name
 * @param  integer $id
 * @return array or row
 */
function get_wh_group_name($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'items_groups')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblitems_groups')->result_array();
    }

}


/**
 * get size name
 * @param  integer $id
 * @return array or row
 */
function get_size_name($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('size_type_id', $id);

        return $CI->db->get(db_prefix() . 'ware_size_type')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblware_size_type')->result_array();
    }

}


/**
 * get style name
 * @param  integer $id
 * @return array or row
 */
function get_style_name($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('style_type_id', $id);
        return $CI->db->get(db_prefix() . 'ware_style_type')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblware_style_type')->result_array();
    }

}

/**
 * get model name
 * @param  integer $id
 * @return array or row
 */
function get_model_name($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('body_type_id', $id);

        return $CI->db->get(db_prefix() . 'ware_body_type')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblware_body_type')->result_array();
    }

}

/**
 * get puchase order aproved on module purchase
 * get purchae order
 * @param  integer $id
 * @return array or row
 */
function get_pr_order($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);
        return $CI->db->get(db_prefix() . 'pur_orders')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblpur_orders where approve_status = 2 AND status_goods = 0')->result_array();
    }

}


/**
 * reformat currency
 * @param  string  $value
 * @return float
 */
function reformat_currency_j($value)
{

    $f_dot = str_replace(',','', $value);
    return ((float)$f_dot + 0);
}


/**
 * get purchase order request name
 * @param  integer $id
 * @return array or row
 */
function get_pur_request_name($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'pur_request')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblpur_request')->result_array();
    }

}


/**
 * get warehouse name
 * @param  integer $id
 * @return array or row
 */
function get_warehouse_name($id = false)
{
    $CI           = & get_instance();

    if ($id != false) {
        $CI->db->where('warehouse_id', $id);

        return $CI->db->get(db_prefix() . 'warehouse')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblwarehouse')->result_array();
    }

}


/**
 * get commodity name
 * @param  integer $id
 * @return array or row
 */
function get_commodity_name($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'items')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblitems')->result_array();
    }

}


/**
 * get status inventory
 * @param  integer $commodity, integer $inventory
 * @return boolean
 */
function get_status_inventory($commodity, $inventory)
{
    $CI           = & get_instance();
    $CI->db->where('commodity_id', $commodity);

    $result = $CI->db->get(db_prefix() . 'inventory_commodity_min')->row();

    if($result != null){
        return $inventory >= (float)get_object_vars($result)['inventory_number_min'] ? true : false;
    }else{
        return true;
    }

}

/**
 * get goods receipt code
 * @param  integer $id
 * @return array or row
 */
function get_goods_receipt_code($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'goods_receipt')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblgoods_receipt')->result_array();
    }

}


/**
 * warehouse process digital signature image
 * @param  string $partBase64
 * @param  string $path
 * @param  string $image_name
 * @return boolean
 */
function warehouse_process_digital_signature_image($partBase64, $path, $image_name)
{
    if (empty($partBase64)) {
        return false;
    }

    _maybe_create_upload_path($path);
    $filename = unique_filename($path, $image_name.'.png');

    $decoded_image = base64_decode($partBase64);

    $retval = false;

    $path = rtrim($path, '/') . '/' . $filename;

    $fp = fopen($path, 'w+');

    if (fwrite($fp, $decoded_image)) {
        $retval                                 = true;
        $GLOBALS['processed_digital_signature'] = $filename;
    }

    fclose($fp);

    return $retval;
}


/**
 * numberTowords 
 * @param  string $num 
 * @return string
 */
function numberTowords($num)
{ 
    $ones = array( 
        0 => '',
        1 => "One", 
        2 => "Two", 
        3 => "Three", 
        4 => "Four", 
        5 => "Five", 
        6 => "Six", 
        7 => "Seven", 
        8 => "Eight", 
        9 => "Nine", 
        10 => "Ten", 
        11 => "Eleven", 
        12 => "Twelve", 
        13 => "Thirteen", 
        14 => "Fourteen", 
        15 => "Fifteen", 
        16 => "Sixteen", 
        17 => "Seventeen", 
        18 => "Eighteen", 
        19 => "Nineteen" 
    ); 
    $tens = array( 
        0 => '',
        1 => "Ten",
        2 => "Twenty", 
        3 => "Thirty", 
        4 => "Fourty", 
        5 => "Fifty", 
        6 => "Sixty", 
        7 => "Seventy", 
        8 => "Eighty", 
        9 => "Ninety" 
    ); 
    $hundreds = array( 
        "Hundred", 
        "Thousand", 
        "Million", 
        "Billion", 
        "Thousands of billions", 
        "Million billion" 
    ); //limit t quadrillion 
    $num = number_format($num,2,".",","); 
    $num_arr = explode(".",$num); 
    $wholenum = $num_arr[0]; 
    
    $decnum = $num_arr[1]; 
    $whole_arr = array_reverse(explode(",",$wholenum)); 
    krsort($whole_arr); 
    $rettxt = ""; 
    foreach($whole_arr as $key => $i){ 

        if($i == '0' || $i == '000' || $i == '00'){
            $rettxt .= $ones[0];
        }elseif($i < 20){ 

            $rettxt .= $ones[$i]; 
        }elseif($i < 100){ 
            $rettxt .= $tens[substr($i,0,1)]; 
            $rettxt .= " ".$ones[substr($i,1,1)]; 
        }else{ 
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            $rettxt .= " ".$tens[substr($i,1,1)]; 
            $rettxt .= " ".$ones[substr($i,2,1)]; 
        }

        if($key > 0){ 
            $rettxt .= " ".$hundreds[$key]." "; 
        } 

    } 
    if($decnum > 0){ 
        $rettxt .= " and "; 
        if($decnum < 20){ 
            $rettxt .= $ones[$decnum]; 
        }elseif($decnum < 100){ 
            $rettxt .= $tens[substr($decnum,0,1)]; 
            $rettxt .= " ".$ones[substr($decnum,1,1)]; 
        } 
    } 

    return $rettxt; 
} 


/**
 * get status modules wh
 * @param  string $module_name 
 * @return boolean             
 */
function get_status_modules_wh($module_name){
    $CI             = &get_instance();

    $sql = 'select * from '.db_prefix().'modules where module_name = "'.$module_name.'" AND active =1 ';
    $module = $CI->db->query($sql)->row();
    if($module){
        return true;
    }else{
        return false;
    }
}


/**
 * get goods delivery code
 * @param  integer $id
 * @return array or row
 */
function get_goods_delivery_code($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'goods_delivery')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblgoods_delivery')->result_array();
    }

}

/**
 * handle commmodity list add edit file
 * @param  integer $id
 * @return boolean
 */
function handle_commodity_list_add_edit_file($id){

    if (isset($_FILES['cd_avar']['name']) && $_FILES['cd_avar']['name'] != '') {

        hooks()->do_action('before_upload_contract_attachment', $id);
        $path = WAREHOUSE_ITEM_UPLOAD. $id . '/';
        // Get the temp file path
        $tmpFilePath = $_FILES['cd_avar']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            _maybe_create_upload_path($path);
            $filename    = unique_filename($path, $_FILES['cd_avar']['name']);
            $newFilePath = $path . $filename;
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI           = & get_instance();
                $attachment   = [];
                $attachment[] = [
                    'file_name' => $filename,
                    'filetype'  => $_FILES['cd_avar']['type'],
                ];
                $CI->misc_model->add_attachment_to_database($id, 'commodity_item_file', $attachment);

                return true;
            }
        }
    }

    return false;
}


/**
 * handle commodity attchment
 * @param  integer $id
 * @return array or row
 */
function handle_commodity_attachments($id)
{

    if (isset($_FILES['file']) && _perfex_upload_error($_FILES['file']['error'])) {
        header('HTTP/1.0 400 Bad error');
        echo _perfex_upload_error($_FILES['file']['error']);
        die;
    }
    $path = WAREHOUSE_ITEM_UPLOAD . $id . '/';
    $CI   = & get_instance();

    if (isset($_FILES['file']['name'])) {

        // 
        // Get the temp file path
        $tmpFilePath = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {

            _maybe_create_upload_path($path);
            $filename    = $_FILES['file']['name'];
            $newFilePath = $path . $filename;
            // Upload the file into the temp dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {

                $attachment   = [];
                $attachment[] = [
                    'file_name' => $filename,
                    'filetype'  => $_FILES['file']['type'],
                ];

                $CI->misc_model->add_attachment_to_database($id, 'commodity_item_file', $attachment);
            }
        }
    }

}



/**
 * get color type
 * @param  integer $id, string $index_name
 * @return array, object
 */
function get_color_type($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('color_id', $id);

        return $CI->db->get(db_prefix() . 'ware_color')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblware_color')->result_array();
    }

}

/**
 * get warehouse by commodity
 * @param  integer $commodity_id 
 * @return array               
 */
function get_warehouse_by_commodity($commodity_id )
{
    $CI           = & get_instance();

    if (is_numeric($commodity_id)) {
        $sql ='SELECT distinct warehouse_id FROM '.db_prefix().'inventory_manage where inventory_number > 0 AND commodity_id = "'.$commodity_id.'"';

        return $CI->db->query($sql)->result_array();
    }

}


/**
 * row options exist
 * @param  string $name 
 *        
 */
function warehouse_row_options_exist($name){
    $CI = & get_instance();
    $i = count($CI->db->query('Select * from '.db_prefix().'options where name = '.$name)->result_array());
    if($i == 0){
        return 0;
    }
    if($i > 0){
        return 1;
    }
}

/**
 * Gets the warehouse option.
 *
 * @param      <type>        $name   The name
 *
 * @return     array|string  The warehouse option.
 */
function get_warehouse_option($name)
{
    $CI = & get_instance();
    $options = [];
    $val  = '';
    $name = trim($name);
    

    if (!isset($options[$name])) {
        // is not auto loaded
        $CI->db->select('value');
        $CI->db->where('name', $name);
        $row = $CI->db->get(db_prefix() . 'options')->row();
        if ($row) {
            $val = $row->value;
        }
    } else {
        $val = $options[$name];
    }

    return $val;
}

/**
 * get pur order name
 * @param  integer $id 
 * @return string     
 */
function get_pur_order_name($id)
{   
    $name='';
    $CI = & get_instance();
    $CI->db->where('id',$id);
    $pur_orders = $CI->db->get(db_prefix().'pur_orders')->row();

    if($pur_orders){
       $name .= $pur_orders->pur_order_number.' - '.$pur_orders->pur_order_name;
    }

   return $name;

}

/**
 * get staff
 * @param  integer $id
 * @return array or row
 */
function wh_get_staff($id =''){

    $CI = &get_instance();
    $CI->load->model('warehouse/warehouse_model');
    return  $CI->warehouse_model->get_staff($invoice_id);


}

hooks()->add_action('after_email_templates', 'add_inventory_warning_email_templates');

if (!function_exists('add_inventory_warning_email_templates')) {
    /**
     * Init inventory email templates and assign languages
     * @return void
     */
    function add_inventory_warning_email_templates()
    {
        $CI = &get_instance();

        $data['inventory_warning_templates'] = $CI->emails_model->get(['type' => 'inventory_warning', 'language' => 'english']);

        $CI->load->view('warehouse/inventory_warning_email_template', $data);
    }
}

/**
 * get internal delivery code
 * @param  boolean $id 
 * @return [type]      
 */
function get_internal_delivery_code($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'internal_delivery_note')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblinternal_delivery_note')->result_array();
    }

}

/**
 * wh get pr order delivered on module purchase
 * get purchae order
 * @param  integer $id
 * @return array or row
 */
function wh_get_pr_order_delivered($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);
        return $CI->db->get(db_prefix() . 'pur_orders')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblpur_orders where approve_status = 2 AND delivery_status = 1')->result_array();
    }

}


/**
 * wh check approval setting
 * @param  integer $type 
 * @return [type]       
 */
function wh_check_approval_setting($type)
{   
    $CI = &get_instance();
    $CI->load->model('warehouse/warehouse_model');

    $check_appr = $CI->warehouse_model->get_approve_setting($type);

    return $check_appr;
}


/**
 * wh handle propsal file
 * @param  integer $id 
 * @return boolean     
 */
function wh_handle_propsal_file($id)
{
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
        hooks()->do_action('before_upload_contract_attachment', $id);
        $path = WAREHOUSE_PROPOSAL_UPLOAD_FOLDER. $id . '/';
        // Get the temp file path
        $tmpFilePath = $_FILES['file']['tmp_name'];
        // Make sure we have a filepath
        if (!empty($tmpFilePath) && $tmpFilePath != '') {
            _maybe_create_upload_path($path);
            $filename    = unique_filename($path, $_FILES['file']['name']);
            $newFilePath = $path . $filename;
            // Upload the file into the company uploads dir
            if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                $CI           = & get_instance();
                $attachment   = [];
                $attachment[] = [
                    'file_name' => $filename,
                    'filetype'  => $_FILES['file']['type'],
                ];
                $CI->misc_model->add_attachment_to_database($id, 'wh_proposal', $attachment);

                return true;
            }
        }
    }

    return false;
}

/**
 * get brand
 * @param  integer $id
 * @return array or row
 */
function get_brand_name($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'wh_brand')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblwh_brand')->result_array();
    }

}

/**
 * get model
 * @param  integer $id
 * @return array or row
 */
function get_models_name($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'wh_model')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblwh_model')->result_array();
    }

}

/**
 * get series
 * @param  integer $id
 * @return array or row
 */
function get_series_name($id = false)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'wh_series')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblwh_series')->result_array();
    }

}


/**
 * wh_render_custom_fields
 * @param  [type]  $belongs_to      
 * @param  boolean $rel_id          
 * @param  array   $where           
 * @param  array   $items_cf_params 
 * @return [type]                   
 */
function wh_render_custom_fields($belongs_to, $rel_id = false, $where = [], $items_cf_params = [])
{


    // Is custom fields for items and in add/edit
    $items_add_edit_preview = isset($items_cf_params['add_edit_preview']) && $items_cf_params['add_edit_preview'] ? true : false;

    // Is custom fields for items and in add/edit area for this already added
    $items_applied = isset($items_cf_params['items_applied']) && $items_cf_params['items_applied'] ? true : false;

    // Used for items custom fields to add additional name on input
    $part_item_name = isset($items_cf_params['part_item_name']) ? $items_cf_params['part_item_name'] : '';

    // Is this custom fields for predefined items Sales->Items
    $items_pr = isset($items_cf_params['items_pr']) && $items_cf_params['items_pr'] ? true : false;

    $is_admin = is_admin();

    $CI = & get_instance();
    $CI->db->where('active', 1);
    $CI->db->where('fieldto', $belongs_to);

    if (is_array($where) && count($where) > 0 || is_string($where) && $where != '') {
        $CI->db->where($where);
    }

    $CI->db->order_by('field_order', 'asc');
    $fields = $CI->db->get(db_prefix() . 'customfields')->result_array();

    $fields_html = '';

    if($rel_id != false && $rel_id != 0){
        $is_add = false;

        $string_where = 'find_in_set('.$rel_id.', '.db_prefix().'wh_custom_fields.warehouse_id) ';
        $CI->db->where($string_where);
        $custom_fields_value = $CI->db->get(db_prefix() . 'wh_custom_fields')->result_array();

        $array_custom_fields=[];
        foreach ($custom_fields_value as $value) {
            array_push($array_custom_fields, $value['custom_fields_id']);
        }

        if(count($array_custom_fields) == 0){

            $is_add = true;
        }

    }else{
        $is_add = true;
    }


    if (count($fields)) {
        if (!$items_add_edit_preview && !$items_applied) {
            $fields_html .= '<div class="row custom-fields-form-row">';
        }

        foreach ($fields as $field) {

            if ($field['only_admin'] == 1 && !$is_admin) {
                continue;
            }

            $field['name'] = _maybe_translate_custom_field_name($field['name'], $field['slug']);

            $value = '';
            if ($field['bs_column'] == '' || $field['bs_column'] == 0) {
                $field['bs_column'] = 12;
            }


            $hidden ='';
            if($is_add == true){
                $hidden = ' hidden';
            }else{
                if(!in_array($field['id'], $array_custom_fields)){
                    $hidden = ' hidden';
                }
            }

            $field['bs_column'] .= ' '.$field['fieldto'].$field['id'].$hidden;

            if (!$items_add_edit_preview && !$items_applied) {
                $fields_html .= '<div class="col-md-' . $field['bs_column'] . '">';
            } elseif ($items_add_edit_preview) {
                $fields_html .= '<td class="custom_field" data-id="' . $field['id'] . '">';
            } elseif ($items_applied) {
                $fields_html .= '<td class="custom_field">';
            }

            if ($is_admin
                && ($items_add_edit_preview == false && $items_applied == false)
                && (!defined('CLIENTS_AREA') || hooks()->apply_filters('show_custom_fields_edit_link_on_clients_area', false))) {
                $fields_html .= '<a href="' . admin_url('custom_fields/field/' . $field['id']) . '" tabindex="-1" target="_blank" class="custom-field-inline-edit-link"><i class="fa fa-pencil-square-o"></i></a>';
            }

            if ($rel_id !== false) {
                if (!is_array($rel_id)) {
                    $value = get_custom_field_value($rel_id, $field['id'], ($items_pr ? 'items_pr' : $belongs_to), false);
                } else {
                    if (is_custom_fields_smart_transfer_enabled()) {
                        // Used only in:
                        // 1. Convert proposal to estimate, invoice
                        // 2. Convert estimate to invoice
                        // This feature is executed only on CREATE, NOT EDIT
                        $transfer_belongs_to = $rel_id['belongs_to'];
                        $transfer_rel_id     = $rel_id['rel_id'];
                        $tmpSlug             = explode('_', $field['slug'], 2);
                        if (isset($tmpSlug[1])) {
                            $CI->db->where('fieldto', $transfer_belongs_to);
                            $CI->db->where('slug LIKE "' . $rel_id['belongs_to'] . '_' . $tmpSlug[1] . '%" AND type="' . $field['type'] . '" AND options="' . $field['options'] . '" AND active=1');
                            $cfTransfer = $CI->db->get(db_prefix() . 'customfields')->result_array();

                            // Don't make mistakes
                            // Only valid if 1 result returned
                            // + if field names similarity is equal or more then CUSTOM_FIELD_TRANSFER_SIMILARITY%
                            //
                            if (count($cfTransfer) == 1 && ((similarity($field['name'], $cfTransfer[0]['name']) * 100) >= CUSTOM_FIELD_TRANSFER_SIMILARITY)) {
                                $value = get_custom_field_value($transfer_rel_id, $cfTransfer[0]['id'], $transfer_belongs_to, false);
                            }
                        }
                    }
                }
            }

            $_input_attrs = [];

            if ($field['required'] == 1) {
                $_input_attrs['data-custom-field-required'] = true;
            }

            if ($field['disalow_client_to_edit'] == 1 && is_client_logged_in()) {
                $_input_attrs['disabled'] = true;
            }

            $_input_attrs['data-fieldto'] = $field['fieldto'];
            $_input_attrs['data-fieldid'] = $field['id'];

            $cf_name = 'custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']';

            if ($part_item_name != '') {
                $cf_name = $part_item_name . '[custom_fields][items][' . $field['id'] . ']';
            }

            if ($items_add_edit_preview) {
                $cf_name = '';
            }

            $field_name = $field['name'];

            if ($field['type'] == 'input' || $field['type'] == 'number') {
                $t = $field['type'] == 'input' ? 'text' : 'number';
                $fields_html .= render_input($cf_name, $field_name, $value, $t, $_input_attrs);
            } elseif ($field['type'] == 'date_picker') {
                $fields_html .= render_date_input($cf_name, $field_name, _d($value), $_input_attrs);
            } elseif ($field['type'] == 'date_picker_time') {
                $fields_html .= render_datetime_input($cf_name, $field_name, _dt($value), $_input_attrs);
            } elseif ($field['type'] == 'textarea') {
                $fields_html .= render_textarea($cf_name, $field_name, $value, $_input_attrs);
            } elseif ($field['type'] == 'colorpicker') {
                $fields_html .= render_color_picker($cf_name, $field_name, $value, $_input_attrs);
            } elseif ($field['type'] == 'select' || $field['type'] == 'multiselect') {
                $_select_attrs = [];
                $select_attrs  = '';
                $select_name   = $cf_name;

                if ($field['required'] == 1) {
                    $_select_attrs['data-custom-field-required'] = true;
                }

                if ($field['disalow_client_to_edit'] == 1 && is_client_logged_in()) {
                    $_select_attrs['disabled'] = true;
                }

                $_select_attrs['data-fieldto'] = $field['fieldto'];
                $_select_attrs['data-fieldid'] = $field['id'];

                if ($field['type'] == 'multiselect') {
                    $_select_attrs['multiple'] = true;
                    $select_name .= '[]';
                }

                foreach ($_select_attrs as $key => $val) {
                    $select_attrs .= $key . '=' . '"' . $val . '" ';
                }

                $fields_html .= '<div class="form-group">';
                $fields_html .= '<label for="' . $cf_name . '" class="control-label" style="margin-bottom:9px;">' . $field_name . '</label>';
                $fields_html .= '<select ' . $select_attrs . ' name="' . $select_name . '" class="' . ($items_add_edit_preview == false ? 'select-placeholder ': '') . 'selectpicker form-control' . ($field['type'] == 'multiselect' ? ' custom-field-multi-select' : '') . '" data-width="100%" data-none-selected-text="' . _l('dropdown_non_selected_tex') . '"  data-live-search="true">';

                $fields_html .= '<option value=""' . ($field['type'] == 'multiselect' ? ' class="hidden"' : '') . '></option>';

                $options = explode(',', $field['options']);

                if ($field['type'] == 'multiselect') {
                    $value = explode(',', $value);
                }

                foreach ($options as $option) {
                    $option = trim($option);
                    if ($option != '') {
                        $selected = '';
                        if ($field['type'] == 'select') {
                            if ($option == $value) {
                                $selected = ' selected';
                            }
                        } else {
                            foreach ($value as $v) {
                                $v = trim($v);
                                if ($v == $option) {
                                    $selected = ' selected';
                                }
                            }
                        }

                        $fields_html .= '<option value="' . $option . '"' . $selected . '' . set_select($cf_name, $option) . '>' . $option . '</option>';
                    }
                }
                $fields_html .= '</select>';
                $fields_html .= '</div>';
            } elseif ($field['type'] == 'checkbox') {
                $fields_html .= '<div class="form-group chk">';

                $fields_html .= '<br /><label class="control-label' . ($field['display_inline'] == 0 ? ' no-mbot': '') . '" for="' . $cf_name . '[]">' . $field_name . '</label>' . ($field['display_inline'] == 1 ? ' <br />': '');

                $options = explode(',', $field['options']);

                $value = explode(',', $value);

                foreach ($options as $option) {
                    $checked = '';
                    // Replace double quotes with single.
                    $option = htmlentities($option);
                    $option = trim($option);
                    foreach ($value as $v) {
                        $v = trim($v);
                        if ($v == $option) {
                            $checked = 'checked';
                        }
                    }

                    $_chk_attrs                 = [];
                    $chk_attrs                  = '';
                    $_chk_attrs['data-fieldto'] = $field['fieldto'];
                    $_chk_attrs['data-fieldid'] = $field['id'];

                    if ($field['required'] == 1) {
                        $_chk_attrs['data-custom-field-required'] = true;
                    }

                    if ($field['disalow_client_to_edit'] == 1 && is_client_logged_in()) {
                        $_chk_attrs['disabled'] = true;
                    }
                    foreach ($_chk_attrs as $key => $val) {
                        $chk_attrs .= $key . '=' . '"' . $val . '" ';
                    }

                    $input_id = 'cfc_' . $field['id'] . '_' . slug_it($option) . '_' . app_generate_hash();

                    $fields_html .= '<div class="checkbox' . ($field['display_inline'] == 1 ? ' checkbox-inline': '') . '">';
                    $fields_html .= '<input class="custom_field_checkbox" ' . $chk_attrs . ' ' . set_checkbox($cf_name . '[]', $option) . ' ' . $checked . ' value="' . $option . '" id="' . $input_id . '" type="checkbox" name="' . $cf_name . '[]">';

                    $fields_html .= '<label for="' . $input_id . '" class="cf-chk-label">' . $option . '</label>';
                    $fields_html .= '<input type="hidden" name="' . $cf_name . '[]" value="cfk_hidden">';
                    $fields_html .= '</div>';
                }
                $fields_html .= '</div>';
            } elseif ($field['type'] == 'link') {
                $fields_html .= '<div class="form-group cf-hyperlink" data-fieldto="' . $field['fieldto'] . '" data-field-id="' . $field['id'] . '" data-value="' . html_escape($value) . '" data-field-name="' . html_escape($field_name) . '">';
                $fields_html .= '<label class="control-label" for="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']">' . $field_name . '</label></br>';

                $fields_html .= '<a id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_popover" type="button" href="javascript:">' . _l('cf_translate_input_link_tip') . '</a>';

                $fields_html .= '<input type="hidden" ' . ($field['required'] == 1 ? 'data-custom-field-required="1"' : '') . ' value="" id="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']" name="custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']">';

                $field_template = '';
                $field_template .= '<div id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_popover-content" class="hide cfh-field-popover-template"><div class="form-group">';
                $field_template .= '<div class="row"><div class="col-md-12"><label class="control-label" for="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_title">' . _l('cf_translate_input_link_title') . '</label>';
                $field_template .= '<input type="text"' . ($field['disalow_client_to_edit'] == 1 && is_client_logged_in() ? ' disabled="true" ' : ' ') . 'id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_title" value="" class="form-control">';
                $field_template .= '</div>';
                $field_template .= '</div>';
                $field_template .= '</div>';
                $field_template .= '<div class="form-group">';
                $field_template .= '<div class="row">';
                $field_template .= '<div class="col-md-12">';
                $field_template .= '<label class="control-label" for="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_link">' . _l('cf_translate_input_link_url') . '</label>';
                $field_template .= '<div class="input-group"><input type="text"' . ($field['disalow_client_to_edit'] == 1 && is_client_logged_in() ? ' disabled="true" ' : ' ') . 'id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_link" value="" class="form-control"><span class="input-group-addon"><a href="#" id="cf_hyperlink_open_' . $field['id'] . '" target="_blank"><i class="fa fa-globe"></i></a></span></div>';
                $field_template .= '</div>';
                $field_template .= '</div>';
                $field_template .= '</div>';
                $field_template .= '<div class="row">';
                $field_template .= '<div class="col-md-6">';
                $field_template .= '<button type="button" id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_btn-cancel" class="btn btn-default btn-md pull-left" value="">' . _l('cancel') . '</button>';
                $field_template .= '</div>';
                $field_template .= '<div class="col-md-6">';
                $field_template .= '<button type="button" id="custom_fields_' . $field['fieldto'] . '_' . $field['id'] . '_btn-save" class="btn btn-info btn-md pull-right" value="">' . _l('apply') . '</button>';
                $field_template .= '</div>';
                $field_template .= '</div>';
                $fields_html .= '<script>';
                $fields_html .= 'cfh_popover_templates[\'' . $field['id'] . '\'] = \'' . $field_template . '\';';
                $fields_html .= '</script>';
                $fields_html .= '</div>';
            }

            $name = $cf_name;

            if ($field['type'] == 'checkbox' || $field['type'] == 'multiselect') {
                $name .= '[]';
            }

            $fields_html .= form_error($name);
            if (!$items_add_edit_preview && !$items_applied) {
                $fields_html .= '</div>';
            } elseif ($items_add_edit_preview) {
                $fields_html .= '</td>';
            } elseif ($items_applied) {
                $fields_html .= '</td>';
            }
        }

        // close row
        if (!$items_add_edit_preview && !$items_applied) {
            $fields_html .= '</div>';
        }
    }

    return $fields_html;
}

/**
 * wh get custom fields
 * @param  [type] $id 
 * @return [type]     
 */
function wh_get_custom_fields($id)
{
    $CI           = & get_instance();

    if (is_numeric($id)) {
        $CI->db->where('id', $id);

        return $CI->db->get(db_prefix() . 'customfields')->row();
    }
    if ($id == false) {
        return $CI->db->query('select * from tblcustomfields')->result_array();
    }

}


/**
 * handle send delivery note
 * @param  [type] $id 
 * @return [type]     
 */
function handle_send_delivery_note($id){
 if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != '') {

    $path = WAREHOUSE_MODULE_UPLOAD_FOLDER .'/send_delivery_note/'. $id . '/';
        // Get the temp file path
    $tmpFilePath = $_FILES['attachment']['tmp_name'];
        // Make sure we have a filepath
    if (!empty($tmpFilePath) && $tmpFilePath != '') {
        _maybe_create_upload_path($path);
        $filename    = unique_filename($path, $_FILES['attachment']['name']);
        $newFilePath = $path . $filename;
            // Upload the file into the company uploads dir
        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
            return true;
        }
    }
}

return false;
}

/**
 * Gets the vendor company name.
 *
 * @param      string   $userid                 The userid
 * @param      boolean  $prevent_empty_company  The prevent empty company
 *
 * @return     string   The vendor company name.
 */
function wh_get_vendor_company_name($userid, $prevent_empty_company = false)
{
    if ($userid !== '') {
        $_userid = $userid;
    }
    $CI = & get_instance();

    $client = $CI->db->select('company')
    ->where('userid', $_userid)
    ->from(db_prefix() . 'pur_vendor')
    ->get()
    ->row();
    if ($client) {
        return $client->company;
    }

    return '';
}

/**
 * get invoice company projecy
 * @param  [type] $invoice_id 
 * @return [type]             
 */
function get_invoice_company_projecy($invoice_id)
{
    $CI           = & get_instance();
    $invoice_info = '';

    if (is_numeric($invoice_id)) {

        $invoices = $CI->db->query('select *, iv.id as id from '.db_prefix().'invoices as iv left join '.db_prefix().'projects as pj on pj.id = iv.project_id left join '.db_prefix().'clients as cl on cl.userid = iv.clientid  where iv.id ='.$invoice_id)->row();

        if($invoices){
            $invoice_info .= ' - '.$invoices->company.' - '.$invoices->name;
        }

    }
    
    return $invoice_info;

}

/**
 * wh get warehouse address
 * @param  [type] $id 
 * @return [type]     
 */
function wh_get_warehouse_address($id)
{
    $CI           = & get_instance();

    $CI->db->where('warehouse_id', $id);
    $warehouse_value = $CI->db->get(db_prefix() . 'warehouse')->row();

    $address='';

    if($warehouse_value){

        $warehouse_address = [];
        $warehouse_address[0] =  $warehouse_value->warehouse_address;
        $warehouse_address[1] = $warehouse_value->city;
        $warehouse_address[2] =  $warehouse_value->state;
        $warehouse_address[3] =  $warehouse_value->country;
        $warehouse_address[4] =  $warehouse_value->zip_code;

        foreach ($warehouse_address as $key => $add_value) {
            if(isset($add_value) && $add_value !=''){
                switch ($key) {
                    case 0:
                        $address .= $add_value;
                        break;
                    case 1:
                        $address .= ', '.$add_value;
                        break;
                    case 2:
                        $address .= ', '.$add_value;
                        break;
                    case 3:
                        $address .= ', '.get_country_name($add_value);
                        break;
                    case 4:
                        $address .= ', '.$add_value;
                        break;
                    default:
                    break;
                }
            }
        }

    }
    return $address;

}