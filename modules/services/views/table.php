<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    'id',
    'name',
    'stripe_plan_id',
    'price',
    'period',
    db_prefix() . 'subscription_products.group as groupId',
    'description',
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'subscription_products';

$filter = [];
$where  = [];
    
$statusIds = [];

$join = [];

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    'currency',
    'count',
    'client_id',
    'customer_group',
]);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {

    $subtext = app_format_money(strcasecmp($aRow['price'], 'JPY') == 0 ? $aRow['price'] : $aRow['price'] / 100, strtoupper($aRow['currency']));
    if ($aRow['count']  == 1) {
       $subtext .= ' / ' . $aRow['period'];
    } else {
       $subtext .= ' (every ' . $aRow['count'] . ' ' . $aRow['period'] . 's)';
    }

    $link       = admin_url('subscriptions/edit/' . $aRow['id']);
    $options = '<div class="row-options">';

    if (has_permission('subscriptions', '', 'edit')) {
        $options .= '<a href="' . admin_url('services/products/create/subscription/' . $aRow['id']) . '">' . _l('edit') . '</a>';
    }
    if (has_permission('subscriptions', '', 'delete')) {
        $options .= ' | <a class=" text-danger" href="' . admin_url('services/products/delete/subscription/' . $aRow['id']) . '">' . _l('delete') . '</a>';
    }
    $options .= '</div>';

    $for = '';
    // if($aRow['client_id']){
    //     $client = get_client($aRow['client_id']);
    //     $contact_name = get_contact_full_name(get_primary_contact_user_id($aRow['client_id']));
    //     $name = (!is_empty_customer_company($aRow['client_id'])) ? $client->company : $contact_name ;
    //     $for .= "<a href='".admin_url('clients/client/'.$aRow['client_id'])."'>{$name}</a>";
    // } elseif ($aRow['customer_group']){
    //     $name = get_group_name($aRow['customer_group']);
    //     $for .= "<a href='".admin_url('clients')."'>{$name->name} group</a>";
    // } else { $for = _l('customers');}
    
    $link = get_product_url($aRow['id'],$aRow['name'],'subscription');
    $group = $aRow['groupId'] ? services_get_product_group_name($aRow['groupId'])->name : '';

    $row = [];
    $row[] = $aRow['id'] . $options;
    $row[] = $aRow['name'];
    $row[] = $subtext;
    $row[] = $for;
    $row[] = $group;
    $row[] = clear_textarea_breaks($aRow['description']);
    $row[] = '<a href="'.$link.'" target="_blank">' . $link . '</a>';
    $row['DT_RowClass'] = 'has-row-options';
    $output['aaData'][] = $row;
}
