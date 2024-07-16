<?php

defined('BASEPATH') or exit('No direct script access allowed');
$this->ci->load->model('clients_model');
$customer_fillter = $this->ci->input->post('customer_fillter');
$workplace_fillter = $this->ci->input->post('workplace_fillter');
$aColumns = [
   'id',
   'id',
   'id',
   'id',
   'id',
   'id',
   'id',
];
$sIndexColumn = 'name';
$sTable       = db_prefix().'timesheets_route_point';
$join = [];
$where = [];

if(isset($customer_fillter)){
    if(count($customer_fillter) > 0){
        $list_id = implode(',',array_filter($customer_fillter));
        if($list_id != ''){
            array_push($where, ' AND ((related_to = 1) and (related_id in ('.$list_id.')))');
        }
    }
}
if(isset($workplace_fillter)){
    if(count($workplace_fillter) > 0){
        $list_id = implode(',',array_filter($workplace_fillter));
        if($list_id != ''){
            array_push($where, ' OR ((related_to = 2) and (related_id in ('.$list_id.')))');
        }
    }
}

$result  = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    'id',
    'name',
    'related_to',
    'related_id',
    'route_point_address',
    'latitude',
    'longitude',
    'distance',
    db_prefix().'timesheets_route_point.default',
]);

$output  = $result['output'];
$rResult = $result['rResult'];
foreach ($rResult as $aRow) {
    $row = [];   
    $row[] = $aRow['name'];

    $related_to = '';
    if($aRow['related_to'] == 1){
        $data_client = $this->ci->clients_model->get($aRow['related_id']);
        if($data_client){            
            $related_to =  $data_client->company;
        }
    }
    else{
        $data_workplace = $this->ci->timesheets_model->get_workplace($aRow['related_id']);
        if($data_workplace){
            $related_to = $data_workplace->name;                
        }
    }
    $row[] = $related_to;
    $row[] = $aRow['route_point_address'];
    $row[] = $aRow['latitude'];
    $row[] = $aRow['longitude'];
    $row[] = $aRow['distance'];

    $option = '';
    $option .= '<a href="#" onclick="edit_route_point(this,'.$aRow['id'].'); return false" 
    data-name="'.$aRow['name'].'" data-id="'.$aRow['id'].'" 
    data-route_point_address="'.$aRow['route_point_address'].'" 
    data-latitude="'.$aRow['latitude'].'" 
    data-longitude="'.$aRow['longitude'].'" 
    data-distance="'.$aRow['distance'].'" 
    data-related_to="'.$aRow['related_to'].'" 
    data-related_id="'.$aRow['related_id'].'" 
    data-default="'.$aRow['default'].'" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i></a>';
    $option .= '<a href="'.admin_url('timesheets/delete_route_point/'.$aRow['id']).'" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>';

    $row[] = $option;

    $output['aaData'][] = $row;
}


