 
 <?php 
 if(isset($client)){ ?>
   <div class="col-md-4">
   <input type="hidden" name="userid" value="<?php echo html_entity_decode($client->userid); ?>">
                  <h4 class="no-mtop">
                     <i class="fa fa-user"></i>
                     <?php echo _l('customer_details'); ?>
                  </h4>
                  <hr />
                  <?php  echo ( isset($client) ? $client->company : ''); ?><br>
                  <?php  echo ( isset($client) ? $client->phonenumber : ''); ?><br>
                  <?php echo ( isset($client) ? $client->address : ''); ?><br>
                  <?php echo ( isset($client) ? $client->city : ''); ?> <?php echo ( isset($client) ? $client->state : ''); ?><br>
                  <?php echo isset($client) ? get_country_short_name($client->country) : ''; ?> <?php echo ( isset($client) ? $client->zip : ''); ?><br>
               </div>
               <div class="col-md-4">
                   <h4 class="no-mtop">
                     <i class="fa fa-map"></i>
                     <?php echo _l('billing_address'); ?>
                  </h4>
                  <hr />
                  <address class="invoice-html-customer-shipping-info">
                  <?php echo isset($client) ? $client->billing_street : ''; ?>
                  <br><?php echo isset($client) ? $client->billing_city : ''; ?> <?php echo isset($client) ? $client->billing_state : ''; ?>
                  <br><?php echo isset($client) ? get_country_short_name($client->billing_country) : ''; ?> <?php echo isset($client) ? $client->billing_zip : ''; ?>
                  </address>
               </div>
               <div class="col-md-4">
                  <h4 class="no-mtop">
                    <a href="<?php echo site_url('omni_sales/omni_sales_client/client/'.$client->userid); ?>" class="btn btn-primary pull-right go_to_edit_link"><i class="fa fa-edit"></i></a>
                     <i class="fa fa-street-view"></i>
                     <?php echo _l('shipping_address'); ?>
                  </h4>
                  <hr />
                  <address class="invoice-html-customer-shipping-info">
                  <?php echo isset($client) ? $client->shipping_street : ''; ?>
                  <br><?php echo isset($client) ? $client->shipping_city : ''; ?> <?php echo isset($client) ? $client->shipping_state : ''; ?>
                  <br><?php echo isset($client) ? get_country_short_name($client->shipping_country) : ''; ?> <?php echo isset($client) ? $client->shipping_zip : ''; ?>
                  </address>
               </div>
               <div class="row">
         <?php
            $price_tax = 0;
            $currency_name = '';
             if(isset($base_currency)){
                $currency_name = $base_currency->name;
             }
            
            $cart_empty = 0;
            $list_id = '';
            if(isset($_COOKIE['cart_id_list'])){
              $list_id = $_COOKIE['cart_id_list'];
              if(!$list_id){
                 $cart_empty = 1;
              }
            }
            $sub_total = 0;
            $date = date('Y-m-d');
            $discount_price = 0;
         ?>
        <div class="clearfix"></div>
          <br><br>     
          <div class="col-md-3 pull-right">
            <div id="discount_area">
                <div>
                   <?php echo _l('voucher'); ?>
                </div>
                <br>     

                  <div width="200px">
                     <input type="text" class="form-control" name="voucher">
                  </div>
                   <?php
                   echo form_hidden('discount_type', ''); ?>
                  <?php echo form_hidden('discount', '0'); ?>
                  <?php echo form_hidden('discount_total','0'); ?>
             </div> 
          </div>      
          </div>      
          <br><br>     

            <div class="invoice accounting-template fr1 <?php if($cart_empty == 1){ echo 'hide'; } ?>">
                  <div class="row">
                    
                  </div>


                 <div class="fr1">
                  <div class="table-responsive s_table">
                     <table class="table invoice-items-table items table-main-invoice-edit has-calculations no-mtop">
                        <thead>
                           <tr>
                              <th width="50%" align="right"><?php echo _l('invoice_table_item_heading'); ?></th>
                              <th width="5%" align="right" class="qty"><?php echo _l('quantity'); ?></th>
                              <th width="10%" align="right"  valign="center"><?php echo _l('tax').' (%)'; ?></th>
                              <th width="15%" align="right"  valign="center"><?php echo _l('price').' ('.$currency_name.')'; ?></th>
                              <th width="20%" align="right"><?php echo _l('line_total').' ('.$currency_name.')'; ?></th>
                           </tr>
                        </thead>
                        <tbody>
                            <?php 
                              if($list_id){
                                $array_list_id = explode(',',$list_id);
                                $list_qty = $_COOKIE['cart_qty_list'];
                                $array_list_qty = explode(',',$list_qty); ?>
                                <input type="hidden" name="list_id_product" value="<?php echo html_entity_decode($list_id); ?>">
                                <input type="hidden" name="list_qty_product" value="<?php echo html_entity_decode($list_qty); ?>">
                                <input type="hidden" name="list_group_product" value="<?php echo html_entity_decode($list_group); ?>">
                                <input type="hidden" name="list_prices_product" value="<?php echo html_entity_decode($list_prices); ?>">


                            <?php foreach ($array_list_id as $key => $product_id) { ?>
                                    <tr class="main">
                                      <td>
                                          <a href="#">
                                            <?php 
                                                $file_name = $this->omni_sales_model->get_image_file_name($product_id)->file_name;
                                            ?>
                                            <img class="product pic" src="<?php echo site_url('modules/warehouse/uploads/item_img/'.$product_id.'/'.$file_name); ?>">  
                                            <strong>
                                                <?php
                                                    $prices = 0;
                                                    $data_product = $this->omni_sales_model->get_product($product_id);
                                                    if($data_product){
                                                      $prices = $data_product->rate;
                                                      echo html_entity_decode($data_product->description);
                                                    }
                                                     $prices  = 0;
                                                    $data_prices = $this->omni_sales_model->get_price_channel($product_id,2);
                                                    if($data_prices){
                                                      $prices  = $data_prices->prices;
                                                    }

                                                    $discount_percent = 0;
                                                    $price_after_dc = 0;
                                                    $discountss = $this->omni_sales_model->check_discount($product_id, $date, 2);
                                                    $array_product = [];
                                                    
                                                    if($discountss){
                                                        $discount_percent = $discountss->discount;
                                                        $discount_price += ($discount_percent * $prices) / 100;
                                                        $price_after_dc = $prices-(($discount_percent * $prices) / 100);
                                                        array_push($array_product, array('product_id' => $product_id, 'name_discount' => $discountss->name_trade_discount, 'price' => ($discount_percent * $prices) / 100 ));
                                                        echo form_hidden('discount_price', $discount_price);
                                                    }else{
                                                      $price_after_dc = $prices;
                                                    }
                                                    echo form_hidden('data_log',$array_product);
                                                 ?>
                                            </strong>
                                          </a>
                                      </td>
                                      <td align="right" class="middle">
                                          <strong><?php echo html_entity_decode($array_list_qty[$key]); ?></strong>
                                      </td>
                                      <td align="right" class="middle">
                                          <strong><?php
                                           $data_tax = $this->omni_sales_model->get_tax_product($product_id);
                                           echo html_entity_decode($data_tax); ?></strong>
                                      </td>
                                      <td align="right" class="middle prices_<?php echo html_entity_decode($product_id); ?>">

                                          <div class="price_w2 hide"><span class="new_prices"></span></br><span class="old_prices"><?php echo app_format_money($prices,''); ?></span></div>

                                          <div class="price_w1"><span class="new_prices"><?php echo app_format_money($prices,''); ?></span></div>
                                      

                                      </td>
                                      <td align="right" class="middle">
                                         <strong class="line_total_<?php echo html_entity_decode($key); ?>">
                                           <?php
                                              $line_total = (int)$array_list_qty[$key]*$prices;
                                              $sub_total += $line_total;
                                              echo app_format_money($line_total,'');
                                              $tax = ($line_total * $data_tax)/100;
                                              $price_tax += $tax;
                                         
                                          ?>

                                         </strong>
                                      </td>
                                        
                            <?php 
                                }
                                echo form_hidden('tax',$price_tax);
                              }else{ $cart_empty = 1; ?>

                                <center><?php echo _l('cart_empty'); ?></center>
                            <?php  } ?>
                        </tbody>
                     </table>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-8 col-md-offset-4">
                     <table class="table text-right">
                        <tbody>
                           <tr id="subtotal">
                              <td><span class="bold"><?php echo _l('invoice_subtotal'); ?> :</span>
                              </td>
                              <td class="subtotal">
                                <?php echo app_format_money($sub_total,''); ?>
                                <?php echo form_hidden('sub_total', $sub_total);?>
                                <?php $total = $sub_total; ?>
                              </td>
                           </tr>
                            <?php if(!isset($discount)) {?>
                              <tr class="discount_area_discount">
                                <td>
                                   <span class="promotions"><?php echo _l('Discount'); ?> :</span>
                                </td>
                                <td class="promotions_discount_price promotions">- <?php echo app_format_money($discount_price,''); ?>
                                </td>
                              </tr>

                              <tr class="discount_area_discount">
                                <td>
                                   <span class="promotions"><?php echo _l('tax'); ?> :</span>
                                </td>
                                <td class="promotions_tax_price promotions"><?php echo app_format_money($price_tax,''); ?>
                                </td>
                              </tr>
                            <?php } ?>  
                            <?php if(isset($discount) && $discount[0]['formal'] == 1){ ?>
                              
                              <tr id="discount_area">
                                <td>
                                   <span class="promotions"><?php echo _l('Discount'); ?> :</span>
                                </td>
                                <td class="promotions_discount_price promotions">
                                  - <?php echo app_format_money((($total*$discount[0]['discount'])/100),''); ?>
                                </td>
                              </tr>

                              <tr class="discount_area_discount">
                                <td>
                                   <span class="promotions"><?php echo _l('tax'); ?> :</span>
                                </td>
                                <td class="promotions_tax_price promotions"><?php echo app_format_money($price_tax,''); ?>
                                </td>
                              </tr>

                            <?php }?> 

                            <?php if(isset($discount) && $discount[0]['formal'] == 2){ ?>                              
                              <tr id="discount_area">
                                <td>
                                   <span class="promotions"><?php echo _l('Discount'); ?> :</span>
                                </td>
                                <td class="promotions_discount_price">
                                  - <?php echo app_format_money($discount[0]['discount'],''); ?>
                                </td>
                              </tr>

                              <tr class="discount_area_discount">
                                <td>
                                   <span class="promotions"><?php echo _l('tax'); ?> :</span>
                                </td>
                                <td class="promotions_tax_price promotions">
                                   <?php echo app_format_money($price_tax,''); ?>
                                </td>
                              </tr>

                            <?php } ?>
                           <tr>
                              <td>
                                <?php echo _l('total'); ?>
                              </td>
                              <td class="total">
                                
                              </td>
                                <?php 
                                echo form_hidden('total', $total);?>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  </div>
                  
             
                 
               </div>
               <div class="row">
                  <div class="col-md-12 mtop15">
                     <div class="col-md-12">
                        <?php echo render_textarea('notes','notes','');  ?>                        
                     </div>
                  </div>
               </div>
               <div class="clearfix"></div>
                <div class="modal-footer">
                    <button id="sm_btn2" type="submit" class="btn btn-primary"><?php echo _l('order'); ?></button>
                </div>                <div class="content fr2 <?php if($cart_empty != 1){ echo 'hide'; } ?>">
                  <div class="panel_s">
                   <div class="panel-body">
                     <div class="col-md-12 text-center">
                        <h4><?php echo _l('cart_empty'); ?></h4>                    
                     </div>
                     <br>
                     <br>
                     <br>
                     <br>
                     <div class="col-md-12 text-center">
                        <a href="javascript:history.back()" class="btn btn-primary">
                           <i class="fa fa-long-arrow-left" aria-hidden="true"></i> <?php echo _l('return_to_the_previous_page'); ?></a>
                     </div>
                    </div>
                 </div>
                </div>
         </div>
      </div>
 <?php  }else{ ?>
    <div class="row">
      <div class="col-md-12">
        <center>
          <a href="<?php echo site_url('omni_sales/omni_sales_client/index/1/0'); ?>" class="btn btn-primary"><?php echo _l('return_to_the_previous_page'); ?></a>
        </center>
      </div>
    </div>
 <?php   } ?> 
<?php hooks()->do_action('client_pt_footer_js'); ?>
