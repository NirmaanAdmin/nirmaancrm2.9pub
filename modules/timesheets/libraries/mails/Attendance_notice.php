<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_notice extends App_mail_template
{
    protected $for = 'staff';

    protected $timesheets;

    public $slug = 'attendance_notice';

    public function __construct($timesheets)
    {
        parent::__construct();

        $this->timesheets = $timesheets;
        // For SMS and merge fields for email
        $this->set_merge_fields('attendance_notice_merge_fields', $this->timesheets);
    }
    public function build()
    {
        $this->to($this->timesheets->receiver);
    }
}
