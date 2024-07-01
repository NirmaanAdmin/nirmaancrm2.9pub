<?php

defined('BASEPATH') or exit('No direct script access allowed');
add_option('staff_sync_orders');
add_option('minute_sync_orders');
add_option('time_cron_woo');
add_option('minute_sync');

add_option('sync_omni_sales_products', 1);
add_option('sync_omni_sales_orders', 1);
add_option('sync_omni_sales_inventorys', 1);
add_option('sync_omni_sales_description', 0);
add_option('sync_omni_sales_images', 0);

add_option('price_crm_woo', 0);
add_option('product_info_enable_disable', 0);
add_option('product_info_image_enable_disable', 0);

add_option('minute_sync_product_info_time1');
add_option('minute_sync_inventory_info_time2');
add_option('minute_sync_price_time3');
add_option('minute_sync_decriptions_time4');
add_option('minute_sync_images_time5');
add_option('minute_sync_product_info_time7');
add_option('minute_sync_product_info_images_time8');

add_option('records_time1', date('H:i:s'));
add_option('records_time2', date('H:i:s'));
add_option('records_time3', date('H:i:s'));
add_option('records_time4', date('H:i:s'));
add_option('records_time5', date('H:i:s'));
add_option('records_time6', date('H:i:s'));
add_option('records_time7', date('H:i:s'));
add_option('records_time8', date('H:i:s'));



if (!$CI->db->table_exists(db_prefix() . 'sales_channel')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "sales_channel` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `channel` varchar(150) NOT NULL,
      `status` varchar(15) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
    $data['channel'] = 'pos';
    $data['status'] = 'active';
    $CI->db->insert('sales_channel' , $data);
    $data['channel'] = 'portal';
    $data['status'] = 'active';
    $CI->db->insert('sales_channel' , $data);
    $data['channel'] = 'woocommerce';
    $data['status'] = 'deactive';
    $CI->db->insert('sales_channel' , $data);
}

if (!$CI->db->table_exists(db_prefix() . 'sales_channel_detailt')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "sales_channel_detailt` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `group_product_id` int(11) NOT NULL,
      `product_id` int(11) NOT NULL,
      `sales_channel_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

 
if (!$CI->db->table_exists(db_prefix() . 'woocommere_store')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "woocommere_store` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(150) NULL,
      `ip` varchar(30) NULL,
      `url` varchar(350) NULL,
      `port` varchar(10) NULL,
      `token` varchar(250) NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'cart')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "cart` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `id_contact` int(11) NOT NULL,
      `name` varchar(120) NOT NULL,
      `address` varchar(250) NOT NULL,
      `phone_number` varchar(20) NOT NULL,
      `voucher` varchar(100) NOT NULL,
      `status` int(11) null DEFAULT 0,
      `complete` int(11) null DEFAULT 0,
      `datecreator` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->table_exists(db_prefix() . 'cart_detailt')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "cart_detailt` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `product_id` int(11) NOT NULL,
      `quantity` int(11) NOT NULL,
      `classify` varchar(30) NULL,      
      `cart_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('product_name' ,db_prefix() . 'cart_detailt')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart_detailt`
      ADD COLUMN `product_name` VARCHAR(150) NULL,
      ADD COLUMN `prices` DECIMAL(15,2) NULL,
      ADD COLUMN `long_description` text NULL
  ');
}

