<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_130 extends App_module_migration
{
    public function up()
    {
        add_option('hide_invoice_subcription_group_from_client_side', '');

        $CI = &get_instance();

        if (!$CI->db->field_exists('order', db_prefix() . 'products_groups')) {
            $this->db->query(
                'ALTER TABLE `' . db_prefix() . 'products_groups` ADD `order` INT DEFAULT NULL AFTER `name`;'
            );
        }

        $CI->db->where('order', null);
        $result = $CI->db->get(db_prefix() . 'products_groups')->result();
        foreach ($result as $group) {
            $CI->db->where('id', $group->id);
            $CI->db->update(db_prefix() . 'products_groups', ['order' => $group->id]);
        }
    }
}
