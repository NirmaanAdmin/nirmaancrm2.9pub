<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_order_to_approver extends App_mail_template
{
    protected $for = 'purchase';

    protected $data;

    public $slug = 'purchase-order-to-approver';

    public function __construct($data)
    {
        parent::__construct();

        $this->data = $data;
        $this->ci->load->library('merge_fields/purchase_order_to_approver_merge_fields');
        $this->set_merge_fields($this->ci->purchase_order_to_approver_merge_fields->format($this->data));
    }
    public function build()
    {
        $this->to($this->data->mail_to);
    }
}

?>