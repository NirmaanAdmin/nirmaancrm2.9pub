<?php hooks()->do_action('head_element_client'); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
				$currency_name = '';
			    if(isset($base_currency)){
			       $currency_name = $base_currency->name;
			    }
				
				$cart_empty = 0;
				$list_id = [];
				if(isset($_COOKIE['cart_id_list'])){
					$list_id = $_COOKIE['cart_id_list'];
					if($list_id){
						$cart_empty = 1;
					}
				}
				$sub_total = 0;
				$date = date('Y-m-d');

			?>
			<div class="col-md-12">	

			 					
				<div class="panel_s invoice accounting-template fr1 <?php if($cart_empty == 0){ echo 'hide'; } ?>">
				   <div class="panel-body mtop10">
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
				                  <th></th>
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
				                <?php foreach ($array_list_id as $key => $product_id) { ?>
				                        <tr class="main">
				                          <td>
				                              <a href="<?php echo site_url('omni_sales/omni_sales_client/detailt/'.$product_id); ?>">
				                                <?php 
				                                    $file_name = $this->omni_sales_model->get_image_file_name($product_id)->file_name;
				                                ?>
				                                <img class="product pic" src="<?php echo site_url('modules/warehouse/uploads/item_img/'.$product_id.'/'.$file_name); ?>">  
				                                <strong>
				                                    <?php
				                                        $data_product = $this->omni_sales_model->get_product($product_id);
				                                        if($data_product){
				                                          echo html_entity_decode($data_product->description);
				                                        }
				                                        $prices  = 0;
												        $data_prices = $this->omni_sales_model->get_price_channel($product_id,2);
												        if($data_prices){
												            $prices  = $data_prices->prices;
												        }

												        $discount_percent = 0;
				                                        $prices_discount  = 0;

												        $discount = $this->omni_sales_model->check_discount($product_id, $date, 2);
												        if($discount){
												              $discount_percent = $discount->discount;
												              $prices_discount = $prices-(($discount_percent * $prices) / 100);
												        }

											           $w_qty = 0;
												        $wh = $this->omni_sales_model->get_total_inventory_commodity($product_id);
												        if($wh){
												          if($wh->inventory_number){
												            $w_qty = $wh->inventory_number;
												          }
												        }
												        $true_p = $prices;
												        if($prices_discount>0){
												        	$true_p = $prices_discount;
												        }

													        
				                                     ?>
				                                </strong>
				                              </a>
				                          </td>
				                          <td align="center" class="middle">
				                             <input type="number" onchange="change_cart_qty(this);" min="1" max="<?php echo html_entity_decode($w_qty); ?>" value="<?php echo html_entity_decode($array_list_qty[$key]); ?>" data-price="<?php echo html_entity_decode($true_p); ?>" data-key="<?php echo html_entity_decode($key); ?>" class="form-control line_data qty" placeholder="<?php echo _l('item_quantity_placeholder'); ?>">
				                          </td>
				                          <td align="center" class="middle">
				                             <strong>
				                             	 <?php if($prices_discount>0){ ?>
		                                         <strong><?php echo app_format_money($prices_discount,''); ?></strong>
		                                          <p class="price">
		                                          	<span class="old-price"><?php echo app_format_money($prices,''); ?></span>
		                                          </p>
		                                        <?php }else{ ?>
		                                          <strong><?php echo app_format_money($prices,''); ?></strong>
		                                        <?php } ?> 
				                             	<?php 
				                              ?></strong>
				                          </td>
				                          <td align="center" class="middle">
				                             <strong class="line_total">
				                               <?php
				                               	  

				                               $line_total = (int)$array_list_qty[$key]*$true_p;
				                               $sub_total += $line_total;
				                                echo app_format_money($line_total,''); ?>
				                             </strong>
				                          </td>
				                          <td align="center" class="middle text-danger">
				                          	<i onclick="delete_item(this);" data-id="<?php echo html_entity_decode($product_id); ?>" data-key="<?php echo html_entity_decode($key); ?>" data-toggle="tooltip" data-title="<?php echo _l('delete'); ?>" data-placement="top" class=" fa fa-times"></i></td>
				                        </tr>
				                <?php     }
				                  }else{ ?>

				                    <center><?php echo _l('cart_empty'); ?></center>
				                <?php  } ?>
				            </tbody>
				         </table>
				      </div>

				      <div class="col-md-8 col-md-offset-4">
				         <table class="table text-right">
				            <tbody>
				               <tr id="subtotal">
				                  <td><span class="bold"><?php echo _l('invoice_total'); ?> :</span>
				                  </td>
				                  <td class="subtotal">
				                    <?php echo app_format_money($sub_total,''); ?>
				                  </td>
				               </tr>
				               

				         
				            </tbody>
				         </table>
				      </div>
				    </div>
				 
				     
				   </div>
				   <div class="row">
				      <div class="col-md-12 mtop15">
				         <div class="panel-body bottom-transaction">
				         	<?php 
				         		if(is_client_logged_in()){
				         			$logged = 1;
				         		}
				         	 ?>
				           <a href="<?php echo site_url('omni_sales/omni_sales_client/check_out/'.$logged); ?>" class="btn btn-primary pull-right">
				             <?php echo _l('order'); ?>
				           </a>
				         </div>
				        <div class="btn-bottom-pusher"></div>
				      </div>
				   </div>
				</div>
					 <div class="content fr2 <?php if($cart_empty == 1){ echo 'hide'; } ?>">
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
	</div>
</div>
<?php hooks()->do_action('client_pt_footer_js'); ?>