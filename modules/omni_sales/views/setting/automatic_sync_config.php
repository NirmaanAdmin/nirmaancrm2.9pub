<?php echo form_open(site_url('omni_sales/save_setting/automatic_sync_config'),array('id'=>'invoice-form','class'=>'_transaction_form invoice-form')); ?>
<?php 

	$syn1 = '';	
	$syn2 = '';
	$syn3 = '';
	$syn4 = '';
	$syn5 = '';  

	if($sync_omni_sales_products  == "1"){
		$syn1 = "checked";
	}
	if($sync_omni_sales_inventorys  == "1"){
		$syn2 = "checked";
	}
	if($price_crm_woo  == "1"){
		$syn3 = "checked";
	}
	if($sync_omni_sales_description  == "1"){
		$syn4 = "checked";
	}
	if($sync_omni_sales_images  == "1"){
		$syn5 = "checked";
	}
?>
<div class="row">
	<div class="col-md-12">
		<h4><?php echo _l('crm_to_woocommerce_store'); ?>&nbsp;<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="<?php echo _l('note_setting_1'); ?>"></i></h4>
		<div class="col-md-12 position_partent">
	            <input type="checkbox" name="sync_omni_sales_products" id="sync_omni_sales_products"  <?php echo html_entity_decode($syn1); ?> />
	            <label for="sync_omni_sales_products"><?php echo _l('product_info_enable_disable') ?></label>
	            <input type="number" name="time1" class="pull-right cus_input" placeholder="<?php echo _l('num_of_minutes'); ?>" value="<?php echo html_entity_decode($minute_sync_product_info_time1)?>"/>
		</div>
	    <div class="col-md-12 position_partent">
	    	<div class="funkyradio-warning">
	            <input type="checkbox" name="sync_omni_sales_inventorys" id="sync_omni_sales_inventorys" <?php echo html_entity_decode($syn2); ?> />
	            <label for="sync_omni_sales_inventorys"><?php echo _l('inventory_info_enable_disable'); ?></label>
	            <input type="number" name="time2" class="pull-right cus_input" placeholder="<?php echo _l('num_of_minutes'); ?>" value="<?php echo html_entity_decode($minute_sync_inventory_info_time2)?>"/>
	        </div>
	    </div>
	    <div class="col-md-12 position_partent">
	    	<div class="funkyradio-warning">
	            <input type="checkbox" name="price_crm_woo" id="price_crm_woo" <?php echo html_entity_decode($syn3); ?> />
	            <label for="price_crm_woo"><?php echo _l('price_enable_disable'); ?></label>
	            <input type="number" name="time3" class="pull-right cus_input" placeholder="<?php echo _l('num_of_minutes'); ?>" value="<?php echo html_entity_decode($minute_sync_price_time3)?>"/>
	        </div>
	    </div>
	    <div class="col-md-12 position_partent">
	    	<div class="funkyradio-info">
	            <input type="checkbox" name="sync_omni_sales_description" id="sync_omni_sales_description"  <?php echo html_entity_decode($syn4); ?> />
	            <label for="sync_omni_sales_description"><?php echo _l('descripton_enable_disable'); ?></label>
	            <input type="number" name="time4" class="pull-right cus_input" placeholder="<?php echo _l('num_of_minutes'); ?>" value="<?php echo html_entity_decode($minute_sync_decriptions_time4)?>"/>
	        </div>
	    </div>
	    <div class="col-md-12 position_partent">
	    	 <div class="funkyradio-danger">
	            <input type="checkbox" name="sync_omni_sales_images" id="sync_omni_sales_images"  <?php echo html_entity_decode($syn5); ?> />
	            <label for="sync_omni_sales_images"><?php echo _l('product_image_enable_disable'); ?></label>
	            <input type="number" name="time5" class="pull-right cus_input" placeholder="<?php echo _l('num_of_minutes'); ?>" value="<?php echo html_entity_decode($minute_sync_images_time5)?>"/>
	        </div>
	    </div>
	</div>
</div>


<?php 

	$syn1 = '';	
	$syn2 = '';
	$syn3 = '';
	
	if($sync_omni_sales_orders  == "1"){
		$syn1 = "checked";
	}
	if($product_info_enable_disable  == "1"){
		$syn2 = "checked";
	}
	if($product_info_image_enable_disable  == "1"){
		$syn3 = "checked";
	}
	
?>
		<hr>

<div class="row">
	<div class="col-md-12">
	<h4><?php echo _l('woocommerce_store_to_crm'); ?>&nbsp;<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top" title="<?php echo _l('note_setting_2'); ?>"></i></h4>
 		<div class="col-md-12 position_partent">
		   	<div class="funkyradio">
	            <div class="funkyradio-success">
	                <input type="checkbox" name="sync_omni_sales_orders" id="sync_omni_sales_orders" <?php echo html_entity_decode($syn1); ?> />
	                <label for="sync_omni_sales_orders"><?php echo _l('order_enable_disable'); ?></label>
	                <input type="number" name="time6" class="pull-right cus_input" placeholder="<?php echo _l('num_of_minutes'); ?>" value="<?php echo html_entity_decode($minute); ?>"/>

	            </div>
	        </div>
 		</div>

 		<div class="col-md-12 position_partent">
 			<div class="funkyradio-success">
	                <input type="checkbox" name="product_info_enable_disable" id="product_info_enable_disable" <?php echo html_entity_decode($syn2); ?> />
	                <label for="product_info_enable_disable"><?php echo _l('product_info_enable_disable'); ?></label>
	                <input type="number" name="time7" class="pull-right cus_input" placeholder="<?php echo _l('num_of_minutes'); ?>" value="<?php echo html_entity_decode($minute_sync_product_info_time7); ?>"/>
	            </div>
 		</div>
 		<div class="col-md-12 position_partent">
	            <div class="funkyradio-success">
	                <input type="checkbox" name="product_info_image_enable_disable" id="product_info_image_enable_disable" <?php echo html_entity_decode($syn3); ?> />
	                <label for="product_info_image_enable_disable"><?php echo _l('product_info_image_enable_disable'); ?></label>
	                <input type="number" name="time8" class="pull-right cus_input" placeholder="<?php echo _l('num_of_minutes'); ?>" value="<?php echo html_entity_decode($minute_sync_product_info_images_time8); ?>"/>
	            </div>
 		</div>
	</div>
</div>
	<hr>
	<button class="btn btn-primary pull-right"><?php echo _l('save'); ?></button>
</div>
<?php echo form_close(); ?>
  
