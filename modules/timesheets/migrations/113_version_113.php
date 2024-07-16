<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_113 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();     
		if (row_timesheets_options_exist('"start_month_for_annual_leave_cycle"') == 0){
			$CI->db->query('INSERT INTO `'.db_prefix().'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("start_month_for_annual_leave_cycle", "1", "1");');
		}

		if (row_timesheets_options_exist('"start_year_for_annual_leave_cycle"') == 0){
			$CI->db->query('INSERT INTO `'.db_prefix().'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("start_year_for_annual_leave_cycle", "'.date("Y").'", "1");');
		}

		if (row_timesheets_options_exist('"hour_notification_approval_exp"') == 0){
			$CI->db->query('INSERT INTO `'.db_prefix().'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("hour_notification_approval_exp","3", "1");');
		}
		if (!$CI->db->table_exists(db_prefix() . 'timesheets_type_of_leave')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_type_of_leave` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`type_name` varchar(200) NUll,
				`slug` varchar(200) NUll,
				`symbol` varchar(5) NUll,
				`date_creator` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
		}
		if (!$CI->db->field_exists('type_of_leave_text', db_prefix() . 'timesheets_requisition_leave')) {
			$CI->db->query('ALTER TABLE `'.db_prefix() . "timesheets_requisition_leave`
				ADD COLUMN `type_of_leave_text` varchar(200) NULL");            
		}
	}
}