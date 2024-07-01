<?php
defined('BASEPATH') or exit('No direct script access allowed');
require 'modules/omni_sales/third_party/WooCommerce/HttpClient/OAuth.php';
require 'modules/omni_sales/third_party/WooCommerce/HttpClient/BasicAuth.php';
require 'modules/omni_sales/third_party/WooCommerce/HttpClient/HttpClientException.php';
require 'modules/omni_sales/third_party/WooCommerce/HttpClient/HttpClient.php';
require 'modules/omni_sales/third_party/WooCommerce/HttpClient/Options.php';
require 'modules/omni_sales/third_party/WooCommerce/HttpClient/Request.php';
require 'modules/omni_sales/third_party/WooCommerce/HttpClient/Response.php';
require 'modules/omni_sales/third_party/WooCommerce/Client.php';
use Automattic\WooCommerce\Client;
/**
 * Omni sales model
 */
class Omni_sales_model extends App_Model
{
  /**
   * change active channel 
   * @param   array  $data  
   * @return  bool         
   */
  public function change_active_channel($data){
    $this->db->where('channel',$data['channel']);
        $this->db->update(db_prefix().'sales_channel',$data);
        return true;
  }   
  /**
   * get sales channel by channel   
   * @param  string $channel    
   * @return  object              
   */
  public function get_sales_channel_by_channel($channel =''){
    if($channel != ''){
      $this->db->where('channel',$channel);
          return $this->db->get(db_prefix().'sales_channel')->row();
    }
    else{
      return $this->db->get(db_prefix().'sales_channel')->result_array();
    }
  }
  /**
   *  get_group_product  
   * @param  int $id   
   * @return  object or array object        
   */
  public function get_group_product($id = ''){
    if($id != ''){
      $this->db->where('id',$id);
          return $this->db->get(db_prefix().'items_groups')->row();
    }
    else{
      return $this->db->get(db_prefix().'items_groups')->result_array();
    }
  }
  /**
   *  get_product_by_group   
   * @param  string $group_id    
   * @return  array object               
   */
  public function get_product_by_group($group_id = ''){
    if($group_id != ''){
      $this->db->select('id');      
      $this->db->select('description'); 
      $this->db->select('commodity_code');  
      $this->db->where('group_id',$group_id);
          return $this->db->get(db_prefix().'items')->result_array();
    }
    else{
      $this->db->select('id');      
      $this->db->select('description');
      $this->db->select('commodity_code');        
      return $this->db->get(db_prefix().'items')->result_array();
    }
  }
  /**
   *  get product   
   * @param  int $id    
   * @return  object or array object       
   */
  public function get_product($id = ''){
    if($id != ''){
      $this->db->select(db_prefix() . 'ware_unit_type.unit_name'.','.db_prefix() . 'items.*');
      $this->db->join(db_prefix() . 'ware_unit_type', db_prefix() . 'ware_unit_type.unit_type_id=' . db_prefix() . 'items.unit_id');
      $this->db->where('id',$id);
      return $this->db->get(db_prefix().'items')->row();
    }
    else{     
      return $this->db->get(db_prefix().'items')->result_array();
    }
  }
  /**
   *  add_product   
   * @param  array  $data 
   * @return  int $insert_id
   */
  public function add_product($data){
    $insert_id = 0;
    if($data['group_product_id'] && empty($data['product_id'])){
      $items = $this->get_all_product_group($data['group_product_id']);
      foreach ($items as $key => $value) {
        if($data['prices'] == ''){
          $get_data = $this->omni_sales_model->get_product($value['id']);
          if($get_data){
            $prices = $get_data->rate;
          } 
        }else{
          $prices = str_replace(',', '', $data['prices']);
        }
        $data_add['sales_channel_id'] = $data['sales_channel_id'];
        $data_add['group_product_id'] = $data['group_product_id'];
        $data_add['product_id'] = $value['id'];
        $data_add['prices'] = $prices;
        $data_saved = $this->get_product_channel($value['id'],$data['sales_channel_id']);
        if($data_saved){
        $this->db->where('id', $data_saved->id);
        $this->db->update('sales_channel_detailt', $data_add);
        }
        else{
            $this->db->insert('sales_channel_detailt', $data_add);
        }
      }
    }
    foreach ($data['product_id'] as $key => $value) {
      $prices = 0;
      if($data['prices'] == ''){
        $get_data = $this->omni_sales_model->get_product($value);
        if($get_data){
          $prices = $get_data->rate;
        } 
      }
      else{
          $prices = str_replace(',', '', $data['prices']);
      }

      $data_add['sales_channel_id'] = $data['sales_channel_id'];
      $data_add['group_product_id'] = $data['group_product_id'];
      $data_add['product_id'] = $value;
      $data_add['prices'] = $prices;
      $data_saved = $this->get_product_channel($value,$data['sales_channel_id']);

      if($data_saved){
        $this->db->where('id', $data_saved->id);
        $this->db->update('sales_channel_detailt', $data_add);
      }
      else{
         
          $this->db->insert('sales_channel_detailt', $data_add);
      }
      $insert_id = 1;     
    }   
    return $insert_id;
  }
  /**
   *  delete_product  
   * @param   int $id   
   * @return  bool       
   */
  public function delete_product($id){
    $this->db->where('id',$id);
        $this->db->delete(db_prefix().'sales_channel_detailt');
        if ($this->db->affected_rows() > 0) {           
            return true;
        }
        return false;
  }
  /**
   *  add channel woocommerce   
   * @param  array  $data 
   * @return  int $insert_id     
   */
  public function add_channel_woocommerce($data){
    $this->db->insert('omni_master_channel_woocommere', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
  }
  /**
   *  update channel woocommerce  
   * @param   array  $data   
   * @param   int  $id     
   * @return  bool          
   */
  public function update_channel_woocommerce($data, $id){
        $this->db->where('id', $id);
        $this->db->update(db_prefix() . 'omni_master_channel_woocommere', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
  }
  /**
   *  delete channel woocommerce   
   * @param   int  $id    
   * @return  bool         
   */
  public function delete_channel_woocommerce($id){
    $this->db->where('id',$id);
        $this->db->delete(db_prefix().'omni_master_channel_woocommere');
        if ($this->db->affected_rows() > 0) {           
            return true;
        }
        return false;
  }
  /**
   *  add product channel wcm   
   * @param  array  $data 
   * @return  int insert_id      
   */
  public function add_product_channel_wcm($data){
    $insert_id = 0;
    if(isset($data[0])){
      $data['woocommere_store_id'] =  implode($data[0]);
      $data['group_product_id'] =  implode($data[1]);
      $data['prices'] =  implode($data[3]);
      $data['product_id'] =  $data[2];
      unset($data[0]);
      unset($data[1]);
      unset($data[2]);
      unset($data[3]);
    }

    if($data['group_product_id'] && empty($data['product_id'])){
      $items = $this->get_all_product_group($data['group_product_id']);
      foreach ($items as $key => $value) {
        if($data['prices'] == ''){
          $get_data = $this->omni_sales_model->get_product($value['id']);
          if($get_data){
            $prices = $get_data->rate;
          } 
        }else{
          $prices = str_replace(',', '', $data['prices']);
        }
        $data_add['woocommere_store_id'] = $data['woocommere_store_id'];
        $data_add['group_product_id'] = $data['group_product_id'];
        $data_add['product_id'] = $value['id'];
        $data_add['prices'] = $prices;
        $data_saved = $this->get_product_channel($value['id'],$data['woocommere_store_id']);
        if($data_saved){
        $this->db->where('id', $data_saved->id);
        $this->db->update('woocommere_store_detailt', $data_add);
        }
        else{
            $this->db->insert('woocommere_store_detailt', $data_add);
        }
      }
    }

    foreach ($data['product_id'] as $key => $value) {
      $prices = 0;
      if($data['prices'] == ''){
        $get_data = $this->get_product($value);
        if($get_data){
          $prices = $get_data->rate;
        } 
      }
      else{
          $prices = str_replace(',', '', $data['prices']);
      }
      $data_add['woocommere_store_id'] = $data['woocommere_store_id'];
      $data_add['group_product_id'] = $data['group_product_id'];
      $data_add['product_id'] = $value;
      $data_add['prices'] = $prices;
      $data_saved = $this->get_woocommere_store_detailt($value,$data['woocommere_store_id']);
      if($data_saved){
        $this->db->where('id', $data_saved->id);
        $this->db->update('woocommere_store_detailt', $data_add);
        $this->process_price_synchronization_update_product($data_add['woocommere_store_id'], $data_add['prices'], $data_add['product_id']);
      }
      else{
          $this->db->insert('woocommere_store_detailt', $data_add);
      }
      $insert_id = 1;     
    }   
        return $insert_id;
  }
  /**
   *  get_woocommere_store_detailt 
   * @param   int  $product_id           
   * @param   int  $woocommere_store_id  
   * @return  object                        
   */
  public function get_woocommere_store_detailt($product_id, $woocommere_store_id){
    $this->db->where('product_id', $product_id);
    $this->db->where('woocommere_store_id', $woocommere_store_id);
    return $this->db->get('woocommere_store_detailt')->row();
  }
  /**
   *  get woocommere store   
   * @param   int  $id    
   * @return  object         
   */
  public function get_woocommere_store($id = ''){
    if($id != ''){
      $this->db->where('id', $id);
      return $this->db->get(db_prefix().'omni_master_channel_woocommere')->row();
    }else{
      return $this->db->get(db_prefix().'omni_master_channel_woocommere')->result_array();
    }
  }


  /**
   *  get list product by group
   * @param  int  $id_chanel 
   * @param  int  $id_group  
   * @param  string  $key       
   * @param  integer $limit     
   * @param  integer $ofset     
   * @return  array $result             
   */
  public function get_list_product_by_group($id_chanel, $id_group = '0',$key = '',$limit = 0, $ofset = 1){
    if($key != ''){
      if($id_group!='0'){
        $where = 'and (SELECT sum(inventory_number) as inventory_number FROM '.db_prefix().'inventory_manage where '.db_prefix().'inventory_manage.commodity_id = '.db_prefix().'items.id order by '.db_prefix().'inventory_manage.warehouse_id) > 0';
        $count_product = 'select count(id) as count from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') and group_id = '.$id_group.' and  description like \'%'.$key.'%\' or rate like \'%'.$key.'%\' or long_description like \'%'.$key.'%\' '.$where.'';
        $select_list_product = 'select  id, description, long_description, rate, sku_code, tax, group_id from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') and group_id = '.$id_group.' and  description like \'%'.$key.'%\' or rate like \'%'.$key.'%\' or long_description like \'%'.$key.'%\' '.$where.' limit '.$limit.','.$ofset;
        $result = [
          'list_product' => $this->db->query($select_list_product)->result_array(),
          'count' => (int)$this->db->query($count_product)->row()->count
        ];
        return $result;
      }
      else{
        $where = 'and (SELECT sum(inventory_number) as inventory_number FROM '.db_prefix().'inventory_manage where '.db_prefix().'inventory_manage.commodity_id = '.db_prefix().'items.id order by '.db_prefix().'inventory_manage.warehouse_id) > 0';
        $count_product = 'select count(id) as count from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') and description like \'%'.$key.'%\' or rate like \'%'.$key.'%\' or long_description like \'%'.$key.'%\' '.$where.'';

        $select_list_product = 'select  id, description, long_description, rate, sku_code, tax, group_id from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.')  and  description like \'%'.$key.'%\' or rate like \'%'.$key.'%\' or long_description like \'%'.$key.'%\' '.$where.' limit '.$limit.','.$ofset;
        $result = [
          'list_product' => $this->db->query($select_list_product)->result_array(),
          'count' => (int)$this->db->query($count_product)->row()->count
        ];
        return $result;
      }
    }
    else{      
      if($id_group!='0'){
        $where = 'and (SELECT sum(inventory_number) as inventory_number FROM '.db_prefix().'inventory_manage where '.db_prefix().'inventory_manage.commodity_id = '.db_prefix().'items.id order by '.db_prefix().'inventory_manage.warehouse_id) > 0';
        $count_product = 'select count(id) as count from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') and group_id = '.$id_group.' '.$where.'';
        $select_list_product = 'select  id, description, long_description, rate, sku_code, tax, group_id from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') and group_id = '.$id_group.' '.$where.' limit '.$limit.','.$ofset;
        $result = [
          'list_product' => $this->db->query($select_list_product)->result_array(),
          'count' => (int)$this->db->query($count_product)->row()->count
        ];
        return $result;
      }
      else{
        $where = 'and (SELECT sum(inventory_number) as inventory_number FROM '.db_prefix().'inventory_manage where '.db_prefix().'inventory_manage.commodity_id = '.db_prefix().'items.id order by '.db_prefix().'inventory_manage.warehouse_id) > 0';
        $count_product = 'select count(id) as count from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') '.$where.'';

        $select_list_product = 'select  id, description, long_description, rate, sku_code, tax, group_id from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') '.$where.' limit '.$limit.','.$ofset;
        $result = [
          'list_product' => $this->db->query($select_list_product)->result_array(),
          'count' => (int)$this->db->query($count_product)->row()->count
        ];
        return $result;
      }
    }
  }
  /**
   * get image file name
   * @param   int $id 
   * @return  object   
   */
  public function get_image_file_name($id){
    $this->db->where('rel_id',$id);
    $this->db->where('rel_type','commodity_item_file');
    $this->db->select('file_name');
        return $this->db->get(db_prefix().'files')->row();
  }
  /**
   *  add contact 
   * @param array $data
   * @return  int $insert_id   
   */
  public function add_contact($data)
    {     
        $this->db->insert(db_prefix() . 'contacts', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    /**
     * get contact
     * @param  int $id 
     * @return object or object array     
     */
    public function get_contact($id = ''){
    if($id != ''){
      $this->db->where('id',$id);
          return $this->db->get(db_prefix().'contacts')->row();
    }
    else{     
      return $this->db->get(db_prefix().'contacts')->result_array();
    }
  }
  /**
   * incrementalHash
   * @return string hash 
   */
  public function incrementalHash(){
    $charset = "01FGHIJ23OPQ456TUVWXYZ789ABCDEKLMNRS";
    $base = strlen($charset);
    $result = '';

    $now = explode(' ', microtime())[1];
    while ($now >= $base){
      $i = $now % $base;
      $result = $charset[$i] . $result;
      $now /= $base;
    }
    return substr($result, -5).strtotime(date('Y-m-d H:i:s'));
  }
  /**
   * check out
   * @param  array $data 
   * @return string order_number       
   */
  public function check_out($data){
    $this->load->model('clients_model');
    $data_client = $this->clients_model->get($data['userid']);
    if($data_client){
        $user_id = $data['userid'];
        $order_number = $this->incrementalHash();
        $channel_id = 2;
        $data_cart['userid'] = $user_id;
        $data_cart['voucher'] = $data['voucher'];
        $data_cart['order_number'] = $order_number;
        $data_cart['channel_id'] = $channel_id;
        $data_cart['channel'] = 'portal';
        $data_cart['company'] =  $data_client->company;
        $data_cart['phonenumber'] =  $data_client->phonenumber;
        $data_cart['city'] =  $data_client->city;
        $data_cart['state'] =  $data_client->state;
        $data_cart['country'] =  $data_client->country;
        $data_cart['zip'] =  $data_client->zip;
        $data_cart['billing_street'] =  $data_client->billing_street;
        $data_cart['billing_city'] =  $data_client->billing_city;
        $data_cart['billing_state'] =  $data_client->billing_state;
        $data_cart['billing_country'] =  $data_client->billing_country;
        $data_cart['billing_zip'] =  $data_client->billing_zip;
        $data_cart['shipping_street'] =  $data_client->shipping_street;
        $data_cart['shipping_city'] =  $data_client->shipping_city;
        $data_cart['shipping_state'] =  $data_client->shipping_state;
        $data_cart['shipping_country'] =  $data_client->shipping_country;
        $data_cart['shipping_zip'] =  $data_client->shipping_zip;
        $data_cart['total'] =  preg_replace('%,%','',$data['total']);
        $data_cart['sub_total'] =  $data['sub_total'];
        $data_cart['discount'] =  $data['discount'];
        $data_cart['discount_type'] =  2;
        $data_cart['notes'] =  $data['notes'];
        $data_cart['tax'] =  $data['tax'];

        $this->db->insert(db_prefix() . 'cart', $data_cart);
        $insert_id = $this->db->insert_id();
      if($insert_id){


          $date = date('Y-m-d');
          $productid_list = explode(',',$data['list_id_product']);
          $quantity_list = explode(',',$data['list_qty_product']);

          
          foreach ($productid_list as $key => $value) {
              $data_detailt['product_id'] = $value;         
                $data_detailt['quantity'] = $quantity_list[$key];
                $data_detailt['classify'] = '';
                $data_detailt['cart_id']  = $insert_id;
                $product_name = '';
                $prices = '';
                $long_description = '';
                $sku = '';
                $data_products = $this->get_product($value);
                if($data_products){
                    $product_name = $data_products->description;
                $long_description = $data_products->long_description;
                $sku = $data_products->sku_code;
                }
              $prices = $this->get_price_channel($value,2);
                $data_detailt['product_name'] = $product_name;

                $prices  = 0;
                  $data_prices = $this->get_price_channel($value,2);
                  if($data_prices){
                    $prices  = $data_prices->prices;
                  }
                  
                 

                  $data_detailt['prices'] = $prices;
                  $data_detailt['sku'] = $sku;
                  $data_detailt['long_description'] = $long_description;
                $this->db->insert(db_prefix() . 'cart_detailt', $data_detailt);
            } 
            $staff_approve = get_option('staff_sync_orders');
            if($staff_approve){
              $this->notifications($staff_approve,'omni_sales/view_order_detailt/'.$insert_id,_l('new_orders_are_waiting_for_your_confirmation'));
            }     

            $this->add_inv_when_order($insert_id,0);  
            $data_inv = $this->get_cart($insert_id);
            $this->remove_cart_data_cookie();

            $this->add_log_trade_discount($user_id, $order_number,$channel_id, $data_cart['sub_total'], $data_cart['discount'], $data_cart['tax'], $data_cart['total'], $data['voucher']);
            if($data_inv){
                return $data_inv->number_invoice;   
            }
            else{
              return 0;
            }     
          }
          return '';
    }     
  }
  /**
   * remove cart data cookie   
   * @return bool
   */
  public function remove_cart_data_cookie(){
    if (isset($_COOKIE['cart_id_list'])&&isset($_COOKIE['cart_qty_list'])) {
        unset($_COOKIE['cart_id_list']); 
        unset($_COOKIE['cart_qty_list']); 
        setcookie('cart_id_list', null, -1, '/'); 
        setcookie('cart_qty_list', null, -1, '/'); 
        return true;
    } else {
        return false;
    }
  }
  /**
   * get cart
   * @param  int $id 
   * @return object or array    
   */
  public function get_cart($id = ''){
    if($id != ''){
      $this->db->where('id',$id);
          return $this->db->get(db_prefix().'cart')->row();
    }
    else{     
      return $this->db->get(db_prefix().'cart')->result_array();
    }
  }
  /**
   * get cart detailt
   * @param  int $id 
   * @return  object or array      
   */
  public function get_cart_detailt($id = ''){
    if($id != ''){
      $this->db->where('id',$id);
          return $this->db->get(db_prefix().'cart_detailt')->row();
    }
    else{     
      return $this->db->get(db_prefix().'cart_detailt')->result_array();
    }
  }
  /**
   * get cart detailt by master
   * @param  int $id 
   * @return array     
   */
  public function get_cart_detailt_by_master($id = ''){
    if($id != ''){
      $this->db->where('cart_id',$id);
          return $this->db->get(db_prefix().'cart_detailt')->result_array();
    }
    else{     
      return $this->db->get(db_prefix().'cart_detailt')->result_array();
    }
  }
  /**
   * sync_from_the_system_to_the_store
   * @param  int $store_id          
   */
  public function sync_from_the_system_to_the_store($store_id){

    $this->process_inventory_synchronization($store_id);
    $channel =  $this->get_woocommere_store($store_id);
    $consumer_key = $channel->consumer_key;
    $consumer_secret = $channel->consumer_secret;
    $url = $channel->url;
    $woocommerce = new Client(
        $url, 
        $consumer_key, 
        $consumer_secret,
        [
            'version' => 'wc/v3',
        ]
    );
    $products_store = $woocommerce->get('products');
    $taxes_classes = $woocommerce->get('taxes/classes');
    $arr_taxes = [];
    foreach ($taxes_classes as  $taxes) {
      array_push($arr_taxes, $taxes->name);
    }
    $arr_product_store = [];
    $arr_product_id_store = [];
    foreach ($products_store as $key => $value) {
      if($value->sku != ''){
        array_push($arr_product_store, $value->sku);
        array_push($arr_product_id_store, $value->id);
      }
    }
    $products_list =  $this->products_list_store($store_id);
    foreach ($products_list as $key => $product) {
      $product_detail[] =  $this->get_product($product['product_id']);
    }
    foreach ($product_detail as $key => $value) {
      if(!is_null($value)){
        if(!in_array($value->sku_code, $arr_product_store)){
        if($this->omni_sales_model->get_all_image_file_name($value->id)){
          $file_name = $this->omni_sales_model->get_all_image_file_name($value->id);
        }

        $images = [];
        $images_final = [];
        if(isset($file_name)){
          foreach ($file_name as $k => $name) {
            array_push($images, array('src' => site_url('modules/warehouse/uploads/item_img/'.$value->id.'/'.$name['file_name'])));
          }
        }
        $date = date('Y-m-d');
        $discount =  $this->check_discount($value->id, $date, 3);

        $price_discount = 0;
        $date_on_sale_from = null;
        $date_on_sale_to = null;
        if(!is_null($discount)){
          if($discount->formal == 1){
            $price_discount = $value->rate - (($value->rate * $discount->discount)/100);
          }else{
            $price_discount = $value->rate - $discount->discount;
          }
          $date_on_sale_from = $discount->start_time;
          $date_on_sale_to = $discount->end_time;
        }else{
          $price_discount = "";
        }
        $tax_status = 'taxable';
        $tax_class = '';
        $taxname = '';
        if($value->tax != '' && !is_null($value->tax)){
          $tax = $this->get_tax($value->tax);
          if($tax != ''){
            $tax_status = 'taxable';
            if(!in_array($tax->name, $arr_taxes)){
              $slug_class = $this->create_new_tax_sync($store_id, $tax->name, $tax->taxrate);
              $data_rates = [
             "country"=> "",
             "state" => "",
             "postcode" => "",
             "city" => "",
             "compound" => false,
             "shipping" => false,
             'rate' => $tax_rate,
             'name' => $tax->name,    
             'class' => $slug_class,
             ];
             $woocommerce->post('taxes', $data_rates);
                }else{
              $name_tax_finnal = explode(" ", $tax->name);
                    $slug_class = strtolower(implode("-", $name_tax_finnal));
                }
                  if($tax == ''){
                    $taxname = 'zero-rate';
                  }else{
                    if(isset($slug_class)){
                      $taxname = $slug_class;
                    }else{
                      $taxname = 'standard';
                    }
                  }
                $tax_class = $taxname;
              }
          }
          


        $stock_quantity = $this->get_total_inventory_commodity($value->id); 
        $regular_price = $this->get_price_store($value->id, $store_id);
        $data = [
            'name' => $value->description,
            'type' => 'simple',
            'regular_price' => $value->rate,
            'sale_price' => strval($price_discount),
            'date_on_sale_from' => $date_on_sale_from,
            'date_on_sale_to' => $date_on_sale_to,
            'description' => $value->long_descriptions,
            'short_description' => $value->description,
            'stock_quantity' => $stock_quantity->inventory_number,
            'manage_stock' => true,
            'tax_status' => $tax_status,
            'tax_class' => $tax_class,
            'sku' => $value->sku_code,
            'categories' => [
                [
                    'id' => $value->group_id
                ]
            ],
        ];

        $data1 = [
            'name' => $value->description,
            'type' => 'simple',
            'regular_price' => $value->rate,
            'sale_price' => strval($price_discount),
            'date_on_sale_from' => $date_on_sale_from,
            'date_on_sale_to' => $date_on_sale_to,
            'description' => $value->long_descriptions,
            'short_description' => $value->description,
            'stock_quantity' => $stock_quantity->inventory_number,
            'manage_stock' => true,
            'tax_status' => $tax_status,
            'tax_class' => $tax_class,
            'categories' => [
                [
                    'id' => $value->group_id
                ]
            ],
        ];

        $log_product = [
            'name' => $value->description,
            'regular_price' => $value->rate,
            'sale_price' => strval($price_discount),
            'date_on_sale_from' => $date_on_sale_from,
            'date_on_sale_to' => $date_on_sale_to,
            'short_description' => $value->description,
            'stock_quantity' => $stock_quantity->inventory_number,
            'sku' => $value->sku_code,
            'type' => "products",
        ];        
        $this->db->insert(db_prefix().'omni_log_sync_woo', $log_product);
          try {
            $rs = $woocommerce->post('products', $data);
          } catch (Exception $e) {
            $woocommerce->post('products/'.$arr_product_id_store[$key], $data);
          }
        }
      }
    }
    return true;
  }
  /**
   * products list store
   * @param  int $store_id 
   * @return array           
   */
  public function products_list_store($store_id){
    $this->db->where('woocommere_store_id', $store_id);
    return $this->db->get(db_prefix().'woocommere_store_detailt')->result_array();
  }
  /**
   * sync order woo system
   * @param  int $store_id 
   * @return string           
   */
  public function sync_order_woo_system($store_id){
    $channel =  $this->get_woocommere_store($store_id);
    $consumer_key = $channel->consumer_key;
    $consumer_secret = $channel->consumer_secret;
    $url = $channel->url;
    $woocommerce = new Client(
        $url, 
        $consumer_key, 
        $consumer_secret,
        [
            'version' => 'wc/v3',
        ]
    );
    return $orders = $woocommerce->get('orders');
  }
/**
 * process orders woo
 * @param  int $store_id 
 * @return bool           
 */
  public function process_orders_woo($store_id){
    $this->load->model('clients_model');
    $this->load->model('emails_model');
    $password = $this->generate_string();
    $store  = $this->get_woocommere_store($store_id);
    $store_name = $store->name_channel;
    $order_number = [];
    $carts = $this->get_cart(); 
    foreach ($carts as $key => $value) {
      $order_number[] = $value['order_number'];
    }
    $data = $this->sync_order_woo_system($store_id);
    $this->db->select('iso2');
    $iso2 = $this->db->get(db_prefix().'countries')->result_array();
    $iso1 = [];
    foreach ($iso2 as $key => $value) {
      $iso1[] = $value['iso2'];
    }
      $email_client = get_all_email_contacts();

    $orders = [];
    if(!empty($data)){
      foreach ($data as $key => $value) {
        if($value->status == "processing"){

          if(!in_array($value->billing->email, $email_client)){
            if(in_array($value->billing->country, $iso1)){
              $this->db->where('iso2',$value->billing->country);
              $info_create['country'] = $this->db->get(db_prefix().'countries')->row()->country_id;
            }
            $first_name = $value->billing->first_name;
            $last_name = $value->billing->last_name;
            $address_1 = $value->billing->address_1;
            $address_2 = $value->billing->address_2;
            $street = $address_1 .','. $address_2;
            $city = $value->billing->city;
            $state = $value->billing->state;
            $postcode = $value->billing->postcode;
            $info_create['company'] = $first_name . ' ' . $last_name;
            $info_create['address'] = $street;
            $info_create['city'] = $city;
            $info_create['state'] = $state;
            $info_create['billing_street'] = $street;
            $info_create['billing_city'] = $city;
            $info_create['billing_state'] = $state;
            $info_create['billing_zip'] = $postcode;
            $info_create['billing_country'] = is_numeric($info_create['country']) ? $info_create['country'] : 0;
            $info_create['shipping_street'] = $street;
            $info_create['shipping_city'] = $city;
            $info_create['shipping_state'] = $info_create['country'];
            $info_create['country'] = $info_create['country'];
            $info_create['shipping_zip'] = $postcode;
            $info_create['shipping_country'] = $info_create['country'];
            $info_create['firstname'] = $first_name;
            $info_create['lastname'] = $last_name;
            $info_create['zip'] = $postcode;
            $info_create['email'] = $value->billing->email;
            $info_create['contact_phonenumber'] = $value->billing->phone;
            $info_create['password'] = $password;
                    $link = '<a href="'.site_url("authentication/login").'">'.site_url('authentication/login').'</a>';
                    $client = $this->clients_model->add($info_create, true);
                    $message = 'Congratulations! The order has been successfully placed - The system has automatically created an account for you.';
                    $message = '';
                    $message .= '<br>';
                    $message .= 'Link : '.$link.'<br>';
                    $message .= 'Account : '.$value->billing->email.'<br>';
                    $message .= 'Password : '.$password.'<br>';


          }

          array_push($orders, 
            array(
              'order_number' => $value->order_key, 
              'billing' => $value->billing, 
              'status' => 'processing', 
              'shipping' => $value->shipping, 
              'line_items' =>  $value->line_items,
              'email' =>  $value->billing->email,
              'notes' => $value->customer_note,
              'tax' => $value->total_tax
            )
          );
          foreach ($orders as $key => $value) {

            if(!in_array($value['order_number'], $order_number)){
              $productid_list = [];
              $prices = [];
              $quantity_list = [];

              foreach ($value['line_items'] as $items) {
                  $prices[] = $items->price;
                  $quantity_list[] = $items->quantity;
                  $this->db->where('sku_code', $items->sku);
                  $productid_list[] = $this->db->get(db_prefix().'items')->row()->id;
              }
              $total = 0;
              foreach ($prices as $kq) {
                $total += $kq;
              }

              $this->db->where('email', $value['email']);
              $contact = $this->db->get(db_prefix().'contacts')->row();

              $data_client = $this->clients_model->get($contact->userid);
              $data_cart['userid'] = $contact->userid;
                $data_cart['voucher'] = '';
                $data_cart['order_number'] = $value['order_number'];
                $data_cart['channel_id'] = 3;
                $data_cart['channel'] = 'WooCommerce('.$store_name.')';
                $data_cart['company'] =  $data_client->company;
                $data_cart['phonenumber'] =  $data_client->phonenumber;
                $data_cart['city'] =  $data_client->city;
                $data_cart['state'] =  $data_client->state;
                $data_cart['country'] =  $data_client->country;
                $data_cart['zip'] =  $data_client->zip;
                $data_cart['billing_street'] =  $data_client->billing_street;
                $data_cart['billing_city'] =  $data_client->billing_city;
                $data_cart['billing_state'] =  $data_client->billing_state;
                $data_cart['billing_country'] =  $data_client->billing_country;
                $data_cart['billing_zip'] =  $data_client->billing_zip;
                $data_cart['shipping_street'] =  $data_client->shipping_street;
                $data_cart['shipping_city'] =  $data_client->shipping_city;
                $data_cart['shipping_state'] =  $data_client->shipping_state;
                $data_cart['shipping_country'] =  $data_client->shipping_country;
                $data_cart['shipping_zip'] =  $data_client->shipping_zip;
                $data_cart['shipping_zip'] =  $data_client->shipping_zip;
                $data_cart['notes'] =  $value['notes'];
                $data_cart['admin_action'] = 0; 
                $data_cart['total'] = $total; 
                $data_cart['sub_total'] = $total; 
                $data_cart['tax'] =  $value['tax'];
              $this->db->insert(db_prefix() . 'cart', $data_cart);
                  $insert_id = $this->db->insert_id();
                  
                  $staff_approve = get_option('staff_sync_orders');
              if($staff_approve){
                $this->notifications($staff_approve,'omni_sales/view_order_detailt/'.$insert_id,_l('new_orders_are_waiting_for_your_confirmation'));
              } 
              $temp = '';
                  if($insert_id){
                foreach ($productid_list as $key => $value) {
                    $data_detailt['product_id'] = $value;         
                      $data_detailt['quantity'] = $quantity_list[$key];
                      $data_detailt['classify'] = '';
                      $data_detailt['cart_id']  = $insert_id;
                      $product_name = '';
                      $long_description = '';
                      $sku = '';
                      $data_products = $this->get_product($value);
                      if($data_products){
                          $product_name = $data_products->description;
                      $long_description = $data_products->long_description;
                          $sku = $data_products->sku_code;
                      }
                      $data_detailt['product_name'] = $product_name;
                      $data_detailt['prices'] = $prices[$key];
                        $data_detailt['sku'] = $sku;
                      $data_detailt['long_description'] = $long_description;
                    $this->db->insert(db_prefix() . 'cart_detailt', $data_detailt);
                    $temp = $data_detailt;
                }
                $this->remove_cart_data_cookie();
                      
                  }
                  $cart_after_insert = $this->get_cart($insert_id);

                  $log_orders = [
                  'name' => $cart_after_insert->order_number,
                  'order_id' => $insert_id,
                  'regular_price' => $cart_after_insert->total,
                  'sale_price' => $cart_after_insert->sub_total,
                  'chanel' => $cart_after_insert->channel,
                  'company' => $cart_after_insert->company,
                  "type" => "orders",
              ];
              
              $this->db->insert(db_prefix().'omni_log_sync_woo', $log_orders);  
                  return true;

            }
          }
          return true;
        }
      }
    
    } 
    
  }
  /**
   * get cart by order number
   * @param  string $order_number 
   * @return object or array               
  */
  public function get_cart_by_order_number($order_number=''){
    if($order_number != ''){
      $this->db->where('order_number',$order_number);
          return $this->db->get(db_prefix().'cart')->row();
    }
    else{     
      return $this->db->get(db_prefix().'cart')->result_array();
    }
  }
  /**
   * get cart detailt by cart id
   * @param  int $cart_id 
   * @return array          
   */
  public function get_cart_detailt_by_cart_id($cart_id = ''){
    if($cart_id != ''){
      $this->db->where('cart_id',$cart_id);
          return $this->db->get(db_prefix().'cart_detailt')->result_array();
    }
    else{     
      return $this->db->get(db_prefix().'cart_detailt')->result_array();
    }
  }
  /**
   * [change_status_order
   * @param  array  $data         
   * @param  string  $order_number 
   * @param  integer $admin_action 
   * @return bool                
   */
  public function change_status_order($data, $order_number,$admin_action = 0){
    $this->db->where('order_number',$order_number);
    $data_update['reason'] = _l($data['cancelReason']);
    $data_update['status'] = $data['status'];
    $data_update['admin_action'] = $admin_action;
        $this->db->update(db_prefix().'cart',$data_update);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
  }
  /**
   * get cart of client by status
   * @param  int  $userid 
   * @param  int $status 
   * @return array          
   */
  public function get_cart_of_client_by_status($userid = '', $status = 0){
    if($userid != ''){
      $this->db->where('userid',$userid);
      $this->db->where('status',$status);
          return $this->db->get(db_prefix().'cart')->result_array();
    }
    elseif($userid == '' && $status !=''){  
        $this->db->where('status',$status);   
      return $this->db->get(db_prefix().'cart')->result_array();
    }
    else{
      return $this->db->get(db_prefix().'cart')->result_array();
    }
  }
  /**
   * generate_string
   * @param  integer $strength 
   * @return string            
   */
  public function generate_string($strength = 16) {
    $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $input_length = strlen($input);
      $random_string = '';
      for($i = 0; $i < $strength; $i++) {
          $random_character = $input[mt_rand(0, $input_length - 1)];
          $random_string .= $random_character;
      }
      return $random_string;
  }
  /**
   * add inv and out of stock
   * @param int $orderid 
   * @return bolean
   */
  public function add_inv_and_out_of_stock($orderid, $status = '') {
    $this->load->model('invoices_model');
    $this->load->model('credit_notes_model');
    $this->load->model('warehouse/warehouse_model');
    $cart = $this->get_cart($orderid);

    $cart_detailt = $this->get_cart_detailt_by_master($orderid);
    $newitems = [];
    foreach ($cart_detailt as $key => $value) {
      $unit = 0;
      $unit_name = '';
      $data_product = $this->get_product($value['product_id']);
      $tax = $this->get_tax($data_product->tax);
      if($tax == ''){
        $taxname = '';
      }else{
        $taxname = $tax->name.'|'.$tax->taxrate;
      }
      if($data_product){        
        $unit = $data_product->unit_id;
        $unit_name = $data_product->unit_name;

      }
      array_push($newitems, array('order' => $key, 'description' => $value['product_name'], 'long_description' => $value['long_description'], 'qty' => $value['quantity'], 'unit' => $unit_name, 'rate'=> $value['prices'], 'taxname' => array($taxname)));
    }   
    
    $total = $this->get_total_order($orderid)['total'];
    $sub_total = $this->get_total_order($orderid)['sub_total'];
    $discount_total = $this->get_total_order($orderid)['discount'];
    $__number = get_option('next_invoice_number');
        $_invoice_number = str_pad($__number, get_option('number_padding_prefixes'), '0', STR_PAD_LEFT);
    $this->db->where('isdefault', 1);
    $curreny = $this->db->get(db_prefix().'currencies')->row()->id;

    if($cart){
      $data['clientid'] = $cart->userid;
      $data['billing_street'] = $cart->billing_street;
      $data['billing_city'] = $cart->billing_city;
      $data['billing_state'] = $cart->billing_state;
      $data['billing_zip'] = $cart->billing_zip;
      $data['billing_country'] = $cart->billing_country;
      $data['include_shipping'] = 1;
      $data['show_shipping_on_invoice'] = 1;
      $data['shipping_street'] = $cart->shipping_street;
      $data['shipping_city'] = $cart->shipping_city;
      $data['shipping_state'] = $cart->shipping_state;
      $data['shipping_zip'] = $cart->shipping_zip;
      $date_format   = get_option('dateformat');
        $date_format   = explode('|', $date_format);
        $date_format   = $date_format[0];       
      $data['date'] = date($date_format);
      $data['duedate'] = date($date_format);

      $data['currency'] = $curreny;
      $data['newitems'] = $newitems;
      $data['number'] = $_invoice_number;
      $data['total'] = $cart->total;
      $data['subtotal'] = $cart->sub_total;      
      $data['total_tax'] = $cart->tax;
      $data['discount_total'] = $cart->discount_total;
      if($cart->discount_type == 1){
        $data['discount_percent' ]= $cart->discount;
      }elseif($cart->discount_type == 2){
        $data['discount_percent'] =  ($cart->discount_total/$data['subtotal'])*100;
      }
      
            $id = $this->invoices_model->add($data);

            if($cart->discount != '' && $cart->discount_type != '' && $cart->voucher != ''){
              $credit_notes = $this->credit_note_from_invoice_omni($id);
            }            
            if($id){
              
              $this->warehouse_model->auto_create_goods_delivery_with_invoice($id);
            $prefix = get_option('invoice_prefix');
            if($status!=''){
                $this->update_status_order_comfirm($orderid, $prefix, $_invoice_number, $__number, $status);
            }
            else{
                $this->update_status_order_comfirm($orderid, $prefix, $_invoice_number, $__number);
            }           
              return true;
            }
    }   
      return true;

  }
  /**
   *  get total order
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
     * add_goods_delivery
     * @param array  $data 
     * @param bool $id  
     * @return bool   
     */
    public function add_goods_delivery($data, $id = false) {

    $data['approval'] = 1;
    

    if (isset($data['cart_detailt'])) {
      $cart_detailt = $data['cart_detailt'];
      unset($data['cart_detailt']);
    }
    $hot_purchase = [];
    
    $data['goods_delivery_code'] = $this->create_goods_delivery_code();

    if(!$this->check_format_date($data['date_c'])){
      $data['date_c'] = to_sql_date($data['date_c']);
    }else{
      $data['date_c'] = $data['date_c'];
    }


    if(!$this->check_format_date($data['date_add'])){
      $data['date_add'] = to_sql_date($data['date_add']);
    }else{
      $data['date_add'] = $data['date_add'];
    }

    $data['total_money']  = reformat_currency_j($data['total_money']);
    $data['total_discount'] = reformat_currency_j($data['total_discount']);
    $data['after_discount'] = reformat_currency_j($data['after_discount']);   

    $data['addedfrom'] = get_staff_user_id();

    $this->db->insert(db_prefix() . 'goods_delivery', $data);
    $insert_id = $this->db->insert_id();

    if (isset($insert_id)) {


      foreach ($cart_detailt as $key => $value) {
        $total_inventory = $this->get_total_inventory_commodity($value['product_id']);

        $quantity = $value['quantity'];
        if($quantity < $total_inventory){
          $this->db->where('commodity_id', $value['product_id']);
          $this->db->order_by('id', 'ASC');
          $result = $this->db->get('tblinventory_manage')->result_array();
          $temp_quantities = $value['quantity'];

          $expiry_date = '';
          $lot_number = '';
          foreach ($result as $result_value) {
            if (($result_value['inventory_number'] != 0) && ($temp_quantities != 0)) {

              if ($temp_quantities >= $result_value['inventory_number']) {
                $temp_quantities = (float) $temp_quantities - (float) $result_value['inventory_number'];

                if(($result_value['lot_number'] != null) && ($result_value['lot_number'] != '') ){
                  if(strlen($lot_number) != 0){
                    $lot_number .=','.$result_value['lot_number'].','.$result_value['inventory_number'];
                  }else{
                    $lot_number .= $result_value['lot_number'].','.$result_value['inventory_number'];
                  }
                }
                
                if(($result_value['expiry_date'] != null) && ($result_value['expiry_date'] != '') ){
                  if(strlen($expiry_date) != 0){
                    $expiry_date .=','.$result_value['expiry_date'].','.$result_value['inventory_number'];
                  }else{
                    $expiry_date .= $result_value['expiry_date'].','.$result_value['inventory_number'];
                  }
                }

                $this->db->where('id', $result_value['id']);
                $this->db->update(db_prefix() . 'inventory_manage', [
                  'inventory_number' => 0,
                ]);

              } else {

                if(($result_value['lot_number'] != null) && ($result_value['lot_number'] != '') ){
                  if(strlen($lot_number) != 0){
                    $lot_number .=','.$result_value['lot_number'].','.$temp_quantities;
                  }else{
                    $lot_number .= $result_value['lot_number'].','.$temp_quantities;
                  }
                }

                if(($result_value['expiry_date'] != null) && ($result_value['expiry_date'] != '') ){
                  if(strlen($expiry_date) != 0){
                    $expiry_date .=','.$result_value['expiry_date'].','.$temp_quantities;
                  }else{
                    $expiry_date .= $result_value['expiry_date'].','.$temp_quantities;
                  }
                }


                $this->db->where('id', $result_value['id']);
                $this->db->update(db_prefix() . 'inventory_manage', [
                  'inventory_number' => (float) $result_value['inventory_number'] - (float) $temp_quantities,
                ]);

                $temp_quantities = 0;

              }

            }

          }

          $this->db->where('id', $data['id']);
          $this->db->update(db_prefix() . 'goods_delivery_detail', [
                  'expiry_date' => $expiry_date,
                  'lot_number' => $lot_number,
                ]);
          
          $data['expiry_date'] = $expiry_date;
          $data['lot_number'] = $lot_number;

        }else{
          return false;
        }

        $this->db->where('commodity_code', $value['product_id']);
        $warehouse = $this->db->get(db_prefix().'goods_receipt_detail')->row();
      }
    
      $results = 0;
      foreach ($hot_purchase as $purchase_key => $purchase_value) {
          $this->db->insert(db_prefix() . 'goods_delivery_detail', $purchase_value);
          $insert_detail = $this->db->insert_id();
          $results++;
        } 

      }
      $data_log = [];
      $data_log['rel_id'] = $insert_id;
      $data_log['rel_type'] = 'stock_export';
      $data_log['staffid'] = get_staff_user_id();
      $data_log['date'] = date('Y-m-d H:i:s');
      $data_log['note'] = "stock_export";
      $this->add_activity_log($data_log);     
      return $insert_id;
  }

  /**
   * check format date Y-m-d
   *
   * @param      String   $date   The date
   *
   * @return     boolean 
   */
  public function check_format_date($date){
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
        return true;
    } else {
        return false;
    }
  }
  /**
   * create goods delivery code
   * @return string 
   */
  public function create_goods_delivery_code() {
    $id = $this->db->query('SELECT id FROM ' . db_prefix() . 'goods_delivery order by id desc limit 1')->row();
    if ($id == null) {
      $goods_code = 'XK01';
    } else {
      $goods_code = 'XK0' . (get_object_vars($id)['id'] + 1);
    }
    return $goods_code;
  }

  
  /**
   * add activity log
   * @param array $data
   * @return boolean
   */
  public function add_activity_log($data) {
    $this->db->insert(db_prefix() . 'wh_activity_log', $data);
    return true;
  }
  /**
   * get all image file name
   * @param  int $id 
   * @return array     
   */
   public function get_all_image_file_name($id){
    $this->db->where('rel_id',$id);
    $this->db->where('rel_type','commodity_item_file');
    $this->db->select('file_name');
        return $this->db->get(db_prefix().'files')->result_array();
  }
  /**
   * get list product by group and key
   * @param  int $id_chanel 
   * @param  int $id_group  
   * @param  int $limit     
   * @param  int $ofset     
   * @param  string  $key       
   * @return array             
   */
  public function get_list_product_by_group_and_key($id_chanel, $id_group = '', $limit = 0, $ofset = 1,$key){
    if($id_group!=''){
      $count_product = 'select count(id) as count from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') and group_id = '.$id_group.' and description like \'%'.$key.'%\'';
      $select_list_product = 'select  id, description, long_description, rate from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') and group_id = '.$id_group.' limit '.$limit.','.$ofset.' and description like \'%'.$key.'%\'';
      $result = [
        'list_product' => $this->db->query($select_list_product)->result_array(),
        'count' => (int)$this->db->query($count_product)->row()->count
      ];
      return $result;
    }
    else{
      $count_product = 'select count(id) as count from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') and description like \'%'.$key.'%\'';

      $select_list_product = 'select  id, description, long_description, rate from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') limit '.$limit.','.$ofset.' and description like \'%'.$key.'%\'';
      $result = [
        'list_product' => $this->db->query($select_list_product)->result_array(),
        'count' => (int)$this->db->query($count_product)->row()->count
      ];
      return $result;
    }
  }
  /**
   * get list product by group
   * @param  int  $id_chanel  
   * @param  int  $id_group   
   * @param  int  $id_product 
   * @param  int $limit      
   * @param  int $ofset      
   * @return array              
   */
  public function get_list_product_by_group_s($id_chanel, $id_group = '', $id_product = '', $limit = 0, $ofset = 1){
    if($id_group!=''){
      $count_product = 'select count(id) as count from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') and group_id = '.$id_group.' and id != '.$id_product;
      $select_list_product = 'select  id, description, long_description, rate from '.db_prefix().'items where id in (select product_id from '.db_prefix().'sales_channel_detailt where sales_channel_id = '.$id_chanel.') and group_id = '.$id_group.' and id != '.$id_product.' limit '.$limit.','.$ofset;
      $result = [
        'list_product' => $this->db->query($select_list_product)->result_array(),
        'count' => (int)$this->db->query($count_product)->row()->count
      ];
      return $result;
    }
  }
  /**
   * get_group_product
   * @param  int $id_group 
   * @return array           
   */
  public function get_group_product_s($id_group){
    return $this->db->query('select * from '.db_prefix().'items_groups where id != '.$id_group)->result_array();
  }
  /**
   * quantity detail product
   * @param  int $product_id 
   * @return object             
   */
  public function quantity_detail_product($product_id){
    return $this->db->query('SELECT sum(quantities) as quantity FROM '.db_prefix().'goods_receipt_detail where commodity_code = '.$product_id.'')->row();
  }
