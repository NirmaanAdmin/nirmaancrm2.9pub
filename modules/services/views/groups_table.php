<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id','name',
     db_prefix() . 'products_groups.order as ord'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'products_groups';

$where  = [];
$join = [];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, []);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {

    $options = '<div class="row-options">';

    if (has_permission('subscriptions', '', 'edit')) {
        $options .= '<a class="text-info" id="editGroupbtn" onclick="editGroup(this)" data-id="'.$aRow['id'].'" data-name="'. $aRow['name'].'" data-order="'. $aRow['ord'].'">' . _l('edit') . '</a>';
    }
    if (has_permission('subscriptions', '', 'delete')) {
        $options .= ' | <a class="text-danger" href="' . admin_url('services/products/groups/delete/' . $aRow['id']) . '">' . _l('delete') . '</a>';
    }
    $options .= '</div>';

    $row = [];
    $row[] = $aRow['id'] . $options;
    $row[] = $aRow['name'];
    $row[] = $aRow['ord'];
    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
