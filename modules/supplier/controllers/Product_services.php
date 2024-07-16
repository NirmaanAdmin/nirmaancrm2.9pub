<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product_services extends ClientsController
{
     public function __construct()
    {
        parent::__construct();
        $this->load->model('taxes_model');
        $this->load->model('invoice_items_model');
        $this->load->model('currencies_model');
        $this->load->model('items_model');
    }

    public function index()
    {
        if (!has_contact_permission('items')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }

        $data['taxes']        = $this->taxes_model->get();
        $data['items_groups'] = $this->invoice_items_model->get_groups();
        $data['items'] = $this->items_model->get();

      
        $data['currencies'] = $this->currencies_model->get();

        $data['base_currency'] = $this->currencies_model->get_base_currency();

        $data['title'] = _l('invoice_items');

        /**
         * Pass data to the view
         */
        $this->data(['currencies' => $data['currencies'],'base_currency'=>$data['base_currency'],'taxes'=>$data['taxes'],'items_groups'=>$data['items_groups'],'items'=>$data['items'] ]);

        /**
         * Set page title
         */
        $this->title($data['title']);

        /**
         * The view name
         */
        $this->view('client/manage');
        /**
         * Render the layout/view
         */
        $this->layout();
    }

    public function items_create($id = '')
    {
        if (!has_contact_permission('items')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }
        $userid = $this->input->post('userid');
        $id = $this->input->post('itemid');
        if ($this->input->post()) {

            if ($id == '') {
               if (!has_contact_permission('items')) {
                    set_alert('warning', _l('access_denied'));
                    redirect(site_url());
                }
                $id = $this->invoice_items_model->add($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('items')));
                    // redirect(admin_url('mindmap'));
                    redirect(site_url('supplier/product_services/'));
                }
            } else {
                if (!has_contact_permission('items')) {
                    set_alert('warning', _l('access_denied'));
                    redirect(site_url());
                }
                $success = $this->invoice_items_model->edit($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('items')));
                    redirect(site_url('supplier/product_services/'));
                }
                //redirect(admin_url('mindmap/mindmap_create/' . $id));
            }
        }
        
      }

      public function edit($id = ''){
        if (!has_contact_permission('items')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }
         if ($this->input->is_ajax_request()) {
            $item                     = $this->invoice_items_model->get($id);
            $item->long_description   = nl2br($item->long_description);
            $item->custom_fields_html = render_custom_fields('items', $id, [], ['items_pr' => true]);
            $item->custom_fields      = [];

            $cf = get_custom_fields('items');

            foreach ($cf as $custom_field) {
                $val = get_custom_field_value($id, $custom_field['id'], 'items_pr');
                if ($custom_field['type'] == 'textarea') {
                    $val = clear_textarea_breaks($val);
                }
                $custom_field['value'] = $val;
                $item->custom_fields[] = $custom_field;
            }

            echo json_encode($item);
        }
      }


       /* Delete items */
    public function delete($id)
    {
        if (!has_contact_permission('items')) {
            set_alert('warning', _l('access_denied'));
            redirect(site_url());
        }
        if (!$id) {
            redirect(site_url('supplier/product_services/'));
        }
        $response = $this->invoice_items_model->delete($id);
        if (is_array($response) && isset($response['referenced'])) {
            set_alert('warning', _l('is_referenced', _l('invoice_item_lowercase')));
        } elseif ($response == true) {
            set_alert('success', _l('deleted', _l('invoice_item')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('invoice_item_lowercase')));
        }
       
        redirect(site_url('supplier/product_services/'));
    }


   
}