/**
 * process inventory synchronization
 * @param  int $store_id 
 * @return bool           
 */
  public function process_inventory_synchronization($store_id){
    $store =  $this->get_woocommere_store($store_id);
    $products_store = $this->get_product();
    $items = [];
    if(!empty($products_store)){
      foreach ($products_store  as $key => $product) {

        if(!is_null($this->get_product($product['id']))){
          array_push($items, $this->get_product($product['id']));
        }
      }
    }
    $consumer_key = $store->consumer_key;
    $consumer_secret = $store->consumer_secret;
    $url = $store->url;
    $woocommerce = new Client(
        $url, 
        $consumer_key, 
        $consumer_secret,
        [
            'version' => 'wc/v3',
        ]
    );

    $products_store = $woocommerce->get('products');
    $arr_product_store = [];
    
    foreach ($products_store as $key => $value) {

      if($value->sku != ''){
        foreach ($items as $item) {
          if($item->sku_code == $value->sku){

            $stock_quantity = $this->get_total_inventory_commodity($item->id);
            $stock_quantity = $stock_quantity->inventory_number;
            $images = [];
            if($this->get_all_image_file_name($item->id)){
              $file_name = $this->omni_sales_model->get_all_image_file_name($item->id);
            }
            if(isset($file_name)){
              foreach ($file_name as $k => $name) {
                array_push($images, array('src' => site_url('modules/warehouse/uploads/item_img/'.$item->id.'/'.$name['file_name'])));
              }
            }
            if(is_null($stock_quantity)){
              $stock_quantity = 0;
            }
            $date = date('Y-m-d');
            $discount =  $this->check_discount($item->id, $date, 3, $store_id);
            $price_discount = 0;
            $date_on_sale_from = null;
            $date_on_sale_to = null;
            if(!is_null($discount)){
              if($discount->formal == 1){
                $price_discount = $item->rate - (($item->rate * $discount->discount)/100);
              }else{
                $price_discount = $item->rate - $discount->discount;
              }
              $date_on_sale_from = $discount->start_time;
              $date_on_sale_to = $discount->end_time;
            }else{
              $price_discount = "";
            }
            $data = [
                'name' => $item->description,
                "stock_quantity" => $stock_quantity,
                "manage_stock" => true,
                'regular_price' => $item->rate,
                'sale_price' => strval($price_discount),
                'date_on_sale_from' => $date_on_sale_from,
                'date_on_sale_to' => $date_on_sale_to,

            ];
            if(is_null($value->stock_quantity)){
              $value->stock_quantity = 0;
            }
            $log_inventory = [
                'name' => $item->description,
                'regular_price' => $item->rate,
                'sale_price' => strval($price_discount),
                'date_on_sale_from' => $date_on_sale_from,
                'date_on_sale_to' => $date_on_sale_to,
                'short_description' => $item->description,
                "stock_quantity" => $stock_quantity,
                "stock_quantity_history" => $value->stock_quantity,
                "sku" => $item->sku_code,
                "type" => "inventory",
            ];
            $this->db->insert(db_prefix().'omni_log_sync_woo', $log_inventory);
            $woocommerce->post('products/'.$value->id, $data);
          }
        }   
      }
    }
    return true;
  }

  /**
   * get total inventory commodity
   * @param  boolean $id
   * @return object
   */
  public function get_total_inventory_commodity($commodity_id = false) {
    if ($commodity_id != false) {
      $sql = 'SELECT sum(inventory_number) as inventory_number FROM ' . db_prefix() . 'inventory_manage
      where ' . db_prefix() . 'inventory_manage.commodity_id = ' . $commodity_id . ' order by ' . db_prefix() . 'inventory_manage.warehouse_id';
      return $this->db->query($sql)->row();
    }

  }

  /**
   * get goods delivery detail
   * @param  integer $id
   * @return array
   */
  public function get_goods_delivery_detail($id) {
    if (is_numeric($id)) {
      $this->db->where('goods_delivery_id', $id);

      return $this->db->get(db_prefix() . 'goods_delivery_detail')->result_array();
    }
    if ($id == false) {
      return $this->db->query('select * from tblgoods_delivery_detail')->result_array();
    }
  }
  /**
   * get unit
   * @param  int $id 
   * @return object or array     
   */
  public function get_unit($id=''){   
    if($id != ''){
      $this->db->where('unit_type_id',$id);
          return $this->db->get(db_prefix().'ware_unit_type')->row();
    }
    else{     
      return $this->db->get(db_prefix().'ware_unit_type')->result_array();
    }
  }
  /**
   *  get product channel
   * @param  int $product_id       
   * @param  int $sales_channel_id 
   * @return object                   
   */
  public function get_product_channel($product_id = '', $sales_channel_id = ''){
      $this->db->where('product_id',$product_id);
      $this->db->where('sales_channel_id',$sales_channel_id);
          return $this->db->get(db_prefix().'sales_channel_detailt')->row();    
  }
  /**
   * get_price_channel
   * @param  $product_id       
   * @param  $sales_channel_id 
   * @return  object                 
   */
  public function get_price_channel($product_id,$sales_channel_id){
        $this->db->where('product_id',$product_id);
        $this->db->where('sales_channel_id',$sales_channel_id);
        $this->db->select('prices');
        return $this->db->get(db_prefix().'sales_channel_detailt')->row();  
    }
    /**
     * get price store
     * @param  int $product_id          
     * @param  int $woocommere_store_id 
     * @return object                      
     */
    public function get_price_store($product_id,$woocommere_store_id){
      $this->db->where('product_id', $product_id);
      $this->db->where('woocommere_store_id', $woocommere_store_id);
      $this->db->select('prices');    
      return $this->db->get('woocommere_store_detailt')->row();
    }
