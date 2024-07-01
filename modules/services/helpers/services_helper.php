<?php
defined('BASEPATH') or exit('No direct script access allowed');

function services_invoice_data($data, $extra, $type = '')
{
    $CI = &get_instance();
    $CI->load->model('clients_model');
    $client                       = $CI->clients_model->get($extra['clientid']);
    $new_invoice_data             = [];
    $new_invoice_data['clientid'] = $extra['clientid'];
    $new_invoice_data['number']   = get_option('next_invoice_number');
    $new_invoice_data['date']     = _d(date('Y-m-d'));
    $new_invoice_data['duedate']  = _d(date('Y-m-d', strtotime('+' . get_option('invoice_due_after') . ' DAY', strtotime(date('Y-m-d')))));

    $new_invoice_data['show_quantity_as'] = 1;
    $new_invoice_data['currency']         = $data->currency;

    if ($data->is_recurring == 1) {
        $new_invoice_data['recurring_type']   = $data->interval_type;
        $new_invoice_data['custom_recurring'] = 1;
        $new_invoice_data['recurring']        = $data->interval;
    }

    $new_invoice_data['subtotal']         = floatval($data->price) * $extra['quantity'];
    $new_invoice_data['adjustment']       = 0;
    $new_invoice_data['discount_percent'] = 0;
    $new_invoice_data['discount_total']   = 0;
    $new_invoice_data['discount_type']    = 0;

    $new_invoice_data['terms']      = clear_textarea_breaks(get_option('predefined_terms_invoice'));
    $new_invoice_data['sale_agent'] = $data->created_from;

    $new_invoice_data['billing_street']           = clear_textarea_breaks($client->billing_street);
    $new_invoice_data['billing_city']             = $client->billing_city;
    $new_invoice_data['billing_state']            = $client->billing_state;
    $new_invoice_data['billing_zip']              = $client->billing_zip;
    $new_invoice_data['billing_country']          = $client->billing_country;
    $new_invoice_data['shipping_street']          = clear_textarea_breaks($client->shipping_street);
    $new_invoice_data['shipping_city']            = $client->shipping_city;
    $new_invoice_data['shipping_state']           = $client->shipping_state;
    $new_invoice_data['shipping_zip']             = $client->shipping_zip;
    $new_invoice_data['shipping_country']         = $client->shipping_country;
    $new_invoice_data['show_shipping_on_invoice'] = 0;
    $new_invoice_data['status']                   = 1;

    if (!empty($client->shipping_street)) {
        $new_invoice_data['show_shipping_on_invoice'] = 1;
        $new_invoice_data['include_shipping']         = 1;
    }

    $new_invoice_data['clientnote']            = clear_textarea_breaks(get_option('predefined_clientnote_invoice'));
    $new_invoice_data['adminnote']             = 'created from prodducts page by client';
    $new_invoice_data['allowed_payment_modes'] = services_default_payment_gateways();

    $new_invoice_data['newitems'] = [];
    $key                          = 1;
    $items                        = 1;

    $new_invoice_data['newitems'][$key]['rate']             = $data->price;
    $new_invoice_data['newitems'][$key]['description']      = trim($data->name);
    $new_invoice_data['newitems'][$key]['long_description'] = $data->description;
    $new_invoice_data['newitems'][$key]['qty']              = $extra['quantity'];
    $new_invoice_data['newitems'][$key]['unit']             = $type;
    $new_invoice_data['newitems'][$key]['order']            = $key;
    $new_invoice_data['newitems'][$key]['taxname']          = [];

    if (isset($data->tax_1) && (!is_numeric($data->tax_1))) {
        $taxes = explode(',', $data->tax_1);

        foreach ($taxes as $t) {
            // tax name is in format TAX1|10.00
            $tax = get_tax_by_id($t);
            array_push($new_invoice_data['newitems'][$key]['taxname'], $tax->name . '|' . $tax->taxrate);
        }
    } elseif (is_numeric($data->tax_1)) {
        $tax                                           = get_tax_by_id($data->tax_1);
        $new_invoice_data['newitems'][$key]['taxname'] = [$tax->name . '|' . $tax->taxrate];
    }

    if (isset($data->tax_1) && (!is_numeric($data->tax_1))) {
        $taxes =  explode(',', $data->tax_1);
        $sum_tax = 0;
        $new_invoice_data['newitems'][$key]['taxname'] = [];
        foreach ($taxes as $t) {
            // tax name is in format TAX1|10.00
            $tax = get_tax_by_id($t);
            $sum_tax += $tax->taxrate;
            array_push($new_invoice_data['newitems'][$key]['taxname'], $tax->name . '|' . $tax->taxrate);
        }

        $totalTax = (($data->price * $extra['quantity']) *  ($sum_tax / 100));
        $new_invoice_data['total']            = ($data->price * $extra['quantity']) + $totalTax;
    } elseif (is_numeric($data->tax_1)) {
        $tax = get_tax_by_id($data->tax_1);
        $new_invoice_data['newitems'][$key]['taxname'] = [$tax->name . '|' . $tax->taxrate];
        $new_invoice_data['total']            = ($data->price * $extra['quantity']) + (($data->price * $extra['quantity']) *  ($tax->taxrate / 100));
    } else {
        $new_invoice_data['newitems'][$key]['taxname'] = [];
        $new_invoice_data['total']            = $data->price;
    }
    
    $new_invoice_data = hooks()->apply_filters('whm_invoice_data', $new_invoice_data);
    return $new_invoice_data;
}

/**
 * gets group in db
 * @param int $id group id
 * @return object row in db. uses ->name to get name.
 */
function services_get_product_group_name($id)
{
    $CI =  &get_instance();
    $CI->load->model('subscription_products_model');
    return $CI->subscription_products_model->get_group($id);
}

function services_default_payment_gateways()
{
    $CI = &get_instance();
    $CI->load->model('payment_modes_model');
    $CI->load->model('payments_model');
    $payment_modes = $CI->payment_modes_model->get('', [
        'expenses_only !=' => 1,
    ]);
    $default = [];
    foreach ($payment_modes as $mode) {
        if ($mode['selected_by_default'] == 1 && $mode['active'] == 1) {
            $default[] = $mode['id'];
        }
    }
    return $default;
}

function get_product_url($id, $name, $type)
{
    $slug = str_replace(' ', '-', strtolower($name));
    if ($type == 'invoice') {
        return site_url('services/details/inv/' . $id . '/' . $slug);
    } elseif ($type == 'subscription') {
        return site_url('services/details/sub/' . $id . '/' . $slug);
    }

    return null;
}

function services_get_product($id, $type)
{
    $CI = &get_instance();
    if ($type == 'invoice') {
        $CI->load->model('invoice_products_model');
        return $CI->invoice_products_model->get($id);
    } else {
        $CI->load->model('subscription_products_model');
        return $CI->subscription_products_model->get($id);
    }
}

function services_purchase_invoice($id)
{
    $CI = &get_instance();
    $CI->load->model('invoices_model');
    return $CI->invoices_model->get($id);
}

function services_purchased_subscription($id)
{
    $CI = &get_instance();
    $CI->load->model('subscriptions_model');
    return $CI->subscriptions_model->get_by_id($id);
}
