<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: supplier 
Description: Module for supplier 
Version: 2.3.4
Requires at least: 2.3.*
*/


if (!defined('MODULE_SUPPLIER')) {
    define('MODULE_SUPPLIER', basename(__DIR__));
}



hooks()->add_action('after_custom_profile_tab_content', 'supplier_content_tab_product_service',10,1);
hooks()->add_action('after_customer_admins_tab', 'supplier_tab_product_services',10,1);
hooks()->add_action('admin_init', 'supplier_module_init_menu_items');
hooks()->add_action('admin_init', 'supplier_permissions');
hooks()->add_filter('customers_table_sql_where', 'supplier_client_sql_where',10,1);
hooks()->add_action('clients_init', 'supplier_clients_area_menu_items');
hooks()->add_filter('get_contact_permissions', 'supplier_contact_permission',10,1);
hooks()->add_filter('invoices_table_row_data', 'supplier_invoices_table_row_data',10,2);
function supplier_invoices_table_row_data( $row, $aRow){
    $client = get_client($aRow['clientid']);
   
    if(!empty($client)){
        if($client->is_supplier !=0){

            $row[5] =  '<a href="'.admin_url().'supplier/client/'.$aRow['clientid'].'">'.$aRow['company'].'</a>';
        }
    }
    return $row;
}

function supplier_tab_product_services($clients){

 if(isset($clients)){ 
    if($clients->is_supplier != 0){
    ?>
    <li role="presentation">
        <a href="#product_services" aria-controls="product_services" role="tab" data-toggle="tab">
        <?php echo _l('product_and_service'); ?>
        </a>
    </li>
<?php }

    }
}

function supplier_content_tab_product_service($client){
    if(!empty($client)){
    if($client->is_supplier != 0){
        $checked = '';
    ?>
    <div class="checkbox checkbox-info mbot20 no-mtop is_preffered" style="display: none;">

        <?php
         if (isset($client) && ($client->is_supplier == 1)) {
            $checked =  ' checked';
          }
           ?>
                     <input type="checkbox" name="is_preffered" <?php echo $checked;?> value="1" id="is_preffered">
                     <label for="is_preffered"><?php echo _l('preffered_supplier'); ?></label>
                  </div><?php 
        $CI = &get_instance();
        $CI->load->model(MODULE_SUPPLIER.'/items_model');
        $CI->load->model('taxes_model');
        $CI->load->model('invoice_items_model');
        $CI->load->model('currencies_model');
        $data['taxes']        = $CI->taxes_model->get();
        $data['items_groups'] = $CI->invoice_items_model->get_groups();
        $data['items'] = $CI->items_model->get();
        $data['currencies'] = $CI->currencies_model->get();
        $data['base_currency'] = $CI->currencies_model->get_base_currency();
        $data['client'] = $client;
        $data['CI'] = $CI;
        if(isset($client)){ 
            $CI->load->view(MODULE_SUPPLIER . '/admin/suppliers/items/manage',$data); 
             
         }
     }
 }
}


function supplier_contact_permission($permissions){
        $item = array(
            'id'         => 7,
            'name'       => _l('items'),
            'short_name' => 'items',
        );
        $permissions[] = $item;
      return $permissions;

}
function supplier_client_sql_where($where){
    array_push($where, 'AND '.db_prefix().'clients.is_supplier =0');
    return $where;
}


function supplier_permissions() {
    $capabilities = [];

    $capabilities['capabilities'] = [
            'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
            'create' => _l('permission_create'),
            'edit'   => _l('permission_edit'),
            'delete' => _l('permission_delete'),
    ];
    if (function_exists('register_staff_capabilities')) {
        register_staff_capabilities('supplier', $capabilities, _l('supplier'));
    }
}
function supplier_clients_area_menu_items()
{   

    // Show menu item only if client is logged in
    if (is_client_logged_in()) {

        add_theme_menu_item('product-services-in-item-id', [
                    'name'     => _l('product_and_service'),
                    'href'     => site_url('supplier/product_services/'),
                    'position' => 21,
        ]);
    }
}
/**
* Register activation module hook
*/
register_activation_hook(MODULE_SUPPLIER, 'supplier_module_activation_hook');

function supplier_module_activation_hook() {
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}
/**
* Load the module helper
*/
get_instance()->load->helper(MODULE_SUPPLIER . '/supplier');

// print_r(MODULE_SUPPLIER );exit;
/**
* Register language files, must be registered if the module is using languages
*/

register_language_files(MODULE_SUPPLIER, [MODULE_SUPPLIER]);

/**
 * Init supplier module menu items in setup in admin_init hook
 * @return null
 */

function supplier_module_init_menu_items() {
    $CI = &get_instance();

    $CI->app->add_quick_actions_link([
        'name'       => _l('suppliers'),
        'url'        => 'suppliers',
        'permission' => 'supplier',
        'position'   => 57,
    ]);

    // if (has_permission('supplier', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('supplier', [
            'slug'     => 'supplier',
            'name'     => _l('suppliers'),
            'position' => 5,
            'icon'     => 'fa fa-user',
            'href'     => admin_url('supplier')
        ]);
        $CI->app_tabs->add_customer_profile_tab('map', [
        'name'     => _l('customer_map'),
        'icon'     => 'fa fa-map-marker',
        'view'     => 'admin/clients/groups/map',
        'position' => 95,
    ]);
    // }
    // auto create custom js file
    if (!file_exists(APP_MODULES_PATH.MODULE_SUPPLIER.'/assets/js')) {
        mkdir(APP_MODULES_PATH.MODULE_SUPPLIER.'/assets/js',0755,true);
        file_put_contents(APP_MODULES_PATH.MODULE_SUPPLIER.'/assets/js/'.MODULE_SUPPLIER.'.js', '');
    }
    //  auto create custom css file
    if (!file_exists(APP_MODULES_PATH.MODULE_SUPPLIER.'/assets/css')) {
        mkdir(APP_MODULES_PATH.MODULE_SUPPLIER.'/assets/css',0755,true);
        file_put_contents(APP_MODULES_PATH.MODULE_SUPPLIER.'/assets/css/'.MODULE_SUPPLIER.'.css', '');
    }
    $CI->app_css->add(MODULE_SUPPLIER.'-css', base_url('modules/'.MODULE_SUPPLIER.'/assets/css/'.MODULE_SUPPLIER.'.css'));
    $CI->app_scripts->add(MODULE_SUPPLIER.'-js', base_url('modules/'.MODULE_SUPPLIER.'/assets/js/'.MODULE_SUPPLIER.'.js'));

}
