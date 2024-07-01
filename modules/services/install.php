<?php
defined('BASEPATH') or exit('No direct script access allowed');

add_option('subscription_product_notify_days', '["7","3"]');
add_option('subscription_product_public', '0');
add_option('enable_subscription_products_view', '1');
add_option('enable_invoice_products_view', '0');
add_option('enable_products_more_info_button', '0');
add_option('show_product_quantity_field', '0');
add_option('hide_invoice_subcription_group_from_client_side', '');

$CI = &get_instance();
$CI->db->query(
    "CREATE TABLE IF NOT EXISTS " . db_prefix() . "subscription_products(
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
        `name` VARCHAR(255) NOT NULL,
        `description` TEXT DEFAULT NULL,
        `long_description` TEXT DEFAULT NULL,
        `price` int NOT NULL,
        `period` VARCHAR(255) NOT NULL,
        `description_in_item` INT DEFAULT NULL,
        `stripe_plan_id` VARCHAR(255) NOT NULL,
        `terms` TEXT DEFAULT NULL,
        `stripe_tax_id` varchar(50) ,
        `currency` INT NOT NULL,
        `count` INT NOT NULL,
        `group` INT DEFAULT NULL,
        `client_id` INT DEFAULT NULL,
        `customer_group` INT DEFAULT NULL,
        `created_from` INT DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"

);

create_email_template('Your subscription will be renewed soon !', '<span> Hello {contact_firstname} ,&nbsp;</span><br /><br />Your Subscription will be expiring soon. Details below.<br /><br />view link : {subscription_link}<br /><br /><br />Kind Regards<br /><br /><span>{email_signature}</span>', 'subscriptions', 'subscription renewal notification (Sent to customer)', 'subscription-products-to-customer');

$CI->db->query(
    "CREATE TABLE IF NOT EXISTS " . db_prefix() . "products_groups(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(100) NOT NULL,
    `order` VARCHAR(100) DEFAULT NULL,
    `color` VARCHAR(100) DEFAULT NULL,
    PRIMARY KEY (`id`)

    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
);

$CI->db->query(
    "CREATE TABLE IF NOT EXISTS " . db_prefix() . "invoice_products(
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(255) NOT NULL,    
    `description` VARCHAR(255) NOT NULL,    
    `long_description` TEXT  DEFAULT NULL,
    `price` VARCHAR(15),
    `group` INT DEFAULT NULL,
    `itemid` INT DEFAULT NULL,
    `image` VARCHAR(255) DEFAULT NULL,
    `tax_1` VARCHAR(255) DEFAULT NULL,   
    `tax_2` INT DEFAULT NULL,
    `is_recurring` INT DEFAULT NULL,
    `interval` INT DEFAULT NULL,
    `interval_type` varchar(15) DEFAULT NULL,
    `cycle` INT DEFAULT NULL,
    `created_from` INT DEFAULT NULL,
    `currency` INT DEFAULT NULL,
    `client_id` INT DEFAULT NULL,
    `customer_group` INT DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;"
);

if (!$CI->db->field_exists('group', 'subscription_products')) {
    $CI->load->dbforge();
    $fields =  array(
        'group' => array(
            'type' => 'INT',
            'constraint' => 9,
            'null' => TRUE
        )
    );
    $CI->dbforge->add_column('subscription_products', $fields);
}

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
