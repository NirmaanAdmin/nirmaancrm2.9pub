<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_117 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();   
		if (!$CI->db->field_exists('token' ,db_prefix() . 'staff')) { 
			$CI->db->query('ALTER TABLE `' . db_prefix() . "staff`
				ADD COLUMN `token` VARCHAR(255) NULL
				;");
		}
	}
}
