<?php

defined('BASEPATH') or exit('No direct script access allowed');

$aColumns = [
    db_prefix() . 'product_purchase_log.id', 'invoice_id', 'product_id', 'client_id', 'subscription_id'
];

$sIndexColumn = 'id';
$sTable       = db_prefix() . 'product_purchase_log';

$filter = [];
$where  = [];
$join = [];

$custom_fields = get_table_custom_fields('products');

foreach ($custom_fields as $key => $field) {
    $selectAs = (is_cf_date($field) ? 'date_picker_cvalue_' . $key : 'cvalue_' . $key);
    array_push($customFieldsColumns, $selectAs);
    array_push($aColumns, 'ctable_' . $key . '.value as ' . $selectAs);
    array_push($join, 'LEFT JOIN ' . db_prefix() . 'customfieldsvalues as ctable_' . $key . ' ON ' . db_prefix() . 'product_purchase_log.id = ctable_' . $key . '.relid AND ctable_' . $key . '.fieldto="' . $field['fieldto'] . '" AND ctable_' . $key . '.fieldid=' . $field['id']);
}

$result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
    'created_at',
    'quantity',
    'contact_id',
]);

$output  = $result['output'];
$rResult = $result['rResult'];

foreach ($rResult as $aRow) {

    $name = get_contact_full_name($aRow['contact_id']);
    $company = get_company_name($aRow['client_id']);
    if ($aRow['invoice_id'] != '' | $aRow['invoice_id'] != null) {
        $product = services_get_product($aRow['product_id'],'invoice');
        $invoice = services_purchase_invoice($aRow['invoice_id']);
        $status = $invoice->status;
    } else {
        $product = services_get_product($aRow['product_id'],'subscription');
        $sub = services_purchased_subscription($aRow['subscription_id']);
        $status = '';

        $subtext = app_format_money( $product->price / 100, strtoupper($sub->currency_name));

        if ($product->count  == 1) {
           $subtext .= ' / ' . $product->period;
        } else {
           $subtext .= ' (every ' . $product->count . ' ' . $product->period . 's)';
        }
    
    }

    $productLink = get_product_url($product->id, $product->name, 'invoice');

    $row = [];
    $row[] = $aRow[db_prefix() . 'product_purchase_log.id'];
    if ($aRow['invoice_id'] != '' | $aRow['invoice_id'] != null) {
        $row[] = '<a href="' . admin_url('invoices/list_invoices/' . $aRow['invoice_id']) . '" target="_blank">' . format_invoice_number($aRow['invoice_id'])  . '</a>';
        $row[] = format_invoice_status($status);
        $row[] = app_format_money($invoice->total, $invoice->currencyid);
    } else {
        $row[] = '<a href="' . admin_url('subscriptions/edit/' . $aRow['subscription_id']) . '" target="_blank">' . $sub->hash;
        $row[] = $sub->status;
        $row[] = $subtext;
    }
    $row[] = '<a href="' . $productLink . '" target="_blank">' . $product->name . '</a>';
    $row[] = $aRow['quantity'];
    $row[] = '<a href="' . admin_url('clients/client/' . $aRow['client_id']) . '" target="_blank">' . $company . '</a>';
    // $row[] = '<a href="' .  admin_url('clients/client/' . $aRow['client_id']) . '?group=contacts" target="_blank">' . $name . '</a>';
    $row[] = _dt($aRow['created_at']);

    // Custom fields add values
    foreach ($customFieldsColumns as $customFieldColumn) {
        $row[] = (strpos($customFieldColumn, 'date_picker_') !== false ? _d($aRow[$customFieldColumn]) : $aRow[$customFieldColumn]);
    }

    $output['aaData'][] = $row;
}
