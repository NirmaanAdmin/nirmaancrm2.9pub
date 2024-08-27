<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Loss_adjustment_sender extends App_mail_template
{
    protected $for = 'inventory';

    protected $data;

    public $slug = 'loss-adjustment-sender';

    public function __construct($data)
    {
        parent::__construct();

        $this->data = $data;
        $this->ci->load->library('merge_fields/loss_adjustment_sender_merge_fields');
        $this->set_merge_fields($this->ci->loss_adjustment_sender_merge_fields->format($this->data));
    }
    public function build()
    {
        $this->to($this->data->mail_to);
    }
}

?>