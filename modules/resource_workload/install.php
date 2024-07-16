<?php
defined('BASEPATH') or exit('No direct script access allowed');
add_option('standard_workload', 8);
$i = count($CI->db->query('Select * from ' . db_prefix() . 'customfields where fieldto = "tasks" and slug = "tasks_estimate_hour"')->result_array());
if ($i == 0) {
	$CI->db->query("INSERT INTO `" . db_prefix() . "customfields` (`fieldto`, `name`, `slug`, `required`, `type`, `options`, `display_inline`, `field_order`, `active`, `show_on_pdf`, `show_on_ticket_form`, `only_admin`, `show_on_table`, `show_on_client_portal`, `disalow_client_to_edit`, `bs_column`) VALUES ('tasks', 'Estimate hour', 'tasks_estimate_hour', '0', 'number', '', '0', '0', '1', '0', '0', '0', '0', '0', '0', '12');");
	return 0;
}
add_option('staff_workload_monday', 1);
add_option('staff_workload_tuesday', 1);
add_option('staff_workload_thursday', 1);
add_option('staff_workload_wednesday', 1);
add_option('staff_workload_friday', 1);
add_option('staff_workload_saturday', 0);
add_option('staff_workload_sunday', 0);

add_option('staff_workload_monday_visible', 1);
add_option('staff_workload_tuesday_visible', 1);
add_option('staff_workload_thursday_visible', 1);
add_option('staff_workload_wednesday_visible', 1);
add_option('staff_workload_friday_visible', 1);
add_option('staff_workload_saturday_visible', 1);
add_option('staff_workload_sunday_visible', 1);

add_option('integrated_timesheet_holiday', 0);
add_option('integrated_timesheet_leave', 0);
add_option('staff_workload_exception', '');

// Version 1.0.3
if (!$CI->db->table_exists(db_prefix() . 'workload_dayoff')) {
    $CI->db->query('CREATE TABLE `' . db_prefix() . "workload_dayoff` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
			  `reason` VARCHAR(255) NOT NULL,
			  `date` DATE NOT NULL,
			  PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
}

if (!$CI->db->field_exists('addedfrom', db_prefix() . 'workload_dayoff')) {
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

if (!$CI->db->field_exists('monday', db_prefix() . 'standard_workload')) {
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