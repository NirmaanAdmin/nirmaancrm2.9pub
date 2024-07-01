<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php 
$inv = '';
$inv_id = '';
$hash = '';
if(isset($invoice)){
	$inv_id = $invoice->id;
	$hash = $invoice->hash;
} 

 ?>
<div id="wrapper">
 <div class="content">
    <div class="panel_s">
        <div class="panel-body">

			<div class="col-md-6">
			  <h5><?php echo _l('order_number');  ?>: #<?php  echo ( isset($order) ? $order->order_number : ''); ?></h5>
			  <span><?php echo _l('order_date');  ?>: <?php  echo ( isset($order) ? $order->datecreator : ''); ?></span>
			  <?php if(isset($invoice)){ ?>
			  	<h4><?php echo _l('invoice');  ?>: <a href="<?php echo admin_url('invoices#'.$invoice->id) ?>"><?php echo html_entity_decode($order->invoice); ?></a></h4>
				
			  <?php	} ?>
			  <input type="hidden" name="order_number" value="<?php echo html_entity_decode($order->order_number); ?>">
			</div>
			<div class="col-md-6 status_order">
			  <?php
		      $currency_name = '';
		      if(isset($base_currency)){
		        $currency_name = $base_currency->name;
		      }
			  $status = '';
			    if($order->status == 0){
			    $status = _l('processing');
			    }      
			    if($order->status == 1){
			        $status = _l('pending_payment');
			    }
			    if($order->status == 2){
			        $status = _l('confirm');
			    }
			    if($order->status == 3){
			        $status = _l('being_transported');
			    }
			    if($order->status == 4){
			        $status = _l('finish');
			    }
			    if($order->status == 5){
			        $status = _l('refund');
			    }
			    if($order->status == 6){
			        $status = _l('lie');
			    } 
			    if($order->status == 7){
			        $status = _l('cancelled');
			    }     
			   ?>
			   <div class="col-md-8 reasion text-danger">
			     <?php 
			        if($order->status == 7){ 
			            if($order->admin_action == 0){
			              echo _l('was_canceled_by_you_for_a_reason').': '._l($order->reason); 
			            }
			            else
			            {
			              echo _l('was_canceled_by_us_for_a_reason').': '._l($order->reason);  
			            } 
			        } ?> 
			   </div>
			   <div class="col-md-4">
			   	<ul> 
			     	<li class="dropdown pull-right">
	                  	 <button href="#" class="dropdown-toggle btn" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true" >
	                      <?php echo _l($status); ?>  <span class="caret" data-toggle="" data-placement="top" data-original-title="<?php echo _l('change_status'); ?>"></span>
	                     </button>
	                     <ul class="dropdown-menu animated fadeIn">
	                        <li class="customers-nav-item-edit-profile">
						           <a href="#" class="change_status" data-status="0">
								    	<?php echo _l('processing'); ?>
								   </a>      
								   <a href="#" class="change_status" data-status="1">
								        <?php echo _l('pending_payment'); ?>
								   </a>
								   <a href="#" class="change_status" data-status="2">
								        <?php echo _l('confirm'); ?>
								   </a>
								   <a href="#" class="change_status" data-status="3">
								        <?php echo _l('being_transported'); ?>
								   </a>
								   <a href="#" class="change_status" data-status="4">
								        <?php echo _l('finish'); ?>
								   </a>
								   <a href="#" class="change_status" data-status="5">
								        <?php echo _l('refund'); ?>
								   </a>
								   <a href="#" class="change_status" data-status="6">
								        <?php echo _l('lie'); ?>
								   </a> 
								   <a href="#" class="change_status" data-status="7">
								        <?php echo _l('cancelled'); ?>
								   </a>     
	                        </li> 

	                     </ul>
                    </li>
			   	</ul>




			   </div>
			   <br>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-12">
			  <hr>  
			</div>
			<br>
			<br>
			<br>
			<div class="clearfix"></div>
			 <div class="col-md-4">
			   <input type="hidden" name="userid" value="<?php echo html_entity_decode($order->userid); ?>">
			                  <h4 class="no-mtop">
			                     <i class="fa fa-user"></i>
			                     <?php echo _l('customer_details'); ?>
			                  </h4>
			                  <hr />
			                  <?php  echo ( isset($order) ? $order->company : ''); ?><br>
			                  <?php  echo ( isset($order) ? $order->phonenumber : ''); ?><br>
			                  <?php echo ( isset($order) ? $order->address : ''); ?><br>
			                  <?php echo ( isset($order) ? $order->city : ''); ?> <?php echo ( isset($order) ? $order->state : ''); ?><br>
			                  <?php echo isset($order) ? get_country_short_name($order->country) : ''; ?> <?php echo ( isset($order) ? $order->zip : ''); ?><br>
			               </div>
			               <div class="col-md-4">
			                   <h4 class="no-mtop">
			                     <i class="fa fa-map"></i>
			                     <?php echo _l('billing_address'); ?>
			                  </h4>
			                  <hr />
			                  <address class="invoice-html-customer-shipping-info">
			                  <?php echo isset($order) ? $order->billing_street : ''; ?>
			                  <br><?php echo isset($order) ? $order->billing_city : ''; ?> <?php echo isset($order) ? $order->billing_state : ''; ?>
			                  <br><?php echo isset($order) ? get_country_short_name($order->billing_country) : ''; ?> <?php echo isset($order) ? $order->billing_zip : ''; ?>
			                  </address>
			               </div>
			               <div class="col-md-4">
			                  <h4 class="no-mtop">
			                     <i class="fa fa-street-view"></i>
			                     <?php echo _l('shipping_address'); ?>
			                  </h4>
			                  <hr />
			                  <address class="invoice-html-customer-shipping-info">
			                  <?php echo isset($order) ? $order->shipping_street : ''; ?>
			                  <br><?php echo isset($order) ? $order->shipping_city : ''; ?> <?php echo isset($order) ? $order->shipping_state : ''; ?>
			                  <br><?php echo isset($order) ? get_country_short_name($order->shipping_country) : ''; ?> <?php echo isset($order) ? $order->shipping_zip : ''; ?>
			                  </address>
			               </div>
			               <div class="row">
			         <?php
			            $currency_name = '';
			             if(isset($base_currency)){
			                $currency_name = $base_currency->name;
			             }
			            $sub_total = 0;
			         ?>
			        <div class="clearfix"></div>
			                <br><br>        
			            <div class="invoice accounting-template">
			                  <div class="row">
			                    
			                  </div>


			                 <div class="fr1">
			                  <div class="table-responsive s_table">
			                     <table class="table invoice-items-table items table-main-invoice-edit has-calculations no-mtop">
			                        <thead>
			                           <tr>
			                              <th width="50%" align="center"><?php echo _l('invoice_table_item_heading'); ?></th>
			                              <th width="10%" align="center" class="qty"><?php echo _l('quantity'); ?></th>
			                              <th width="20%" align="center"  valign="center"><?php echo _l('price').' ('.$currency_name.')'; ?></th>
			                              <th width="20%" align="center"><?php echo _l('line_total').' ('.$currency_name.')'; ?></th>
			                           </tr>
			                        </thead>
			                        <tbody>
			                          <?php 
			                              $sub_total = 0; 
			                              $date = date('Y-m-d');
			                          ?>
			                          
			                        <?php foreach ($order_detait as $key => $item_cart) { ?>
			                                <tr class="main">
			                                  <td>
			                                      <a href="#">
			                                        <?php 
			                                        	$discount_price = 0;
			                                            $file_name = $this->omni_sales_model->get_image_file_name($item_cart['product_id'])->file_name;
                                                    	$discountss = $this->omni_sales_model->check_discount($item_cart['product_id'], $date);
                                                    	if($discountss){
	                                                        $discount_percent = $discountss->discount;
	                                                        $discount_price += ($discount_percent * $item_cart['prices']) / 100;
	                                                        $price_after_dc = $item_cart['prices']-(($discount_percent * $item_cart['prices']) / 100);
	                                                        echo form_hidden('discount_price', $discount_price);
	                                                    }else{
	                                                    	$price_after_dc = $item_cart['prices'];
	                                                    }

			                                        ?>
			                                        <img class="product pic" src="<?php echo site_url('modules/warehouse/uploads/item_img/'.$item_cart['product_id'].'/'.$file_name); ?>">  
			                                        <strong>
			                                            <?php   
			                                                  echo html_entity_decode($item_cart['product_name']);
			                                             ?>
			                                        </strong>
			                                      </a>
			                                  </td>
			                                  <td align="center" class="middle">
			                            	<?php echo html_entity_decode($item_cart['quantity']); ?>
			                                  </td>
			                                  <td align="center" class="middle">
			                                  	<?php if($discountss){ ?>
			                                     <strong><?php 
			                                              echo app_format_money($price_after_dc,'');
			                                      ?></strong>
		                                      	<p class="price">
                                              		<span class="old-price"><?php echo app_format_money($item_cart['prices'], ''); ?></span>&nbsp;  
                                          		</p>
                                          	<?php }else{ ?>
												<strong><?php 
			                                              echo app_format_money($price_after_dc,'');
			                                      ?></strong>
                                          	<?php } ?>
			                                  </td>
			                                  <td align="center" class="middle">
			                                     <strong class="line_total_<?php echo html_entity_decode($key); ?>">
			                                       <?php
			                                       $line_total = (int)$item_cart['quantity']*$item_cart['prices'];
			                                       $sub_total += $line_total;
			                                        echo app_format_money($line_total,''); ?>
			                                     </strong>

			                                  </td>
			                                </tr>
			                        <?php     } ?>
			                        </tbody>
			                     </table>
			                  </div>

			                  <div class="col-md-8 col-md-offset-4">
			                     <table class="table text-right">
			                        <tbody>
			                           <tr id="subtotal">
			                              <td><span class="bold"><?php echo _l('invoice_subtotal'); ?> :</span>
			                              </td>
			                              <td class="subtotal_s">
			                                <?php
			                                	$sub_total = 0;
			                                	if($order->sub_total){
			                                		$sub_total = $order->sub_total;
			                                	}
			                                 echo app_format_money($sub_total,'').' '.$currency_name; ?>
			                              </td>
			                           </tr>
			                            <?php if($order->discount){
			                            if($order->discount>0){
			                              if($order->discount_type == 1){
			                                  $voucher = '';
			                                  if($order->voucher){
			                                    if($order->voucher!=''){
			                                      $voucher = '<span class="text-danger">'.$order->voucher.'</span>';
			                                    }
			                                  }
			                                ?>



			                               <tr>
			                                  <td><span class="bold"><?php echo _l('discount').' ('.$voucher.' -'.$order->discount.'%)'; ?> :</span>
			                                  </td>
			                                  <td>
			                                    <?php

			                                    $price_discount = $order->sub_total * $order->discount/100;
			                                     echo '-'.app_format_money($price_discount,''); ?>
			                                  </td>
			                               </tr>


			                              <?php  }if($order->discount_type == 2){  ?>
			                                <tr>
			                                  <td><span class="bold"><?php echo _l('discount'); ?> :</span>
			                                  </td>
			                                  <td>
			                                    <?php
			                                   		 $price_discount = $order->sub_total - $order->discount;
			                                     echo '-'.app_format_money($order->discount,'').' '.$currency_name; ?>
			                                  </td>
			                               </tr>
			                              <?php 
			                                }
			                              }
			                           } ?>
			                           <tr>
			                              <td><span class="bold"><?php echo _l('tax'); ?> :</span>
			                              </td>
			                              <td>
			                                <?php echo app_format_money($order->tax,'').' '.$currency_name; ?>
			                              </td>
			                           </tr>
			                           <tr>
			                              <td><span class="bold"><?php echo _l('invoice_total'); ?> :</span>
			                              </td>
			                              <td class="total_s">			                              	
			                                 <?php echo app_format_money($order->total,'').' '.$currency_name; ?>
			                              </td>
			                           </tr>
			                        </tbody>
			                     </table>
			                  </div>		             
			                 
			               </div>
			                  <div class="col-md-12 mtop15">
									<div class="row">
								         <div class="panel-body bottom-transaction">
								            <a href="<?php echo admin_url('omni_sales/order_list'); ?>" class="btn btn-default"><?php echo _l('close'); ?></a>
								            <div class="btn pull-right"></div>
								            <?php if($order->channel_id == 3){ ?>
									           <a href="<?php echo admin_url('omni_sales/add_inv_and_out_of_stock/'.$id); ?>" class="btn btn-primary pull-right ">
									             <?php echo _l('create_invoice_out_of_stock'); ?>
									           </a>
								         	<?php }?>
								            <?php if ($order->stock_export_number=='') { ?>
												<a href="<?php echo admin_url('omni_sales/create_export_stock/'.$id.'/'.$order->invoice); ?>" class="btn btn-warning pull-right">
									             <?php echo _l('create_export_stock'); ?>
									            </a>
								            <?php }else{ ?>
								            	 <a href="<?php echo admin_url('warehouse/manage_delivery#'.$order->stock_export_number); ?>" class="btn pull-right"><?php echo _l('view_export_stock'); ?></a>
								            <?php } ?>								            
								            <a href="<?php echo admin_url('invoices#'.$order->number_invoice); ?>" class="btn pull-right"><?php echo _l('view_invoice'); ?></a>
								         </div>
								        <div class="btn-bottom-pusher"></div>
								   </div>     
			                  </div>
			              </div>
			            </div>               
         </div>
      </div>

<div class="modal fade" id="chosse" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                <span class="add-title"><?php echo _l('please_let_us_know_the_reason_for_canceling_the_order') ?></span>
            </h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                 <?php echo render_textarea('cancel_reason','cancel_reason',''); ?>
               </div>
            </div>
            <div class="clearfix">               
            <br>
            <br>
            <div class="clearfix">               
        </div>
        <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
      		<button type="button" data-status="7" class="btn btn-danger cancell_order"><?php echo _l('cancell'); ?></button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

				   
<?php init_tail(); ?>
</body>
</html>