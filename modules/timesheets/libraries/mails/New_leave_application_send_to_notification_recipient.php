<?php

defined('BASEPATH') or exit('No direct script access allowed');

class New_leave_application_send_to_notification_recipient extends App_mail_template
{
    protected $for = 'staff';

    protected $timesheets;

    public $slug = 'new_leave_application_send_to_notification_recipient';

    public function __construct($timesheets)
    {
        parent::__construct();

        $this->timesheets = $timesheets;
        // For SMS and merge fields for email
        $this->set_merge_fields('new_leave_application_send_to_notification_recipient_merge_fields', $this->timesheets);
    }
    
    public function build()
    {
        $this->to($this->timesheets->receiver);
    }
}