/**
 * add discount form
 * @param array $data 
 * @return int $insert_id
 */
  public function add_discount_form($data){
    if($data){
      if(isset($data['minimum_order_value'])){
        if($data['minimum_order_value']!=''){
          $data['minimum_order_value'] =  preg_replace('%,%','',$data['minimum_order_value']);
        }
      }
      unset($data['select-option-items']);
      unset($data['select-option-client']);
      $data['start_time'] = to_sql_date($data['start_time']);
      $data['end_time'] = to_sql_date($data['end_time']);
      if(isset($data['group_clients'])){
        if(count($data['group_clients'])){
          $data['group_clients'] = implode('',$data['group_clients']);
          if(is_null($data['group_clients'])){
            $data['group_clients'] = '';
          }
        }else{
          $data['group_clients'] = implode(',', $data['group_clients']);
        }
      }
      if(isset($data['clients'])){
        if(count($data['clients']) == 1){
          $data['clients'] = implode('', $data['clients']);
          if(is_null($data['clients'])){
            $data['clients'] = '';
          }
        }else{
          $data['clients'] = implode(',', $data['clients']);
        }
      }

      if(isset($data['group_items'])){
        if(count($data['group_items']) == 1){
          $data['group_items'] = implode('', $data['group_items']);
          if(is_null($data['group_items'])){
            $data['group_items'] = '';
          }
        }else{
          $data['group_items'] = implode(',', $data['group_items']);
        }
      }

      if(isset($data['items'])){
        if(count($data['items']) == 1){
          $data['items'] = implode('', $data['items']);
          if(is_null($data['items'])){
            $data['items'] = '';
          }
        }else{
          $data['items'] = implode(',', $data['items']);
        }
      }
      if(!$this->check_format_date($data['start_time'])){
        $data['start_time'] = to_sql_date($data['start_time']);
      }  
      if(!$this->check_format_date($data['end_time'])){
        $data['end_time'] = to_sql_date($data['end_time']);
      }
      $this->db->insert(db_prefix() . 'omni_trade_discount', $data);
          $insert_id = $this->db->insert_id();
          return $insert_id;
      }
  }
