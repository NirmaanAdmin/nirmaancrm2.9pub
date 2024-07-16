<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [ 
  db_prefix().'timesheets_workplace_assign.staffid',
  db_prefix().'timesheets_workplace_assign.staffid',
  db_prefix().'timesheets_workplace_assign.workplace_id',
  db_prefix().'timesheets_workplace_assign.id'
];

$sIndexColumn = 'id';
$sTable       = db_prefix().'timesheets_workplace_assign';
$join         = [
  'left join '.db_prefix().'staff on '.db_prefix().'staff.staffid = '.db_prefix().'timesheets_workplace_assign.staffid', 
  'left join '.db_prefix().'timesheets_workplace on '.db_prefix().'timesheets_workplace.id = '.db_prefix().'timesheets_workplace_assign.workplace_id'
];
$where = [];
array_push($where, ' AND '.db_prefix().'staff.active = 1');
array_push($where, timesheet_staff_manager_query('table_workplace_management', db_prefix().'timesheets_workplace_assign.staffid', 'AND'));

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [db_prefix().'timesheets_workplace_assign.id', db_prefix().'timesheets_workplace.name', db_prefix().'timesheets_workplace.workplace_address', db_prefix().'staff.firstname', db_prefix().'staff.lastname', db_prefix().'timesheets_workplace_assign.staffid']);

$output  = $result['output'];
$rResult = $result['rResult'];
$disabled = '';
if(!(is_admin() || has_permission('table_workplace_management', '', 'view'))){
  $disabled = ' disabled="disabled"';
}

foreach ($rResult as $aRow) {
  $row = [];
  $row[] = '<input type="checkbox" class="wp-assign" data-id="'.$aRow['id'].'" onchange="checked_add(this); return false;" '.$disabled.'/>';  
  $row[] = get_staff_full_name($aRow[db_prefix().'timesheets_workplace_assign.staffid']);

  $data_workplace = $this->ci->timesheets_model->get_workplace($aRow[db_prefix().'timesheets_workplace_assign.workplace_id']);
  $workplace_name = '';
  if($data_workplace){
   $workplace_name = $data_workplace->name.' '.$data_workplace->workplace_address;
  }
 $row[] = $workplace_name;
 $option = '';
 if (has_permission('table_workplace_management', '', 'view') || is_admin()) {
   $option .= '<a href="#" class="btn btn-primary" data-id="'. $aRow['id'] . '" data-staffid="'. $aRow[db_prefix().'timesheets_workplace_assign.staffid'] . '" data-workplace_id = "'.$aRow[db_prefix().'timesheets_workplace_assign.workplace_id'].'" onclick="edit_workplace_assign(this)">';
   $option .= '<i class="fa fa-pencil-square-o"></i>';
   $option .= '</a>';
   $option .= '<a href="' . admin_url('timesheets/delete_workplace_assign/'. $aRow['id']) . '" class="btn btn-danger mleft15 _delete">';
   $option .= '<i class="fa fa-remove"></i>';
   $option .= '</a>';
 }
 $row[] = $option;
 $output['aaData'][] = $row;
}
