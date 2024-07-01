<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'invoice_products.id',
    db_prefix() . 'invoice_products.name','price','currency', 
    db_prefix() . 'products_groups.name as group_name',
];

$sIndexColumn =  'id';
$sTable       = db_prefix() . 'invoice_products';

$filter = [];
$where  = [];

$join = [
    'LEFT JOIN ' . db_prefix() . 'products_groups ON ' . db_prefix() . 'invoice_products.group=' . db_prefix() . 'products_groups.id'
];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    'client_id',
    'customer_group',
    'description',
]);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {

    $aRow['price'] = is_numeric($aRow['price']) ? $aRow['price'] : 0 ;
    $currency = get_currency($aRow['currency']);
    $price = app_format_money($aRow['price'], $currency);

    $options = '<div class="row-options">';
    if (has_permission('invoices', '', 'edit')) {
        $options .= '<a href="' . admin_url('services/products/create/invoice/' . $aRow[db_prefix() . 'invoice_products.id']) . '">' . _l('edit') . '</a>';
    }
    if (has_permission('invoices', '', 'delete')) {
        $options .= ' | <a class=" text-danger" href="' . admin_url('services/products/delete/invoice/' . $aRow[db_prefix() . 'invoice_products.id']) . '">' . _l('delete') . '</a>';
    }
    $options .= '</div>';

    $for = '';
    if($aRow['client_id']){
        $client = get_client($aRow['client_id']);
        $contact_name = get_contact_full_name(get_primary_contact_user_id($aRow['client_id']));
        $name = (!is_empty_customer_company($aRow['client_id'])) ? $client->company : $contact_name ;
        $for .= "<a href='".admin_url('clients/client/'.$aRow['client_id'])."'>{$name}</a>";
    } elseif ($aRow['customer_group']){
        $name = get_group_name($aRow['customer_group']);
        $for .= "<a href='".admin_url('clients')."'>{$name->name} group</a>";
    } else { $for = _l('customers');}

    $link = get_product_url($aRow[db_prefix() . 'invoice_products.id'],$aRow[db_prefix() . 'invoice_products.name'],'invoice');

    $row = [];
    $row[] = $aRow[db_prefix() . 'invoice_products.id'] . $options;
    $row[] = $aRow[db_prefix() . 'invoice_products.name'];
    $row[] = $price;
    $row[] = $for;
    $row[] =  $aRow['group_name'] ;
    $row[] = clear_textarea_breaks($aRow['description']);
    $row[] = '<a href="'.$link.'" target="_blank">' . $link . '</a>';
    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