if (!$CI->db->field_exists('order_number' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `order_number` varchar(100) NULL
  ');
}

if (!$CI->db->field_exists('channel_id' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `channel_id` int(11) NULL,
      ADD COLUMN `channel` varchar(150) NULL,
      ADD COLUMN `first_name` varchar(60) NULL,
      ADD COLUMN `last_name` varchar(60) NULL,
      ADD COLUMN `email` varchar(150) NULL
  ');
}

if (!$CI->db->table_exists(db_prefix() . 'omni_master_channel_woocommere')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "omni_master_channel_woocommere` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name_channel` TEXT NOT NULL,
      `consumer_key` TEXT NOT NULL,
      `consumer_secret` TEXT NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('url' ,db_prefix() . 'omni_master_channel_woocommere')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'omni_master_channel_woocommere`
      ADD COLUMN `url` TEXT NOT NULL
  ');
}
if (!$CI->db->field_exists('company' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `company` varchar(150) null,                  
      ADD COLUMN `phonenumber` varchar(15) null,                 
      ADD COLUMN `city` varchar(50) null,
      ADD COLUMN `state` varchar(50) null,                  
      ADD COLUMN `country` varchar(50) null,
      ADD COLUMN `zip` varchar(50) null,          
      ADD COLUMN `billing_street` varchar(150) null,                 
      ADD COLUMN `billing_city` varchar(50) null, 
      ADD COLUMN `billing_state` varchar(50) null,                 
      ADD COLUMN `billing_country` varchar(50) null,
      ADD COLUMN `billing_zip` varchar(50) null,
      ADD COLUMN `shipping_street` varchar(150) null,
      ADD COLUMN `shipping_city` varchar(50) null,
      ADD COLUMN `shipping_state` varchar(50) null,                
      ADD COLUMN `shipping_country` varchar(50) null,
      ADD COLUMN `shipping_zip` varchar(50) null
  ');
}
if (!$CI->db->field_exists('userid' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `userid` int(11) null                
     
  ');
}
if (!$CI->db->field_exists('notes' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `notes` text null                
     
  ');
}

if (!$CI->db->field_exists('reason' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `reason` varchar(250) NULL,
      ADD COLUMN `admin_action` int NULL DEFAULT 0
  ');
}

if (!$CI->db->field_exists('sku' ,db_prefix() . 'cart_detailt')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart_detailt`
      ADD COLUMN `sku` text not null                
  ');
}

if (!$CI->db->table_exists(db_prefix() . 'omni_trade_discount')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "omni_trade_discount` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name_trade_discount` varchar(250) NOT NULL,
      `start_time` date NOT NULL,
      `end_time` date NOT NULL,      
      `group_clients` TEXT NOT NULL,
      `clients` TEXT NOT NULL,
      `group_items` TEXT NOT NULL,
      `items` TEXT NOT NULL,
      `formal` int(11) NOT NULL,
      `discount` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('voucher' ,db_prefix() . 'omni_trade_discount')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'omni_trade_discount`
      ADD COLUMN `voucher` text null                
  ');
}

if (!$CI->db->field_exists('discount' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `discount` varchar(250) NULL,
      ADD COLUMN `discount_type` int NULL DEFAULT 0
  ');
}

if (!$CI->db->field_exists('total' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `total` varchar(250) NULL
  ');
}

if (!$CI->db->field_exists('sub_total' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `sub_total` varchar(250) NULL
  ');
}
if (!$CI->db->field_exists('prices' ,db_prefix() . 'sales_channel_detailt')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'sales_channel_detailt`
      ADD COLUMN `prices` DECIMAL(15,2)
  ');
}
if (!$CI->db->table_exists(db_prefix() . 'woocommere_store_detailt')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "woocommere_store_detailt` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `group_product_id` int(11) NOT NULL,
      `product_id` int(11) NOT NULL,
      `woocommere_store_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->field_exists('prices' ,db_prefix() . 'woocommere_store_detailt')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'woocommere_store_detailt`
      ADD COLUMN `prices` DECIMAL(15,2)
');}

if (!$CI->db->field_exists('discount_total' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `discount_total` varchar(250) NOT NULL DEFAULT ""
  ');
}

if (!$CI->db->field_exists('invoice' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `invoice` varchar(250) NOT NULL DEFAULT ""
  ');
}
if (!$CI->db->field_exists('number_invoice' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `number_invoice` varchar(250) NOT NULL DEFAULT ""
  ');
}

if (!$CI->db->table_exists(db_prefix() . 'omni_log_discount')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "omni_log_discount` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name_discount` varchar(250) NOT NULL,
      `client` int(11) NOT NULL,
      `price` int(11) NOT NULL,
      `product_id` int(11) NOT NULL,
      `product_quality` int(11) NOT NULL,
      `total_product` int(11) NOT NULL,
      `date_apply` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}
if (!$CI->db->field_exists('stock_export_number' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `stock_export_number` varchar(250) NOT NULL DEFAULT ""
  ');
}

if (!$CI->db->field_exists('create_invoice' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `create_invoice` varchar(5) NOT NULL DEFAULT "off",
      ADD COLUMN `stock_export` varchar(5) NOT NULL DEFAULT "off"
  ');
}

if (!$CI->db->field_exists('customers_pay' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `customers_pay` DECIMAL(15,2) NOT NULL DEFAULT 0,
      ADD COLUMN `amount_returned` DECIMAL(15,2) NOT NULL DEFAULT 0
  ');
}

if (!$CI->db->field_exists('channel' ,db_prefix() . 'omni_trade_discount')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'omni_trade_discount`
      ADD COLUMN `channel` int(11) NOT NULL DEFAULT 0,
      ADD COLUMN `store` varchar(11) NOT NULL DEFAULT ""
  ');
}

if (!$CI->db->table_exists(db_prefix() . 'omni_log_sync_woo')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "omni_log_sync_woo` (
      `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` varchar(250) NOT NULL,
      `regular_price` int(11) NOT NULL,
      `sale_price` int(11) NOT NULL,
      `date_on_sale_from` date NULL,
      `date_on_sale_to` date NULL,
      `short_description` TEXT NULL,
      `stock_quantity` int(11) NULL,
      `sku` TEXT NOT NULL,
      `type` varchar(225) NOT NULL,
      `date_sync` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('stock_quantity_history' ,db_prefix() . 'omni_log_sync_woo')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'omni_log_sync_woo`
      ADD COLUMN `stock_quantity_history` int(11) NOT NULL DEFAULT 0,
      ADD COLUMN `order_id` int(11) NOT NULL,
      ADD COLUMN `chanel` varchar(250) NOT NULL DEFAULT "",
      ADD COLUMN `company` varchar(250) NOT NULL DEFAULT ""
  ');
}

if (!$CI->db->field_exists('tax' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `tax` DECIMAL(15,2) NOT NULL DEFAULT 0
  ');
}
if (!$CI->db->field_exists('percent_discount' ,db_prefix() . 'cart_detailt')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart_detailt`
      ADD COLUMN `percent_discount`  DECIMAL(15,0) not null,                
      ADD COLUMN `prices_discount`  DECIMAL(15,2) not null                
  ');
}
if (!$CI->db->field_exists('seller' ,db_prefix() . 'cart')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'cart`
      ADD COLUMN `seller` int(11) NULL
  ');
}
if (!$CI->db->field_exists('minimum_order_value' ,db_prefix() . 'omni_trade_discount')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'omni_trade_discount`
      ADD COLUMN `minimum_order_value` DECIMAL(15,2) null              
  ');
}

if (!$CI->db->field_exists('voucher_coupon' ,db_prefix() . 'omni_log_discount')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'omni_log_discount`
      ADD COLUMN `voucher_coupon` varchar(250) null
  ');
}

if (!$CI->db->field_exists('order_number' ,db_prefix() . 'omni_log_discount')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'omni_log_discount`
      ADD COLUMN `order_number` varchar(100) null,
      ADD COLUMN `total_order` varchar(100) null,
      ADD COLUMN `discount` varchar(100) null,
      ADD COLUMN `tax` varchar(100) null,
      ADD COLUMN `total_after` varchar(100) null
  ');
}

if (!$CI->db->field_exists('channel_id' ,db_prefix() . 'omni_log_discount')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'omni_log_discount`
      ADD COLUMN `channel_id` int(11) null
  ');
}