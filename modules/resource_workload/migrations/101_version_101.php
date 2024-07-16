<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_101 extends App_module_migration
{
     public function up()
     {
        add_option('staff_workload_monday', 1);
        add_option('staff_workload_tuesday', 1);
        add_option('staff_workload_thursday', 1);
        add_option('staff_workload_wednesday', 1);
        add_option('staff_workload_friday', 1);
        add_option('staff_workload_saturday', 0);
        add_option('staff_workload_sunday', 0);

     }
}
