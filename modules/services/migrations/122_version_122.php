<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_122 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();
        $CI->load->dbforge();
        $fields = array(
            'long_description' => array(
                'name' => 'long_description',
                'type' => 'TEXT',
                'null' => TRUE
            ),
        );
        $CI->dbforge->modify_column('subscription_products', $fields);
    }
}
