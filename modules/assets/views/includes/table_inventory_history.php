<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'date_time',
    'acction',
    'inventory_begin',
    'inventory_end',
    'cost'
    ];
$sIndexColumn = 'id';
$sTable       = db_prefix().'inventory_history';
$join         = [];
$where = [];

if(isset($asset_id)){
    array_push($where, 'AND assets = '.$asset_id);
}
$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
    $row = [];
    for ($i = 0; $i < count($aColumns); $i++) {
        $_data = $aRow[$aColumns[$i]];
        if($aColumns[$i] == 'date_time'){
            $_data = _dt($aRow['date_time']);
        }elseif ($aColumns[$i] == 'acction') {
            $_data = _l($aRow['acction']);
        }elseif ($aColumns[$i] == 'cost') {
            $_data = app_format_money($aRow['cost'],'');
        }
        $row[] = $_data;
    }

    $output['aaData'][] = $row;

}
