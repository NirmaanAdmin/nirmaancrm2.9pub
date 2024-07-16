<?php

defined('BASEPATH') or exit('No direct script access allowed');
$aColumns = [
    'staffid',
    'firstname',
    'lastname',
];
$sIndexColumn = 'staffid';
$sTable       = db_prefix().'staff';
$join = [];
$where = [];


$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where,['staffid', 'firstname', 'lastname']);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {
  $row = [];
  $row[] = $aRow['firstname'].' '.$aRow['lastname'];
  $route_point = '';
  $data_route_point = $this->ci->timesheets_model->get_route_point_staff($aRow['staffid']);
  if($data_route_point){
    foreach ($data_route_point as $k_route_point => $route_point) {
         $route_point = $this->ci->timesheets_model->get_route_point($route_point['route_point_id']);
         $route_point .= $route_point['route_point_id'];  
    }
  }
  $row[] = $route_point;

  $options = '';
  $row[]   = $options;

  $output['aaData'][] = $row;
}
