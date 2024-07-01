<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php 
	$group_product_id = '';
	$product_id = '';
 ?>
<div id="wrapper">
 <div class="content">
   <div class="panel_s">
    <div class="panel-body">
	 <div class="clearfix"></div><br>
	 <div class="col-md-12">
	 	<h4><i class="fa fa-list-ul">&nbsp;&nbsp;</i><?php echo html_entity_decode($title); ?></h4>
	 	<hr>
	 </div>
	     <div class="col-md-3"> 
		    <a href="#" onclick="add_product(); return false;" class="btn btn-info pull-left">
		        <?php echo _l('add'); ?>
		    </a>
		    <div class="clearfix"></div><br>
		 </div>
		<div class="clearfix"></div>
		<hr class="hr-panel-heading" />
		<div class="clearfix"></div>
		<table class="table table-add_product_management scroll-responsive">
		      <thead>
		        <th>ID#</th>
			    <th><?php echo _l('product_code'); ?></th>
			    <th><?php echo _l('product_name'); ?></th>
			    <th><?php echo _l('price'); ?></th>
			    <th><?php echo _l('price_on_channel'); ?></th>
			    <th><?php echo _l('options'); ?></th>
		      </thead>
		      <tbody></tbody>
		      <tfoot>
		         <td></td>
		         <td></td>
		         <td></td>
		         <td></td>
		         <td></td>
		         <td></td>      
		      </tfoot>
		   </table>
		   <div class="col-md-12">
		   		<a href="<?php echo admin_url('omni_sales/omni_sales_channel'); ?>" class="btn btn-danger"><?php echo _l('close'); ?></a>
		   </div>
	</div>
  </div>
 </div>
</div>
<div class="modal fade" id="chose_product" tabindex="-1" role="dialog">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">
	                    <span class="add-title"><?php echo _l('add_product'); ?></span>
	                    <span class="update-title hide"><?php echo _l('update_product'); ?></span>
	                </h4>
	            </div>
	        <?php echo form_open(admin_url('omni_sales/add_product'),array('id'=>'form_add_product')); ?>	            
	            <div class="modal-body">
			        <div class="row">
						<input type="hidden" name="sales_channel_id" value="<?php echo html_entity_decode($id_channel); ?>">
						<input type="hidden" name="channel" value="<?php echo html_entity_decode($channel); ?>">
						<input type="hidden" name="id" value="">
						<div class="col-md-12">
							<?php 
				              echo render_select('group_product_id',$group_product,array('id',array('commodity_group_code','name')),'group_product',$group_product_id,array('onchange'=>'get_list_product(this);'));
				            ?>
						</div>

	                    <div class="col-md-12">
	                       <div class="form-group" app-field-wrapper="product_id">
	                       	<label for="product_id" class="control-label"><?php echo _l('product'); ?></label>
	                       	
	                       		<select id="product_id" name="product_id[]" class="selectpicker" multiple  data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true" data-actions-box="true" tabindex="-98">
	                       			<?php foreach ($products as $key => $value) { ?>
	                       				<option value="<?php echo html_entity_decode($value['id']); ?>"><?php echo html_entity_decode($value['description']); ?></option>
	                       			<?php } ?>
	                       		</select>
		                   
		                   </div>
	                    </div>
	                    <div class="col-md-12 pricefr hide">
							<?php 
				                $arrAtt = array();
		                        $arrAtt['data-type']='currency';
		                        echo render_input('prices','prices','','text',$arrAtt); ?>

						</div>
		            </div>
	            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                </div>
	            <?php echo form_close(); ?>	                
	          </div>
	        </div>
	    </div>
<?php init_tail(); ?>
</body>
</html>
