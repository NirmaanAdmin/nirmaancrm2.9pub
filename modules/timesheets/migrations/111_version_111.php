<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_111 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();     
		if (row_timesheets_options_exist('"googlemap_api_key"') == 0){
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("googlemap_api_key", "", "1");');
		}
		if (!$CI->db->table_exists(db_prefix() . 'timesheets_route_point')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_route_point` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` varchar(200) NOT NULL,
				`route_point_address` varchar(400) NULL,
				`latitude` varchar(30),
				`longitude` varchar(30),
				`distance` double,
				`related_to` int(11) NULL,
				`related_id` int(11) NULL,
				`default` bit NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
		}
		if (!$CI->db->table_exists(db_prefix() . 'timesheets_route')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_route` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`staffid` int(11) NOT NULL,
				`route_point_id` int(11) NOT NULL,
				`date_work` date NOT NULL,    
				`order` int(11) NOT NULL DEFAULT 0,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
		}
		if (!$CI->db->field_exists('route_point_id', db_prefix() . 'check_in_out')) {
			$CI->db->query('ALTER TABLE `'.db_prefix() . "check_in_out`
				ADD COLUMN `route_point_id` int(11);");            
		}
		if (row_timesheets_options_exist('"allow_attendance_by_route"') == 0){
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("allow_attendance_by_route", "0", "1");
				');
		}
		if ($CI->db->field_exists('days_off' ,db_prefix() . 'timesheets_day_off')) {
			$CI->db->query('ALTER TABLE `' . db_prefix() . 'timesheets_day_off`
				MODIFY `days_off` float NULL  DEFAULT 0'
			);
		}
		if ($CI->db->field_exists('start_time' ,db_prefix() . 'timesheets_requisition_leave')) {
			$CI->db->query('ALTER TABLE `' . db_prefix() . 'timesheets_requisition_leave`
				MODIFY `start_time` datetime NULL,
				MODIFY `end_time` datetime NULL'
			);
		}
		if (row_timesheets_options_exist('"allow_attendance_by_route"') == 0){
			$CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("allow_attendance_by_route", "0", "1");
				');
		}
		if (!$CI->db->table_exists(db_prefix() . 'timesheets_go_bussiness_advance_payment')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . "timesheets_go_bussiness_advance_payment` (
				`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
				`requisition_leave` int(11) NOT NULL,
				`used_to` varchar(200) NUll,
				`amoun_of_money` varchar(200) NUll,
				`request_date` DATE NULL,
				`advance_payment_reason` TEXT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=" . $CI->db->char_set . ';');
		}
	}
}