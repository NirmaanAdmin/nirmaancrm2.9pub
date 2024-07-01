<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Services extends ClientsController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('subscription_products_model', 'spm');
        $this->load->model('invoice_products_model', 'ipm');
        $this->load->model('subscriptions_model');
        $this->load->model('invoices_model');
    }

    /**
     * loades the products page for clients
     */
    public function index()
    {

        $data = [];
        $data['products'] = [];
        if (get_option('enable_subscription_products_view') == 1) {
            $products = $this->spm->get_all();
            $data['products'] = array_merge($data['products'], $products);
        }
        if (get_option('enable_invoice_products_view') == 1) {
            $products = $this->ipm->get_all();
            $data['products'] = array_merge($data['products'], $products);
        }

        $data['products'] = hooks()->apply_filters('services_arrange_products', $data['products']);

        $data['groups']  = $this->spm->get_group(null, true);
        $this->data($data);
        $this->title('Products');

        if (is_client_logged_in()) {
            $this->view('list_products');
        } else {
            $data['bodyclass'] = 'register';
            $this->view('public');
        }

        $this->layout();
    }
    /**
     * Creates a subscription in perfex when customer clicks subscribe on client portal
     * 
     */
    public function subscribe($clientid = null)
    {
        $this->form_validation->set_rules('product_id', _l('product'), 'required');
        $this->form_validation->set_rules('quantity', 'quantity', 'required');

        if (is_null($clientid)) {
            $this->form_validation->set_rules('clientid', _l('login_first'), 'required');
            $clientid = $this->input->post('clientid');
        }

        if ($this->input->post()) {
            $subscriptionProduct = $this->spm->get($this->input->post('product_id'));
            $insert_id = $this->subscriptions_model->create([
                'name'                => $subscriptionProduct->name,
                'description'         => $subscriptionProduct->description,
                'description_in_item' => $subscriptionProduct->description_in_item,
                'date'                => null,
                'clientid'            => $clientid,
                'project_id'          => 0,
                'stripe_plan_id'      => $subscriptionProduct->stripe_plan_id,
                'quantity'            => $this->input->post('quantity'),
                'terms'               => $subscriptionProduct->terms,
                'stripe_tax_id'       => $subscriptionProduct->stripe_tax_id,
                'currency'            => $subscriptionProduct->currency,
            ]);

            if ($insert_id) {

                $purchaseData = [];
                $purchaseData['subscription_id'] = $insert_id;
                $purchaseData['contact_id'] = get_contact_user_id();
                $purchaseData['client_id'] = $clientid;
                $purchaseData['product_id'] = $this->input->post('product_id');
                $purchaseData['quantity'] = $this->input->post('quantity');
                $purchaseData['created_at'] = date('c');

                $this->log_purchase($purchaseData);

                $this->subscriptions_model->update($insert_id, ['created_from' => $subscriptionProduct->created_from]);
                $hash = $this->subscriptions_model->get_by_id($insert_id)->hash;
                redirect(site_url('subscription/' . $hash));
            }
        }
    }

    /**
     * Register new users through subscription
     */
    public function register()
    {

        if (get_option('allow_registration') != 1 || is_client_logged_in()) {
            redirect(site_url());
        }

        if (get_option('company_is_required') == 1) {
            $this->form_validation->set_rules('company', _l('client_company'), 'required');
        }

        if (is_gdpr() && get_option('gdpr_enable_terms_and_conditions') == 1) {
            $this->form_validation->set_rules(
                'accept_terms_and_conditions',
                _l('terms_and_conditions'),
                'required',
                ['required' => _l('terms_and_conditions_validation')]
            );
        }

        $this->form_validation->set_rules('firstname', _l('client_firstname'), 'required');
        $this->form_validation->set_rules('lastname', _l('client_lastname'), 'required');
        $this->form_validation->set_rules('email', _l('client_email'), 'trim|required|is_unique[' . db_prefix() . 'contacts.email]|valid_email');
        $this->form_validation->set_rules('password', _l('clients_register_password'), 'required');
        $this->form_validation->set_rules('passwordr', _l('clients_register_password_repeat'), 'required|matches[password]');

        if (
            get_option('use_recaptcha_customers_area') == 1
            && get_option('recaptcha_secret_key') != ''
            && get_option('recaptcha_site_key') != ''
        ) {
            $this->form_validation->set_rules('g-recaptcha-response', 'Captcha', 'callback_recaptcha');
        }

        $custom_fields = get_custom_fields('customers', [
            'show_on_client_portal' => 1,
            'required'              => 1,
        ]);

        $custom_fields_contacts = get_custom_fields('contacts', [
            'show_on_client_portal' => 1,
            'required'              => 1,
        ]);
        foreach ($custom_fields as $field) {
            $field_name = 'custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']';
            if ($field['type'] == 'checkbox' || $field['type'] == 'multiselect') {
                $field_name .= '[]';
            }
            $this->form_validation->set_rules($field_name, $field['name'], 'required');
        }
        foreach ($custom_fields_contacts as $field) {
            $field_name = 'custom_fields[' . $field['fieldto'] . '][' . $field['id'] . ']';
            if ($field['type'] == 'checkbox' || $field['type'] == 'multiselect') {
                $field_name .= '[]';
            }
            $this->form_validation->set_rules($field_name, $field['name'], 'required');
        }

        if ($this->input->post()) {
            if ($this->form_validation->run() !== false) {
                $data = $this->input->post();

                define('CONTACT_REGISTERING', true);

                $clientid = $this->clients_model->add([
                    'billing_street'      => $data['address'],
                    'billing_city'        => $data['city'],
                    'billing_state'       => $data['state'],
                    'billing_zip'         => $data['zip'],
                    'billing_country'     => is_numeric($data['country']) ? $data['country'] : 0,
                    'firstname'           => $data['firstname'],
                    'lastname'            => $data['lastname'],
                    'email'               => $data['email'],
                    'contact_phonenumber' => $data['contact_phonenumber'],
                    'website'             => $data['website'],
                    'title'               => $data['title'],
                    'password'            => $data['passwordr'],
                    'company'             => $data['company'],
                    'vat'                 => isset($data['vat']) ? $data['vat'] : '',
                    'phonenumber'         => $data['phonenumber'],
                    'country'             => $data['country'],
                    'city'                => $data['city'],
                    'address'             => $data['address'],
                    'zip'                 => $data['zip'],
                    'state'               => $data['state'],
                    'custom_fields'       => isset($data['custom_fields']) && is_array($data['custom_fields']) ? $data['custom_fields'] : [],
                ], true);

                if ($clientid) {
                    hooks()->do_action('after_client_register', $clientid);

                    if (get_option('customers_register_require_confirmation') == '1') {
                        send_customer_registered_email_to_administrators($clientid);

                        $this->clients_model->require_confirmation($clientid);
                        set_alert('success', _l('customer_register_account_confirmation_approval_notice'));
                        redirect(site_url('authentication/login'));
                    }

                    $this->load->model('authentication_model');

                    $logged_in = $this->authentication_model->login(
                        $this->input->post('email'),
                        $this->input->post('password', false),
                        false,
                        false
                    );

                    $redUrl = site_url();

                    if ($logged_in) {
                        hooks()->do_action('after_client_register_logged_in', $clientid);
                        set_alert('success', _l('clients_successfully_registered'));
                    } else {
                        set_alert('warning', _l('clients_account_created_but_not_logged_in'));
                        $redUrl = site_url('authentication/login');
                    }

                    send_customer_registered_email_to_administrators($clientid);

                    $this->form_validation->set_rules('product_id', _l('product'), 'required');
                    $this->form_validation->set_rules('quantity', _l('quantity'), 'required');
                    $this->form_validation->set_rules('type', _l('type'), 'required');

                    if ($this->input->post('type') == 'invoice') {
                        $this->invoice($clientid);
                    } elseif ($this->input->post('type') == 'subscription') {
                        $this->subscribe($clientid);
                    }

                    redirect($redUrl);
                }
            }
        }
    }

    /**
     * Public products page
     */
    public function public()
    {
        if (is_client_logged_in()) {
            redirect(site_url('services'));
        }

        if (get_option('subscription_product_public') == 0) {
            redirect(site_url());
        }

        if ($this->input->post()) $this->register();
        $data = [];
        $data['products'] = [];

        $data['title']     = _l('products');

        $data['products'] = [];
        if (get_option('enable_subscription_products_view') == 1) {
            $products = $this->spm->get_all();
            $data['products'] = array_merge($data['products'], $products);
        }
        if (get_option('enable_invoice_products_view') == 1) {
            $products = $this->ipm->get_all();
            $data['products'] = array_merge($data['products'], $products);
        }

        $data['products'] = hooks()->apply_filters('services_arrange_products', $data['products']);

        $data['groups']  = $this->spm->get_group(null, true);
        $data['bodyclass'] = 'register';
        $this->data($data);
        $this->view('public');
        $this->layout();
    }

    public function recaptcha($str = '')
    {
        return do_recaptcha_validation($str);
    }

    /**
     * loades the products page for clients by group
     */
    public function category($group, $slug = null)
    {
        $data = [];
        $data['products'] = [];

        if ($group == 'subscriptions') {
            $data['products'] = $this->spm->get_all();
        } elseif ($group == 'invoices') {
            $data['products'] = $this->ipm->get_all();
        } elseif ($slug) {
            if (get_option('enable_subscription_products_view') == 1) {
                $products = $this->spm->get_all($group);
                $data['products'] = array_merge($data['products'], $products);
            }
            if (get_option('enable_invoice_products_view') == 1) {
                $products = $this->ipm->get_all($group);
                $data['products'] = array_merge($data['products'], $products);
            }
        } else {
            redirect(site_url('services'));
        }

        $data['group']   = $group;
        $data['groups']  = $this->spm->get_group(null, true);
        $this->data($data);
        $this->title('Products');

        if (is_client_logged_in()) {
            $this->view('list_products');
        } else {
            $data['bodyclass'] = 'register';
            $this->view('public');
        }

        $this->layout();
    }

    public function invoice($clientid = null)
    {
        $this->form_validation->set_rules('product_id', _l('product'), 'required');
        $this->form_validation->set_rules('quantity', 'quantity', 'required');

        if (is_null($clientid)) {
            $this->form_validation->set_rules('clientid', _l('login_first'), 'required');
        }

        $data = $this->input->post();
        if (!is_null($clientid)) {
            $data['clientid'] = $clientid;
        }
        $product = $this->ipm->get($data['product_id']);
        $invoiceData = services_invoice_data($product, $data);

        $id = $this->invoices_model->add($invoiceData);
        if ($id) {
            $this->db->where('id', $id);
            $this->db->update(db_prefix() . 'invoices', [
                'addedfrom' => 2,
            ]);

            $purchaseData = [];
            $purchaseData['invoice_id'] = $id;
            $purchaseData['contact_id'] = get_contact_user_id();
            $purchaseData['client_id'] = $data['clientid'];
            $purchaseData['product_id'] = $data['product_id'];
            $purchaseData['quantity'] = $data['quantity'];
            $purchaseData['created_at'] = date('c');

            $this->log_purchase($purchaseData);

            $invoice = $this->invoices_model->get($id);
            redirect(site_url("invoice/$id/$invoice->hash"));
        }
        // redirect($this->agent->referrer());
    }

    public function details($type, $id, $slug)
    {
        $data = [];
        if ($type == 'sub') {
            $data['product'] = $this->spm->get($id);
        } elseif ($type == 'inv') {
            $data['product'] = $this->ipm->get($id);
        }
        if ($this->input->post()) $this->register();

        if (!$data['product']) {
            show_404();
        }

        $data['title'] = str_replace('-', ' ', strtoupper($slug));
        $data['groups']  = $this->spm->get_group();
        $this->data($data);
        $this->title($data['title']);

        if (is_client_logged_in()) {
            $this->view('details');
        } else {
            if (get_option('subscription_product_public') == 0) {
                redirect(site_url());
            }
            $this->view('public_details');
        }
        $this->layout();
    }

    protected function log_purchase($purchaseData)
    {
        $data = $this->input->post();
        $purchase_id = $this->ipm->record_purchase($purchaseData);
        if ($purchase_id) {
            if (isset($data['custom_fields'])) {
                $custom_fields = $data['custom_fields'];
                unset($data['custom_fields']);
            }

            if (isset($custom_fields)) {
                handle_custom_fields_post($purchase_id, $custom_fields);
            }
        }
    }
}
