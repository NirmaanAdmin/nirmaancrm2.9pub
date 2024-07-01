<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Products extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('stripe_subscriptions');
        $this->load->model('taxes_model');
        $this->load->model('currencies_model');
        $this->load->model('services/subscription_products_model', 'spm');
        $this->load->model('services/invoice_products_model', 'ipm');
    }

    /**
     * ../admin/products
     * loades the products page in admin panel
     */
    public function index()
    {
        $data = [];
        $data['a'] = app_format_money(1, '$');
        $data['title'] = _l('stripe_products');

        if ($this->input->post()) {
            $data = $this->input->post();
            update_option('subscription_product_public', $data['subscription_product_public']);
            $days = json_encode($data['days']);
            update_option('subscription_product_notify_days', $days);
            set_alert('success', 'success');
        }

        $this->load->view('manage', $data);
    }

    /**
     * Loads Tables for products
     * only accepts ajax request
     */

    public function table($type)
    {
        if (!has_permission('invoices', '', 'view') && !has_permission('invoices', '', 'view_own')) {
            ajax_access_denied();
        }

        if ($type == 'subscription') {

            $this->app->get_table_data(module_views_path('services', 'table'), ['type' => 'products',]);
        } elseif ($type == 'invoice') {
            $this->app->get_table_data(module_views_path('services', 'invoice_product_table'), ['type' => 'products',]);
        } elseif ($type == 'groups') {
            $this->app->get_table_data(module_views_path('services', 'groups_table'), ['type' => 'products',]);
        } elseif ($type == 'purchaseLog') {
            $this->app->get_table_data(module_views_path('services', 'tables/purchase_log'), ['type' => 'products',]);
        }
    }
    /**
     * loads page to add/edit product
     * @param int $id optional to add. if added product is edited
     */
    public function create($type, $id = false)
    {
        if (!has_permission('subscriptions', '', 'create')) {
            access_denied('Subscriptions Create');
        }

        $data['title'] = _l('add_new', _l('product'));
        $data['taxes']      = $this->taxes_model->get();
        $data['currencies'] = $this->currencies_model->get();
        $data['groups']     = json_decode(json_encode($this->spm->get_group()), true);

        if ($type == 'subscription') {

            if ($id) {
                $data['product'] = $this->spm->get($id);
            }
            $data['customers_groups'] = $this->clients_model->get_groups();
            $data['customers'] = $this->clients_model->get();
            try {
                $data['plans'] = $this->stripe_subscriptions->get_plans();
                $this->load->library('stripe_core');
                $data['stripe_tax_rates'] = $this->stripe_core->get_tax_rates();
            } catch (Exception $e) {
                if ($this->stripe_subscriptions->has_api_key()) {
                    $data['product_error'] = $e->getMessage();
                } else {
                    $data['product_error'] = _l('api_key_not_set_error_message', '<a href="' . admin_url('settings?group=payment_gateways&tab=online_payments_stripe_tab') . '">Stripe Checkout</a>');
                }
            }

            $data['bodyclass']  = 'subscription';
            $this->load->view('create', $data);
        } elseif ($type == 'invoice') {

            if ($id) {
                $data['product'] = $this->ipm->get($id);
            }
            $data['customers_groups'] = $this->clients_model->get_groups();
            $data['customers'] = $this->clients_model->get();

            $data['bodyclass']  = 'invoice';
            $data['invoice_product']  = true;
            $this->load->view('create', $data);
        }
    }

    /**
     * Adds or updates product
     */
    public function add($type)
    {
        $long_description = html_purify($this->input->post('long_description', false));
        $long_description = remove_emojis($long_description);
        $long_description = nl2br($long_description);

        if ($type == 'subscription') {
            $plan = $this->stripe_subscriptions->get_plan($this->input->post('stripe_plan_id'));
            $data = [
                'name'                => $this->input->post('name'),
                'description'         => nl2br($this->input->post('description')),
                'price'               => $plan->amount,
                'period'              => $plan->interval,
                'description_in_item' => $this->input->post('description_in_item') ? 1 : 0,
                'long_description'    => $long_description,
                'stripe_plan_id'      => $this->input->post('stripe_plan_id'),
                'terms'               => nl2br($this->input->post('terms')),
                'stripe_tax_id'       => $this->input->post('stripe_tax_id') ? $this->input->post('stripe_tax_id') : false,
                'currency'            => $this->input->post('currency'),
                'count'               => $plan->interval_count,
                'group'               => $this->input->post('group'),
                'created_from'        => get_staff_user_id(),
            ];

            if ($this->input->post('related_to') ==  'customer_groups') {
                $data['customer_group'] = $this->input->post('customer_group');
                $data['client_id'] = null;
            } else if ($this->input->post('related_to') == 'customers') {
                $data['client_id'] = $this->input->post('clientid');
                $data['customer_group'] = null;
            } else {
                $data['client_id'] = null;
                $data['customer_group'] = null;
            }

            if ($this->input->post('id')) {
                $update = $this->spm->update($this->input->post('id'), $data);
                if ($update) {
                    set_alert('success', _l('stripe_product_added_successfully'));
                }
            } else if ($this->input->post()) {
                $insert_id = $this->spm->create($data);
                if ($insert_id) {
                    set_alert('success', _l('stripe_product_added_successfully'));
                }
            }
            redirect(admin_url('services/products/subscription'));
        } elseif ($type == 'invoice') {

            $tax = implode(',', (array) $this->input->post('tax'));
            $data = [
                'name'                  => $this->input->post('name'),
                'description'           => nl2br($this->input->post('description')),
                'long_description'      => $long_description,
                'price'                 => $this->input->post('price'),
                'group'                 => $this->input->post('group'),
                'tax_1'                 => $tax,
                'currency'              => $this->input->post('currency'),
                'is_recurring'          => $this->input->post('is_recurring'),
                'interval'              => $this->input->post('interval'),
                'interval_type'         => $this->input->post('interval_type'),
                // 'cycle'                 =>$this->input->post('name'),
                'created_from'          => get_staff_user_id(),
            ];

            if ($this->input->post('related_to') ==  'customer_groups') {
                $data['customer_group'] = $this->input->post('customer_group');
                $data['client_id'] = null;
            } else if ($this->input->post('related_to') == 'customers') {
                $data['client_id'] = $this->input->post('clientid');
                $data['customer_group'] = null;
            } else {
                $data['client_id'] = null;
                $data['customer_group'] = null;
            }

            if ($this->input->post('id')) {
                $update = $this->ipm->update($this->input->post('id'), $data);
                if ($update) {
                    set_alert('success', _l('updated_successfully'));
                }
            } else if ($this->input->post()) {
                $insert_id = $this->ipm->create($data);
                if ($insert_id) {
                    set_alert('success', _l('added_successfully'));
                }
            }
            redirect(admin_url('services/products/invoice'));
        }
    }
    /**
     * delete product
     * @param int $id product id 
     */
    public function delete($type, $id)
    {
        if ($type == 'subscription') {
            $this->spm->delete($id);
            set_alert('success', 'successful');
        } elseif ($type == 'invoice') {
            $resp = $this->ipm->delete($id);
            set_alert('success', 'successful');
        }
        redirect($this->agent->referrer());
    }

    public function modal()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $data['public']    = get_option('subscription_product_public');
        $data['db_days']    = json_decode(get_option('subscription_product_notify_days'));
        $this->load->view('modals/settings', $data);
    }

    public function subscription()
    {
        $data = [];
        $data['a'] = app_format_money(1, '$');
        $data['title'] = _l('stripe_products');
        $this->load->view('manage', $data);
    }

    public function invoice()
    {
        $data = [];
        $data['title'] = _l('invoice_products');
        $data['invoice'] = true;

        if ($this->input->post()) {
            $data = $this->input->post();
            update_option('subscription_product_public', $data['subscription_product_public']);
            $days = json_encode($data['days']);
            update_option('subscription_product_notify_days', $days);
            set_alert('success', 'success');
        }

        $this->load->view('manage', $data);
    }

    public function purchase_log()
    {
        $data = [];
        $data['title'] = _l('product_purchase_log');
        $this->load->view('purchase_log', $data);
    }

    public function groups($type = null, $id = null)
    {
        if ($type) {
            $delete = $this->spm->delete_group($id);
            if ($delete) {
                set_alert('success', _l('deleted_successfully'));
            }
        }
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $post = $this->input->post();
            $this->form_validation->set_rules('name', _l('name'), 'required');
            if (!isset($post['id'])) {
                $resp = $this->spm->create_group($post);
                if ($resp) {
                    set_alert('success', _l('updated_successfully'));
                }
            } else {
                $resp  = $this->spm->update_group($post['id'], ['name' => $post['name'], 'order' => $post['order']]);
                if ($resp) {
                    set_alert('success', _l('added_successfully'));
                }
            }
            redirect(site_url($this->uri->uri_string()));
        }

        $this->app_scripts->add(
            'groups-js',
            module_dir_url('services', 'assets/groups.js') . '?v=' . $this->app_scripts->core_version()
        );

        $data = [];
        $data['title'] = _l('groups');
        $this->load->view('groups', $data);
    }

    public function settings()
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            $days = json_encode($data['days']);

            update_option('subscription_product_notify_days', $days);
            update_option('subscription_product_public', $data['subscription_product_public']);
            update_option('enable_subscription_products_view', $data['enable_subscription_products_view']);
            update_option('enable_invoice_products_view', $data['enable_invoice_products_view']);
            update_option('enable_products_more_info_button', $data['enable_products_more_info_button']);
            update_option('show_product_quantity_field', $data['show_product_quantity_field']);
            update_option('hide_invoice_subcription_group_from_client_side', $data['hide_invoice_subcription_group_from_client_side']);

            set_alert('success', 'success');
        }
        redirect(site_url('services/products/groups'));
    }
}
