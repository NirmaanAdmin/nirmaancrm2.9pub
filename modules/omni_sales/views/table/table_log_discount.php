<?php

defined('BASEPATH') or exit('No direct script access allowed');
$this->ci->load->model('omni_sales_model');
$this->ci->load->model('client_groups_model');
$this->ci->load->model('clients_model');
$this->ci->load->model('warehouse/warehouse_model');

$aColumns = [ 
    'id',
    'name_discount',
    'client',
    'price',
    'product_id',
    'total_product',
    ];
$sIndexColumn = 'id';
$sTable       = db_prefix().'omni_log_discount';
$join         = [];
$where = [];
$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, ['date_apply']);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {

    $row = [];
    $row[] = $aRow['name_discount'];
    $row[] = get_company_name($aRow['client']);
    $row[] = '';
    $row[] = app_format_money($aRow['price'], '');
    $row[] = '';
    $row[] = '';
    $row[] = app_format_money($aRow['total_product'], '');
    $row[] = _d($aRow['date_apply']);
    $output['aaData'][] = $row;

}
