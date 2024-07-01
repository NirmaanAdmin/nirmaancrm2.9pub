<!DOCTYPE html>
<html>
<head>
	<title></title>
	<?php hooks()->do_action('head_element_client'); ?>
</head>
<body class="bodyfixed">
    <?php 
          $currency_name = '';
          if(isset($base_currency)){
            $currency_name = $base_currency->name;
          }
     ?>
<div class="row header_pos">
	<div class="col-md-6">
<div class="search_frame">
    <input type="text" class="form-control" onkeyup="change_result(this);" name="keyword" placeholder="Search for products here ..." aria-describedby="basic-addon1">
    <span class="search_btn bbrr3 btrr3" data-id_group="0" onclick="search(this)"><i class="fa fa-search"></i></span>
</div>

	</div>
	<div class="col-md-6"> 
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-md-12">
            <div class="customerfr">
              <select name="client_id" class="selectpicker input_groups" onchange="get_trade_discount(this);" data-width="100%" data-none-selected-text="<?php echo _l('customer'); ?>" data-live-search="true"> 
                 <option></option>
                  <?php 
                        foreach ($client as $key => $value) { ?>
                          <option value="<?php echo html_entity_decode($value['userid']) ?>"><?php echo html_entity_decode($value['company']) ?></option>                    
                  <?php } ?>  
              </select>
              <a href="../clients/client" target="blank" class="append_right bbrr3 btrr3">
                <i class="fa fa-plus"></i>
              </a>
            </div>
          </div>          
        </div>
      </div>
      <div class="col-md-6">
         <div class="col-md-12">
            <div class="customerfr">
              <select name="seller" class="selectpicker input_groups" data-width="100%" data-none-selected-text="<?php echo _l('salesman'); ?>" data-live-search="true"> 
                 <option></option>
                  <?php 
                        foreach ($staff as $key => $value) { ?>
                          <option value="<?php echo html_entity_decode($value['staffid']) ?>" <?php if(get_staff_user_id() == $value['staffid']){ echo 'selected'; } ?>><?php echo html_entity_decode($value['lastname'].' '.$value['firstname']) ?></option>                    
                  <?php } ?>  
              </select>
              <a href="../staff" target="blank" class="append_right bbrr3 btrr3">
                <i class="fa fa-plus"></i>
              </a>
            </div>
          </div>
      </div>
    </div>
    </div>

	<div class="clearfix"></div>
	<br>
	<br>
</div>
<div class="row frame_1">
	<div class="col-md-9 product_list_fr">

		    <div class="horizontal-scrollable-tabs preview-tabs-top" >
            <div class="arrow_left" onclick="scroll_list(-1);">
              <i class="fa fa-chevron-left"></i>
            </div>
            <div class="horizontal-tabs header-tab-group">
               <ul class="nav nav-tabs nav-tabs-horizontal mbot15" role="tablist">
                 <li role="presentation" data-id_group="0" id="all_product" class="active item-group">
                     <a href="#tab_0" aria-controls="tab_invoice" role="tab" data-toggle="tab" aria-expanded="true">
                     <?php echo _l('all_products'); ?></a>
                 </li>  
               	<?php foreach ($list_group as $key => $value) { ?>
               	 <li role="presentation" class="item-group" data-id_group="<?php echo html_entity_decode($value['id']); ?>">
                     <a href="#tab_<?php echo html_entity_decode($key+1); ?>" aria-controls="tab_invoice" data-id="<?php echo html_entity_decode($value['id']); ?>" role="tab" data-toggle="tab" aria-expanded="true">
                     <?php echo html_entity_decode($value['name']); ?></a>
                 </li>  
               	<?php } ?> 
 

               </ul>
            </div>
            <div class="arrow_right" onclick="scroll_list(1);">
              <i class="fa fa-chevron-right"></i>
            </div>
         </div>

		<div class="tab-content w-100">
		   <div role="tabpanel" class="tab-pane active" id="tab_invoice">
			 <div class="panel panel-info" >
		      <div class="panel-body frame_content">
		    	<div class="col-md-12 pad_left0 pad_right0 content_list">
		    	</div>
		      </div>
		     </div>
		  </div>
		</div>
	</div>
	<div class="col-md-3 right_pos">
		<div class="preview-tabs-top">
		  <div class="horizontal-tabs">
		  	<ul class="nav nav-tabs mbot15 gen_cart" role="tablist">
		  	  <li role="presentation" onclick="open_tab(this);" onmouseleave="active_customer();" class="tab_cart wtab_1 active">
		         <a href="#tab1" class="exits_show" aria-controls="tab1" role="tab" data-toggle="tab" >
		         1
		         </a>
             <span class="exit_tab" onclick="remove_tab(this);">&#10006;</span>
		      </li>

		      <li onclick="general_tab(this);" class="tab">
		         <a href="#tab2" aria-controls="tab2" role="tab">
		          <i class="fa fa-plus"></i>
		         </a>
		      </li>

		  	</ul>
		  </div>
		</div> 
		<div class="tab-content cart-tab w-100">
		  <div role="tab1" class="tab-pane item-tab client_tab_content client_tab_content_1  active" id="tab1">
		  </div>
		</div>
	</div>
