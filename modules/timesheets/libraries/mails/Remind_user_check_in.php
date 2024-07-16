<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Remind_user_check_in extends App_mail_template
{
    protected $for = 'staff';

    protected $timesheets;

    public $slug = 'remind_user_check_in';

    public function __construct($timesheets)
    {
        parent::__construct();

        $this->timesheets = $timesheets;
        // For SMS and merge fields for email
        $this->set_merge_fields('remind_user_check_in_merge_fields', $this->timesheets);
    }
    public function build()
    {
        $this->to($this->timesheets->receiver);
    }
}
