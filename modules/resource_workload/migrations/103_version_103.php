<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_103 extends App_module_migration
{
    public function up()
    {
        $CI = &get_instance(); 
        if (!$CI->db->table_exists(db_prefix() . 'workload_dayoff')) {
            $CI->db->query('CREATE TABLE `' . db_prefix() . "workload_dayoff` (
              `id` INT(11) NOT NULL AUTO_INCREMENT,
                  `reason` VARCHAR(255) NOT NULL,
                  `date` DATE NOT NULL,
                  PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
        }

      if (!$CI->db->field_exists('addedfrom', 'workload_dayoff')) {
        $CI->db->query('ALTER TABLE `'.db_prefix() . 'workload_dayoff` 
        ADD COLUMN `addedfrom` INT(11) NOT NULL,
        ADD COLUMN `datecreated` DATETIME NOT NULL
        ;');            
        }

      if (!$CI->db->table_exists(db_prefix() . 'standard_workload')) {
          $CI->db->query('CREATE TABLE `' . db_prefix() . "standard_workload` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `staffid` INT(11) NOT NULL,
            `standard_workload` VARCHAR(45) NOT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
      }

       if (!$CI->db->field_exists('monday', 'standard_workload')) {
        $CI->db->query('ALTER TABLE `'.db_prefix() . 'standard_workload` 
        CHANGE COLUMN `standard_workload` `monday` VARCHAR(45) NULL ,
        ADD COLUMN `tuesday` VARCHAR(45) NULL,
        ADD COLUMN `wednesday` VARCHAR(45) NULL,
        ADD COLUMN `thursday` VARCHAR(45) NULL,
        ADD COLUMN `friday` VARCHAR(45) NULL,
        ADD COLUMN `saturday` VARCHAR(45) NULL,
        ADD COLUMN `sunday` VARCHAR(45) NULL;
        ;');            
      }
    }
}
