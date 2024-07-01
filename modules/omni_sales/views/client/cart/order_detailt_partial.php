 <?php hooks()->do_action('head_element_client'); ?>
<div class="col-md-6">
  <h5><?php echo _l('order_number');  ?>: #<?php  echo ( isset($order) ? $order->order_number : ''); ?></h5>
  <span><?php echo _l('order_date');  ?>: <?php  echo ( isset($order) ? $order->datecreator : ''); ?></span>
</div>
<div class="col-md-6 status_order">
  <?php 
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
     <button class="btn pull-right">
       <?php echo _l($status); ?>
     </button>     
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
                  <!-- <span class="bold invoice-html-ship-to">Ship to:</span> -->
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
                  <!-- <span class="bold invoice-html-ship-to">Ship to:</span> -->
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
                          ?>
                          
                        <?php foreach ($order_detait as $key => $item_cart) { ?>
                                <tr class="main">
                                  <td>
                                      <a href="#">
                                        <?php 
                                            $file_name = $this->omni_sales_model->get_image_file_name($item_cart['product_id'])->file_name;
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
                                     <strong><?php 
                                              echo app_format_money($item_cart['prices'],'');
                                      ?></strong>
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
                              <td class="subtotal">
                                <?php echo app_format_money($order->sub_total,''); ?>
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
                                     echo '-'.app_format_money($price_discount,''); ?>
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
                                <?php echo app_format_money($order->tax,''); ?>
                              </td>
                           </tr>
                           <tr>
                              <td><span class="bold"><?php echo _l('invoice_total'); ?> :</span>
                              </td>
                              <td class="total">
                                 <?php echo app_format_money($order->total,''); ?>
                              </td>
                           </tr>
                        </tbody>
                     </table> 

                  </div>
             
                 
               </div>
                  <div class="col-md-12 mtop15">
                    <a href="<?php echo site_url('omni_sales/omni_sales_client/index/1/0'); ?>" class="btn btn-default"><?php echo _l('continue_shopping'); ?></a>
                    <?php  if($order->status == 0){ ?>
                        <button class="btn btn-primary pull-right" onclick="open_modal_chosse();">
                           <?php echo _l('cancel_order'); ?>
                        </button>    
                    <?php } ?>                   
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
    <?php echo form_open(site_url('omni_sales/omni_sales_client/change_status_order/'.$order->order_number),array('id'=>'form_medicine_category')); ?>         
        <input type="hidden" name="status" value="7">
        <div class="modal-body">
            <div class="col-md-12">
                  <div class="input-field">
                     <div class="radio-button">
                        <input name="cancelReason" checked id="cancel_reason_1" type="radio" value="change_line_items">
                        <label for="cancel_reason_1"><?php echo _l('change_line_items'); ?></label>
                     </div>
                     <div class="radio-button">
                        <input name="cancelReason" id="cancel_reason_2" type="radio" value="change_delivery_address">
                        <label for="cancel_reason_2"><?php echo _l('change_delivery_address'); ?></label>
                     </div><div class="radio-button">
                        <input name="cancelReason" id="cancel_reason_3" type="radio" value="high_shipping_cost">
                        <label for="cancel_reason_3"><?php echo _l('high_shipping_cost'); ?></label>
                     </div>
                     <div class="radio-button">
                        <input name="cancelReason" id="cancel_reason_4" type="radio" value="delivery_time_is_too_long">
                        <label for="cancel_reason_4"><?php echo _l('delivery_time_is_too_long'); ?></label>
                     </div>
                     <div class="radio-button">
                        <input name="cancelReason" id="cancel_reason_5" type="radio" value="misplaced_identical_product">
                        <label for="cancel_reason_5"><?php echo _l('misplaced_identical_product'); ?></label>
                     </div>
                     <div class="radio-button">
                        <input name="cancelReason" id="cancel_reason_6" type="radio" value="do_not_want_to_buy_anymore">
                        <label for="cancel_reason_6"><?php echo _l('do_not_want_to_buy_anymore'); ?></label>
                     </div><div class="radio-button">
                        <input name="cancelReason" id="cancel_reason_7" type="radio" value="change_payment_method">
                        <label for="cancel_reason_7"><?php echo _l('change_payment_method'); ?></label>
                     </div>
                     <div class="radio-button">
                        <input name="cancelReason" id="cancel_reason_8" type="radio" value="forgot_to_use_discount_code_refund_codes">
                        <label for="cancel_reason_8"><?php echo _l('forgot_to_use_discount_code_refund_codes'); ?></label>
                     </div>
                     <br>
                  </div>

               </div>
            </div>
            <div class="clearfix">               
            <br>
            <br>
            <div class="clearfix">               
        </div>
        <div class="modal-footer">
            <button class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
            <button class="btn btn-danger" type="submit"><?php echo _l('cancel_order'); ?></button>
        </div>
        <?php echo form_close(); ?>                 
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->