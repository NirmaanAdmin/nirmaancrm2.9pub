<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_116 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();   
		
		if (row_timesheets_options_exist('"send_email_check_in_out_customer_location"') == 0) {
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("send_email_check_in_out_customer_location", "0", "1");
				');
		}
		if (row_timesheets_options_exist('"allow_employees_to_create_work_points"') == 0) {
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("allow_employees_to_create_work_points", "0", "1");
				');
		}
		if (!$CI->db->field_exists('type_of_leave', db_prefix() . 'timesheets_day_off')) {
			$CI->db->query('ALTER TABLE `' . db_prefix() . 'timesheets_day_off`
				ADD COLUMN `type_of_leave` varchar(200) NOT NULL  DEFAULT "8"'
			);
		}
		if (row_timesheets_options_exist('"type_of_leave_selected"') == 0) {
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("type_of_leave_selected", 8, "1");
				');
		}
	}
}
