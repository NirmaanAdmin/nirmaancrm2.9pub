<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_107 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();     
		$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("allow_attendance_by_coordinates", "0", "1");
			');
		if (!$CI->db->table_exists(db_prefix() . 'timesheets_workplace')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_workplace` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` varchar(200) NOT NULL,
				`workplace_address` varchar(400) NULL,
				`latitude` varchar(30),
				`longitude` varchar(30),
				`distance` double,
				`default` bit NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
		}
		if (!$CI->db->table_exists(db_prefix() . 'timesheets_workplace_assign')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_workplace_assign` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`staffid` int(11) NOT NULL,
				`workplace_id` int(11) NOT NULL,
				`datecreator` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
		}
		if (!$CI->db->field_exists('relate_id' ,db_prefix() . 'timesheets_timesheet')) {
			$CI->db->query('ALTER TABLE `' . db_prefix() . 'timesheets_timesheet`
				ADD COLUMN `relate_id` INT(11) NULL AFTER `overtime_setting`;');
		}
		if (!$CI->db->field_exists('relate_type' ,db_prefix() . 'timesheets_timesheet')) {
			$CI->db->query('ALTER TABLE `' . db_prefix() . 'timesheets_timesheet`
				ADD COLUMN `relate_type` varchar(25) NULL AFTER `relate_id`;');
		}
	}
}