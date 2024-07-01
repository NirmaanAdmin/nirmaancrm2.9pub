<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_123 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance();
        $CI->db->query(
            "CREATE TABLE IF NOT EXISTS " . db_prefix() . "product_purchase_log(
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
            `invoice_id` INT DEFAULT NULL,
            `product_id` INT DEFAULT NULL,
            `subscription_id` INT DEFAULT NULL,
            `contact_id` INT NOT NULL,
            `client_id` INT NOT NULL,
            `quantity` INT NOT NULL,
            `created_at` DATETIME,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
        );
    }
}
