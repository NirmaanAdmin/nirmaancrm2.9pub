<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Site_transfer_entry_sender extends App_mail_template
{
    protected $for = 'inventory';

    protected $data;

    public $slug = 'site-transfer-entry-sender';

    public function __construct($data)
    {
        parent::__construct();

        $this->data = $data;
        $this->ci->load->library('merge_fields/site_transfer_entry_sender_merge_fields');
        $this->set_merge_fields($this->ci->site_transfer_entry_sender_merge_fields->format($this->data));
    }
    public function build()
    {
        $this->to($this->data->mail_to);
    }
}

?>