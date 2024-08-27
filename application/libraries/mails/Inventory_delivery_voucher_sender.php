<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_delivery_voucher_sender extends App_mail_template
{
    protected $for = 'inventory';

    protected $data;

    public $slug = 'inventory-delivery-voucher-sender';

    public function __construct($data)
    {
        parent::__construct();

        $this->data = $data;
        $this->ci->load->library('merge_fields/inventory_delivery_voucher_sender_merge_fields');
        $this->set_merge_fields($this->ci->inventory_delivery_voucher_sender_merge_fields->format($this->data));
    }
    public function build()
    {
        $this->to($this->data->mail_to);
    }
}

?>