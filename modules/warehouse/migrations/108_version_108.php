<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_108 extends App_module_migration
{
     public function up()
     {   
     	//update Set the selling price rule according to profit ratio
     	$CI = &get_instance();
        if (warehouse_row_options_exist('"warehouse_selling_price_rule_profif_ratio"') == 0){
            $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("warehouse_selling_price_rule_profif_ratio", "0", "1");
          ');
        }

        if (!$CI->db->field_exists('profif_ratio' ,db_prefix() . 'items')) { 
			  $CI->db->query('ALTER TABLE `' . db_prefix() . "items`
			      ADD COLUMN `profif_ratio` text  NULL
			  ;");
		} 

        /*value 0 purchase price, 1 selling price*/
        $CI = &get_instance();
        if (warehouse_row_options_exist('"profit_rate_by_purchase_price_sale"') == 0){
            $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("profit_rate_by_purchase_price_sale", "0", "1");
          ');
        }

        $CI = &get_instance();
        if (warehouse_row_options_exist('"warehouse_the_fractional_part"') == 0){
            $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("warehouse_the_fractional_part", "0", "1");
          ');
        }
        
        $CI = &get_instance();
        if (warehouse_row_options_exist('"warehouse_integer_part"') == 0){
            $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("warehouse_integer_part", "0", "1");
          ');
        }


        
     }
}
