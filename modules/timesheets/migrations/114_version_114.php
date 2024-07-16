<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_Version_114 extends App_module_migration {
	public function up() {
		create_email_template('Timesheets - New application - Send to notification recipient', '{staff_name} created a new application {link} at {date_time}', 'timesheets_attendance_mgt', 'New application (Send to notification recipient)', 'new_leave_application_send_to_notification_recipients');
	}
}