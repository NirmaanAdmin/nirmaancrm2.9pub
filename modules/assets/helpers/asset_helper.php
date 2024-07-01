<?php
defined('BASEPATH') or exit('No direct script access allowed');


/**
 * Check whether column exists in a table
 * Custom function because Codeigniter is caching the tables and this is causing issues in migrations
 * @param  string $column column name to check
 * @param  string $table table name to check
 * @return boolean
 */
function handle_asset_file($id)
{
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
        hooks()->do_action('before_upload_contract_attachment', $id);
        $path = ASSETS_UPLOAD_FOLDER .'/'. $id . '/';
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
                $CI->misc_model->add_attachment_to_database($id, 'assets', $attachment);

                return true;
            }
        }
    }

    return false;
}

function get_asset_location($id = ''){
    $CI           = & get_instance();
    if($id != 0){
        $CI->db->where('location_id',$id);
        $location = $CI->db->get(db_prefix().'asset_location')->row();
        return $location->location;
    }else{
        return '';
    }
}

function get_asset_group($id = ''){
    $CI           = & get_instance();
    if($id != 0){
        $CI->db->where('group_id',$id);
        $group = $CI->db->get(db_prefix().'assets_group')->row();
        return $group->group_name;
    }else{
        return '';
    }
}

function get_asset_units($id = ''){
    $CI           = & get_instance();
    if($id != 0){
        $CI->db->where('unit_id',$id);
        $unit = $CI->db->get(db_prefix().'asset_unit')->row();
        return $unit->unit_name;
    }else{
        return '';
    }
}

function get_asset_dpm($id = ''){
    $CI           = & get_instance();
    if($id != 0){
        $CI->db->where('departmentid',$id);
        $dpm = $CI->db->get(db_prefix().'departments')->row();
        return $dpm->name;
    }else{
        return '';
    }
}

function get_asset_name_by_id($id){
    $CI           = & get_instance();
    $CI->db->where('id',$id);
    $assets = $CI->db->get(db_prefix().'assets')->row();
    return $assets->assets_name;
}

function reformat_currency_asset($value)
{
    return str_replace(',','', $value);
}