<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix().'inspections.id'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'inspections';

$join = [
    'LEFT JOIN ' . db_prefix() . 'inspection_types ON ' . db_prefix() . 'inspection_types.id = ' . db_prefix() . 'inspections.inspection_type_id',
    'LEFT JOIN ' . db_prefix() . 'projects ON ' . db_prefix() . 'projects.id = ' . db_prefix() . 'inspections.project_id',
    'LEFT JOIN ' . db_prefix() . 'clients ON ' . db_prefix() . 'clients.userid = ' . db_prefix() . 'projects.clientid',
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], [
    db_prefix().'inspections.id',
    db_prefix().'inspections.name as inspection_name',
    db_prefix().'projects.name as project_name',
    db_prefix().'clients.company as client_name',
    db_prefix().'inspection_types.name as inspection_type',
    db_prefix().'inspections.status',
    db_prefix().'inspections.dateadded',
    db_prefix().'inspections.done_by',
    '(SELECT GROUP_CONCAT(name SEPARATOR ",") FROM ' . db_prefix() . 'taggables JOIN ' . db_prefix() . 'tags ON ' . db_prefix() . 'taggables.tag_id = ' . db_prefix() . 'tags.id WHERE rel_id = ' . db_prefix() . 'inspections.id and rel_type="inspection" ORDER by tag_order ASC) as tags',
]);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $key => $aRow) {
    $row = [];
    $row[] = '<div class="checkbox"><input type="checkbox" value="' . $aRow['id'] . '"><label></label></div>';
    $row[] = $key + 1;

    $outputName = '';
    $outputName .= '<a href="' . admin_url('inspection/create_inspection/' . $aRow['id']) . '" class="display-block main-tasks-table-href-name">' . $aRow['inspection_name'] . '</a><span>' . $aRow['project_name'] . ' - ' . $aRow['client_name'] . '<br />' . $aRow['inspection_type'] . '</span>';
    $outputName .= '<div class="row-options">';

    if($aRow['status'] == 0) {
        $outputName .= '<span class="text-dark"></span><a href="' . admin_url('inspection/perform_inspection/' . $aRow['id']) . '">' . _l('perform') . '</a> | ';
        $outputName .= '<span class="text-dark"></span><a href="' . admin_url('inspection/create_inspection/' . $aRow['id']) . '">' . _l('edit') . '</a> | ';
    }
    
    $outputName .= '<span class="text-dark"></span><a href="' . admin_url('inspection/delete/' . $aRow['id']) . '" class="text-danger _delete task-delete">' . _l('delete') . '</a>';
    $outputName .= '</div>';
    $row[] = $outputName;

    $row[] = 'Ready For Review';

    $row[] = date('d-m-Y', strtotime($aRow['dateadded']));

    $done_by_list_ids = done_by_list_ids($aRow['done_by']);
    $done_by_list_names = done_by_list_names($aRow['done_by']);
    $row[] = format_members_by_ids_and_names($done_by_list_ids, $done_by_list_names);

    $row[] = render_tags($aRow['tags']);

    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
