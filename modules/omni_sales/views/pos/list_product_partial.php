<?php 
	  $currency_name = '';
	  if(isset($base_currency)){
	    $currency_name = $base_currency->name;
	  }
	  $array_list_id = [];
	  if(isset($_COOKIE['cart_id_list'])){
	    $list_id = $_COOKIE['cart_id_list'];
	    if($list_id){
	        $array_list_id = explode(',',$list_id);
	    }
	  }
?>

<div class="row">
	<?php foreach ($product as $item) { ?>
		<div class="col-md-1 grid col-6 col-sm-2" onclick="add_cart(this);" 
		data-percent-tax="<?php echo html_entity_decode($item['percent_tax']); ?>" 
		data-total-tax="<?php echo html_entity_decode($item['total_tax']); ?>" 
		data-tax="<?php echo html_entity_decode($item['tax']); ?>" 
		data-w_quantity="<?php echo html_entity_decode($item['w_quantity']); ?>" 
		data-id="<?php echo html_entity_decode($item['id']); ?>" 
		data-gid="<?php echo html_entity_decode($item['group_id']); ?>" >
            <div class="grid product-cell">
                <div class="product-image contain_image">
                	<?php 
                		$file_name = $this->omni_sales_model->get_image_file_name($item['id']);
                	 ?>
                	<img class="pic-1" src="<?php echo site_url('modules/warehouse/uploads/item_img/'.$item['id'].'/'.$file_name->file_name); ?>">				                  
                </div>
                <div class="product-content">
                    <div class="title"><?php echo html_entity_decode($item['name']); ?></div>
                    <div class="row info">
	                    <strong class="sku w-100">SKU: <?php echo html_entity_decode($item['sku_code']).' /'.$item['w_quantity']; ?></strong> <br><br>
                    </div>
                    <span class="price"  data-price="<?php echo html_entity_decode($item['price']);  ?>" data-price_discount="<?php echo html_entity_decode($item['price_discount']);  ?>" data-discount_percent="<?php echo html_entity_decode($item['discount_percent']);  ?>"><?php echo app_format_money($item['price'],$currency_name); ?></span>				                    
                </div>
               
            </div>
        </div>
	<?php } ?>	             
</div>
