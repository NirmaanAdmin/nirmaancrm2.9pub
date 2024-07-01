<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [ 
    'id',
    'name_channel',
    'consumer_key',
    'url',
    'consumer_secret',
    ];
$sIndexColumn = 'id';
$sTable       = db_prefix().'omni_master_channel_woocommere';
$join         = [];
$where = [];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    $company = '';
    $company = '<a href="' . admin_url('omni_sales/detail_channel_wcm/'. $aRow['id']) . '">' .  $aRow['name_channel'] . '</a>';

    $company .= '<div class="row-options">';
    if(is_admin()){
        $company .= '<a href="' . admin_url('omni_sales/detail_channel_wcm/'. $aRow['id']) . '">' . _l('view') . '</a>';

        $company .= ' | <a href="#" onclick="edit(this);" data-id="'.$aRow['id'].'" data-name="'.$aRow['name_channel'].'" data-key="'.$aRow['consumer_key'].'" data-secret="'.$aRow['consumer_secret'].'" data-url="'.$aRow['url'].'" class="text-danger">' . _l('edit') . '</a>';

        $company .= ' | <a href="' . admin_url('omni_sales/delete_channel_wcm/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
    }

    $company .= '</div>';

    $row[] = $company;
    $row[] = $aRow['url'];

    $row[] = $aRow['consumer_key'];
    $row[] = $aRow['consumer_secret'];

    $option = '';
    $option .= '<a href="' . admin_url('omni_sales/detail_channel_wcm/'. $aRow['id']) . '" class="btn btn-primary btn-icon" data-toggle="tooltip" data-placement="top" data-original-title="'._l("setting_product").'" data-id="'.$aRow['id'].'" >';
    $option .= '<i class="fa fa-arrow-right "></i>';
    $option .= '</a>';
  
    $option .= '<a href="#" onclick="sync_store(this); return false;" data-id="'.$aRow['id'].'" data-toggle="tooltip" data-placement="top" data-original-title="'._l("sync_from_the_system_to_the_store").'" class="btn btn-warning btn-icon orders-woo" data-toggle="dropdown" aria-expanded="false">';
    $option .= '<i class="fa fa-refresh" aria-hidden="true"></i>';
    $option .= '</a>';

    $option .= '<a href="#" onclick="sync_inventory_synchronization(this); return false;" data-id="'.$aRow['id'].'" data-toggle="tooltip" data-placement="top" data-original-title="'._l("sync_from_store").'" class="btn btn-success btn-icon">';
    $option .= '<i class="fa fa-refresh" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i>';
    $option .= '</a>';

    $option .= '<a href="#" onclick="sync_decriptions_synchronization(this); return false;" data-id="'.$aRow['id'].'" data-toggle="tooltip" data-placement="top" data-original-title="'._l("sync_decriptions").'" class="btn btn-info btn-icon">';
    $option .= '<i class="fa fa-refresh" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i>';
    $option .= '</a>';


    $option .= '<a href="#" onclick="sync_images_synchronization(this); return false;" data-id="'.$aRow['id'].'" data-toggle="tooltip" data-placement="top" data-original-title="'._l("sync_images").'" class="btn btn-danger btn-icon">';
    $option .= '<i class="fa fa-refresh" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i>';
    $option .= '</a>';

    $row[] = $option;

    $output['aaData'][] = $row;

}
