<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_112 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();     
		if (row_timesheets_options_exist('"auto_checkout"') == 0){
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("auto_checkout", "0", "1");
				');
		}
		if (row_timesheets_options_exist('"auto_checkout_type"') == 0){
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("auto_checkout_type", "1", "1");
				');
		}
		if (row_timesheets_options_exist('"auto_checkout_value"') == 0){
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("auto_checkout_value", "1", "1");
				');
		}
		if (!$CI->db->field_exists('workplace_id', db_prefix() . 'check_in_out')) {
			$CI->db->query('ALTER TABLE `'.db_prefix() . "check_in_out`
				ADD COLUMN `workplace_id` int(11) NOT NULL default 0");            
		}
		if (row_timesheets_options_exist('"send_notification_if_check_in_forgotten"') == 0){
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("send_notification_if_check_in_forgotten", "0", "1");
				');
		}
		if (row_timesheets_options_exist('"send_notification_if_check_in_forgotten_value"') == 0){
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("send_notification_if_check_in_forgotten_value", "30", "1");
				');
		}
		create_email_template('Timesheets - Remind user check in', 'Remind you to check in to record the start time of the shift', 'timesheets_attendance_mgt', 'Remind user check in', 'remind_user_check_in');
		if (!$CI->db->table_exists(db_prefix() . 'timesheets_log_send_notify')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_log_send_notify` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`sent` int(11) NOT NULL DEFAULT 0,
				`staffid` int(11) NOT NULL DEFAULT 0,
				`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`type` varchar(200) NUll,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
		}
	}
}