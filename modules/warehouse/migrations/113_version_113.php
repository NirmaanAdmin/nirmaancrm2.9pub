<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_113 extends App_module_migration
{
     public function up()
     {   
        $CI = &get_instance();

        if (warehouse_row_options_exist('"inventory_received_number_prefix"') == 0){
            $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("inventory_received_number_prefix", "NK", "1");
          ');
        }

        if (warehouse_row_options_exist('"next_inventory_received_mumber"') == 0){
            $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("next_inventory_received_mumber", "1", "1");
          ');
        }

        if (warehouse_row_options_exist('"inventory_delivery_number_prefix"') == 0){
            $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("inventory_delivery_number_prefix", "XK", "1");
          ');
        }

        if (warehouse_row_options_exist('"next_inventory_delivery_mumber"') == 0){
            $CI->db->query('INSERT INTO `tbloptions` (`name`,`value`, `autoload`) VALUES ("next_inventory_delivery_mumber", "1", "1");
          ');
        }
        


 

          

     }
}
