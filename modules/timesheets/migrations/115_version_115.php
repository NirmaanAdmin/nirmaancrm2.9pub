<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_115 extends App_module_migration {
	public function up() {
		$CI = &get_instance();
		if (row_timesheets_options_exist('"timekeeping_enable_valid_ip"') == 0) {
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("timekeeping_enable_valid_ip", "0", "1");
        ');
		}

		if (!$CI->db->table_exists(db_prefix() . 'timesheets_valid_ip')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_valid_ip` (
        `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        `ip` varchar(30) NUll,
        `enable` int(11) NOT NULL DEFAULT 1,
        `date_creator` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
		}
	}
}