/**
 * get commodity code name id
 * @param  int $id 
 * @return object     
 */
  public function get_commodity_code_name_id($id) {
    return $this->db->query('select id as id, CONCAT(commodity_code,"-",description) as label from ' . db_prefix() . 'items where id = '.$id)->row();
  }
  /**
   * delete_trade_discount
   * @param  int $id 
   * @return bool     
   */
  public function delete_trade_discount($id){
    $this->db->where('id',$id);
        $this->db->delete(db_prefix().'omni_trade_discount');
        if ($this->db->affected_rows() > 0) {           
            return true;
        }
        return false;
  }
  /**
   * update discount form
   * @param  array $data 
   * @param  int $id   
   * @return bool       
   */
  public function update_discount_form($data, $id){
    if(isset($data['minimum_order_value'])){
        if($data['minimum_order_value']!=''){
          $data['minimum_order_value'] =  preg_replace('%,%','',$data['minimum_order_value']);
        }
    }
    unset($data['select-option-items']);
    unset($data['select-option-client']);
    $data['start_time'] = to_sql_date($data['start_time']);
    $data['end_time'] = to_sql_date($data['end_time']);
    if(isset($data['group_clients'])){
        if(count($data['group_clients'])){
          $data['group_clients'] = implode('',$data['group_clients']);
          if(is_null($data['group_clients'])){
            $data['group_clients'] = '';
          }
        }else{
          $data['group_clients'] = implode(',', $data['group_clients']);
        }
      }
      if(isset($data['clients'])){
        if(count($data['clients']) == 1){
          $data['clients'] = implode('', $data['clients']);
          if(is_null($data['clients'])){
            $data['clients'] = '';
          }
        }else{
          $data['clients'] = implode(',', $data['clients']);
        }
      }

      if(isset($data['group_items'])){
        if(count($data['group_items']) == 1){
          $data['group_items'] = implode('', $data['group_items']);
          if(is_null($data['group_items'])){
            $data['group_items'] = '';
          }
        }else{
          $data['group_items'] = implode(',', $data['group_items']);
        }
      }

      if(isset($data['items'])){
        if(count($data['items']) == 1){
          $data['items'] = implode('', $data['items']);
          if(is_null($data['items'])){
            $data['items'] = '';
          }
        }else{
          $data['items'] = implode(',', $data['items']);
        }
      }

      if(!$this->check_format_date($data['start_time'])){
        $data['start_time'] = to_sql_date($data['start_time']);
      }  
      if(!$this->check_format_date($data['end_time'])){
        $data['end_time'] = to_sql_date($data['end_time']);
      }
      if(!isset($data['items'])){
          $data['items'] = '';
      }

      if(!isset($data['clients'])){
          $data['clients'] = '';
      }

      if(!isset($data['group_clients'])){
          $data['group_clients'] = '';
      }

      if(!isset($data['group_items'])){
          $data['group_items'] = '';
      }

      $this->db->where('id', $id);
      $this->db->update(db_prefix() . 'omni_trade_discount', $data);
      if ($this->db->affected_rows() > 0) {
          return true;
      }
      return false;
  }
