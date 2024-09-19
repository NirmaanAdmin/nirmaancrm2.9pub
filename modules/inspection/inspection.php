<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: inspection
Description: Default module for defining inspection
Version: 2.3.0
Requires at least: 2.3.*
*/

define('INSPECTION_MODULE_NAME', 'inspection');

hooks()->add_action('admin_init', 'inspection_module_init_menu_items');

/**
* Register activation module hook
*/
register_activation_hook(INSPECTION_MODULE_NAME, 'inspection_module_activation_hook');

/**
* Load the module helper
*/
$CI = & get_instance();
$CI->load->helper(INSPECTION_MODULE_NAME . '/inspection');

function inspection_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(INSPECTION_MODULE_NAME, [INSPECTION_MODULE_NAME]);

/**
 * Init inspection module menu items in setup in admin_init hook
 * @return null
 */
function inspection_module_init_menu_items()
{
    $CI = &get_instance();

    $CI->app_menu->add_sidebar_menu_item('quality', [
        'name'     => _l('quality'),
        'href'     => admin_url('inspection'),
        'icon'     => 'fa fa-suitcase',
        'position' => 6,
        'badge'    => [],
    ]);
}

?>
