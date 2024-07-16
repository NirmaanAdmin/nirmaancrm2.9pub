<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Send_request_approval extends App_mail_template
{
    protected $for = 'staff';

    protected $timesheets;

    public $slug = 'send_request_approval';

    public function __construct($timesheets)
    {
        parent::__construct();

        $this->timesheets = $timesheets;
        // For SMS and merge fields for email
        $this->set_merge_fields('send_request_approval_merge_fields', $this->timesheets);
    }
    public function build()
    {
        $this->to($this->timesheets->receiver);
    }
}
