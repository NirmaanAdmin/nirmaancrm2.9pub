<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_107 extends App_module_migration
{
    public function up()
    {
       add_option('integrated_timesheet_holiday', 0);
		add_option('integrated_timesheet_leave', 0);
		add_option('staff_workload_monday_visible', 1);
		add_option('staff_workload_tuesday_visible', 1);
		add_option('staff_workload_thursday_visible', 1);
		add_option('staff_workload_wednesday_visible', 1);
		add_option('staff_workload_friday_visible', 1);
		add_option('staff_workload_saturday_visible', 1);
		add_option('staff_workload_sunday_visible', 1);
		add_option('staff_workload_exception', '');
    }
}
