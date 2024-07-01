<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_121 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();
        $CI->load->dbforge();
        $fields = array(
            'tax_1' => array(
                'name' => 'tax_1',
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        );
        $CI->dbforge->modify_column('invoice_products', $fields);
    }
}
