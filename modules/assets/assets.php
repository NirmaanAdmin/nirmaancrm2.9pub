<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Asset Management
Description: Asset management module, allocation, recovery, depreciation, asset status
Version: 1.0.0
Requires at least: 2.3.*
*/

define('ASSETS_MODULE_NAME', 'assets');
define('ASSETS_PATH', 'modules/assets/uploads/');
define('ASSETS_UPLOAD_FOLDER', module_dir_path(ASSETS_MODULE_NAME, 'uploads'));

hooks()->add_action('admin_init', 'assets_permissions');
hooks()->add_action('admin_init', 'assets_module_init_menu_items');
hooks()->add_action('app_admin_head', 'assets_add_head_components');

/**
 * Injects needed CSS
 */
function assets_add_head_components(){
        $CI = &get_instance();
        echo '<link href="' . base_url('modules/assets/css/style.css') .'?v=' . $CI->app_scripts->core_version(). '"  rel="stylesheet" type="text/css" />';
}

/**
* Register activation module hook
*/
register_activation_hook(ASSETS_MODULE_NAME, 'assets_module_activation_hook');
/**
* Load the module helper
*/
$CI = & get_instance();

function assets_module_activation_hook()
{
    $CI = &get_instance();
    require_once(__DIR__ . '/install.php');
}

/**
* Register language files, must be registered if the module is using languages
*/
register_language_files(ASSETS_MODULE_NAME, [ASSETS_MODULE_NAME]);

$CI = & get_instance();
$CI->load->helper(ASSETS_MODULE_NAME . '/asset');
/**
 * Init goals module menu items in setup in admin_init hook
 * @return null
 */
function assets_module_init_menu_items()
{
    
    $CI = &get_instance();
    if (has_permission('assets', '', 'view') || is_admin()) {

        $CI->app_menu->add_sidebar_menu_item('assets', [
            'name'     => _l('assets'),
            'icon'     => 'fa fa-bank',
            'position' => 40,
        ]);
        $CI->app_menu->add_sidebar_children_item('assets', [
            'slug'     => 'assets_menu',
            'name'     => _l('asset'),
            'icon'     => 'fa fa-bank',
            'href'     => admin_url('assets/manage_assets'),
            'position' => 1,
        ]);

        $CI->app_menu->add_sidebar_children_item('assets', [
            'slug'     => 'allocations',
            'name'     => _l('allocation'),
            'icon'     => 'fa fa-pencil-square-o',
            'href'     => admin_url('assets/allocation'),
            'position' => 2,
        ]);

        $CI->app_menu->add_sidebar_children_item('assets', [
            'slug'     => 'evictions',
            'name'     => _l('eviction'),
            'icon'     => 'fa fa-pencil-square',
            'href'     => admin_url('assets/eviction'),
            'position' => 3,
        ]);

        $CI->app_menu->add_sidebar_children_item('assets', [
            'slug'     => 'depreciations',
            'name'     => _l('depreciation'),
            'icon'     => 'fa fa-legal',
            'href'     => admin_url('assets/depreciation'),
            'position' => 4,
        ]);
        $CI->app_menu->add_sidebar_children_item('assets', [
            'slug'     => 'settings',
            'name'     => _l('setting'),
            'icon'     => 'fa fa-cogs',
            'href'     => admin_url('assets/setting'),
            'position' => 5,
        ]);
    }
    
}
function assets_permissions()
{
    $capabilities = [];

    $capabilities['capabilities'] = [
            'view'   => _l('permission_view') . '(' . _l('permission_global') . ')',
            'create' => _l('permission_create'),
            'edit'   => _l('permission_edit'),
            'delete' => _l('permission_delete'),
    ];

    register_staff_capabilities('assets', $capabilities, _l('assets'));
}