</div>


<div class="hide" id="tab_content_template">
 <div class="panel panel-info" >
    <div class="panel-body">

    <div class="row col-md-12 title_pn">
      <div class="col-md-6">
          <h4><?php echo _l('shopping_cart') ?></h4>
      </div>
      <div class="col-md-6">
          <input type="text" class="form-control" onchange="get_voucher(this);" name="voucher" placeholder="<?php echo _l('vouchers'); ?>">
      </div>
      <hr/>
    </div>
    <div class="row contents">
              <input type="hidden" name="list_id_product" class="list_id_product" value="">
              <input type="hidden" name="list_qty_product" class="list_qty_product" value="">
              <input type="hidden" name="list_price_product" class="list_price_product" value="">                     
              <input type="hidden" name="list_price_discount_product" class="list_price_discount_product" value="">                     
              <input type="hidden" name="list_percent_discount_product" class="list_percent_discount_product" value="">                     
              <input type="hidden" name="list_price_tax" class="list_price_tax" value="">   
              <input type="hidden" name="discount_total" class="discount_total" value="">
              <input type="hidden" name="discount_voucher" class="discount_voucher" value="0">
              <input type="hidden" name="discount_auto" class="discount_auto" value="0">
              <input type="hidden" name="discount_type" class="discount_type" value="">

              <input type="hidden" name="discount_auto_event" class="discount_auto_event" value="">
              <input type="hidden" name="discount_voucher_event" class="discount_voucher_event" value="">

              <input type="hidden" name="customer_id" class="customer_id" value="">

              <div class="content_cart">
                  <div class="list_item"></div>
                   <table class="table text-right">
                      <tbody>
                         <tr id="subtotal">
                            <td><span class="bold"><?php echo _l('invoice_subtotal').' ('.$currency_name.')'; ?> :</span>
                            </td>
                              <input type="hidden" name="sub_total_cart" value="">                   
                            <td class="subtotal">
                              <?php echo app_format_money(0,$currency_name); ?>
                            </td>
                         </tr>
                         <tr id="discount_area">
                            <td>
                               <?php echo _l('discount').':'; ?>
                            </td>
                            <td class="discount-total">
                                
                            </td>
                         </tr>
                        <tr>
                          <tr class="discount_area_discount">
                          <td>
                             <span class="promotions bold"><?php echo _l('tax'); ?> :</span>
                          </td>
                          <td class="promotions_tax_price promotions">+ <?php echo app_format_money(0,''); ?>
                          </td>
                            <input type="hidden" name="tax" value="">                   
                        </tr>
                        </tr>
                         <tr>
                            <td><span class="bold"><?php echo _l('invoice_total').' ('.$currency_name.')'; ?> :</span>
                            </td>
                              <input type="hidden" name="total_cart" value="0">             
                            <td class="total">  
                              <?php echo app_format_money(0,$currency_name); ?>   
                            </td>
                         </tr>
                         <tr>
                             <td>
                                <?php echo  _l('customers_pay').' ('.$currency_name.')'; ?>
                             </td>
                             <td>
                              <div class="clearfix"></div>
                                    <input class="form-control" placeholder="..." data-type="currency" onkeyup="formatCurrency($(this));" onblur="formatCurrency($(this), 'blur');" onchange="cal_price(this);" name="customers_pay" aria-describedby="basic-addon2">
                              <div class="clearfix"></div>
                             </td>
                         </tr>
                         <tr>
                             <td>
                                <?php echo  _l('amount_returned').' ('.$currency_name.')'; ?>
                             </td>
                             <td>
                              <div class="clearfix"></div>
                                  <input type="text" name="amount_returned" class="form-control" aria-describedby="basic-addon3">                         
                              <div class="clearfix"></div>
                             </td>
                         </tr>
                         <tr>
                             <td>                                      
                                  <div class="checkbox create_invoice_fr pull-left">                          
                                    <input type="checkbox" class="capability" name="create_invoice" checked value="on">
                                    <label><?php echo _l('create_invoice'); ?></label>
                                  </div>
                             </td>
                             <td>                                     
                                  <div class="checkbox stock_export_fr pull-left">                          
                                    <input type="checkbox" class="capability" name="stock_export" checked value="on">
                                    <label><?php echo _l('stock_export'); ?></label>
                                  </div>
                             </td>
                         </tr>
                      </tbody>
                   </table>
                   <div class="col-md-12">
                       <button class="btn btn-info create_invoice" onclick="create_invoice(this);"><?php echo _l('order'); ?></button>
                       <div class="clearfix"></div>
                       <br>
                       <br>
                   </div>
            </div> 
    </div>
    </div>
   </div>
</div>
  <div class="modal fade" id="alert" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">   
            <div class="modal-body">
              <center class="alert_content"></center>
            </div>       
        </div>
    </div>
  </div>
<?php hooks()->do_action('client_pt_footer_js'); ?>
<?php require 'modules/omni_sales/assets/js/pos/pos_js.php';?>
</body>
</html>



