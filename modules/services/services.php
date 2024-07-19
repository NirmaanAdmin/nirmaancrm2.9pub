<?php

/**
 * Ensures that the module init file can't be accessed directly, only within the application.
 */

defined('BASEPATH') or exit('No direct script access allowed');
/*
Module Name: Products [Subscription and Invoice]
Description: Allows Customers Subscribe to Stripe subscriptions from customer portal and purchase products using Invoices
Author: Boxvibe Technologies [Tecy4m]
Author URI: https://www.boxvibe.com
Version: 1.3.2
Requires at least: 2.4.4
*/

// runs when module is been activated
register_activation_hook('services', 'setup_services_module');

// add menu for admin
hooks()->add_action('admin_init', 'subscriptionProducts_menu');

//add menu item for client 
hooks()->add_action('clients_init', 'subscriptionProducts_client_menu_items');

//add menu item for guest 
hooks()->add_action('clients_init', 'subscriptionProducts_public_menu_items');

// adds translation file
register_language_files('services', ['subscription_product']);

// ads help option
hooks()->add_filter('module_services_action_links', 'services_module_action_links');

// add css in head
hooks()->add_action('app_customers_head', 'services_module_css');

hooks()->add_filter('other_merge_fields_available_for', 'subscription_products_other_merge_fields');

hooks()->add_filter('available_tracking_templates', 'subscription_products_tracking');

hooks()->add_action('after_cron_run', 'subscription_renewal_notification');

add_module_support('services', 'my_prefixed_view_files');
/**
 * creates db operations for subscription products
 */
function setup_services_module()
{
    require(__DIR__ . '/install.php');
}

/**
 *  registers menu item for admin
 */
function subscriptionProducts_menu()
{
    if (has_permission('subscriptions', '', 'view')) {

        $CI = &get_instance();
        // $CI->app_menu->add_sidebar_menu_item('products_', [
        //     'name'     => _l('products'),
        //     'collapse' => true,
        //     'position' => 16,
        //     'icon'     => 'fa fa-product-hunt',
        // ]);

        $CI->app_menu->add_sidebar_children_item('products_', [
            'slug'     => 'services_products_invoice',
            'name'     => _l('invoice_products'),
            'href'     => admin_url('services/products/invoice'),
            'position' => 5,
        ]);

        $CI->app_menu->add_sidebar_children_item('products_', [
            'slug'     => 'services_products_subscription',
            'name'     => _l('subscription_products'),
            'href'     => admin_url('services/products/subscription'),
            'position' => 10,
        ]);

        $CI->app_menu->add_sidebar_children_item('products_', [
            'slug'     => 'services_products_groups',
            'name'     => _l('product_groups'),
            'href'     => admin_url('services/products/groups'),
            'position' => 16,
        ]);

        $CI->app_menu->add_sidebar_children_item('products_', [
            'slug'     => 'product_purchase_log',
            'name'     => _l('product_menu_purchase_log'),
            'href'     => admin_url('services/products/purchase_log'),
            'position' => 16,
        ]);
    }
}

/**
 * registers menu item for client
 */
function subscriptionProducts_client_menu_items()
{
    if (is_client_logged_in()) {
        add_theme_menu_item('Products', [
            'name' => _l('products'),
            'href' => site_url('services'),
            'position' => 2,
        ]);
    }
}

/**
 * gets group in db
 * @param int $id group id
 * @return object row in db. uses ->name to get name.
 */
function get_group_name($id)
{
    $CI =  &get_instance();
    $CI->load->model('client_groups_model');
    return $CI->client_groups_model->get_groups($id);
}

/**
 * adds help module button on modules page
 * @param array $actions  current actions
 * @return array 
 */
function services_module_action_links($actions)
{
    $actions[] = '<a href="https://www.boxvibe.com/support?envato_item_id=26621431" target="_blank">' . _l('help') . '</a>';
    return $actions;
}

/**
 * Injects theme CSS
 * @return null
 */
function services_module_css()
{
    echo '<link href="' . module_dir_url('services', 'assets/services.css?v=1.1.0') . '"  rel="stylesheet" type="text/css" >';
}

/**
 * registers menu item for guest
 */
function subscriptionProducts_public_menu_items()
{
    if (get_option('subscription_product_public') != 0) {

        if (!is_client_logged_in()) {
            add_theme_menu_item('Products', [
                'name' => _l('products'),
                'href' => site_url('services/public'),
                'position' => 2,
            ]);
        }
    }
}


/**
 * send renewal notification to customer with cron
 * @param void
 */
function subscription_renewal_notification()
{
    $CI = &get_instance();
    $CI->load->model('subscriptions_model', 'sbm');
    $CI->load->model('services/subscription_products_model', 'spm');
    $subscriptions = $CI->sbm->get(" status = 'active'");
    $subscriptions = $CI->db->query("SELECT hash,last_notified FROM " . db_prefix() . "subscriptions WHERE status = 'active'")->result();;

    foreach ($subscriptions as $subscription) {
        $last_notified = $subscription->last_notified;
        $subscription = $CI->sbm->get_by_hash($subscription->hash);
        if ($subscription) {

            if (send_subscription_reminder($last_notified, $subscription->next_billing_cycle)) {
                $CI->spm->send_email_template(
                    $subscription->id,
                    subscriptionProductStaffCCForMailTemplate($subscription->created_from),
                    'subscription_products_to_customer'
                );

                $CI->sbm->update(
                    $subscription->id,
                    ['last_notified' => date('Y-m-d')]
                );
            }
        }
    }
}

/**
 * checks if email should be sent 
 * @param $next_billing_cycle renewal date timestamp
 * @param date $last_notified last notification date
 * @return boolean true if should be sent else false
 */

function send_subscription_reminder($last_notified, $next_billing_cycle)
{
    $notify_days = json_decode(get_option('subscription_product_notify_days'));

    foreach ($notify_days as $day) {
        echo "\n";
        $_last_notified = is_null($last_notified) ? 0 : $last_notified;
        $today = date('Y-m-d');
        $comparedate = date('Y-m-d', strtotime($today . '+' . $day . ' days'));
        $_next_billing_cycle = date('Y-m-d', $next_billing_cycle);

        if (($_last_notified != $today) &&  $_next_billing_cycle == $comparedate) {
            return true;
        }
    }
    return false;
}

function subscription_products_other_merge_fields($for)
{
    $for[] = 'subscription';
    return $for;
}

function subscription_products_tracking($slugs)
{
    array_push($slugs, 'subscription-products-to-customer');
    return $slugs;
}

function subscriptionProductStaffCCForMailTemplate($staff_id)
{
    $CI = &get_instance();
    $CI->db->select('email')
        ->from(db_prefix() . 'staff')
        ->where('staffid', $staff_id);
    $staff = $CI->db->get()->row();

    $cc = '';
    if ($staff) {
        $cc = $staff->email;
    }

    return $cc;
}

/**
 * Register new custom fields for
 */
hooks()->add_action('after_custom_fields_select_options', 'services_module_custom_fields');
function services_module_custom_fields($custom_field)
{
    $selected = (isset($custom_field) && $custom_field->fieldto == 'products') ? 'selected' : '';
    echo '<option value="products"  ' . ($selected) . '>' . _l('invoice_subscription_products') . '</option>';
}


$CI = &get_instance();
$CI->load->helper('services/services');
