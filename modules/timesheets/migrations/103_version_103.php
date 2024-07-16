<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_103 extends App_module_migration
{
     public function up()
     {
     	$CI = &get_instance();        
        create_email_template('Timesheets - Attendance notice', '{staff_name} {type_check} at {date_time}', 'timesheets_attendance_mgt', 'Attendance notice', 'attendance_notice');

		create_email_template('Timesheets - Send request approval to approver', 'Hi {approver}! <br>-{staff_name} has created an apply for leave and requires your approval. Please go to this link for details and approval: {link}', 'timesheets_attendance_mgt', 'Send request approval', 'send_request_approval');

		if (row_timesheets_options_exist('"attendance_notice_recipient"') == 0){
		  $CI->db->query('INSERT INTO `' . db_prefix() . 'timesheets_option` (`option_name`, `option_val`, `auto`) VALUES ("attendance_notice_recipient", "", "1");
		');
		}
     }
}
