<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'assets_code',  
    'assets_name',
    'asset_group',
    'date_buy',
    'total_allocation', 
    'amount',
    'unit_price',
    'unit',
    'department',
    ];
$sIndexColumn = 'id';
$sTable       = db_prefix().'assets';
$join         = [
    'LEFT JOIN '.db_prefix().'asset_unit on '.db_prefix().'asset_unit.unit_id = '.db_prefix().'assets.unit',
    'LEFT JOIN '.db_prefix().'assets_group on '.db_prefix().'assets_group.group_id = '.db_prefix().'assets.asset_group',
    'LEFT JOIN '.db_prefix().'departments on '.db_prefix().'departments.departmentid = '.db_prefix().'assets.department',
];
$where = [];

if(isset($status)){
    if($status == 1){
        array_push($where, 'AND total_allocation = 0');
    }elseif($status == 2){
        array_push($where, 'AND total_allocation > 0');
    }elseif($status == 3){
        array_push($where, 'AND total_liquidation > 0');
    }elseif($status == 4){
        array_push($where, 'AND total_warranty > 0');
    }elseif($status == 5){
        array_push($where, 'AND total_lost > 0');
    }elseif($status == 6){
        array_push($where, 'AND total_damages > 0');
    }
    
}
$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['id','description','warranty_period','asset_location','depreciation','series','supplier_name','supplier_address','supplier_phone','unit_name','group_name',db_prefix().'departments.name as dpm_name']);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if($aColumns[$i] == 'date_buy'){
            $_data = _d($aRow['date_buy']);
        }elseif ($aColumns[$i] == 'unit_price') {
            $op = $aRow['unit_price'] * $aRow['amount'];
            $_data = app_format_money($op,'');
        }elseif ($aColumns[$i] == 'unit') {
            $_data = $aRow['unit_name'];
        }elseif ($aColumns[$i] == 'asset_group'){
            $_data = $aRow['group_name'];
        }elseif ($aColumns[$i] == 'department') {
            $_data = $aRow['dpm_name'];
        }elseif ($aColumns[$i] == 'amount') {
            $_data = $aRow['amount'] - $aRow['total_allocation'];
        }elseif ($aColumns[$i] == 'assets_name') {
            
            $name = '<a href="' . admin_url('assets/manage_assets/' . $aRow['id'] ).'" onclick="init_asset('.$aRow['id'].'); return false;">' . $aRow['assets_name'] . '</a>';

            $name .= '<div class="row-options">';

            $name .= '<a href="' . admin_url('assets/manage_assets/' . $aRow['id'] ).'" onclick="init_asset('.$aRow['id'].'); return false;">' . _l('view') . '</a>';
            if (has_permission('assets', '', 'edit') || is_admin()) {
                $name .= ' | <a href="#" onclick="edit_asset(this,' . $aRow['id'] . '); return false;" data-assets_name="' . $aRow['assets_name'] .'" data-assets_code="' . $aRow['assets_code'] .'" data-date_buy="' . $aRow['date_buy'] .'" data-amount="' . $aRow['amount'] .'" data-unit_price="' . $aRow['unit_price'] .'" data-description="' . $aRow['description'] .'" data-supplier_phone="' . $aRow['supplier_phone'] .'" data-supplier_name="' . $aRow['supplier_name'] .'" data-supplier_address="' . $aRow['supplier_address'] .'" data-warranty_period="' . $aRow['warranty_period'] .'" data-depreciation="' . $aRow['depreciation'] .'" data-series="' . $aRow['series'] .'" data-unit="' . $aRow['unit'] .'" data-department="' . $aRow['department'] .'" data-asset_group="' . $aRow['asset_group'] .'" data-asset_location="' . $aRow['asset_location'] .'" >' ._l('edit') . '</a>';
            }

            if (has_permission('assets', '', 'delete') || is_admin()) {
                $name .= ' | <a href="' . admin_url('assets/delete_assets/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
            }

            $name .= '</div>';

            $_data = $name;
        }elseif ($aColumns[$i] == 'assets_code') {
            $_data = '<a href="' . admin_url('assets/manage_assets/' . $aRow['id'] ).'" onclick="init_asset('.$aRow['id'].'); return false;">' . $aRow['assets_code'] . '</a>';
        }
        $row[] = $_data;
    }

    $output['aaData'][] = $row;

}
