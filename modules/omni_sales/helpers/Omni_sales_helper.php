<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * load error page
 * @param  string $title  
 * @param  string $content
 * @return view         
 */
function infor_page($title = '',$content = '',$previous_link=''){
      $data['title'] = $title;
      $data['content'] = $content;  
      $data['previous_link'] = $previous_link;  
      $CI = & get_instance();                  
      $CI->data($data);
      $CI->view('client/info_page');
      $CI->layout();
}

/**
 * get all email contacts
 * @return $data_email
 */
function get_all_email_contacts(){
	$CI = & get_instance();                  
	$data = $CI->db->get(db_prefix() . 'contacts')->result_array();
	$data_email = [];
	foreach ($data as $key => $value) {
		$data_email[] = $value['email'];
	}
	return $data_email;
}
/**
 * cron job sync woo
 * @param  string $type    
 * @param  int $store   
 * @param  int $minutes 
 * @return  bolean         
 */
function cron_job_sync_woo($type, $store = '', $minutes){
	$CI = & get_instance();      

    $CI->load->model('omni_sales/omni_sales_model');
	$hour = date("H:i:s");
	$hour_cron = get_option('time_cron_woo');
	$sync_omni_sales_products = get_option('sync_omni_sales_products');
	$sync_omni_sales_orders = get_option('sync_omni_sales_orders');
	$sync_omni_sales_inventorys = get_option('sync_omni_sales_inventorys');
	$sync_omni_sales_description = get_option('sync_omni_sales_description');
	$sync_omni_sales_images = get_option('sync_omni_sales_images');


	$price_crm_woo = get_option('price_crm_woo');
	$product_info_enable_disable = get_option('product_info_enable_disable');
	$product_info_image_enable_disable = get_option('product_info_image_enable_disable');

	//time
	$minute_sync_product_info_time1 = get_option('minute_sync_product_info_time1');
    $minute_sync_inventory_info_time2 = get_option('minute_sync_inventory_info_time2');
    $minute_sync_price_time3 = get_option('minute_sync_price_time3');
    $minute_sync_decriptions_time4 = get_option('minute_sync_decriptions_time4');
    $minute_sync_images_time5 = get_option('minute_sync_images_time5');
    $minute_sync_orders_time6 = get_option('minute_sync_orders');
    $minute_sync_product_info_time7 = get_option('minute_sync_product_info_time7');
    $minute_sync_product_info_images_time8 = get_option('minute_sync_product_info_images_time8');
    //records
    $records_time1 = get_option('records_time1');
	$records_time2 = get_option('records_time2');
	$records_time3 = get_option('records_time3');
	$records_time4 = get_option('records_time4');
	$records_time5 = get_option('records_time5');
	$records_time6 = get_option('records_time6');
	$records_time7 = get_option('records_time7');
	$records_time8 = get_option('records_time8');

	if($type == 'products'){
		if($store != ''){
	    	if($sync_omni_sales_inventorys == "1"){
	    		if(strtotime($hour) >= strtotime($records_time2)){
	            	$CI->omni_sales_model->process_inventory_synchronization($store);
	            	$records_time2 = strtotime($records_time2);
					$run_time2 = date("H:i:s", strtotime('+'.$minute_sync_inventory_info_time2.' minutes', $records_time2));
					update_option('records_time2', $run_time2);

	    		}

	    	}
	    	if($sync_omni_sales_description == "1"){
	    		if(strtotime($hour) >= strtotime($records_time4)){
	            	$CI->omni_sales_model->process_decriptions_synchronization($store);
	            	$records_time4 = strtotime($records_time4);
					$run_time4 = date("H:i:s", strtotime('+'.$minute_sync_decriptions_time4.' minutes', $records_time4));
					update_option('records_time4', $run_time4);

	    		}
	    	}
	    	if($sync_omni_sales_images == "1"){
	    		if(strtotime($hour) >= strtotime($records_time5)){
	            	$CI->omni_sales_model->process_images_synchronization($store);
	            	$records_time5 = strtotime($records_time5);
					$run_time5 = date("H:i:s", strtotime('+'.$minute_sync_images_time5.' minutes', $records_time5));
					update_option('records_time5', $run_time5);

	    		}
	    	}
	    	if($price_crm_woo == "1"){
	    		if(strtotime($hour) >= strtotime($records_time3)){
	            	$CI->omni_sales_model->process_price_synchronization($store);
	            	$records_time3 = strtotime($records_time3);
					$run_time3 = date("H:i:s", strtotime('+'.$minute_sync_price_time3.' minutes', $records_time3));
					update_option('records_time3', $run_time3);

	    		}
	    	}
	    	if($product_info_enable_disable == "1"){
	    		if(strtotime($hour) >= strtotime($records_time7)){
	            	$CI->omni_sales_model->sync_products_from_info_woo($store);
	            	$records_time7 = strtotime($records_time7);
					$run_time7 = date("H:i:s", strtotime('+'.$minute_sync_product_info_time7.' minutes', $records_time7));
					update_option('records_time7', $run_time7);

	    		}
	    	}

	    	if($product_info_image_enable_disable == "1"){
	    		if(strtotime($hour) >= strtotime($records_time8)){
	            	$CI->omni_sales_model->sync_from_the_store_to_the_system($store);
	            	$records_time8 = strtotime($records_time8);
					$run_time8 = date("H:i:s", strtotime('+'.$minute_sync_product_info_images_time8.' minutes', $records_time8));
					update_option('records_time8', $run_time8);

	    		}
	    	}
		}
	}else{
		if($store != ''){
        	if($sync_omni_sales_orders == "1"){
        		if(strtotime($hour) >= strtotime($records_time6)){
	            	$CI->omni_sales_model->process_orders_woo($store);
	            	$records_time6 = strtotime($records_time6);
					$run_time6 = date("H:i:s", strtotime('+'.$minute_sync_orders_time6.' minutes', $records_time6));
					update_option('records_time6', $run_time6);
	    		}
	    	}
		}
	}
	
    return true;
}

/**
 * get all store 
 * @return  stores
 */
function get_all_store(){
	$CI = & get_instance();      
    $CI->load->model('omni_sales/omni_sales_model');
	return $CI->omni_sales_model->get_woocommere_store();
}
