<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ticket_deadline_reminder extends App_mail_template
{
    protected $for = 'ticket';

    protected $data;

    public $slug = 'ticket-deadline-reminder';

    public function __construct($data)
    {
        parent::__construct();

        $this->data = $data;
        $this->ci->load->library('merge_fields/ticket_deadline_reminder_merge_fields');
        $this->set_merge_fields($this->ci->ticket_deadline_reminder_merge_fields->format($this->data));
    }
    public function build()
    {
        $this->to($this->data->mail_to);
    }
}

?>