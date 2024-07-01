<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_124 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();
        if (!$CI->db->field_exists('last_notified', 'subscriptions')) {
            $CI->load->dbforge();
            $fields =  array(
                'last_notified' => array(
                    'type' => 'DATE',
                    'null' => TRUE
                )
            );
            $CI->dbforge->add_column('subscriptions', $fields);
        }
    }
}
