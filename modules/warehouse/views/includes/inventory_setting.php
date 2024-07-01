<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php echo form_open_multipart(admin_url('warehouse/inventory_setting'),array('class'=>'inventory_setting','autocomplete'=>'off')); ?>

<div class="row">
	<div class="col-md-12">
      <h5 class="no-margin font-bold h5-color"><?php echo _l('inventory_received_note') ?></h5>
      <hr class="hr-color">
    </div>
</div>

<div class="form-group">
  <label><?php echo _l('inventory_received_number_prefix'); ?></label>
  <div  class="form-group" app-field-wrapper="inventory_received_number_prefix">
    <input type="text" id="inventory_received_number_prefix" name="inventory_received_number_prefix" class="form-control" value="<?php echo get_warehouse_option('inventory_received_number_prefix'); ?>"></div>
</div>

<div class="form-group">
  <label><?php echo _l('next_inventory_received_mumber'); ?></label>
<i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('next_inventory_received_mumber_tooltip'); ?>"></i>
  <div  class="form-group" app-field-wrapper="next_inventory_received_mumber">
    <input type="number" min="0" id="next_inventory_received_mumber" name="next_inventory_received_mumber" class="form-control" value="<?php echo get_warehouse_option('next_inventory_received_mumber'); ?>">
  </div>

</div>


<div class="row">
  <div class="col-md-12">
      <h5 class="no-margin font-bold h5-color"><?php echo _l('inventory_delivery_note') ?></h5>
      <hr class="hr-color">
    </div>
</div>

<div class="form-group">
  <label><?php echo _l('inventory_delivery_number_prefix'); ?></label>
  <div class="form-group" app-field-wrapper="inventory_delivery_number_prefix">
    <input type="text" id="inventory_delivery_number_prefix" name="inventory_delivery_number_prefix" class="form-control" value="<?php echo get_warehouse_option('inventory_delivery_number_prefix'); ?>"></div>
</div>

<div class="form-group">
  <label> <?php echo _l('next_inventory_delivery_mumber'); ?></label>
<i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('next_delivery_received_mumber_tooltip'); ?>"></i>

  <div  class="form-group" app-field-wrapper="next_inventory_delivery_mumber">
    <input type="number" min="0" id="next_inventory_delivery_mumber" name="next_inventory_delivery_mumber" class="form-control" value="<?php echo get_warehouse_option('next_inventory_delivery_mumber'); ?>"></div>
</div>


<div class="row">
  <div class="col-md-12">
      <h5 class="no-margin font-bold h5-color"><?php echo _l('internal_delivery_note') ?></h5>
      <hr class="hr-color">
    </div>
</div>

<div class="form-group">
  <label><?php echo _l('internal_delivery_number_prefix'); ?></label>
  <div class="form-group" app-field-wrapper="internal_delivery_number_prefix">
    <input type="text" id="internal_delivery_number_prefix" name="internal_delivery_number_prefix" class="form-control" value="<?php echo get_warehouse_option('internal_delivery_number_prefix'); ?>"></div>
</div>

<div class="form-group">
  <label> <?php echo _l('next_internal_delivery_mumber'); ?></label>
<i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('next_delivery_received_mumber_tooltip'); ?>"></i>

  <div  class="form-group" app-field-wrapper="next_internal_delivery_mumber">
    <input type="number" min="0" id="next_internal_delivery_mumber" name="next_internal_delivery_mumber" class="form-control" value="<?php echo get_warehouse_option('next_internal_delivery_mumber'); ?>"></div>
</div>

<div class="row">
  <div class="col-md-12">
      <h5 class="no-margin font-bold h5-color"><?php echo _l('item_sku_prefix') ?></h5>
      <hr class="hr-color">
    </div>
</div>

<div class="form-group">
  <label><?php echo _l('item_sku_prefix'); ?></label>
  <div class="form-group" app-field-wrapper="item_sku_prefix">
    <input type="text" id="item_sku_prefix" name="item_sku_prefix" class="form-control" value="<?php echo get_warehouse_option('item_sku_prefix'); ?>"></div>
</div>




<div class="clearfix"></div>

 <div class="modal-footer">
        <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
    </div>
 <?php echo form_close(); ?>


</body>
</html>


