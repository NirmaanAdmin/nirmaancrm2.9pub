<?php
/*
Module Name: Ultimate Purple Theme for Perfex
Description: Ultimate Description: Ultimate Purple Theme for Perfex
 Theme for Perfex
Version: 2.2.0
Author: Dweb Digital Solutions
Author URI: https://dweb.digital
Requires at least: 2.3.2
*/
defined('BASEPATH') or exit('No direct script access allowed');
hooks()->add_action('app_admin_head', 'admin_theme_head_component');
hooks()->add_action('admin_init', 'ultimate_purple_theme_settings_tab');
hooks()->add_action('app_admin_authentication_head', 'admin_theme_staff_login');
hooks()->add_action('app_admin_footer', 'ultimate_theme_admin_theme_footer');
function ultimate_theme_admin_theme_footer(){
    echo '<script src="' . base_url('modules/ultimate_purple_theme/assets/js/ultimate-theme.js') . '"></script>';
}
// Check if customers theme is enabled
if (get_option('ultimate_purple_theme_customers') == '1') {
    hooks()->add_action('app_customers_head', 'app_purple_head');
}
/**
 * Theme customers login includes
 * @return stylesheet / script
 */
function admin_theme_staff_login(){
    $primary_U_color = get_option('u_t_primary_color');
    $secondary_U_color = get_option('u_t_secondary_color');
    if (empty($primary_U_color) && empty($secondary_U_color)) {
        echo "<style>:root {--primary-color: #4332d2;--secondary-color: #2f229d;}</style>";
    } else {
        echo "<style>:root {--primary-color: " . get_option('u_t_primary_color') . "; --secondary-color: " . get_option('u_t_secondary_color') . ";}</style>";
    }
    echo '<link href="' . base_url('modules/ultimate_purple_theme/assets/css/staff_login_styles.css') . '"  rel="stylesheet" type="text/css" >';
}
/**
 * Theme clients footer includes
 * @return stylesheet
 */
function app_purple_head(){
    $primary_U_color = get_option('u_t_primary_color');
    $secondary_U_color = get_option('u_t_secondary_color');
    if (empty($primary_U_color) && empty($secondary_U_color)) {
        echo "<style>:root {--primary-color: #4332d2;--secondary-color: #2f229d;}</style>";
    } else {
        echo "<style>:root {--primary-color: " . get_option('u_t_primary_color') . "; --secondary-color: " . get_option('u_t_secondary_color') . ";}</style>";
    }
    
    echo '<link href="' . base_url('modules/ultimate_purple_theme/assets/css/clients/clients.css') . '"  rel="stylesheet" type="text/css" >';
    
}
/**
 * [ultimate_purple_theme_settings_tab net menu item in setup->settings]
 * @return void
 */
function ultimate_purple_theme_settings_tab(){
    $CI = &get_instance();
    $CI->app_tabs->add_settings_tab('admin-theme-settings', [
        'name'     => '' . _l('Ultimate Theme Config') . '',
        'view'     => 'ultimate_purple_theme/admin_theme_settings',
        'position' => 46,
    ]);
}
/**
 * Injects theme CSS
 * @return null
 */
function admin_theme_head_component(){
    $primary_U_color = get_option('u_t_primary_color');
    $secondary_U_color = get_option('u_t_secondary_color');
    if (empty($primary_U_color) && empty($secondary_U_color)) {
        echo "<style>:root {--primary-color: #4332d2;--secondary-color: #2f229d;}</style>";
    } else {
        echo "<style>:root {--primary-color: " . get_option('u_t_primary_color') . "; --secondary-color: " . get_option('u_t_secondary_color') . ";}</style>";
    }
    echo '<link href="' . base_url('modules/ultimate_purple_theme/assets/css/theme_styles.css') . '"  rel="stylesheet" type="text/css" >';
    
}
/**
 * Changes task filters color and background
 * @return array
 */
hooks()->add_action('app_init', 'initialize_ultimate_purple_theme_task_filters');
/**
 * Changes system favorite colors
 * @return array
 */
hooks()->add_filter('system_favourite_colors', 'admin_purple_system_colors_theme_hook');
function admin_purple_system_colors_theme_hook($colors){
    foreach ($colors as $key => $color) {
        if ($color == '#ff2d42') {
            $colors[$key] = '#ff0019';
        }
        if ($color == '#28B8DA') {
            $colors[$key] = '#E9751E';
        }
        if ($color == '#03a9f4') {
            $colors[$key] = '#2a44c5';
        }
        if ($color == '#757575') {
            $colors[$key] = '#595959';
        }
        if ($color == '#8e24aa') {
            $colors[$key] = '#cc0099';
        }
        if ($color == '#d81b60') {
            $colors[$key] = '#F86A00';
        }
        if ($color == '#0288d1') {
            $colors[$key] = '#3333ff';
        }
        if ($color == '#7cb342') {
            $colors[$key] = '#2eb82e';
        }
        if ($color == '#fb8c00') {
            $colors[$key] = '#e67e00';
        }
        if ($color == '#84C529') {
            $colors[$key] = '#71a923';
        }
        if ($color == '#fb3b3b') {
            $colors[$key] = '#fa1e1e';
        }
    }
    return $colors;
}
function initialize_ultimate_purple_theme_task_filters(){
    hooks()->add_filter('before_get_task_statuses', 'admin_purple_dashboard_label_task_colors');
}
function admin_purple_dashboard_label_task_colors($statuses){
    $CI = &get_instance();
    if (!class_exists('tasks_model', false)) {
        $CI->load->model('tasks_model');
    }
    foreach ($statuses as $key => $status) {
        $id = $status['id'];
        switch ($id) {
            case $id == Tasks_model::STATUS_NOT_STARTED:
                $statuses[$key]['color'] = '#ffb822';
                break;
            case $id == Tasks_model::STATUS_AWAITING_FEEDBACK:
                $statuses[$key]['color'] = '#0abb87';
                break;
            case $id == Tasks_model::STATUS_IN_PROGRESS:
                $statuses[$key]['color'] = '#764abc';
                break;
            case $id == Tasks_model::STATUS_COMPLETE:
                $statuses[$key]['color'] = '#84c529';
                break;
        }
    }
    return $statuses;
}
/**
 * Changes project filters color
 * @return array
 */
hooks()->add_action('app_init', 'initialize_ultimate_purple_theme_project_filters');
function initialize_ultimate_purple_theme_project_filters(){
    hooks()->add_filter('before_get_project_statuses', 'admin_purple_dashboard_label_project_colors');
}
function admin_purple_dashboard_label_project_colors($statuses){
    foreach ($statuses as $key => $status) {
        $id = $status['id'];
        switch ($id) {
            case $id == 3:
                $statuses[$key]['color'] = '#ffb822';
                break;
            case $id == 4:
                $statuses[$key]['color'] = '#0abb87';
                break;
            case $id == 1:
                $statuses[$key]['color'] = '#777777';
                break;
            case $id == 2:
                $statuses[$key]['color'] = '#764abc';
                break;
            case $id == 5:
                $statuses[$key]['color'] = 'rgb(250, 30, 30)';
                break;
        }
    }
    return $statuses;
}