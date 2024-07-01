<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Class Omni sales 
 */
class Omni_sales extends AdminController
{
    /**
     * __construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('omni_sales_model');
    }

    /* List all announcements */

    public function omni_sales_channel()
    {
        $data['title'] = _l('omni_sales_channel');
        $this->load->view('sales_channel_mgt', $data);
    }
    /**
     * add omni sales channel
     * @return view
     */
    public function add_omni_sales_channel(){

        $data['title'] = _l('add_omni_sales_channel');


        $this->load->view('sales_channel/add_omni_sales_channel', $data);
    }
    /**
     * invoice list
     * @param  int $id 
     * @return view    
     */
    public function invoice_list($id = ''){
        $this->load->model('payment_modes_model');
        $this->load->model('invoices_model');
        $data['payment_modes']        = $this->payment_modes_model->get('', [], true);
        $data['invoiceid']            = $id;
        $data['title']                = _l('invoices');
        $data['invoices_years']       = $this->invoices_model->get_invoices_years();
        $data['invoices_sale_agents'] = $this->invoices_model->get_sale_agents();
        $data['invoices_statuses']    = $this->invoices_model->get_statuses();
        $data['bodyclass']            = 'invoices-total-manual';

        $data['title'] = _l('invoice_list');
        $this->load->view('invoice_list/invoice_list_mgt', $data);
    }
    /**
     * diary sync 
     * @param  int $id 
     * @return view
     */
    public function diary_sync($id = ''){
        $data['title'] = _l('diary_sync');
        $this->load->view('diary_sync/diary_sync_mgt', $data);
    }
    /**
     * report
     * @param  int $id
     * @return view
     */
    public function report($id = ''){
        $data['group'] = $this->input->get('group');

        $data['title'] = _l('report');

        $data['tab'][] = 'results_trade_discount';
       
       
     
        if($data['group'] == ''){
            $data['group'] = 'results_trade_discount';
        }

        $data['tabs']['view'] = 'includes/'.$data['group'];
        $data['id'] = $id;
        $data['list_group'] = $this->omni_sales_model->get_group_product();
        $data['product'] = $this->omni_sales_model->get_product();
        $this->load->view('report/manage', $data);
    }
    /**
     * pos channel
     * @return view
     */
     public function pos(){
          $data['title'] = _l('pos');
        $this->load->model('currencies_model');

          $data['base_currency'] = $this->currencies_model->get_base_currency();
          $data['list_group'] = $this->omni_sales_model->get_group_product();
          $data['client'] = $this->clients_model->get();
          $data['staff'] = $this->staff_model->get();
          $this->load->view('pos', $data);
    }

