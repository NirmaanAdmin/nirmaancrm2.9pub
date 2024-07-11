<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_107 extends App_module_migration
{
	public function up()
	{        
		$CI = & get_instance();
		if (!$CI->db->field_exists('realpath_data' ,db_prefix() . 'spreadsheet_online_my_folder')) {
			$CI->db->query('ALTER TABLE `' . db_prefix() . 'spreadsheet_online_my_folder`
				ADD COLUMN `realpath_data` varchar(250) NULL
				');
		}
		
	}
}