/**
 * get discount
 * @param  int $id 
 * @return object     
 */
  public function get_discount($id = ''){
    if($id != ''){
      $this->db->where('id',$id);
          return $this->db->get(db_prefix().'omni_trade_discount')->row();
    }
    else{     
      return $this->db->get(db_prefix().'omni_trade_discount')->result_array();
    }
  }
  /**
   * [apply_trade_discount
   * @param  int $client  
   * @param  int $list_id 
   * @return array or bool          
   */
  public function apply_trade_discount($client, $list_id){
    $this->load->model('clients_model');
    $this->load->model('warehouse/warehouse_model');

    $clients = $this->clients_model->get_customer_groups($client);
    $list_id = explode(',', $list_id);
    
    $date = date('Y-m-d');

    $query = 'select * from '.db_prefix().'omni_trade_discount where end_time > CURDATE() and voucher = ""';
    $list_discount =  $this->db->query($query)->result_array();
    $result = [];
     foreach ($list_discount as $key => $discount) {
      $discount['group_items'] = explode(',', $discount['group_items']);
      $discount['clients'] = explode(',', $discount['clients']);
      $discount['group_clients'] = explode(',', $discount['group_clients']);
      $discount['items'] = explode(',', $discount['items']);
      $formal = $discount['formal'];
      $voucher = $discount['voucher'];
      $name = $discount['name_trade_discount'];
      $discounts = $discount['discount'];
      if(in_array($client, $discount['clients'])){
        array_push($result, array('voucher'=> $voucher, 'name'=> $name,  'formal' => $formal, 'discount' => $discounts));
        return $result;
      }
          
      if(!empty($clients)){
        foreach ($clients as $value) {
          if(in_array($value, $discount['group_clients'])){
            array_push($result, array('voucher'=> $voucher, 'name'=> $name, 'formal' => $formal, 'discount' => $discounts));
            return $result;
          }
        }
      }
      if(!empty($list_id)){
        foreach ($list_id as $item) {
          $gr_items = $this->warehouse_model->get_commodity_group_type($item);
          if(in_array($gr_items, $discount['group_items'])){
            array_push($result, array('voucher'=> $voucher, 'name'=> $name, 'formal' => $formal, 'discount' => $discounts));
            return $result;
          }
          if(in_array($item, $discount['items'])){
            array_push($result, array('voucher'=> $voucher, 'name'=> $name, 'formal' => $formal, 'discount' => $discounts));
            return $result;
          }
        }
      }

      if(empty($discount['group_items']) && empty($discount['items']) && empty($discount['group_clients']) && empty($discount['clients'])){
        array_push($result, array('voucher'=> $voucher, 'name'=> $name, 'formal' => $formal, 'discount' => $discounts));
        return $result;
      }
    }

    if(empty($result)){
      return false;
    }
    
  }
  /**
   * check discount
   * @param  int $id_product 
   * @param  date $date       
   * @return object             
   */
  public function check_discount($id_product, $date, $channel = 0, $store = ''){
      if($store == ''){
        return $this->db->query('select * from '.db_prefix().'omni_trade_discount where find_in_set('.$id_product.',items) and start_time <= \''.$date.'\' and end_time >= \''.$date.'\' and voucher = \'\' and group_clients = \'\' and group_items = \'\' and clients = \'\'
          and channel = '.$channel.'  ')->row();
      }else{
        return $this->db->query('select * from '.db_prefix().'omni_trade_discount where find_in_set('.$id_product.',items) and start_time <= \''.$date.'\' and end_time >= \''.$date.'\' and voucher = \'\' and group_clients = \'\' and group_items = \'\' and clients = \'\' and channel = '.$channel.' and store = '.$store.'')->row();
      }
  }
  /**
   * check out
   * @param  array $data 
   * @return string order_number       
   */
  public function check_out_pos($data){
    $this->load->model('clients_model');
    $this->load->model('warehouse/warehouse_model');
    $chanel_id = 1;
    $data_client = $this->clients_model->get($data['userid']);    
    if($data_client){
        $user_id = $data['userid'];
        $order_number = $this->incrementalHash();
        $data_cart['userid'] = $user_id;
        $data_cart['seller'] = $data['seller'];
        $data_cart['voucher'] = $data['voucher'];
        $data_cart['order_number'] = $order_number;
        $data_cart['channel_id'] = $chanel_id;
        $data_cart['channel'] = 'pos';
        $data_cart['company'] =  $data_client->company;
        $data_cart['phonenumber'] =  $data_client->phonenumber;
        $data_cart['city'] =  $data_client->city;
        $data_cart['state'] =  $data_client->state;
        $data_cart['country'] =  $data_client->country;
        $data_cart['zip'] =  $data_client->zip;
        $data_cart['billing_street'] =  $data_client->billing_street;
        $data_cart['billing_city'] =  $data_client->billing_city;
        $data_cart['billing_state'] =  $data_client->billing_state;
        $data_cart['billing_country'] =  $data_client->billing_country;
        $data_cart['billing_zip'] =  $data_client->billing_zip;
        $data_cart['shipping_street'] =  $data_client->shipping_street;
        $data_cart['shipping_city'] =  $data_client->shipping_city;
        $data_cart['shipping_state'] =  $data_client->shipping_state;
        $data_cart['shipping_country'] =  $data_client->shipping_country;
        $data_cart['shipping_zip'] =  $data_client->shipping_zip;
        $data_cart['total'] =  $data['total'];
        $data_cart['sub_total'] =  $data['sub_total'];
        $data_cart['discount'] =  0;
        $data_cart['discount_type'] =  2;        
        $data_cart['notes'] =  $data['notes'];
        $data_cart['create_invoice'] =  $data['create_invoice'];
        $data_cart['stock_export'] =  $data['stock_export'];
        $data_cart['customers_pay'] =  $data['customers_pay'];
        $data_cart['amount_returned'] =  $data['amount_returned'];
        $data_cart['tax'] =  $data['tax'];
          $this->db->insert(db_prefix() . 'cart', $data_cart);
          $insert_id = $this->db->insert_id();
          if($insert_id){
            $date = date('Y-m-d');
            $productid_list = explode(',',$data['list_id_product']);
            $quantity_list = explode(',',$data['list_qty_product']);
            $count_total_percent = 0;
            foreach ($productid_list as $key => $value) {
              $data_detailt['product_id'] = $value;         
              $data_detailt['quantity'] = $quantity_list[$key];
              $data_detailt['classify'] = '';
              $data_detailt['cart_id']  = $insert_id;
              $product_name = '';
              $prices = '';
              $long_description = '';
              $sku = '';
              $data_products = $this->get_product($value);
              if($data_products){
                $product_name = $data_products->description;
                $long_description = $data_products->long_description;
                $sku = $data_products->sku_code;
              }
              $data_detailt['product_name'] = $product_name;
              $prices  = 0;
                $data_prices = $this->get_price_channel($value,$chanel_id);
                if($data_prices){
                  $prices  = $data_prices->prices;
                }


              $data_detailt['prices'] = $prices;
              $data_detailt['percent_discount'] = 0;
              $data_detailt['prices_discount'] = 0;

              $data_detailt['sku'] = $sku;
              $data_detailt['long_description'] = $long_description;
              $this->db->insert(db_prefix() . 'cart_detailt', $data_detailt);
        }
        $data_update['discount'] = $data['discount_total'];
        $this->db->where('id',$insert_id);
        $this->db->update(db_prefix() . 'cart', $data_update);
        if($data['create_invoice'] == 'on'){
            $id = $this->add_inv_when_order($insert_id,4);
            $data_payment["invoiceid"]=$id;
            $data_payment["amount"]=$data_cart['total'];
            $data_payment["date"]= _d(date('Y-m-d'));
            $data_payment["paymentmode"]=1;
            $data_payment["do_not_redirect"]='off';
            $data_payment["transactionid"]=$data_cart['order_number'];
            $data_payment["note"]='';
            $this->payments_model->add($data_payment); 

            if($data_cart['stock_export'] == 'on'){
                $id_exp = $this->create_goods_delivery($id);
                $data_update['status'] = 4;
                $data_update['admin_action'] = 1;
                $data_update['stock_export_number'] = $id_exp;

                $this->db->where('id', $insert_id);
                $this->db->update(db_prefix().'cart', $data_update);                
            }         
        }
        $this->add_log_trade_discount($user_id, $order_number,$chanel_id, $data_cart['sub_total'], $data['discount_total'], $data_cart['tax'], $data_cart['total'], $data['voucher']);
        $data_cart = $this->get_cart($insert_id);
        return ['number_invoice' => $id, 'stock_export_number' => $data_cart->stock_export_number];
        }
        return '';
    }     
  }

    /**
   * get voucher
   * @param   string $voucher 
   * @return     $discount or 0      
   */
  public function get_voucher($voucher){
    $query = 'SELECT * FROM '.db_prefix().'omni_trade_discount where end_time > CURDATE() and voucher != ""';
    $list_voucher = $this->db->query($query)->result_array();

    $array_code = [];
    $discount = [];
    foreach ($list_voucher as $key => $voucher_code) {
      array_push($array_code, $voucher_code['voucher']);
    }
    if(empty($list_voucher)){
      return 0;
    }else{
      if(in_array($voucher['voucher'], $array_code)){
        $this->db->where('voucher', $voucher['voucher']);
        $discount[] = $this->db->get(db_prefix().'omni_trade_discount')->row()->discount;
        $this->db->where('voucher', $voucher['voucher']);
        $discount[] = $this->db->get(db_prefix().'omni_trade_discount')->row()->formal;
        $this->db->where('voucher', $voucher['voucher']);
        $discount[] = $this->db->get(db_prefix().'omni_trade_discount')->row()->name_trade_discount;
        return $discount;
      }else{
        return 0;
      }
    }
  }

  /**
   * credit note from invoice omni
   * @param  int $invoice_id 
   * @return  $id or false
   */
  public function credit_note_from_invoice_omni($invoice_id)
    {
    $this->load->model('invoices_model');
    $this->load->model('credit_notes_model');
        $_invoice = $this->invoices_model->get($invoice_id);

        $new_credit_note_data             = [];
        $new_credit_note_data['clientid'] = $_invoice->clientid;
        $new_credit_note_data['number']   = get_option('next_credit_note_number');
        $new_credit_note_data['date']     = _d(date('Y-m-d'));

        $new_credit_note_data['show_quantity_as'] = $_invoice->show_quantity_as;
        $new_credit_note_data['currency']         = $_invoice->currency;
        $new_credit_note_data['subtotal']         = $_invoice->subtotal;
        $new_credit_note_data['total']            = $_invoice->total;
        $new_credit_note_data['adminnote']        = $_invoice->adminnote;
        $new_credit_note_data['adjustment']       = $_invoice->adjustment;
        $new_credit_note_data['discount_percent'] = $_invoice->discount_percent;
        $new_credit_note_data['discount_total']   = $_invoice->discount_total;
        $new_credit_note_data['discount_type']    = $_invoice->discount_type;


        $new_credit_note_data['billing_street']   = clear_textarea_breaks($_invoice->billing_street);
        $new_credit_note_data['billing_city']     = $_invoice->billing_city;
        $new_credit_note_data['billing_state']    = $_invoice->billing_state;
        $new_credit_note_data['billing_zip']      = $_invoice->billing_zip;
        $new_credit_note_data['billing_country']  = $_invoice->billing_country;
        $new_credit_note_data['shipping_street']  = clear_textarea_breaks($_invoice->shipping_street);
        $new_credit_note_data['shipping_city']    = $_invoice->shipping_city;
        $new_credit_note_data['shipping_state']   = $_invoice->shipping_state;
        $new_credit_note_data['shipping_zip']     = $_invoice->shipping_zip;
        $new_credit_note_data['shipping_country'] = $_invoice->shipping_country;
        $new_credit_note_data['reference_no']     = format_invoice_number($_invoice->id);
        if ($_invoice->include_shipping == 1) {
            $new_credit_note_data['include_shipping'] = $_invoice->include_shipping;
        }
        $new_credit_note_data['show_shipping_on_credit_note'] = $_invoice->show_shipping_on_invoice;
        $new_credit_note_data['clientnote']                   = get_option('predefined_clientnote_credit_note');
        $new_credit_note_data['terms']                        = get_option('predefined_terms_credit_note');
        $new_credit_note_data['adminnote']                    = '';
        $new_credit_note_data['newitems']                     = [];

        $custom_fields_items = get_custom_fields('items');
        $key                 = 1;
        foreach ($_invoice->items as $item) {
            $new_credit_note_data['newitems'][$key]['description']      = $item['description'];
            $new_credit_note_data['newitems'][$key]['long_description'] = clear_textarea_breaks($item['long_description']);
            $new_credit_note_data['newitems'][$key]['qty']              = $item['qty'];
            $new_credit_note_data['newitems'][$key]['unit']             = $item['unit'];
            $new_credit_note_data['newitems'][$key]['taxname']          = [];
            $taxes                                                      = get_invoice_item_taxes($item['id']);
            foreach ($taxes as $tax) {
                array_push($new_credit_note_data['newitems'][$key]['taxname'], $tax['taxname']);
            }
            $new_credit_note_data['newitems'][$key]['rate']  = $item['rate'];
            $new_credit_note_data['newitems'][$key]['order'] = $item['item_order'];
            foreach ($custom_fields_items as $cf) {
                $new_credit_note_data['newitems'][$key]['custom_fields']['items'][$cf['id']] = get_custom_field_value($item['id'], $cf['id'], 'items', false);

                if (!defined('COPY_CUSTOM_FIELDS_LIKE_HANDLE_POST')) {
                    define('COPY_CUSTOM_FIELDS_LIKE_HANDLE_POST', true);
                }
            }
            $key++;
        }
        $id = $this->credit_notes_model->add($new_credit_note_data);
        if ($id) {
            if ($_invoice->status != 2) {
                if ($this->credit_notes_model->apply_credits($id, ['invoice_id' => $invoice_id, 'amount' => $new_credit_note_data['discount_total']])) {
                    update_invoice_status($invoice_id, true);
                }
            }

            log_activity('Created Credit Note From Invoice [Invoice: ' . format_invoice_number($_invoice->id) . ', Credit Note: ' . format_credit_note_number($id) . ']');

            hooks()->do_action('created_credit_note_from_invoice', ['invoice_id' => $invoice_id, 'credit_note_id' => $id]);

            return $id;
        }

        return false;
    }

    /**
     * update status order comfirm 
     * @param  int $order_id 
     * @return bolean
     */
    public function update_status_order_comfirm($order_id, $prefix = '' , $_invoice_number = '', $number, $status = 2){
      $code_invoice = $prefix . $_invoice_number;
      $this->db->where('id', $order_id);
      $this->db->update(db_prefix().'cart', ['status' => $status, 'admin_action' => 1, 'invoice' => $code_invoice, 'number_invoice' => $number]);
      if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }
    /**
     * get id invoice 
     * @param  $number
     * @return   id invoice    
     */
    public function get_id_invoice($number){
      $this->db->where('number', $number);
      return $this->db->get(db_prefix().'invoices')->row()->id;
    }
    /**
   * add inv and out of stock pos
   * @param int $orderid 
   * @return bolean
   */
  public function add_inv_and_out_of_stock_pos($orderid, $status = '') {
    $this->load->model('invoices_model');
    $this->load->model('credit_notes_model');
    $cart = $this->get_cart($orderid);

    $cart_detailt = $this->get_cart_detailt_by_master($orderid);
    $newitems = [];   
    foreach ($cart_detailt as $key => $value) {
      array_push($newitems, array('order' => $key, 'description' => $value['product_name'], 'long_description' => $value['long_description'], 'qty' => $value['quantity'], 'unit' => '', 'rate'=> $value['prices']));
    }
    
    $total = $this->get_total_order($orderid)['total'];
    $sub_total = $this->get_total_order($orderid)['sub_total'];
    $discount_total = $this->get_total_order($orderid)['discount'];
    $__number = get_option('next_invoice_number');
        $_invoice_number = str_pad($__number, get_option('number_padding_prefixes'), '0', STR_PAD_LEFT);
    $this->db->where('isdefault', 1);
    $curreny = $this->db->get(db_prefix().'currencies')->row()->id;

    if($cart){
      $data['clientid'] = $cart->userid;
      $data['billing_street'] = $cart->billing_street;
      $data['billing_city'] = $cart->billing_city;
      $data['billing_state'] = $cart->billing_state;
      $data['billing_zip'] = $cart->billing_zip;
      $data['billing_country'] = $cart->billing_country;
      $data['include_shipping'] = 1;
      $data['show_shipping_on_invoice'] = 1;
      $data['shipping_street'] = $cart->shipping_street;
      $data['shipping_city'] = $cart->shipping_city;
      $data['shipping_state'] = $cart->shipping_state;
      $data['shipping_zip'] = $cart->shipping_zip;
      $date_format   = get_option('dateformat');
        $date_format   = explode('|', $date_format);
        $date_format   = $date_format[0];       
      $data['date'] = date($date_format);
      $data['duedate'] = date($date_format);

      $data['currency'] = $curreny;
      $data['newitems'] = $newitems;
      $data['number'] = $_invoice_number;
      $data['total'] = $cart->total;
      $data['subtotal'] = $cart->sub_total;
      $data['discount_total'] = $cart->discount_total;
      if($cart->discount_type == 1){
        $data['discount_percent'] = $cart->discount;
      }elseif($cart->discount_type == 2){
        $data['discount_percent'] =  ($cart->discount_total/$data['subtotal'])*100;
      }

            $id = $this->invoices_model->add($data);
            if($cart->discount != '' && $cart->discount_type != '' && $cart->voucher != ''){
              $credit_notes = $this->credit_note_from_invoice_omni($id);
            }            
            if($id){
              $this->warehouse_model->auto_create_goods_delivery_with_invoice($id);
              $prefix = get_option('invoice_prefix');
            if($status!=''){
                $this->update_status_order_comfirm($orderid, $prefix, $_invoice_number, $__number, $status);
            }
            else{
                $this->update_status_order_comfirm($orderid, $prefix, $_invoice_number, $__number);
            }           
              return true;
            }
        }   
      return true;
  }

   /**
     * get id invoice 
     * @param  $id
     * @return   number invoice    
     */
    public function get_number_invoice($id){
      $this->db->where('id', $id);
      return $this->db->get(db_prefix().'invoices')->row()->number;
    }

    /**
   * add invoice when order
   * @param int $orderid 
   * @return bolean
   */
  public function add_inv_when_order($orderid, $status = '') {
    $this->load->model('invoices_model');
    $this->load->model('credit_notes_model');
    $cart = $this->get_cart($orderid);

    $cart_detailt = $this->get_cart_detailt_by_master($orderid);
    $newitems = [];   
    foreach ($cart_detailt as $key => $value) {
      $unit = 0;
      $unit_name = '';
      $data_product = $this->get_product($value['product_id']);
      $tax = $this->get_tax($data_product->tax);
      if($tax == ''){
        $taxname = '';
      }else{
        $taxname = $tax->name.'|'.$tax->taxrate;
      }
      if($data_product){        
        $unit = $data_product->unit_id;
        $unit_name = $data_product->unit_name;

      }
      array_push($newitems, array('order' => $key, 'description' => $value['product_name'], 'long_description' => $value['long_description'], 'qty' => $value['quantity'], 'unit' => $unit_name, 'rate'=> $value['prices'], 'taxname' => array($taxname)));
    }
    $total = $this->get_total_order($orderid)['total'];
    $sub_total = $this->get_total_order($orderid)['sub_total'];
    $discount_total = $this->get_total_order($orderid)['discount'];
    $__number = get_option('next_invoice_number');
        $_invoice_number = str_pad($__number, get_option('number_padding_prefixes'), '0', STR_PAD_LEFT);
    $this->db->where('isdefault', 1);
    $curreny = $this->db->get(db_prefix().'currencies')->row()->id;

    if($cart){
      $data['clientid'] = $cart->userid;
      $data['billing_street'] = $cart->billing_street;
      $data['billing_city'] = $cart->billing_city;
      $data['billing_state'] = $cart->billing_state;
      $data['billing_zip'] = $cart->billing_zip;
      $data['billing_country'] = $cart->billing_country;
      $data['include_shipping'] = 1;
      $data['show_shipping_on_invoice'] = 1;
      $data['shipping_street'] = $cart->shipping_street;
      $data['shipping_city'] = $cart->shipping_city;
      $data['shipping_state'] = $cart->shipping_state;
      $data['shipping_zip'] = $cart->shipping_zip;
      $date_format   = get_option('dateformat');
      $date_format   = explode('|', $date_format);
      $date_format   = $date_format[0];       
      $data['date'] = date($date_format);
      $data['duedate'] = date($date_format);

      $data['currency'] = $curreny;
      $data['newitems'] = $newitems;
      $data['number'] = $_invoice_number;
      $data['total'] = $cart->total;
      $data['subtotal'] = $cart->sub_total;
      if($cart->discount_type == 1){
        $data['discount_percent'] = $cart->discount;
        $data['discount_total'] =  ($cart->discount * $data['subtotal'])/100;
      }elseif($cart->discount_type == 2){
        $data['discount_total'] = $cart->discount;
        $data['discount_percent'] =  ($cart->discount/$data['subtotal'])*100;
      }else{
        $data['discount_total'] = '';
        $data['discount_percent'] = '';
      }
            $id = $this->invoices_model->add($data);
            if($cart->discount != '' && $cart->discount_type != '' && $cart->voucher != ''){
              $credit_notes = $this->credit_note_from_invoice_omni($id);
            } 
            $prefix = get_option('invoice_prefix');
            $this->update_status_order_comfirm($orderid, $prefix, $_invoice_number, $__number, $status);
            return $id;
      }   
      return true;
  }
   /**
     * get invoice 
     * @param  $number
     * @return   invoice    
     */
    public function get_invoice($number){
      $this->db->where('number', $number);
      return $this->db->get(db_prefix().'invoices')->row();
    }
    /**
   * create export stock
   * @param int $orderid 
   * @param int $status 
   * @return bolean
   */
  public function create_export_stock($orderid, $status = '') {

        $cart = $this->get_cart($orderid);  
        $cart_detailt = $this->get_cart_detailt_by_master($orderid);

                $id = $this->get_id_invoice($cart->number_invoice);
        $this->load->model('invoices_model');
        $this->load->model('credit_notes_model');
        
        $total = $this->get_total_order($orderid)['total'];
        $sub_total = $this->get_total_order($orderid)['sub_total'];
        $discount_total = $this->get_total_order($orderid)['discount'];
        $__number = get_option('next_invoice_number');
            $_invoice_number = str_pad($__number, get_option('number_padding_prefixes'), '0', STR_PAD_LEFT);
        $this->db->where('isdefault', 1);
        $curreny = $this->db->get(db_prefix().'currencies')->row()->id;


              $data_delivery["id"] ='';
              $data_delivery["date_c"] = date('Y-m-d');
              $data_delivery["date_add"] = date('Y-m-d');
              $data_delivery["customer_code"] = $cart->userid;
              $data_delivery["invoice_id"] = $id;
              $data_delivery["to_"] = $cart->company;
              $data_delivery["address"] = $cart->billing_street;
              $data_delivery["staff_id"] = get_staff_user_id();
              $data_delivery["description"] ='';
              $data_delivery["total_money"] = $total;
              $data_delivery["total_discount"] = $discount_total;
              $data_delivery["after_discount"] = $discount_total;
              $data_delivery["cart_detailt"] = $cart_detailt;

              $this->warehouse_model->auto_create_goods_delivery_with_invoice($id);

              $data_update['status'] = $status;
              $data_update['admin_action'] = 1;
              $data_update['stock_export_number'] = $id_exp;

          $this->db->where('id', $orderid);
          $this->db->update(db_prefix().'cart', $data_update);
          if ($this->db->affected_rows() > 0) {
                return true;
            }
        return false;
  }
 public function notifications($id_staff, $link, $description){
        $notifiedUsers = [];
        $id_userlogin = get_staff_user_id();

            if ($id_staff == $id_userlogin) {
                $notified = add_notification([
                    'fromuserid'      => $id_userlogin,
                    'description'     => $description,
                    'link'            => $link,
                    'touserid'        => $id_staff,
                    'additional_data' => serialize([
                       $description,
                    ]),
                ]);
                if ($notified) {
                    array_push($notifiedUsers, $id_staff);
                }
            }
        pusher_trigger_notification($notifiedUsers);
    }
  public function get_data_by_week($start_date, $end_date, $channel_id){
     $query = 'SELECT day(datecreator) as dayonly,count(*) as count FROM '.db_prefix().'cart where datecreator between \''.$start_date.'\' and \''.$end_date.'\' and channel_id = '.$channel_id.' group by dayonly';
     return $this->db->query($query)->result_array();
  }
  /**
     * auto_create_goods_delivery_with_invoice
     * @param  integer $invoice_id 
     *              
     */
    public function auto_create_goods_delivery_with_invoice_s($invoice_id)
    {
      $this->load->model('warehouse/warehouse_model');
      $this->db->where('id', $invoice_id);
      $invoice_value = $this->db->get(db_prefix().'invoices')->row();

      if($invoice_value){

        /*get value for goods delivery*/

      $data['goods_delivery_code'] = $this->warehouse_model->create_goods_delivery_code();

      if(!$this->warehouse_model->check_format_date($invoice_value->date)){
        $data['date_c'] = to_sql_date($invoice_value->date);
      }else{
        $data['date_c'] = $invoice_value->date;
      }


      if(!$this->warehouse_model->check_format_date($invoice_value->date)){
        $data['date_add'] = to_sql_date($invoice_value->date);

      }else{
        $data['date_add'] = $invoice_value->date;
      }

      $data['customer_code']  = $invoice_value->clientid;
      $data['invoice_id']   = $invoice_id;
      $data['addedfrom']  = $invoice_value->addedfrom;
      $data['description']  = $invoice_value->adminnote;

      $data['total_money']  = (float)$invoice_value->subtotal + (float)$invoice_value->total_tax;
      $data['total_discount'] = $invoice_value->discount_total;
      $data['after_discount'] = $invoice_value->total;

      /*get data for goods delivery detail*/
      /*get item in invoices*/
      $this->db->where('rel_id', $invoice_id);
      $this->db->where('rel_type', 'invoice');
      $arr_itemable = $this->db->get(db_prefix().'itemable')->result_array();

      $arr_item_insert=[];
      $index=0;

      if(count($arr_itemable) > 0){
        foreach ($arr_itemable as $key => $value) {
          $commodity_code = $this->warehouse_model->get_itemid_from_name($value['description']);
            if($commodity_code != 0){
              /*get item from name*/
              $arr_item_insert[$index]['commodity_code'] = $commodity_code;
              $arr_item_insert[$index]['quantities'] = $value['qty'] + 0;
              $arr_item_insert[$index]['unit_price'] = $value['rate'] + 0;
              $arr_item_insert[$index]['tax_id'] = '';

              $arr_item_insert[$index]['total_money'] = (float)$value['qty']*(float)$value['rate'];
              $arr_item_insert[$index]['total_after_discount'] = (float)$value['qty']*(float)$value['rate'];

              /*update after : goods_delivery_id, warehouse_id*/

              /*get tax item*/
              $this->db->where('itemid', $value['id']);
              $this->db->where('rel_id', $invoice_id);
            $this->db->where('rel_type', "invoice");

            $item_tax = $this->db->get(db_prefix().'item_tax')->result_array();

            if(count($item_tax) > 0){
              foreach ($item_tax as $tax_value) {
                $tax_id = $this->warehouse_model->get_tax_id_from_taxname_taxrate($tax_value['taxname'], $tax_value['taxrate']);

                if($tax_id != 0){
                  if(strlen($arr_item_insert[$index]['tax_id']) != ''){
                    $arr_item_insert[$index]['tax_id'] .= '|'.$tax_id;
                  }else{
                    $arr_item_insert[$index]['tax_id'] .= $tax_id;

                  }
                }


                $arr_item_insert[$index]['total_money'] += (float)$value['qty']*(float)$value['rate']*(float)$tax_value['taxrate']/100;

                $arr_item_insert[$index]['total_after_discount'] += (float)$value['qty']*(float)$value['rate']*(float)$tax_value['taxrate']/100;
                  
              }
            }

              $index++;
            }


        }
      }

      $data_insert=[];

      $data_insert['goods_delivery'] = $data;
      $data_insert['goods_delivery_detail'] = $arr_item_insert;

      $status = $this->add_goods_delivery_from_invoice_s($data_insert);

      if($status){
        return true;
      }else{
        return false;
      }

      }

      return false;

    }
    /**
     * add goods delivery from invoice
     * @param  $data_insert 
     */
     public function add_goods_delivery_from_invoice_s($data_insert)
    {
      $this->load->model('warehouse/warehouse_model');
    $results=0;
    $flag_export_warehouse = 1;

      $check_appr = $this->warehouse_model->get_approve_setting('2');

    $data_insert['goods_delivery']['approval'] = 0;
    if ($check_appr && $check_appr != false) {
      $data_insert['goods_delivery']['approval'] = 0;
    } else {
      $data_insert['goods_delivery']['approval'] = 1;
    }

    $this->db->insert(db_prefix() . 'goods_delivery', $data_insert['goods_delivery']);
    $insert_id = $this->db->insert_id();


    if (isset($insert_id)) {

      foreach ($data_insert['goods_delivery_detail'] as $delivery_detail_key => $delivery_detail_value) {
        /*check export warehouse*/

        $inventory = $this->warehouse_model->get_inventory_by_commodity($delivery_detail_value['commodity_code']);

            if($inventory){
              $inventory_number =  $inventory->inventory_number;

              if((float)$inventory_number < (float)$delivery_detail_value['quantities'] ){
                $flag_export_warehouse = 0;
              }

            }else{
              $flag_export_warehouse = 0;
            }


        $delivery_detail_value['goods_delivery_id'] = $insert_id;
        $this->db->insert(db_prefix() . 'goods_delivery_detail', $delivery_detail_value);
        $insert_detail = $this->db->insert_id();

        $results++;

      }

      $data_log = [];
      $data_log['rel_id'] = $insert_id;
      $data_log['rel_type'] = 'stock_export';
      $data_log['staffid'] = get_staff_user_id();
      $data_log['date'] = date('Y-m-d H:i:s');
      $data_log['note'] = "stock_export";

      $this->warehouse_model->add_activity_log($data_log);

    }


    if($flag_export_warehouse == 1){
      $data_update['approval'] = 1;
      $this->db->where('id', $insert_id);
      $this->db->update(db_prefix() . 'goods_delivery', $data_update);

      $goods_delivery_detail = $this->warehouse_model->get_goods_delivery_detail($insert_id);

      foreach ($goods_delivery_detail as $goods_delivery_detail_value) {
        $this->warehouse_model->add_inventory_from_invoices($goods_delivery_detail_value);
      }
    }
    return $insert_id;

    }

     /**
   *  delete_product  
   * @param   int $id   
   * @return  bool       
   */
  public function delete_product_store($store, $id){
        $this->db->where('id',$id);
        $this->db->where('woocommere_store_id',$store);
        $this->db->delete(db_prefix().'woocommere_store_detailt');
        if ($this->db->affected_rows() > 0) {           
            return true;
        }
        return false;
  }
  /**
   * get all product group
   * @param  $group_items 
   * @return list items             
   */
  public function get_all_product_group($group_items){
      $this->db->where('group_id',$group_items);
      return $this->db->get(db_prefix().'items')->result_array();
  }
  /**
   *  check tax product
   * @param  $list_product 
   * @return  array           
   */
  public function check_tax_product($list_product){
        $array = [];
      if(!empty($list_product)){
        $list_product = explode(',', $list_product);
        foreach ($list_product as $key => $value) { 
            $product = $this->get_product($value);
            if($product){
              if($product->tax != '' && !is_null($product->tax)){
                $this->db->where('id', $product->tax);              
                $tax = $this->db->get(db_prefix().'taxes')->row();
                if($tax){
                 array_push($array, $tax->taxrate);
                }
                else{
                 array_push($array, 0);                  
                }
              }else{
                array_push($array, 0);
              }
            }
        }
      }
      return $array;
  }
  /**
   * get tax
   * @param $product_id 
   * @return            
   */
  public function get_tax($product_id){
    if($product_id == 0){
      return '';
    }
    $this->db->where('id', $product_id);
    return $this->db->get(db_prefix().'taxes')->row();
  }
  /**
   * get data
   * @param  $query
   * @param  boolean $array 
   * @return data         
   */
    public function get_data($query, $array = false){
      if($array == false){
        return $this->db->query($query)->row();
      }
      else{
        return $this->db->query($query)->result_array();        
      }
    }
    /**
     * process decriptions synchronization
     * @param $store_id
     * @return           
     */
  public function process_decriptions_synchronization($store_id){
    $store =  $this->get_woocommere_store($store_id);
    $products_store = $this->get_product();
    $items = [];
    if(!empty($products_store)){
      foreach ($products_store  as $key => $product) {

        if(!is_null($this->get_product($product['id']))){
          array_push($items, $this->get_product($product['id']));
        }
      }
    }
    $consumer_key = $store->consumer_key;
    $consumer_secret = $store->consumer_secret;
    $url = $store->url;
    $woocommerce = new Client(
        $url, 
        $consumer_key, 
        $consumer_secret,
        [
            'version' => 'wc/v3',
        ]
    );

    $products_store = $woocommerce->get('products');
    $arr_product_store = [];
    
    foreach ($products_store as $key => $value) {

      if($value->sku != ''){
        foreach ($items as $item) {
          if($item->sku_code == $value->sku){
            $data = [
                'description' => $item->long_descriptions,
                'short_description' => $item->description,
            ];
            if(is_null($value->stock_quantity)){
              $value->stock_quantity = 0;
            }
            
            $woocommerce->post('products/'.$value->id, $data);
          }
        }   
      }
    }
    return true;
  }
  /**
   * process images synchronization
   * @param $store_id
   */

  public function process_images_synchronization($store_id){
    $store =  $this->get_woocommere_store($store_id);
    $products_store = $this->get_product();
    $items = [];
    if(!empty($products_store)){
      foreach ($products_store  as $key => $product) {

        if(!is_null($this->get_product($product['id']))){
          array_push($items, $this->get_product($product['id']));
        }
      }
    }
    $consumer_key = $store->consumer_key;
    $consumer_secret = $store->consumer_secret;
    $url = $store->url;
    $woocommerce = new Client(
        $url, 
        $consumer_key, 
        $consumer_secret,
        [
            'version' => 'wc/v3',
        ]
    );

    $products_store = $woocommerce->get('products');
    $arr_product_store = [];
    
    foreach ($products_store as $key => $value) {

      if($value->sku != ''){
        foreach ($items as $item) {
          if($item->sku_code == $value->sku){

            $images = [];
            if($this->get_all_image_file_name($item->id)){
              $file_name = $this->omni_sales_model->get_all_image_file_name($item->id);
            }
            foreach ($file_name as $k => $name) {
              array_push($images, array('src' => site_url('modules/warehouse/uploads/item_img/'.$item->id.'/'.$name['file_name'])));
            }
            $data = [
                'images' => $images
            ];
            $woocommerce->post('products/'.$value->id, $data);
          }
        }   
      }
    }
    return true;
  }

  public function create_new_tax_sync($store_id, $taxclass_name, $tax_rate){
    $store =  $this->get_woocommere_store($store_id);

    $consumer_key = $store->consumer_key;
    $consumer_secret = $store->consumer_secret;
    $url = $store->url;
    $woocommerce = new Client(
        $url, 
        $consumer_key, 
        $consumer_secret,
        [
            'version' => 'wc/v3',
        ]
    );
    $data = [
      'name' => $taxclass_name
    ];

    $tax_class_new = $woocommerce->post('taxes/classes', $data);
    $slug_class =  $tax_class_new->slug;

    $data_rates = [
    "country"=> "",
    "state" => "",
    "postcode" => "",
    "city" => "",
    "compound" => false,
    "shipping" => false,
    'rate' => $tax_rate,
    'name' => $taxclass_name,    
    'class' => $slug_class,
    ];
    $woocommerce->post('taxes', $data_rates);
    return $slug_class;
  }

   /**
     * create goods delivery
     * @param  integer $invoice_id 
     *              
     */
    public function create_goods_delivery($invoice_id)
    {
      $this->load->model('warehouse/warehouse_model');
      $this->db->where('id', $invoice_id);
      $invoice_value = $this->db->get(db_prefix().'invoices')->row();

      if($invoice_value){

        /*get value for goods delivery*/

      $data['goods_delivery_code'] = $this->warehouse_model->create_goods_delivery_code();

      if(!$this->warehouse_model->check_format_date($invoice_value->date)){
        $data['date_c'] = to_sql_date($invoice_value->date);
      }else{
        $data['date_c'] = $invoice_value->date;
      }


      if(!$this->warehouse_model->check_format_date($invoice_value->date)){
        $data['date_add'] = to_sql_date($invoice_value->date);

      }else{
        $data['date_add'] = $invoice_value->date;
      }

      $data['customer_code']  = $invoice_value->clientid;
      $data['invoice_id']   = $invoice_id;
      $data['addedfrom']  = $invoice_value->addedfrom;
      $data['description']  = $invoice_value->adminnote;

      $data['total_money']  = (float)$invoice_value->subtotal + (float)$invoice_value->total_tax;
      $data['total_discount'] = $invoice_value->discount_total;
      $data['after_discount'] = $invoice_value->total;

      /*get data for goods delivery detail*/
      /*get item in invoices*/
      $this->db->where('rel_id', $invoice_id);
      $this->db->where('rel_type', 'invoice');
      $arr_itemable = $this->db->get(db_prefix().'itemable')->result_array();

      $arr_item_insert=[];
      $index=0;

      if(count($arr_itemable) > 0){
        foreach ($arr_itemable as $key => $value) {
          $commodity_code = $this->warehouse_model->get_itemid_from_name($value['description']);
            if($commodity_code != 0){
              /*get item from name*/
              $arr_item_insert[$index]['commodity_code'] = $commodity_code;
              $arr_item_insert[$index]['quantities'] = $value['qty'] + 0;
              $arr_item_insert[$index]['unit_price'] = $value['rate'] + 0;
              $arr_item_insert[$index]['tax_id'] = '';

              $arr_item_insert[$index]['total_money'] = (float)$value['qty']*(float)$value['rate'];
              $arr_item_insert[$index]['total_after_discount'] = (float)$value['qty']*(float)$value['rate'];

              /*update after : goods_delivery_id, warehouse_id*/

              /*get tax item*/
              $this->db->where('itemid', $value['id']);
              $this->db->where('rel_id', $invoice_id);
            $this->db->where('rel_type', "invoice");

            $item_tax = $this->db->get(db_prefix().'item_tax')->result_array();

            if(count($item_tax) > 0){
              foreach ($item_tax as $tax_value) {
                $tax_id = $this->warehouse_model->get_tax_id_from_taxname_taxrate($tax_value['taxname'], $tax_value['taxrate']);

                if($tax_id != 0){
                  if(strlen($arr_item_insert[$index]['tax_id']) != ''){
                    $arr_item_insert[$index]['tax_id'] .= '|'.$tax_id;
                  }else{
                    $arr_item_insert[$index]['tax_id'] .= $tax_id;

                  }
                }


                $arr_item_insert[$index]['total_money'] += (float)$value['qty']*(float)$value['rate']*(float)$tax_value['taxrate']/100;

                $arr_item_insert[$index]['total_after_discount'] += (float)$value['qty']*(float)$value['rate']*(float)$tax_value['taxrate']/100;
                  
              }
            }

              $index++;
            }


        }
      }

      $data_insert=[];

      $data_insert['goods_delivery'] = $data;
      $data_insert['goods_delivery_detail'] = $arr_item_insert;

      $status = $this->add_goods_delivery_from_invoice_s($data_insert);
        if($status){
          return $status;
        }else{
          return false;
        }
      }
      return false;
    }
     /**
   * get tax product
   * @return  decimal $tax           
   */
  public function get_tax_product($id_product){
      if($id_product!=''){
          $product = $this->get_product($id_product);
          if($product){

            if($product->tax != '' && $product->tax){
                $this->db->where('id', $product->tax);              
                $tax = $this->db->get(db_prefix().'taxes')->row();
                if($tax){
                 return $tax->taxrate;
                }
                else{
                 return 0;                  
              }
            }

          }
          return 0;                  
      }
  }
   /**
   * [apply trade_discount pos
   * @param  int $client  
   * @param  int $list_id 
   * @return array or bool          
   */
  public function apply_trade_discount_pos($client, $list_id){
    $this->load->model('clients_model');
    $this->load->model('warehouse/warehouse_model');

    $clients = $this->clients_model->get_customer_groups($client);
    $list_id = explode(',', $list_id);
    
    $date = date('Y-m-d');

    $query = 'select * from '.db_prefix().'omni_trade_discount where end_time > CURDATE() and voucher = ""';
    $list_discount =  $this->db->query($query)->result_array();
    $result = [];
    foreach ($list_discount as $key => $discount) {

      $discount['group_items'] = explode(',', $discount['group_items']);
      $discount['clients'] = explode(',', $discount['clients']);
      $discount['group_clients'] = explode(',', $discount['group_clients']);
      $discount['items'] = explode(',', $discount['items']);
      $formal = $discount['formal'];
      $voucher = $discount['voucher'];
      $name = $discount['name_trade_discount'];
      $discounts = $discount['discount'];
      if(in_array($client, $discount['clients'])){
        array_push($result, array('voucher'=> $voucher, 'name'=> $name,  'formal' => $formal, 'discount' => $discounts));
        return $result;
      }

          
      if(!empty($clients)){
        foreach ($clients as $value) {
          if(in_array($value, $discount['group_clients'])){
            array_push($result, array('voucher'=> $voucher, 'name'=> $name, 'formal' => $formal, 'discount' => $discounts));
            return $result;
          }
        }
      }

      if(!empty($list_id)){
        foreach ($list_id as $item) {
          $gr_items = $this->warehouse_model->get_commodity_group_type($item);
          if(in_array($gr_items, $discount['group_items'])){
            array_push($result, array('voucher'=> $voucher, 'name'=> $name, 'formal' => $formal, 'discount' => $discounts));
            return $result;
          }
          if(in_array($item, $discount['items'])){
            array_push($result, array('voucher'=> $voucher, 'name'=> $name, 'formal' => $formal, 'discount' => $discounts));
            return $result;
          }
        }
      }

      if(empty($discount['group_items']) && empty($discount['items']) && empty($discount['group_clients']) && empty($discount['clients'])){
        array_push($result, array('voucher'=> $voucher, 'name'=> $name, 'formal' => $formal, 'discount' => $discounts));
        return $result;
      }
    }

    if(empty($result)){
      return false;
    }    
  }
  /**
   * Gets the discount list.
   *
   * @param      string  $channel_id  The channel identifier
   * @param      string  $client      The client
   *
   * @return     The discount list.
   */
  public function get_discount_list($channel_id, $client = '', $voucher=''){
    if($voucher == ''){
      if($client!=''){
        $data_group = $this->db->query('select * from '.db_prefix().'customer_groups where customer_id = '.$client)->result_array();
        $list_group = '';
        foreach ($data_group as $key => $group) {
            $list_group .= ' find_in_set('.$group['groupid'].',group_clients) or'; 
        }
        $query = 'select * from '.db_prefix().'omni_trade_discount where (('.$list_group.' clients = '.$client.') or (group_clients="" and clients="")) and end_time >= CURDATE() and channel = '.$channel_id.' and voucher = ""';
        return $this->db->query($query)->result_array();
      }
      else{
        $query = 'select * from '.db_prefix().'omni_trade_discount where group_clients = "" and clients = "" and  end_time > CURDATE() and channel = '.$channel_id.' and voucher = ""';
        return $this->db->query($query)->result_array();      
      }
    }
    else{
       if($client!=''){
        $data_group = $this->db->query('select * from '.db_prefix().'customer_groups where customer_id = '.$client)->result_array();
        $list_group = '';
        foreach ($data_group as $key => $group) {
            $list_group .= ' find_in_set('.$group['groupid'].',group_clients) or'; 
        }
        $query = 'select * from '.db_prefix().'omni_trade_discount where (('.$list_group.' clients = '.$client.') or (group_clients="" and clients="")) and end_time >= CURDATE() and channel = '.$channel_id.' and voucher = "'.$voucher.'"';
        return $this->db->query($query)->row();
      }
    }
  }

  /**
   * sync from the store to the system
   * @param  int $store_id          
   */
  public function sync_from_the_store_to_the_system($store_id){
    $this->load->model('warehouse/warehouse_model');
    $this->load->model('misc_model');
    $channel =  $this->get_woocommere_store($store_id);
    $consumer_key = $channel->consumer_key;
    $consumer_secret = $channel->consumer_secret;
    $url = $channel->url;
    $woocommerce = new Client(
        $url, 
        $consumer_key, 
        $consumer_secret,
        [
            'version' => 'wc/v3',
        ]
    );
    
    $per_page = 100;
    $products_store = [];
    $data_new = [];
    $data_new_s = [];
    $product_update = [];
    $count = 0;
    for($page = 1; $page <= 100; $page++ ){
      $offset = ($page - 1) * $per_page;
      $products_store = $woocommerce->get('products', ['per_page' => $per_page, 'offset' => $offset, 'page' => $page]);
      $commodity_code = [];
      $description = [];
      $commodity_barcode = [];
      $sku_code = [];
      $sku_name = [];
      $long_description = [];
      $commodity_type = [];
      $unit_id = [];
      $group_id = [];
      $purchase_price = [];
      $rate = [];
      $profif_ratio = [];
      $tax = [];
      $origin = [];
      $style_id = [];
      $model_id = [];
      $size_id = [];
      $color = [];
      $guarantee = [];
      $long_descriptions = [];
      $id = [];
      $images = [];

      foreach ($products_store as $key => $products) {
        array_push($id, $products->id);
        array_push($commodity_code, $products->slug);
        array_push($description, $products->name);
        array_push($commodity_barcode, $this->warehouse_model->generate_commodity_barcode());
        array_push($sku_code, $products->sku);
        array_push($sku_name, '');
        array_push($long_description, $products->short_description);
        array_push($commodity_type, '');
        array_push($unit_id, 1);
        array_push($group_id, '');
        array_push($purchase_price, $products->price);
        array_push($rate, $products->price);
        array_push($profif_ratio, '');
        array_push($tax, '');
        array_push($origin, '');
        array_push($style_id, '');
        array_push($model_id, '');
        array_push($size_id, '');
        array_push($color, '');
        array_push($guarantee, '');
        array_push($long_descriptions, $products->description);      
        array_push($images, $products->images);
      }

      $products_all = $this->get_product();
     
      $array_sku_code = [];
      foreach ($products_all as $product) {
        array_push($array_sku_code, $product['sku_code']);
      }
      foreach ($sku_code as $key => $value) {
        if(!in_array($value, $array_sku_code)){
            $data = [
              "commodity_code" => $commodity_code[$key],
              "description" => $description[$key],
              "commodity_barcode" => $commodity_barcode[$key],
              "sku_code" => $sku_code[$key],
              "sku_name" => $sku_name[$key],
              "long_description" => $long_description[$key],
              "commodity_type" => $commodity_type[$key],
              "unit_id" => $unit_id[$key],
              "group_id" => $group_id[$key],
              "purchase_price" => $purchase_price[$key],
              "rate" => $rate[$key],
              "profif_ratio" => $profif_ratio[$key],
              "tax" => $tax[$key],
              "origin" => $origin[$key],
              "style_id" => $style_id[$key],
              "model_id" => $model_id[$key],
              "size_id" => $size_id[$key],
              "color" => $color[$key],
              "guarantee" => $guarantee[$key],
              "long_descriptions" => $long_descriptions[$key]
            ];

            $ids = $this->warehouse_model->add_commodity_one_item($data);

            $data_add_new = [];
            if($ids){
              array_push($data_add_new, ['woocommere_store_id'=>$store_id]);
              array_push($data_add_new, ['group_product_id'=>'']);
              array_push($data_add_new, array($ids));
              array_push($data_add_new, ['prices'=>'']);
            }
            $log_product = [
              'name' => $description[$key],
              'regular_price' => $rate[$key],
              'short_description' => $description[$key],
              'sku' => $sku_code[$key],
              'chanel' => 'WooCommerce('.$this->get_name_store($store_id).')',
              'type' => "products_store_info_images",
            ];        
            $this->db->insert(db_prefix().'omni_log_sync_woo', $log_product);
            $this->add_product_channel_wcm($data_add_new);
            if(!empty($images)){
              foreach ($images[$key] as $image) {
                $url_to_image = $image->src;
                 $my_save_dir = 'modules/warehouse/uploads/item_img/'.$ids.'/';
                 $filename = basename($url_to_image);

                 $filename = explode('?',$filename)[0];

                 $complete_save_loc = $my_save_dir.$filename;
                 
                 _maybe_create_upload_path($my_save_dir);
                 if(file_put_contents($complete_save_loc,file_get_contents($url_to_image))){
                  
                    $filetype = array(
                      'jpg' => 'image/jpeg',
                      'png' => 'image/png',
                      'gif' => 'image/gif',
                    );

                    $attachment   = [];
                    $attachment[] = [
                        'file_name' => $filename,
                        'filetype'  => $filetype[pathinfo($image->src, PATHINFO_EXTENSION)],
                        ];

                    $this->misc_model->add_attachment_to_database($ids, 'commodity_item_file', $attachment);
                 }

              }
            }

            $items = [];
            $items['id'] = $id[$key];
            $items['sku'] = $sku_code[$key];
            if(!isset($update)){
              $update = [];
            }
            array_push($update, $items);
            $count++;
            if( $count % 100 == 0){
              array_push($product_update, $update);
              $update = [];
            }

          }else{
            $this->db->where('sku_code', $value);
            $this->db->update(db_prefix() . 'items', 
              [
                "description" => $description[$key],              
                "purchase_price" => $purchase_price[$key],              
                "long_descriptions" => $long_descriptions[$key],
                "long_description" => $long_description[$key]              
              ]);
          }
        }
        if(count($products_store) < $per_page){
          break;
        }
      }

      if(isset($update) && count($update) > 0){
        array_push($product_update, $update);
      }
      if(count($product_update) > 0){

        foreach ($product_update as $key => $value) {
         $data_cus = [
            'update' => $value
          ];
            $woocommerce->post('products/batch', $data_cus);
          }
          return true;
      }
    
    }
    /**
     * test connect 
     * @param   $data 
     * @return        
     */
    public function test_connect($data)
    {
      $consumer_key = $data['consumer_key'];
      $consumer_secret = $data['consumer_secret'];
      $url = $data['url'];
      $woocommerce = new Client(
          $url, 
          $consumer_key, 
          $consumer_secret,
          [ 
              'wp_api' => true,
              'version' => 'wc/v3',
              'timeout' => 400,
          ]
      );
      try {
          if($woocommerce->get('')){
            return true;
          }
      } catch (Exception $e) {
            return false;
      }
      

    }


    /**
   * sync from the store to the system
   * @param  int $store_id          
   */
  public function sync_products_from_info_woo($store_id){
    $this->load->model('warehouse/warehouse_model');
    $this->load->model('misc_model');
    $channel =  $this->get_woocommere_store($store_id);
    $consumer_key = $channel->consumer_key;
    $consumer_secret = $channel->consumer_secret;
    $url = $channel->url;
    $woocommerce = new Client(
        $url, 
        $consumer_key, 
        $consumer_secret,
        [
            'version' => 'wc/v3',
        ]
    );
    $per_page = 100;
    $products_store = [];
    $data_new = [];
    $data_new_s = [];
    $product_update = [];

    for($page = 1; $page <= 100; $page++ ){
      $offset = ($page - 1) * $per_page;
      $products_store = $woocommerce->get('products', ['per_page' => $per_page, 'offset' => $offset, 'page' => $page]);
      $commodity_code = [];
      $description = [];
      $commodity_barcode = [];
      $sku_code = [];
      $sku_name = [];
      $long_description = [];
      $commodity_type = [];
      $unit_id = [];
      $group_id = [];
      $purchase_price = [];
      $rate = [];
      $profif_ratio = [];
      $tax = [];
      $origin = [];
      $style_id = [];
      $model_id = [];
      $size_id = [];
      $color = [];
      $guarantee = [];
      $long_descriptions = [];
      $id = [];
      $images = [];
      $arry_sku_new = [];
      $count = 0;

      foreach ($products_store as $key => $products) {
        array_push($id, $products->id);
        array_push($commodity_code, $products->slug);
        array_push($description, $products->name);
        array_push($commodity_barcode, $this->warehouse_model->generate_commodity_barcode());
        array_push($sku_code, $products->sku);
        array_push($sku_name, '');
        array_push($long_description, $products->short_description);
        array_push($commodity_type, '');
        array_push($unit_id, 1);
        array_push($group_id, '');
        array_push($purchase_price, $products->price);
        array_push($rate, $products->price);
        array_push($profif_ratio, '');
        array_push($tax, '');
        array_push($origin, '');
        array_push($style_id, '');
        array_push($model_id, '');
        array_push($size_id, '');
        array_push($color, '');
        array_push($guarantee, '');
        array_push($long_descriptions, $products->description);      
        array_push($images, $products->images);
      }

      $products_all = $this->get_product();
     
      $array_sku_code = [];
      foreach ($products_all as $product) {
        array_push($array_sku_code, $product['sku_code']);
      }
      foreach ($sku_code as $key => $value) {
        if(!in_array($value, $array_sku_code)){
          
            $data = [
              "commodity_code" => $commodity_code[$key],
              "description" => $description[$key],
              "commodity_barcode" => $commodity_barcode[$key],
              "sku_code" => $sku_code[$key],
              "sku_name" => $sku_name[$key],
              "long_description" => $long_description[$key],
              "commodity_type" => $commodity_type[$key],
              "unit_id" => $unit_id[$key],
              "group_id" => $group_id[$key],
              "purchase_price" => $purchase_price[$key],
              "rate" => $rate[$key],
              "profif_ratio" => $profif_ratio[$key],
              "tax" => $tax[$key],
              "origin" => $origin[$key],
              "style_id" => $style_id[$key],
              "model_id" => $model_id[$key],
              "size_id" => $size_id[$key],
              "color" => $color[$key],
              "guarantee" => $guarantee[$key],
              "long_descriptions" => $long_descriptions[$key]
            ];
            $ids = $this->warehouse_model->add_commodity_one_item($data);

            $data_add_new = [];
            if($ids){
              array_push($data_add_new, ['woocommere_store_id'=>$store_id]);
              array_push($data_add_new, ['group_product_id'=>'']);
              array_push($data_add_new, array($ids));
              array_push($data_add_new, ['prices'=>'']);
            }


            $data = [
              "commodity_code" => $commodity_code[$key],
              "description" => $description[$key],
              "commodity_barcode" => $commodity_barcode[$key],
              "sku_code" => $sku_code[$key],
              "sku_name" => $sku_name[$key],
              "long_description" => $long_description[$key],
              "commodity_type" => $commodity_type[$key],
              "unit_id" => $unit_id[$key],
              "group_id" => $group_id[$key],
              "purchase_price" => $purchase_price[$key],
              "rate" => $rate[$key],
              "profif_ratio" => $profif_ratio[$key],
              "tax" => $tax[$key],
              "origin" => $origin[$key],
              "style_id" => $style_id[$key],
              "model_id" => $model_id[$key],
              "size_id" => $size_id[$key],
              "color" => $color[$key],
              "guarantee" => $guarantee[$key],
              "long_descriptions" => $long_descriptions[$key]
            ];
            
            $log_product = [
              'name' => $description[$key],
              'regular_price' => $rate[$key],
              'short_description' => $description[$key],
              'sku' => $sku_code[$key],
              'chanel' => 'WooCommerce('.$this->get_name_store($store_id).')',
              'type' => "products_store_info",
            ];        
            $this->db->insert(db_prefix().'omni_log_sync_woo', $log_product);

            $this->add_product_channel_wcm($data_add_new);
            $items = [];
            $items['id'] = $id[$key];
            $items['sku'] = $sku_code[$key];
            if(!isset($update)){
              $update = [];
            }
            array_push($update, $items);
            $count++;
            if( $count % 100 == 0){
              array_push($product_update, $update);
              $update = [];
            }
          }else{
            $this->db->where('sku_code', $value);
            $this->db->update(db_prefix() . 'items', 
              [
                "description" => $description[$key],              
                "purchase_price" => $purchase_price[$key],              
                "long_descriptions" => $long_descriptions[$key],
                "long_description" => $long_description[$key]              
              ]);
          }
        }
        if(count($products_store) < $per_page){
          break;
        }
      }

      if(isset($update) && count($update) > 0){
        array_push($product_update, $update);
      }
      if(count($product_update) > 0){

        foreach ($product_update as $key => $value) {
         $data_cus = [
            'update' => $value
          ];
            $woocommerce->post('products/batch', $data_cus);

          }
      }

      return true;
    }
  
    public function get_name_store($store_id){
      $this->db->where('id', $store_id);
      if($this->db->get(db_prefix().'omni_master_channel_woocommere')->row()->name_channel){
        $this->db->where('id', $store_id);
        return $this->db->get(db_prefix().'omni_master_channel_woocommere')->row()->name_channel;
      }else{
        return "";
      }
    }


    /**
 * process price synchronization
 * @param  int $store_id 
 * @return bool           
 */
  public function process_price_synchronization($store_id){
    $store =  $this->get_woocommere_store($store_id);
    $products_store = $this->get_product();
    $items = [];
    if(!empty($products_store)){
      foreach ($products_store  as $key => $product) {

        if(!is_null($this->get_product($product['id']))){
          array_push($items, $this->get_product($product['id']));
        }
      }
    }
    $consumer_key = $store->consumer_key;
    $consumer_secret = $store->consumer_secret;
    $url = $store->url;
    $woocommerce = new Client(
        $url, 
        $consumer_key, 
        $consumer_secret,
        [
            'version' => 'wc/v3',
        ]
    );

    $products_store = $woocommerce->get('products');
    $arr_product_store = [];
    
    foreach ($products_store as $key => $value) {

      if($value->sku != ''){
        foreach ($items as $item) {
          if($item->sku_code == $value->sku){

            $stock_quantity = $this->get_total_inventory_commodity($item->id);
            $stock_quantity = $stock_quantity->inventory_number;
            $images = [];
            if($this->get_all_image_file_name($item->id)){
              $file_name = $this->omni_sales_model->get_all_image_file_name($item->id);
            }
            foreach ($file_name as $k => $name) {
              array_push($images, array('src' => site_url('modules/warehouse/uploads/item_img/'.$item->id.'/'.$name['file_name'])));
            }
            if(is_null($stock_quantity)){
              $stock_quantity = 0;
            }
            $date = date('Y-m-d');
            $discount =  $this->check_discount($item->id, $date, 3, $store_id);
            $price_discount = 0;
            $date_on_sale_from = null;
            $date_on_sale_to = null;
            if(!is_null($discount)){
              if($discount->formal == 1){
                $price_discount = $item->rate - (($item->rate * $discount->discount)/100);
              }else{
                $price_discount = $item->rate - $discount->discount;
              }
              $date_on_sale_from = $discount->start_time;
              $date_on_sale_to = $discount->end_time;
            }else{
              $price_discount = "";
            }
            $data = [
                'regular_price' => $item->rate,
                'sale_price' => strval($price_discount),
                'date_on_sale_from' => $date_on_sale_from,
                'date_on_sale_to' => $date_on_sale_to,
            ];
            if(is_null($value->stock_quantity)){
              $value->stock_quantity = 0;
            }
            $log_price = [
                'name' => $item->description,
                'regular_price' => $item->rate,
                'sale_price' => strval($price_discount),
                'date_on_sale_from' => $date_on_sale_from,
                'date_on_sale_to' => $date_on_sale_to,
                'chanel' => 'WooCommerce('.$this->get_name_store($store_id).')',
                "type" => "price",
            ];
            $this->db->insert(db_prefix().'omni_log_sync_woo', $log_price);
            $woocommerce->post('products/'.$value->id, $data);
          }
        }   
      }
    }
    return true;
  }


    /**
 * process price synchronization
 * @param  int $store_id 
 * @return bool           
 */
  public function process_price_synchronization_update_product($store_id, $price, $product_id){
    $store =  $this->get_woocommere_store($store_id);
    $product = $this->get_product($product_id);
    $consumer_key = $store->consumer_key;
    $consumer_secret = $store->consumer_secret;
    $url = $store->url;
    $woocommerce = new Client(
        $url, 
        $consumer_key, 
        $consumer_secret,
        [
            'version' => 'wc/v3',
        ]
    );

    $products_store = $woocommerce->get('products');
    $arr_product_store = [];
    
    foreach ($products_store as $key => $value) {

      if($value->sku != ''){
        if($product->sku_code == $value->sku){
          $data = [
                'regular_price' => $price,
            ];

          $log_price = [
                'name' => $item->description,
                'regular_price' => $item->rate,
                'chanel' => 'WooCommerce('.$this->get_name_store($store_id).')',
                "type" => "price",
            ];
            $this->db->insert(db_prefix().'omni_log_sync_woo', $log_price);
            $rs = $woocommerce->post('products/'.$value->id, $data);
        }
      }
    }
    return true;
  }
  public function add_log_trade_discount($user_id, $order_number,$channel_id , $total_order, $discount_price, $tax, $total_after, $voucher){

  }
}