    /**
     * change active channel
     * @return json
     */
    public function change_active_channel(){
        if($this->input->post()){
            $data = $this->input->post();
            $success = $this->omni_sales_model->change_active_channel($data);
            echo json_encode([
                'success' => $success
            ]);
            die;          

        }
    }
    /**
     * add product channel
     * @param int $channel
     * @return view 
     */
    public function add_product_channel($channel){
        $data['title'] =_l($channel).' > '. _l('add_product');
        $data_chanel = $this->omni_sales_model->get_sales_channel_by_channel($channel);
        $data['id_channel'] = $data_chanel->id;
        $data['channel'] = $channel;
        $data['products'] = $this->omni_sales_model->get_product();
        $data['group_product'] = $this->omni_sales_model->get_group_product();
        $this->load->view('sales_channel/add_product_channel', $data);
    }
    /**
     * add product management table
     * @return table
     */
    public function add_product_management_table(){
        if ($this->input->is_ajax_request()) {
            if($this->input->post()){

                $product_filter = $this->input->post('product_filter'); 
                $id_channel = $this->input->post('id_channel'); 
                $channel = $this->input->post('channel'); 

                $select = [
                      db_prefix() . 'sales_channel_detailt.id',
                      db_prefix() . 'items.commodity_code',
                      db_prefix() . 'items.description',
                      db_prefix() . 'sales_channel_detailt.id',
                      db_prefix() . 'sales_channel_detailt.id',
                      db_prefix() . 'sales_channel_detailt.id'         
                ];

                $aColumns     = $select;
                $sIndexColumn = 'id';
                $sTable       = db_prefix() . 'sales_channel_detailt';
                $join         = [' left join '.db_prefix() . 'items on '.db_prefix() . 'items.id = '.db_prefix() . 'sales_channel_detailt.product_id'];

                $where        = [' AND '.db_prefix().'sales_channel_detailt.sales_channel_id = '.$id_channel ];
                $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
                      db_prefix() . 'sales_channel_detailt.id',
                      'group_product_id',
                      'product_id',
                      'sales_channel_id',
                      'prices',
                ]);


                $output  = $result['output'];
                $rResult = $result['rResult'];
                foreach ($rResult as $aRow) {
                    $row = [];
                    $row[] = $aRow['id'];                     
                    $data_product =  $this->omni_sales_model->get_product($aRow['product_id']);
                    $name ='';
                    $code ='';
                    $rate ='';
                    if($data_product){
                        $name = $data_product->description;
                        $code = $data_product->commodity_code;
                        $rate = $data_product->rate;
                    }
                    $rate = app_format_money($rate,'');
                    $price_on_channel = app_format_money($aRow['prices'],'');
                    $row[] = $code;             
                    $row[] = $name;             
                    $row[] = $rate;
                    $row[] = $price_on_channel;


                   
                    $option = '';
                    $option .= '<a href="' . admin_url('warehouse/view_commodity_detail/' . $aRow['product_id']) . '" data-toggle="tooltip" data-placement="top" data-title="'._l('view').'" class="btn btn-default btn-icon" data-id="'.$aRow['id'].'" >';
                    $option .= '<i class="fa fa-eye"></i>';
                    $option .= '</a>';
                    $option .= '<a href="#" onclick="update_product(this);" data-groupid="'.$aRow['group_product_id'].'" data-toggle="tooltip" data-placement="top" data-title="'._l('edit').'"  data-prices="'.app_format_money($aRow['prices'],'').'" data-price_on_channel="'.$price_on_channel.'" data-productid="'.$aRow['product_id'].'" class="btn btn-default btn-icon" data-id="'.$aRow['id'].'" >';
                    $option .= '<i class="fa fa-edit"></i>';
                    $option .= '</a>';
                    $option .= '<a href="' . admin_url('omni_sales/delete_product/'.$channel.'/'. $aRow['id']) . '" data-toggle="tooltip" data-placement="top" data-title="'._l('delete').'" class="btn btn-danger btn-icon _delete">';
                    $option .= '<i class="fa fa-remove"></i>';
                    $option .= '</a>';
                    $row[] = $option; 

                    $output['aaData'][] = $row;                                      
                }
                echo json_encode($output);
                die();
             }
        }
    }
    /**
     * get list product
     * @param  int $id
     * @return json
     */
    public function get_list_product($id=''){
            $list = $this->omni_sales_model->get_product_by_group($id);
            $html = '';
            foreach ($list as $key => $value) {
               $html .= '<option value="'.$value['id'].'">'.$value['commodity_code'].' # '.$value['description'].'</option>';
            }
            echo json_encode([
                'success' => true,
                'html' => $html
            ]);
            die;          


    }
    /**
     * add product
     * @return redirect
     */
    public function add_product(){
        if($this->input->post()){
            $data = $this->input->post();
            if($data['sales_channel_id'] != ''){
                $channel = $data['channel'];
                unset($data['channel']);
                $insert_id = $this->omni_sales_model->add_product($data);
               if ($insert_id) {
                    $message = _l('added_successfully');
                    set_alert('success', $message);
                }
                redirect(admin_url('omni_sales/add_product_channel/'.$channel));
            }           
        }
    }
    /**
     * delete product
     * @param  int $channel 
     * @param  int $id      
     * @return redirect
     */
    public function delete_product($channel,$id){
        $response = $this->omni_sales_model->delete_product($id);
        if($response == true){
            set_alert('success', _l('deleted', _l('category')));
        }
        else{
            set_alert('warning', _l('problem_deleting'));            
        }
        redirect(admin_url('omni_sales/add_product_channel/'.$channel));
    }
    /**
     * order list
     * @param  int $id
     * @return view
     */
    public function order_list($id = ''){
        $this->load->model('clients_model');
        $this->load->model('invoices_model');
        $this->load->model('staff_model');
        $data['customers'] = $this->clients_model->get();
        $data['invoices'] = $this->invoices_model->get();
        $data['prefix'] = get_option('invoice_prefix');
        $data['title'] = _l('order_list');
        $data['staff'] = $this->staff_model->get();
        $this->load->view('order_list/order_list', $data);
    }
    /**
     * order list table
     * @return table
     */
    public function order_list_table(){
   if ($this->input->is_ajax_request()) {
            if($this->input->post()){

                $product_filter = $this->input->post('product_filter'); 
                $channel = $this->input->post('channel');
                $customers = $this->input->post('customers');
                $invoices = $this->input->post('invoices');
                $status = $this->input->post('status');

                $end_date = $this->input->post('end_date');
                $start_date = $this->input->post('start_date');
                $seller = $this->input->post('seller');

                $query = '';      

                $select = [
                      'id',
                      'id',
                      'id',
                      'id',
                      'id',
                      'id',
                      'id'          
                ];
                $where              = [(($query!='')?$query:'')];
                if(isset($channel) && $channel != ''){
                  if($channel == 1){
                    array_push($where, ' where channel = "PORTAL"');
                  }elseif($channel == 2){
                    array_push($where, ' where channel = "POS"');
                  }elseif($channel == 3){
                    array_push($where, ' where channel != "POS" and channel != "PORTAL"');
                  }
                }
                if(isset($customers) && $customers != ''){
                  if(count($where) > 1){
                    array_push($where, ' and userid = '.$customers);
                  }else{
                    array_push($where, ' where userid = '.$customers);
                  }
                }

                if(isset($invoices) && $invoices != ''){
                  if(count($where) > 1){

                    array_push($where, ' and number_invoice = '.$this->omni_sales_model->get_number_invoice($invoices));
                  }else{
                    array_push($where, ' where number_invoice = '.$this->omni_sales_model->get_number_invoice($invoices));
                  }
                }

                if(isset($status) && $status != ''){
                  if(count($where) > 1){
                    array_push($where, ' and status = '.$status);
                  }else{
                    array_push($where, ' where status = '.$status);
                  }
                }
                if(isset($seller) && $seller != ''){
                  if(count($where) > 1){
                    array_push($where, ' and seller = '.$seller);
                  }else{
                    array_push($where, ' where seller = '.$seller);
                  }
                }
                if($end_date!='' && $start_date!=''){
                    if(!$this->omni_sales_model->check_format_date($start_date)){
                      $start_date = to_sql_date($start_date);
                    }else{
                      $start_date = $start_date;
                    }

                    if(!$this->omni_sales_model->check_format_date($end_date)){
                      $end_date = to_sql_date($end_date);
                    }else{
                      $end_date = $end_date;
                    }

                  if(count($where) > 1){
                    array_push($where, ' and date(datecreator) between \''.$start_date.'\' and \''.$end_date.'\'');
                  }else{
                    array_push($where, ' where date(datecreator) between \''.$start_date.'\' and \''.$end_date.'\'');
                  }
                }

                $aColumns     = $select;
                $sIndexColumn = 'id';
                $sTable       = db_prefix() . 'cart';
                $join         = [];

                $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [
                      'id',
                      'name',
                      'address',
                      'phone_number',
                      'voucher',
                      'status',
                      'datecreator',
                      'channel',
                      'company',
                      'number_invoice',
                      'invoice',
                      'order_number'
                ]);


                $output  = $result['output'];
                $rResult = $result['rResult'];
                foreach ($rResult as $aRow) {
                if($aRow['number_invoice'] != ''){
                    $id = $this->omni_sales_model->get_id_invoice($aRow['number_invoice']);
                }
                    $row = [];
                    $row[] = $aRow['id'];              
                    $row[] = $aRow['order_number'];              
                    $row[] = $aRow['datecreator'];              
                    $row[] = $aRow['company'];              
                    $row[] = strtoupper($aRow['channel']);   
                    $status = '';
                    if($aRow['status'] == 0){
                    $status = _l('processing');
                    }      
                    if($aRow['status'] == 1){
                        $status = _l('pending_payment');
                    }
                    if($aRow['status'] == 2){
                        $status = _l('confirm');
                    }
                    if($aRow['status'] == 3){
                        $status = _l('being_transported');
                    }
                    if($aRow['status'] == 4){
                        $status = _l('finish');
                    }
                    if($aRow['status'] == 5){
                        $status = _l('refund');
                    }
                    if($aRow['status'] == 6){
                        $status = _l('lie');
                    } 
                    if($aRow['status'] == 7){
                        $status = _l('cancelled');
                    }  

                    $row[] = $status;              

                    $option = '';
                    $option .= '<a href="' . admin_url('omni_sales/view_order_detailt/'. $aRow['id']) . '" data-toggle="tooltip" data-placement="top" data-title="'._l('view').'" class="btn btn-default btn-icon" data-id="'.$aRow['id'].'" >';
                    $option .= '<i class="fa fa-eye"></i>';
                    $option .= '</a>';
                  
                    $option .= '<a href="' . admin_url('omni_sales/delete_product/'. $aRow['id']) . '" data-toggle="tooltip" data-placement="top" data-title="'._l('delete').'" class="btn btn-danger btn-icon _delete">';
                    $option .= '<i class="fa fa-remove"></i>';
                    $option .= '</a>';

                    if($aRow['invoice'] != ''){
                        $row[] = '<a href="' . admin_url('invoices#'. $id) . '" >'.$aRow['invoice'] .'</a>';
                        $option_invoice = '';
                        $option_invoice .= '<a href="' . admin_url('omni_sales/view_order_detailt/'. $aRow['id']) . '" data-toggle="tooltip" data-placement="top" data-title="'._l('view').'" class="btn btn-default btn-icon" data-id="'.$aRow['id'].'" >';
                        $option_invoice .= '<i class="fa fa-eye"></i>';
                        $option_invoice .= '</a>';     
                        $row[] = $option_invoice;      
                    }else{
                        $row[] = '';      
                        $row[] = $option; 
                    }                


                    $output['aaData'][] = $row;                                      
                }
                echo json_encode($output);
                die();
             }
        }
    }

    /**
     * get cart data 
     * @param  int $id 
     * @return json
     */
     public function get_cart_data($id = ''){
        $data_cart = $this->omni_sales_model->get_cart($id);
        if($data_cart){
            $data['id_contact'] = $data_cart->id_contact; 
            $data['contact'] = $this->omni_sales_model->get_contact($data['id_contact']);
            $this->load->model('currencies_model');
            $data['base_currency'] = $this->currencies_model->get_base_currency(); 
            $data['cart_detailt'] = $this->omni_sales_model->get_cart_detailt_by_master($id);
            $html = $this->load->view('order_list/cart_detailt',$data, true);
            echo json_encode([
                'data' =>  $html,
                'success' => true
            ]); 
        }         
    }
    /**
     * view order detailt
     * @param  int $id
     * @return view
     */
    public function view_order_detailt($id){
        $data_cart = $this->omni_sales_model->get_cart($id);
        if($data_cart){
          $data['id'] = $id;
          $this->load->model('currencies_model');
          $data['base_currency'] = $this->currencies_model->get_base_currency();
          $data['order'] = $this->omni_sales_model->get_cart_by_order_number($data_cart->order_number);
          $data['order_detait'] = $this->omni_sales_model->get_cart_detailt_by_cart_id($data['order']->id);
              if($data['order']->number_invoice != ''){
                    $data['invoice'] = $this->omni_sales_model->get_invoice($data['order']->number_invoice);
              }              
            $data['title'] = $data_cart->name;    
            $this->load->view('order_list/cart_detailt', $data); 
        } 
    }
    /**
     * add_woocommerce_store 
     * @return view
     */
  public function add_woocommerce_store(){
        $data['title'] = _l('channel_woocommerce');
        $this->load->view('sales_channel/manage_channel_woocommerce', $data);
    }
    /**
     * add channel woocommerce
     * @return redirect
     */
    public function add_channel_woocommerce(){
        if($this->input->post()){
            $data = $this->input->post();
            if($data['id'] == ''){
                $insert_id = $this->omni_sales_model->add_channel_woocommerce($data);
                if ($insert_id) {
                    $message = _l('added_successfully');
                    set_alert('success', $message);
                }
            }else{
                $id = $data['id'];
                unset($data['id']);
                $success = $this->omni_sales_model->update_channel_woocommerce($data, $id);
                if ($success) {
                    $message = _l('updated_successfully');
                    set_alert('success', $message);
                }
            }
            redirect(admin_url('omni_sales/add_woocommerce_store/'));
        }
    }
    /**
     * table channel woocommerce
     * @return table
     */
    public function table_channel_woocommerce(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_channel_woocommerce'));
    }
    /**
     * detail channel wcm 
     * @param  int $id
     * @return view
     */
    public function detail_channel_wcm($id){
        $data['group'] = $this->input->get('group');

        $data['title'] = _l('detail_channel_wcm');

        $data['tab'][] = 'product';
       
       
     
        if($data['group'] == ''){
            $data['group'] = 'product';
        }

        $data['tabs']['view'] = 'includes/'.$data['group'];
        $data['id'] = $id;
        $data['group_product'] = $this->omni_sales_model->get_group_product();
        $data['products'] = $this->omni_sales_model->get_product();

        $this->load->view('sales_channel/detail_channel_woocommerce', $data);
    }
    /**
     * delete channel wcm
     * @param  int $id
     * @return  redirect
     */
    public function delete_channel_wcm($id){
        $response = $this->omni_sales_model->delete_channel_woocommerce($id);
        if($response == true){
            set_alert('success', _l('deleted'));
        }
        else{
            set_alert('warning', _l('problem_deleting'));            
        }
        redirect(admin_url('omni_sales/add_woocommerce_store/'));
    }
    /**
     * table product woocommerce
     * @return table
     */
    public function table_product_woocommerce(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_product_woocommerce'));
    }
    /**
     * add product channel wcm
     * @return redirect
     */
    public function add_product_channel_wcm(){
        if($this->input->post()){
            $data = $this->input->post();
            if($data['woocommere_store_id'] != ''){
                $channel = $data['woocommere_store_id'];
                $insert_id = $this->omni_sales_model->add_product_channel_wcm($data);
               if ($insert_id) {
                    $message = _l('added_successfully');
                    set_alert('success', $message);
                }
                redirect(admin_url('omni_sales/detail_channel_wcm/'.$data['woocommere_store_id'].'?group=product'));
            }           
        }
    }
    /**
     * register
     * @return view
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

        if (get_option('use_recaptcha_customers_area') == 1
            && get_option('recaptcha_secret_key') != ''
            && get_option('recaptcha_site_key') != '') {
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
                      'contact_phonenumber' => $data['contact_phonenumber'] ,
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
                    redirect($redUrl);
                }
            }
        }

        $data['title']     = _l('clients_register_heading');
        $data['bodyclass'] = 'register';
        $this->data($data);
        $this->view('register');
        $this->layout();
    }
    /**
     * sync products to store
     * @param  int $store_id
     * @return json
     */
    public function sync_products_to_store($store_id){
        $success = $this->omni_sales_model->sync_from_the_system_to_the_store($store_id);
        echo json_encode([true]);
    }
    /**
     * process orders woo
     * @param  int $store_id 
     * @return json
     */
    public function process_orders_woo($store_id){
        $result = $this->omni_sales_model->process_orders_woo($store_id);
        echo json_encode([$result]);
    }
    /**
     * get total order
     * @param  int  $id
     * @param  boolean $voucher 
     * @return array
     */
    public function get_total_order($id ='',$voucher = false){        
        $data_detailt = $this->get_cart_detailt_by_master($id);
        $total = 0;
        foreach ($data_detailt as $key => $value) {
           $total += $value['quantity'] * $value['prices'];
        }
        return ['total' => $total,'sub_total' => $total,'discount' => '0'];
    }
    /**
     * add invoice and out of stock
     * @param int $orderid
     * @return redirect
     */
    public function add_inv_and_out_of_stock($orderid){
        $success = $this->omni_sales_model->add_inv_and_out_of_stock($orderid);
        if ($success) {
            $message = _l('added_successfully');
            set_alert('success', $message);
        }
        redirect(admin_url('omni_sales/view_order_detailt/'.$orderid));
    }

    /**
     * { admin change status }
     *
     * @param  $order_number  The order number
     * @return json
     */
    public function admin_change_status($order_number){
        if($this->input->post()){
            $data = $this->input->post();
                $message = '';
                $insert_id = $this->omni_sales_model->change_status_order($data,$order_number,1);
                if ($insert_id) {
                   echo json_encode([
                     'message' => $message,
                     'success' => true
                   ]);
                   die;
                }               
        }
    }
    /**
     *  process inventory synchronization
     * @param  int $store_id 
     * @return json
     */
    public function process_inventory_synchronization($store_id){
        $result = $this->omni_sales_model->process_inventory_synchronization($store_id);
        echo json_encode([$result]);
    }
    /* Add new invoice or update existing */
    /**
     * invoice
     * @param  int $id
     * @return view    
     */
    public function invoice($id = '')
    {
        $this->load->model('invoices_model');
        if ($this->input->post()) {
            $invoice_data = $this->input->post();
            if ($id != '') {
                if (!has_permission('invoices', '', 'create')) {
                    access_denied('invoices');
                }
                $newitems = [];     
                foreach ($invoice_data['items'] as $key => $value) {
                    array_push($newitems, array('order' => $key, 'description' => $value['description'], 'long_description' => $value['long_description'], 'qty' => $value['qty'], 'unit' => $value['unit'], 'rate'=> $value['rate']));
                }
                $invoice_data['newitems'] = $newitems;
                unset($invoice_data['items']);
                $id_invoice = $this->invoices_model->add($invoice_data);
                if ($id_invoice) {
                    set_alert('success', _l('create_successfully', _l('invoice')));

                    if (isset($invoice_data['save_and_record_payment'])) {
                        $this->session->set_userdata('record_payment', true);
                    }                    
                    redirect(admin_url('omni_sales/view_order_detailt/'.$id));
                }
                die;
            }
        }

        if($id!=''){
            $data_order = $this->omni_sales_model->get_cart($id);
            $data_order_detailt = $this->omni_sales_model->get_cart_detailt_by_master($id);
            $list_item = [];
            $total = 0;

            foreach ($data_order_detailt as $key => $value) {
                $data_product = $this->omni_sales_model->get_product($value['product_id']);
                $long_description = '';
                $unit = '';
                if($data_product){
                    $long_description = $data_product->long_description;
                    $data_unit = $this->omni_sales_model->get_unit($data_product->unit_id);
                    if($data_unit){
                        $unit = $data_unit->unit_name;
                    }
                }

                array_push($list_item, array(
                      "id"=> '',
                      "rel_id"=> $value['id'],
                      "rel_type"=> 'invoice',
                      "description"=> $value['product_name'],
                      "long_description"=> $long_description,
                      "qty"=> $value['quantity'],
                      "rate"=> $value['prices'],
                      "unit"=> $unit,
                      "taxname"=> 0,
                      "item_order"=> $key,
                  ));
                $total+= $value['quantity'] * $value['prices'];
            }

      $data["invoices_to_merge"] = [];

      $client_std = new stdClass; 
        $client_std->userid = $data_order->userid;
        $client_std->company = $data_order->company;
        $client_std->vat =0;
        $client_std->phonenumber = $data_order->phonenumber;
        $client_std->country = $data_order->country;
        $client_std->city = $data_order->city;
        $client_std->zip = $data_order->zip;
        $client_std->state = $data_order->state;
        $client_std->address = $data_order->address;
        $client_std->website = '';
        $client_std->datecreated = $data_order->datecreator;
        $client_std->active = 1;
        $client_std->leadid = 0;
        $client_std->billing_street = $data_order->billing_street;
        $client_std->billing_city = $data_order->billing_city;
        $client_std->billing_state = $data_order->billing_state;
        $client_std->billing_zip = $data_order->billing_zip;
        $client_std->billing_country = $data_order->billing_country;
        $client_std->shipping_street = $data_order->shipping_street;
        $client_std->shipping_city = $data_order->shipping_city;
        $client_std->shipping_state = $data_order->shipping_state;
        $client_std->shipping_zip = $data_order->shipping_zip;
        $client_std->shipping_country = $data_order->shipping_country;
        $client_std->longitude = '';
        $client_std->latitude ='';
        $client_std->default_language ='';
        $client_std->default_currency = '';
        $client_std->show_primary_contact = '';
        $client_std->stripe_id = '';
        $client_std->registration_confirmed = '';
        $client_std->addedfrom = get_staff_user_id();


      $data_object = new stdClass; 
       $data_object->id = '';
       $data_object->sent = '0';
          $data_object->datesend = date('Y-m-d');
          $data_object->clientid = $data_order->userid;
          $data_object->deleted_customer_name = '';
          $data_object->number = $data_order->order_number;
          $data_object->prefix = '';
          $data_object->number_format = '';
          $data_object->datecreated = date('Y-m-d');
          $data_object->date = date('Y-m-d');
          $data_object->duedate = date('Y-m-d');
          $data_object->currencies = 1;
          $data_object->subtotal = 1223;
          $data_object->total_tax = 1;
          $data_object->total = 1234;
          $data_object->adjustment = '';
          $data_object->addedfrom = get_staff_user_id();
          $data_object->hash = '';
          $data_object->status = 1;
          $data_object->clientnote = '';
          $data_object->adminnote = '';
          $data_object->last_overdue_reminder = '';
          $data_object->cancel_overdue_reminders = '';
          $data_object->allowed_payment_modes = '';
          $data_object->token = '';
          $data_object->discount_percent = '';
          $data_object->discount_total = '';
          $data_object->discount_type = '';
          $data_object->recurring = '';
          $data_object->recurring_type = '';
          $data_object->custom_recurring = '';
          $data_object->cycles = '';
          $data_object->total_cycles = '';
          $data_object->is_recurring_from = '';
          $data_object->last_recurring_date = '';
          $data_object->terms = '';
          $data_object->sale_agent = get_staff_user_id();
          $data_object->billing_street = $data_order->billing_street;
          $data_object->billing_city = $data_order->billing_city;
          $data_object->billing_state = $data_order->billing_state;
          $data_object->billing_zip = $data_order->billing_zip;
          $data_object->billing_country = $data_order->billing_country;
          $data_object->shipping_street = $data_order->shipping_street;
          $data_object->shipping_city = $data_order->shipping_city;
          $data_object->shipping_state = $data_order->shipping_state;
          $data_object->shipping_zip = $data_order->shipping_zip;
          $data_object->shipping_country = $data_order->userid;
          $data_object->include_shipping = '';
          $data_object->show_shipping_on_invoice = '';
          $data_object->show_quantity_as = '';
          $data_object->project_id = '';
          $data_object->subscription_id = '';
          $data_object->percent_company = '';
          $data_object->percent_company_total = '';
          $data_object->percent_patient = '';
          $data_object->company_select = '';
          $data_object->percent_patient_total = '';
          $data_object->symbol = '';
          $data_object->name = '';
          $data_object->decimal_separator = '';
          $data_object->thousand_separator = '';
          $data_object->placement = '';
          $data_object->isdefault = '';
          $data_object->currencyid = '';
          $data_object->currency_name = '';
          $data_object->total_left_to_pay = $total;
          $data_object->items =$list_item;
          $data_object->attachments = [];
          $data_object->visible_attachments_to_customer_found = false;
          $data_object->client = $client_std;
          $data_object->payments =  [];
          $data_object->currency =  '1';
          $data['invoice'] = $data_object;
          array_push($data["invoices_to_merge"],$data_object);
        }


        if ($this->input->get('customer_id')) {
            $data['customer_id'] = $this->input->get('customer_id');
        }

        $this->load->model('payment_modes_model');
        $data['payment_modes'] = $this->payment_modes_model->get('', [
            'expenses_only !=' => 1,
        ]);

               $this->load->model('taxes_model');
        $data['taxes'] = $this->taxes_model->get();
        $this->load->model('invoice_items_model');

        $data['ajaxItems'] = false;
        if (total_rows(db_prefix().'items') <= ajax_on_total_items()) {
            $data['items'] = $this->invoice_items_model->get_grouped();
        } else {
            $data['items']     = [];
            $data['ajaxItems'] = true;
        }
        $data['items_groups'] = $this->invoice_items_model->get_groups();

        $this->load->model('currencies_model');
        $data['currencies'] = $this->currencies_model->get();

        $data['base_currency'] = $this->currencies_model->get_base_currency();

        $data['staff']     = $this->staff_model->get('', ['active' => 1]);
        $data['title'] = _l('create_invoice');
        $data['bodyclass'] = 'invoice';


        $this->load->view('omni_sales/invoice/invoice', $data);
    }
    /**
     * trade discount
     * @return view
     */
  public function trade_discount(){
        $data['title'] = _l('trade_discount_title');
        $this->load->view('trade_discount/manage', $data);
    }
    /**
     * table trade discount
     * @return table
     */
    public function table_trade_discount(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_trade_discount'));
    }
    /**
     * new trade discount
     * @param  int $id 
     * @return view     
     */
    public function new_trade_discount($id = ''){
        $this->load->model('client_groups_model');
        $this->load->model('clients_model');
        $this->load->model('warehouse/warehouse_model');
        $data['title'] = _l('new_trade_discount');
        $data['group_clients'] = $this->client_groups_model->get_groups();
        $data['clients'] = $this->clients_model->get();
        $data['group_items'] = $this->warehouse_model->get_commodity_group_type();
        $data['items'] = $this->warehouse_model->get_commodity_code_name();

        if($id != ''){
            $data['title'] = _l('update_trade_discount');
            $data['stores'] = $this->omni_sales_model->get_woocommere_store();
            $data['id'] = $id;
            $data['discount'] = $this->omni_sales_model->get_discount($id);
        }
        $this->load->model('currencies_model');
        $data['base_currency'] = $this->currencies_model->get_base_currency();
        $this->load->view('trade_discount/new_trade_discount', $data);
    }
    /**
     * add discount form
     * @return redirect
     */
    public function add_discount_form(){
        $data = $this->input->post();
        if($data['id'] == ''){
            $success = $this->omni_sales_model->add_discount_form($data);
            if ($success) {
                $message = _l('added_successfully');
                set_alert('success', $message);
            }
        }else{
            $id = $data['id'];
            unset($data['id']);
            $success = $this->omni_sales_model->update_discount_form($data, $id);
            if ($success) {
                $message = _l('updated_successfully');
                set_alert('success', $message);
            }
        }
        redirect(admin_url('omni_sales/trade_discount'));
    }
    /**
     * delete trade discount
     * @param  int $id 
     * @return  redirect
     */
    public function delete_trade_discount($id){
        $delete_success = $this->omni_sales_model->delete_trade_discount($id);
        if($delete_success == true){
            set_alert('success', _l('deleted', _l('trade_discount')));
        }
        else{
            set_alert('warning', _l('problem_deleting'));            
        }
        redirect(admin_url('omni_sales/trade_discount'));
    }
    /**
     * get product by group pos channel
     * @param  int $page 
     * @param  int $id   
     * @param  string $key  
     * @return json
     */
    public function get_product_by_group_pos_channel($page = '', $id = '',$key=''){ 
                  $data['ofset'] = 30;     
                  $channel = 1;     
                  $date = date('Y-m-d');
                  $data_product = $this->omni_sales_model->get_list_product_by_group(1,$id,$key,($page-1)*$data['ofset'],$data['ofset']);
                  $data['product'] = [];
                  foreach ($data_product['list_product'] as $item) {
                    $discount_percent = 0;
                    $total_tax = 0;
                    $temp = 0;

                    $data_discount = $this->omni_sales_model->check_discount($item['id'], $date, 1);
                    if($data_discount){
                      $discount_percent = $data_discount->discount;
                    }
                    $price = 0;
                    $data_prices = $this->omni_sales_model->get_price_channel($item['id'],$channel);
                    if($data_prices){
                      $price = $data_prices->prices;
                    }
                    $percent_tax = $this->omni_sales_model->get_tax($item['tax']);
                    if($percent_tax == ''){
                      $temp = 1;
                      $percent_tax = 0;
                    }else{
                      $total_tax = ($percent_tax->taxrate * $price)/100;
                      $percent_tax = $percent_tax->taxrate;
                    }
                    array_push($data['product'], array(
                      'id' => $item['id'],
                      'name' => $item['description'],
                      'sku_code' => $item['sku_code'],
                      'price' => $price,
                      'w_quantity' => $this->get_stock($item['id']),
                      'discount_percent' => $discount_percent,
                      'price_discount' => $this->get_price_discount($price, $discount_percent),
                      'tax' => $item['tax'],
                      'percent_tax' => $percent_tax,
                      'total_tax' => $total_tax,
                      'group_id' => $item['group_id'],
                    ));
                  }      

                  $data['group_id'] = $id;
                  $data['page'] = $page;
                  $data['ofset_count'] = $data_product['count'];
                  $data['total_page'] = ceil($data['ofset_count']/$data['ofset']);

                  $data['title_group'] = '';
                  $this->load->model('currencies_model');
                  $data['base_currency'] = $this->currencies_model->get_base_currency();

                  $html = $this->load->view('pos/list_product_with_page',$data,true);

                  echo json_encode([
                    'data'=>$html
                  ]);
                  die;
    }
    /**
     * get stock
     * @param  int $product_id 
     * @return $w_qty         
     */
    public function get_stock($product_id){
        $w_qty = 0;
        $wh = $this->omni_sales_model->get_total_inventory_commodity($product_id);
        if($wh){
          if($wh->inventory_number){
            $w_qty = $wh->inventory_number;
          }
        }
        return $w_qty;
      }
    /**
     * new voucher
     * @param  int $id
     * @return view
     */
    public function new_voucher($id = ''){
        $this->load->model('client_groups_model');
        $this->load->model('clients_model');
        $this->load->model('warehouse/warehouse_model');
        $data['title'] = _l('new_voucher');
        $data['group_clients'] = $this->client_groups_model->get_groups();
        $data['clients'] = $this->clients_model->get();
        $data['group_items'] = $this->warehouse_model->get_commodity_group_type();
        $data['items'] = $this->warehouse_model->get_commodity_code_name();
        if($id != ''){
            $data['id'] = $id;
            $data['discount'] = $this->omni_sales_model->get_discount($id);
            $data['title'] = _l('update_voucher');

        }
        $this->load->model('currencies_model');
        $data['base_currency'] = $this->currencies_model->get_base_currency();
        $this->load->view('trade_discount/voucher', $data);
    }  
    /**
     * table voucher
     * @return table
     */
    public function table_voucher(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_voucher'));
    }
    /**
     *  create invoice pos 
     * @param  int $client 
     * @return json         
     */
  public function create_invoice_pos($client =''){ 
        $data = $this->input->post();
          $data['userid'] = $client;
          $data['discount'] =  '';
          $data['discount_type'] =  '';
          $data['notes'] =   '';
          $data['voucher'] = '';   
          if($client != ''){
                $success = false;
                $id_inv = $this->omni_sales_model->check_out_pos($data);

                if($id_inv){
                    $number_invoice = $id_inv['number_invoice'];
                    $stock_export_number = $id_inv['stock_export_number'];
                    $id = $this->omni_sales_model->get_id_invoice($number_invoice);
                    $success = true;
                }
              echo json_encode([
                'success'=>$success,
                'id'=>$id,
                'stock_export_number'=>$stock_export_number,
                'number_invoice'=>$number_invoice
              ]);
              die;
          }
    }
  /**
   * table log discount
   * @return table
   */
  public function table_log_discount(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_log_discount'));
  }
    /**
     * create export stock
     * @param int $orderid
     * @return redirect
     */
    public function create_export_stock($orderid,$invoice){
        $success = $this->omni_sales_model->create_export_stock($orderid, 2);
        if ($success) {
            $message = _l('create_successfully');
            set_alert('success', $message);
        }
        redirect(admin_url('omni_sales/view_order_detailt/'.$orderid));
    }
    /**
       * get price discount
       * @param  int $prices           
       * @param   $discount_percent 
       * @return      discount_percent              
       */
    public function get_price_discount($prices, $discount_percent){
          return ($discount_percent * $prices) / 100;
    }
    /**
     * setting sync management
     * @return view
     */
    public function setting(){
        $data['tab'] = $this->input->get('tab');
        $data['items'] = $this->input->get('items');

        if($data['tab'] == ''){
                $data['tab'] = 'automatic_sync_config';
        }
        if($data['tab'] == 'order_notificaiton'){
            $data['tab'] = 'notification_recipient';
        }

        if($data['tab'] == 'automatic_sync_config'){
          if($data['items'] == ''){
            $data['items'] = 'crm_to_woocommerce_store';
          }
          switch ($data['items']) {
            case 'crm_to_woocommerce_store':
              $data['items'] = 'crm_to_woocommerce_store';
              break;
            case 'woocommerce_store_to_crm':
              $data['items'] = 'woocommerce_store_to_crm';
              break;

            default:
              $data['items'] = 'crm_to_woocommerce_store';
              break;
          }
        }
        $data['staff'] = get_option('staff_sync_orders');
        $data['time_minute'] = get_option('minute_sync');
        $data['minute'] = get_option('minute_sync_orders');
        $data['sync_omni_sales_products'] = get_option('sync_omni_sales_products');
        $data['sync_omni_sales_orders'] = get_option('sync_omni_sales_orders');
        $data['sync_omni_sales_inventorys'] = get_option('sync_omni_sales_inventorys');
        $data['sync_omni_sales_description'] = get_option('sync_omni_sales_description');
        $data['sync_omni_sales_images'] = get_option('sync_omni_sales_images');
        $data['price_crm_woo'] = get_option('price_crm_woo');
        $data['product_info_enable_disable'] = get_option('product_info_enable_disable');
        $data['product_info_image_enable_disable'] = get_option('product_info_image_enable_disable');

        $data['minute_sync_product_info_time1'] = get_option('minute_sync_product_info_time1');
        $data['minute_sync_inventory_info_time2'] = get_option('minute_sync_inventory_info_time2');
        $data['minute_sync_price_time3'] = get_option('minute_sync_price_time3');
        $data['minute_sync_decriptions_time4'] = get_option('minute_sync_decriptions_time4');
        $data['minute_sync_images_time5'] = get_option('minute_sync_images_time5');
        $data['minute_sync_product_info_time7'] = get_option('minute_sync_product_info_time7');
        $data['minute_sync_product_info_images_time8'] = get_option('minute_sync_product_info_images_time8');

        $this->load->model('staff_model');
          $data['staffs'] = $this->staff_model->get('staff');

          $data['title'] = _l($data['tab']);
         $this->load->view('setting/setting', $data);
    }
    /**
     * setting sync
     * @return view
     */
    public function save_setting($type){
      $data =  $this->input->post();
      switch ($type) {
        case 'sync_orders':
          update_option('minute_sync_orders',$data['minute']);
          redirect(admin_url('omni_sales/setting?tab='.$type));
          break;
        case 'sync_inventory':
          update_option('minute_sync',$data['minute']);
          redirect(admin_url('omni_sales/setting?tab='.$type));
          break;
        case 'notification_recipient':
          update_option('staff_sync_orders',$data['staff']);
          redirect(admin_url('omni_sales/setting?tab='.$type));
          break;
        case 'automatic_sync_config':
          if($data['sync_omni_sales_products']){
            update_option('sync_omni_sales_products', 1);
          }else{
            update_option('sync_omni_sales_products', 0);
          }
          if($data['sync_omni_sales_inventorys']){
            update_option('sync_omni_sales_inventorys', 1);
          }else{
            update_option('sync_omni_sales_inventorys', 0);
          }   
          if($data['sync_omni_sales_description']){
            update_option('sync_omni_sales_description', 1);
          }else{
            update_option('sync_omni_sales_description', 0);
          }   
          if($data['sync_omni_sales_images']){
            update_option('sync_omni_sales_images', 1);
          }else{
            update_option('sync_omni_sales_images', 0);
          }   
          if($data['price_crm_woo']){
            update_option('price_crm_woo', 1);
          }else{
            update_option('price_crm_woo', 0);
          }
          if($data['time1']){
            update_option('minute_sync_product_info_time1', $data['time1']);
          }
          if($data['time2']){
            update_option('minute_sync_inventory_info_time2', $data['time2']);
          }
          if($data['time3']){
            update_option('minute_sync_price_time3', $data['time3']);
          }
          if($data['time4']){
            update_option('minute_sync_decriptions_time4', $data['time4']);
          }
          if($data['time5']){
            update_option('minute_sync_images_time5', $data['time5']);
          }

          if($data['time6']){
            update_option('minute_sync_orders', $data['time6']);
          }
          if($data['time7']){
            update_option('minute_sync_product_info_time7', $data['time7']);
          }
          if($data['time8']){
            update_option('minute_sync_product_info_images_time8', $data['time8']);
          }
          if($data['sync_omni_sales_orders']){
            update_option('sync_omni_sales_orders', 1);
          }else{
            update_option('sync_omni_sales_orders', 0);
          }   
          if($data['product_info_enable_disable']){
            update_option('product_info_enable_disable', 1);
          }else{
            update_option('product_info_enable_disable', 0);
          }
          if($data['product_info_image_enable_disable']){
            update_option('product_info_image_enable_disable', 1);
          }else{
            update_option('product_info_image_enable_disable', 0);
          }
          redirect(admin_url('omni_sales/setting?tab=automatic_sync_config'));
          break;  
        default:
          break;
      }
    }
    /**
     * total_quantity_sold
     * @return json 
     */
    public function total_quantity_sold_table(){
        if ($this->input->is_ajax_request()) {
            if($this->input->post()){
                $select = [
                    'id',           
                    'id',           
                    'id',           
                    'id',           
                    'id',           
                    'id',           
                ];
                $where              = [];
                $aColumns     = $select;
                $sIndexColumn = 'id';
                $sTable       = db_prefix() . 'emr_medical_visit';
                $join         = [];
 $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, $where, [ 
                'datecreator', 'id','status'               
                ]);

                $output  = $result['output'];
                $rResult = $result['rResult'];
                foreach ($rResult as $aRow) {
                    $row = [];
                    $row[] = $aRow['id']; 

                    if($aRow['name_medical_visit']){
                    $data_r = '<a href="'.admin_url('emr/add_medical/'.$aRow['id']).'">'.$aRow['name_medical_visit'].'</a>';

                    $data_r .= '<div class="row-options">
                        <a href="' . admin_url('emr/add_medical/' . $aRow['id'] ).'" >' . _l('view') . '</a>';
                    if(is_admin() || has_permission('medical_visit', '', 'edit')){
                       $data_r .= ' | <a href="#" data-id="'.$aRow['id'].'" onclick="edit(this); return false;" data-name="'.$aRow['name_medical_visit'].'" >' ._l('edit') . '</a> ';   
                    }   
                    
                    if(is_admin() || has_permission('medical_visit', '', 'delete')){
                        $data_r .= '| <a href="' . admin_url('emr/delete_medical_visit/' . $aRow['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
                    }

                        $row[] = $data_r;
                    }
                    
                    $row[] = $this->emr_model->get_client($aRow['patients_id'])->company; 
                    $row[] = _d($aRow['registration_date']); 
                    $row[] = $aRow['datecreator']; 

                    if($aRow['status'] == 0){
                        $row[] = '<span class="label label-primary  s-status status-'.$aRow['status'].'">NEW</span>';
                    }else if($aRow['status'] == 1){
                        $row[] = '<span class="label label-warning  s-status status-'.$aRow['status'].'">TRACKING DISEASE</span>';
                    }else if($aRow['status'] == 2){
                        $row[] = '<span class="label label-success  s-status status-'.$aRow['status'].'">HEALED</span>';
                    }else{
                        $row[] = '<span class="label label-danger  s-status status-'.$aRow['status'].'">CLOSED</span>';
                    }
                    $row[] = $aRow['status']; 
                    $output['aaData'][] = $row;                                      
                }
                
                echo json_encode($output);
             }
        }
    }
    /**
     * total statitic
     * @return json 
     */
    public function total_statitic(){
        if($this->input->is_ajax_request()) {
            $this->load->model('currencies_model');
            $report_from = $this->input->post('report_from');
            $by_year = $this->input->post('by_year');
            $by_month = $this->input->post('by_month');
            $group = $this->input->post('by_group');
            $product = $this->input->post('by_product');
            $channel = $this->input->post('by_channel');
            $report_from = $this->input->post('report_from');
            $report_to = $this->input->post('report_to');
            $type = $this->input->post('type');


            $channel_s = array('POS' => 1, 'PORTAL' => 2, 'WOOCOMMERCE' => 3);
            $list_channel = [];
            $chann_s = [];
            if($channel){
                    $list_temp = [];

                    foreach ($channel_s as $kk => $ch) {
                        foreach ($channel as $kkk => $ch_s) {
                            if($ch_s == $ch){
                               $list_temp[$kk] = $ch;
                            }
                        }
                    }
                    $list_channel = $list_temp;
            }
            else{
               $list_channel = $channel_s;
            }

            if($type == 0){
                $category = array('Su', 'Mon', 'Tu', 'We', 'Th', 'Fr', 'Sa');
                $day_list = []; 
                $day_list[] = date('d', strtotime("Sunday last week")); 
                $day_list[] = date('d', strtotime("Monday this week")); 
                $day_list[] = date('d', strtotime("Tuesday this week")); 
                $day_list[] = date('d', strtotime("Wednesday this week")); 
                $day_list[] = date('d', strtotime("Thursday this week")); 
                $day_list[] = date('d', strtotime("Friday this week")); 
                $day_list[] = date('d', strtotime("Saturday this week")); 

                $first = date('d', strtotime("Sunday last week"));
                $end = date('d', strtotime("Saturday this week"));
                $start_date = date('Y-m-d', strtotime("Sunday last week")).' 00:00:00';
                $end_date = date('Y-m-d', strtotime("Saturday this week")).' 23:59:59';

                $new_array = [];
                foreach ($list_channel as $key => $value) {
                        $list_value = [];
                        $data_count = $this->omni_sales_model->get_data_by_week($start_date, $end_date, $value);
                        foreach ($day_list as $day) {
                            $c = 0;
                            foreach ($data_count as $k => $item) {
                                if((int)$day == (int)$item['dayonly']){
                                    $c = (int)$item['count'];
                                }
                            }
                            $list_value[] = $c;                     
                        }
                        array_push($new_array, array('name' => $key, 'data' => $list_value));
                }

                if($group){

                    $list_id = implode(',', $group);
                    $q = 'select * from tblitems_groups where id in ('.$list_id.')';                      


                    $q_channel = '';
                    $list_channel = [];
                    if($channel){
                          $list_channel = implode(',', $channel);
                          $q_channel .= ' and channel_id in ('.$list_channel.') ';                                
                    }

                    $list_group = $this->omni_sales_model->get_data($q,true);


                    $new_array = [];
                    foreach ($list_group as $key => $value) {                         
                            $list_value = [];
                            $query = 'select day(datecreator) as dayonly, count(1) as count
                                        from tblcart 
                                        where id in (SELECT cart_id
                                        FROM tblcart_detailt 
                                        where product_id in (SELECT id FROM tblitems where group_id ='.$value['id'].')) and datecreator between \''.$start_date.'\' and \''.$end_date.'\''.$q_channel.'group by dayonly';
                            $data_count = $this->omni_sales_model->get_data($query,true);
                            foreach ($day_list as $day) {
                              $c = 0;
                              foreach ($data_count as $k => $item) {
                                  if((int)$day == (int)$item['dayonly']){
                                      $c = (int)$item['count'];
                                  }
                              }
                              $list_value[] = $c;                     
                            }
                            array_push($new_array, array('name' => $value['name'], 'data' => $list_value));
                    }
                }
                if($product){

                    $list_id = [];
                    $q = 'select * from tblitems';
                    $con_q = '';
                    if($product){
                          $list_id = implode(',', $product);
                          $con_q = ' where id in ('.$list_id.')';
                    }

                    $q_channel = '';
                    $list_channel = [];
                    if($channel){
                          $list_channel = implode(',', $channel);
                          $q_channel .= ' and channel_id in ('.$list_channel.')';                                
                    }

                    $q_group = '';
                    if($group){
                          $list_id = implode(',', $group);
                          $q_group .= ' and product_id in (SELECT id FROM tblitems where group_id in ('.$list_id.')) ';
                    }

                    $q = $q.$con_q;
                    $list_product = $this->omni_sales_model->get_data($q,true); 
                    $new_array = [];
                    foreach ($list_product as $key => $value) { 
                            $list_value = [];

                            $query = 'select day(datecreator) as dayonly, count(1) as count
                                        from tblcart 
                                        where id in (SELECT cart_id
                                        FROM tblcart_detailt 
                                        where product_id = '.$value['id'].$q_group.') and datecreator between \''.$start_date.'\' and \''.$end_date.'\''.$q_channel.'group by dayonly';
                            $data_count = $this->omni_sales_model->get_data($query,true);
                            foreach ($day_list as $day) {
                              $c = 0;
                              foreach ($data_count as $k => $item) {
                                  if((int)$day == (int)$item['dayonly']){
                                      $c = (int)$item['count'];
                                  }
                              }
                              $list_value[] = $c;                     
                            }
                            array_push($new_array, array('name' => $value['description'], 'data' => $list_value));
                    }

                }
            }  

            if($type == 1){

                $start_date = $by_month.'-01-01 00:00:00';
                $end_date = $by_month.'-12-31 23:59:59';

                 $category = array('Jan',
                                    'Feb',
                                    'Mar',
                                    'Apr',
                                    'May',
                                    'Jun',
                                    'Jul',
                                    'Aug',
                                    'Sep',
                                    'Oct',
                                    'Nov',
                                    'Dec');            
                $new_array = [];
                foreach ($list_channel as $key => $value) {
                        $list_value = [];
                         $query = 'select month(datecreator) as monthonly, count(1) as count
                                        from tblcart 
                                        where  channel_id = '.$value.'  and datecreator between \''.$start_date.'\' and \''.$end_date.'\' group by monthonly';
                        $data_count = $this->omni_sales_model->get_data($query,true);
                        for($i = 1; $i <= 12; $i++){
                            $c = 0;
                            foreach ($data_count as $k => $item) {
                                if($i == $item['monthonly']){
                                    $c = (int)$item['count'];
                                }
                            }
                            $list_value[] = $c;
                        }
                        array_push($new_array, array('name' => $key, 'data' => $list_value));
                }
                if($group){

                    $list_id = [];
                    $q = 'select * from tblitems_groups';
                    $con_q = '';
                    if($group){
                          $list_id = implode(',', $group);
                          $con_q = ' where id in ('.$list_id.')';
                    }

                    $q_channel = '';
                    $list_channel = [];
                    if($channel){
                          $list_channel = implode(',', $channel);
                          $q_channel .= ' and channel_id in ('.$list_channel.') ';                                
                    }

                    $q = $q.$con_q;
                    $list_group = $this->omni_sales_model->get_data($q,true); 
                    $new_array = [];
                    foreach ($list_group as $key => $value) { 
                            $list_value = [];

                            $query = 'select month(datecreator) as monthonly, count(1) as count
                                        from tblcart 
                                        where id in (SELECT cart_id
                                        FROM tblcart_detailt 
                                        where product_id in (SELECT id FROM tblitems where group_id ='.$value['id'].')) and datecreator between \''.$start_date.'\' and \''.$end_date.'\''.$q_channel.'group by monthonly';

                            $data_count = $this->omni_sales_model->get_data($query,true);
                            for($i = 1; $i <= 12; $i++){
                                $c = 0;
                                foreach ($data_count as $k => $item) {
                                    if($i == $item['monthonly']){                                                
                                        $c = (int)$item['count'];
                                    }
                                }
                                $list_value[] = $c;
                            }
                            array_push($new_array, array('name' => $value['name'], 'data' => $list_value));
                    }
                }
                if($product){

                    $list_id = [];
                    $q = 'select * from tblitems';
                    $con_q = '';
                    if($product){
                          $list_id = implode(',', $product);
                          $con_q = ' where id in ('.$list_id.')';
                    }

                    $q_channel = '';
                    $list_channel = [];
                    if($channel){
                          $list_channel = implode(',', $channel);
                          $q_channel .= ' and channel_id in ('.$list_channel.') ';                                     
                    }

                    $q_group = '';
                    if($group){
                          $list_id = implode(',', $group);
                          $q_group .= ' and product_id in (SELECT id FROM tblitems where group_id in ('.$list_id.'))';
                    }

                    $q = $q.$con_q;
                    $list_product = $this->omni_sales_model->get_data($q,true); 
                    $new_array = [];
                    foreach ($list_product as $key => $value) { 
                            $list_value = [];

                            $query = 'select month(datecreator) as monthonly, count(1) as count
                                        from tblcart 
                                        where id in (SELECT cart_id
                                        FROM tblcart_detailt 
                                        where product_id = '.$value['id'].$q_group.') and datecreator between \''.$start_date.'\' and \''.$end_date.'\''.$q_channel.'group by monthonly';
                            $data_count = $this->omni_sales_model->get_data($query,true);
                            for($i = 1; $i <= 12; $i++){
                                $c = 0;
                                foreach ($data_count as $k => $item) {
                                    if($i == $item['monthonly']){                                                
                                        $c = (int)$item['count'];
                                    }
                                }
                                $list_value[] = $c;
                            }
                            array_push($new_array, array('name' => $value['description'], 'data' => $list_value));
                    }

                }
            } 

               if($type == 2){
                $min = min($by_year);
                $max = max($by_year);
                $start_date = $min.'-01-01 00:00:00';
                $end_date = $max.'-12-31 23:59:59';
                $list_cat = implode(',', $by_year);
                $category = $by_year;

                $new_array = [];
                foreach ($list_channel as $key => $value) {
                        $list_value = [];
                        $query = 'SELECT year(datecreator) as yearonly,count(*) as count FROM '.db_prefix().'cart where datecreator between \''.$start_date.'\' and \''.$end_date.'\' and channel_id = '.$value.' group by yearonly';
                        $data_count = $this->omni_sales_model->get_data($query,true);
                        foreach ($by_year as $i) {
                            $c = 0;
                            foreach ($data_count as $k => $item) {
                                if($i == $item['yearonly']){
                                    $c = (int)$item['count'];
                                }
                            }
                            $list_value[] = $c;
                        }
                        array_push($new_array, array('name' => $key, 'data' => $list_value));
                }

                if($group){

                    $list_id = [];
                    $q = 'select * from tblitems_groups';
                    $con_q = '';
                    if($group){
                          $list_id = implode(',', $group);
                          $con_q = ' where id in ('.$list_id.')';
                    }

                    $q_channel = '';
                    $list_channel = [];
                    if($channel){
                          $list_channel = implode(',', $channel);
                          $q_channel .= ' and channel_id in ('.$list_channel.') ';                                
                    }

                    $q = $q.$con_q;
                    $list_group = $this->omni_sales_model->get_data($q,true); 
                    $new_array = [];
                    foreach ($list_group as $key => $value) { 
                            $list_value = [];

                            $query = 'select year(datecreator) as yearonly, count(1) as count
                                        from tblcart 
                                        where id in (SELECT cart_id
                                        FROM tblcart_detailt 
                                        where product_id in (SELECT id FROM tblitems where group_id ='.$value['id'].')) and datecreator between \''.$start_date.'\' and \''.$end_date.'\''.$q_channel.'group by yearonly';

                            $data_count = $this->omni_sales_model->get_data($query,true);
                            foreach ($by_year as $i) {
                                $c = 0;
                                foreach ($data_count as $k => $item) {
                                    if($i == $item['yearonly']){                                                
                                        $c = (int)$item['count'];
                                    }
                                }
                                $list_value[] = $c;
                            }
                            array_push($new_array, array('name' => $value['name'], 'data' => $list_value));
                    }
                }
                if($product){

                    $list_id = [];
                    $q = 'select * from tblitems';
                    $con_q = '';
                    if($product){
                          $list_id = implode(',', $product);
                          $con_q = ' where id in ('.$list_id.')';
                    }

                    $q_channel = '';
                    $list_channel = [];
                    if($channel){
                          $list_channel = implode(',', $channel);
                          $q_channel .= ' and channel_id in ('.$list_channel.') ';                                     
                    }

                    $q_group = '';
                    if($group){
                          $list_id = implode(',', $group);
                          $q_group .= ' and product_id in (SELECT id FROM tblitems where group_id in ('.$list_id.'))';
                    }


                    $q = $q.$con_q;
                    $list_product = $this->omni_sales_model->get_data($q,true); 
                    $new_array = [];
                    foreach ($list_product as $key => $value) { 
                            $list_value = [];


                            $query = 'select year(datecreator) as yearonly, count(1) as count
                                        from tblcart 
                                        where id in (SELECT cart_id
                                        FROM tblcart_detailt 
                                        where product_id = '.$value['id'].$q_group.') and datecreator between \''.$start_date.'\' and \''.$end_date.'\''.$q_channel.'group by yearonly';
                            $data_count = $this->omni_sales_model->get_data($query,true);
                            foreach ($by_year as $i) {
                                $c = 0;
                                foreach ($data_count as $k => $item) {
                                    if($i == $item['yearonly']){                                                
                                        $c = (int)$item['count'];
                                    }
                                }
                                $list_value[] = $c;
                            }
                            array_push($new_array, array('name' => $value['description'], 'data' => $list_value));
                    }

                }
            } 

            if($type == 3){
               

                    $start_date = to_sql_date($report_from).' 00:00:00';
                    $end_date = to_sql_date($report_to).' 23:59:59';

                    $timestamp1 = strtotime($report_from);
                    $timestamp2 = strtotime($report_to);

                    $min = date('d', $timestamp1);
                    $max = date('d', $timestamp2);

                $category = []; 
                 for($i = (int)$min; $i <= (int)$max; $i++){
                    $category[] = $i;                          
                }


                $new_array = [];
                foreach ($list_channel as $key => $value) {
                        $list_value = [];
                        $query = 'SELECT day(datecreator) as dayonly,count(*) as count FROM '.db_prefix().'cart where datecreator between \''.$start_date.'\' and \''.$end_date.'\' and channel_id = '.$value.' group by dayonly';

                        $data_count = $this->omni_sales_model->get_data($query,true);
                        for($i = (int)$min; $i <= (int)$max; $i++){
                            $c = 0;

                            foreach ($data_count as $k => $item) {
                                if($i == $item['dayonly']){
                                    $c = (int)$item['count'];
                                }
                            }
                            $list_value[] = $c;
                        }
                        array_push($new_array, array('name' => $key, 'data' => $list_value));
                }

                if($group){

                    $list_id = [];
                    $q = 'select * from tblitems_groups';
                    $con_q = '';
                    if($group){
                          $list_id = implode(',', $group);
                          $con_q = ' where id in ('.$list_id.')';
                    }

                    $q_channel = '';
                    $list_channel = [];
                    if($channel){
                          $list_channel = implode(',', $channel);
                          $q_channel .= ' and channel_id in ('.$list_channel.') ';                                
                    }

                    $q = $q.$con_q;
                    $list_group = $this->omni_sales_model->get_data($q,true); 
                    $new_array = [];
                    foreach ($list_group as $key => $value) { 
                            $list_value = [];

                            $query = 'select day(datecreator) as dayonly, count(1) as count
                                        from tblcart 
                                        where id in (SELECT cart_id
                                        FROM tblcart_detailt 
                                        where product_id in (SELECT id FROM tblitems where group_id ='.$value['id'].')) and datecreator between \''.$start_date.'\' and \''.$end_date.'\''.$q_channel.'group by dayonly';

                            $data_count = $this->omni_sales_model->get_data($query,true);
                              for($i = (int)$min; $i <= (int)$max; $i++){
                                $c = 0;
                                foreach ($data_count as $k => $item) {
                                    if($i == $item['dayonly']){                                                
                                        $c = (int)$item['count'];
                                    }
                                }
                                $list_value[] = $c;
                            }
                            array_push($new_array, array('name' => $value['name'], 'data' => $list_value));
                    }
                }
                if($product){

                    $list_id = [];
                    $q = 'select * from tblitems';
                    $con_q = '';
                    if($product){
                          $list_id = implode(',', $product);
                          $con_q = ' where id in ('.$list_id.')';
                    }

            
                    $q_channel = '';
                    $list_channel = [];
                    if($channel){
                          $list_channel = implode(',', $channel);
                          $q_channel .= ' and channel_id in ('.$list_channel.')';                                     
                    }

                    $q_group = '';
                    if($group){
                          $list_id = implode(',', $group);
                          $q_group .= ' and product_id in (SELECT id FROM tblitems where group_id in ('.$list_id.')) ';
                    }
                    $q = $q.$con_q;
                    $list_product = $this->omni_sales_model->get_data($q,true); 
                    $new_array = [];
                    foreach ($list_product as $key => $value) { 
                            $list_value = [];

                            $query = 'select day(datecreator) as dayonly, count(1) as count
                                    from tblcart 
                                    where id in (SELECT cart_id
                                    FROM tblcart_detailt 
                                    where product_id = '.$value['id'].$q_group.') and datecreator between \''.$start_date.'\' and \''.$end_date.'\''.$q_channel.'group by dayonly';
                            $data_count = $this->omni_sales_model->get_data($query,true);
                             for($i = (int)$min; $i <= (int)$max; $i++){
                                $c = 0;
                                foreach ($data_count as $k => $item) {
                                    if($i == $item['dayonly']){                                                
                                        $c = (int)$item['count'];
                                    }
                                }
                                $list_value[] = $c;
                            }
                            array_push($new_array, array('name' => $value['description'], 'data' => $list_value));
                    }

                }
                
            } 


            echo json_encode([
                'category' => $category,
                'data' => $new_array,
            ]);
          
        }
    }
  /**
     * get store woocommerce
     * @return json
     */
    public function get_store_woo(){
      $stores = $this->omni_sales_model->get_woocommere_store();
      $html = '';
      $html .= '<option value=""></option>';
      foreach ($stores as $key => $value) {
        $html .= '<option value="'.$value['id'].'">'.$value['name_channel'].'</option>';
      }
      echo json_encode([$html]);
    }

    /**
     * table diary sync products
     * @return table
     */
    public function table_diary_sync_products(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_diary_sync_products'));
    }

    /**
     * table diary sync orders
     * @return table
     */
    public function table_diary_sync_orders(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_diary_sync_orders'));
    }

    /**
     * table diary sync inventory manage
     * @return table
     */
    public function table_diary_sync_inventory_manage(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_diary_sync_inventory_manage'));
    }

    /**
     * { delete product store }
     *
     * @param  $store  The store
     * @param  $id     The identifier
     * @return redirect
     */
    public function delete_product_store($store ,$id){
      $response = $this->omni_sales_model->delete_product_store($store, $id);
        if($response == true){
            set_alert('success', _l('deleted', _l('product_store')));
        }
        else{
            set_alert('warning', _l('problem_deleting'));            
        }
        redirect(admin_url('omni_sales/detail_channel_wcm/'.$store));
    }

    /**
     *  process decriptions synchronization
     * @param  int $store_id 
     * @return json
     */
    public function process_decriptions_synchronization($store_id){
        $result = $this->omni_sales_model->process_decriptions_synchronization($store_id);
        echo json_encode([$result]);
    }


    /**
     *  process images synchronization
     * @param  int $store_id 
     * @return json
     */
    public function process_images_synchronization($store_id){
        $result = $this->omni_sales_model->process_images_synchronization($store_id);
        echo json_encode([$result]);
    }
    /**
     * voucher_apply 
     * @return  json
     */
    public function voucher_apply(){
      $data = $this->input->post();        
      $return = $this->omni_sales_model->get_discount_list($data['channel'],$data['client'],$data['voucher']);
      echo json_encode([$return]);
    }
    /**
     * get trade discount
     * @return json 
     */
    public function get_trade_discount(){
        $data = $this->input->post();
        $channel = 1;
        if(isset($data['channel'])){
            $channel = $data['channel'];
        }        
        $list_discount = $this->omni_sales_model->get_discount_list($channel, $data['id']);
        $result = [];        
        if($list_discount != false){
          $result = $list_discount;
        }
        echo json_encode([$result]);
    }

    /**
     * sync products from store
     * @param  int $store_id
     * @return json
     */
    public function sync_products_from_store($store_id){
        $success = $this->omni_sales_model->sync_from_the_store_to_the_system($store_id);
        echo json_encode([true]);
    }
    /**
     * test connect
     * @return json
     */
    public function test_connect()
    {
      $data = $this->input->post();
      if($data['url'] != '' && $data['consumer_key'] != '' && $data['consumer_secret'] != ''){
        $success = $this->omni_sales_model->test_connect($data);
        if($success){
          $message = _l('connection_successful');         
        }else{
          $message = _l('connection_failed');         
        }
      }else{
        $success = false;   
        $message = _l('connection_failed');         
      }

      echo json_encode(['check' => $success, 'message' => $message]);
    }

    /**
     * sync products from store
     * @param  int $store_id
     * @return json
     */
    public function sync_products_from_info_woo($store_id){
        $success = $this->omni_sales_model->sync_products_from_info_woo($store_id);
        if($success){
          echo json_encode([true]);
        }
    }

    /**
     * table sync products from the store basic
     * @return table
     */
    public function table_sync_products_from_the_store_information(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_sync_products_from_the_store'));
    }

    /**
     * table sync products from the store full
     * @return table
     */
    public function table_sync_products_from_the_store_information_images(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_sync_products_from_the_store_information_images'));
    }

    /**
     * table sync price
     * @return table
     */
    public function table_sync_price(){
        $this->app->get_table_data(module_views_path('omni_sales', 'table/table_sync_price'));
    }

    
}

