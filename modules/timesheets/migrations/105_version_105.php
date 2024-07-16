<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_105 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();     
		$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("allows_updating_check_in_time", "1", "1");
			');
		$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("allows_to_choose_an_older_date", "0", "1");
			');
	}
}