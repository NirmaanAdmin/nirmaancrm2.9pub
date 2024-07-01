<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_109 extends App_module_migration
{
     public function up()
     {   
        $CI = &get_instance();
     	  
        //update auto create goods received note when create purchase order ( approval)
        //update auto create goods delivery note when create invoices ( paid)
     	
        if (warehouse_row_options_exist('"auto_create_goods_received"') == 0){
            $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("auto_create_goods_received", "0", "1");
          ');
        }


        if (warehouse_row_options_exist('"auto_create_goods_delivery"') == 0){
            $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("auto_create_goods_delivery", "0", "1");
          ');
        }
        

        if (warehouse_row_options_exist('"goods_receipt_warehouse"') == 0){
                $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("goods_receipt_warehouse", "", "1");
              ');
        }

         if ($CI->db->field_exists('warehouse_id' ,db_prefix() . 'goods_transaction_detail')) { 
              $CI->db->query('ALTER TABLE `' . db_prefix() . "goods_transaction_detail`
                    CHANGE COLUMN `warehouse_id` `warehouse_id` TEXT NOT NULL ,
                    DROP PRIMARY KEY,
                    ADD PRIMARY KEY (`id`, `commodity_id`)
              ;");
          }

          if (!$CI->db->field_exists('active' ,db_prefix() . 'items')) { 
            $CI->db->query('ALTER TABLE `' . db_prefix() . "items`
                ADD COLUMN `active` INT(11) NULL DEFAULT 1
            ;");
          }

          if (warehouse_row_options_exist('"barcode_with_sku_code"') == 0){
              $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("barcode_with_sku_code", "0", "1");
            ');
          }
    
        
     }
}
