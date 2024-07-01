<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php 
  $group_product_id = '';
  $product_id = '';
?>
<div class="col-md-12"> 
<a href="#" onclick="add_product(); return false;" class="btn btn-info pull-left">
    <?php echo _l('add'); ?>
</a>
<input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">




<a href="#" onclick="sync_store(this); return false;" data-id="<?php echo html_entity_decode($id); ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l("sync_from_the_system_to_the_store") ?>" class="btn btn-warning btn-icon pull-right orders-woo" data-toggle="dropdown" aria-expanded="false">
<i class="fa fa-refresh" aria-hidden="true"></i>
</a>

<a href="#" class="btn btn-primary pull-right mx-3 btn-icon bg-cus" data-popup-open="popup-1" data-id="<?php echo html_entity_decode($id); ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l("sync_products_from_store") ?>"><i class="fa fa-refresh" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i></a>

<h3 class="pull-right m-0">|</h3>


<a href="#" onclick="sync_decriptions_synchronization(this); return false;" data-id="<?php echo html_entity_decode($id); ?>" data-toggle="tooltip" data-placeme="top" data-original-title="<?php echo _l("sync_decriptions") ?>" class="btn btn-info btn-icon pull-right">
<i class="fa fa-refresh" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i>
</a>

<a href="#" onclick="sync_images_synchronization(this); return false;" data-id="<?php echo html_entity_decode($id); ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l("sync_images") ?>" class="btn btn-primary btn-icon pull-right">
<i class="fa fa-refresh" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i>
</a>

<a href="#" onclick="sync_inventory_synchronization(this); return false;" data-id="<?php echo html_entity_decode($id); ?>" data-toggle="tooltip" data-original-title="<?php echo _l("sync_from_store") ?>" class="btn btn-success pull-right btn-icon">
<i class="fa fa-refresh" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i>
</a>

<a href="#" data-id="<?php echo html_entity_decode($id); ?>" class="btn btn-default btn-icon pull-right sync_products_woo"  data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l("sync_products_to_store") ?>">
<i class="fa fa-refresh" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i>
</a>

<div class="clearfix"></div><br>
</div>
<div id="box-loadding">
</div>
<div class="col-md-12">
  <?php
  $table_data = array(
      _l('product_code'),
      _l('product_name'),
      _l('price'),
      _l('price_on_store'),
      _l('options'),
      );
  render_datatable($table_data,'product-woocommerce');
  ?>
</div>
<div class="col-md-12">
  <a href="<?php echo admin_url('omni_sales/omni_sales_channel'); ?>" class="btn btn-danger"><?php echo _l('close'); ?></a>
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
    <?php echo form_open(admin_url('omni_sales/add_product_channel_wcm'),array('id'=>'form_add_product')); ?>             
        <div class="modal-body">
           <div class="row">
            <input type="hidden" name="woocommere_store_id" value="<?php echo html_entity_decode($id); ?>">
            <div class="col-md-12">
              <?php 
                      echo render_select('group_product_id',$group_product,array('id',array('commodity_group_code','name')),'group_product',$group_product_id,array('onchange'=>'get_list_product(this);'));
                    ?>
            </div>

            <div class="col-md-12">
               <div class="form-group" app-field-wrapper="product_id">
                <label for="product_id" class="control-label"><?php echo _l('product'); ?></label>
                  <select id="product_id" name="product_id[]" class="selectpicker" multiple  data-width="100%" data-none-selected-text="Nothing selected" data-live-search="true" data-actions-box="true" tabindex="-98">
                    <option value=""></option>
                    <?php foreach ($products as $key => $value){ ?>
                      <option value="<?php echo html_entity_decode($value['id']); ?>"><?php echo html_entity_decode($value['description']); ?></option>
                    <?php } ?>
                  </select>
             </div>
            </div>
              <div class="col-md-12 pricefr hide">
              <?php 
                $arrAtt = array();
                    $arrAtt['data-type']='currency';
                    echo render_input('prices','prices','','text',$arrAtt);
              ?>
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

 
<div class="popup" data-popup="popup-1">
    <div class="popup-inner">
       <div class="popup-scroll">
        <div class="col-md-12">
          <button class="btn btn-success mx-3 sync_products_from_info_woo cus_btn" data-id="<?php echo html_entity_decode($id); ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l("synchronize_product_information_basic") ?>"><i class="fa fa-refresh" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i>  <?php echo _l('synchronize_product_information_basic'); ?></button>
        </div>
        <br>
        <br>
        <br>
        <div class="col-md-12 w-sync">
          <button class="btn btn-primary mx-3 sync_products_from_woo cus_btn" data-id="<?php echo html_entity_decode($id); ?>" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo _l("synchronize_product_information_full") ?>"><i class="fa fa-refresh" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i> <?php echo _l('synchronize_product_information_full'); ?></button>
          <a href="#" data-toggle="tooltip" data-original-title="<?php echo _l("warning_may_take_longer") ?>" class="btn btn-danger pull-right btn-icon">
            <i class="fa fa-question-circle" aria-hidden="true" data-toggle="dropdown" aria-expanded="false"></i>
          </a>
        </div>
        <a class="popup-close" data-popup-close="popup-1" href="#">x</a>
    </div>
</div>