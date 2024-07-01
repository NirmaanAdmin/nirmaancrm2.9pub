<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
<div class="_buttons">

   <?php if (has_permission('warehouse', '', 'create') || is_admin()) { ?>

    <a href="#" onclick="new_body_type(); return false;" class="btn btn-info pull-left display-block">
        <?php echo _l('add_body_type'); ?>
    </a>
<?php } ?>

</div>
<div class="clearfix"></div>
<hr class="hr-panel-heading" />
<div class="clearfix"></div>
<table class="table dt-table border table-striped">
 <thead>
    <th><?php echo _l('_order'); ?></th>
    <th><?php echo _l('model_code'); ?></th>
    <th><?php echo _l('model_name'); ?></th>
    <th><?php echo _l('order'); ?></th>
    <th><?php echo _l('display'); ?></th>
    <th><?php echo _l('note'); ?></th>
    <th><?php echo _l('options'); ?></th>
 </thead>
  <tbody>
    <?php foreach($body_types as $body_type){ ?>

    <tr>
        <td><?php echo _l($body_type['body_type_id']); ?></td>
        <td><?php echo _l($body_type['body_code']); ?></td>
        <td><?php echo _l($body_type['body_name']); ?></td>
        <td><?php echo _l($body_type['order']); ?></td>
        <td><?php if($body_type['display'] == 0){ echo _l('not_display'); }else{echo _l('display');} ?></td>
        <td><?php echo _l($body_type['note']); ?></td>

        <td>
            <?php if (has_permission('warehouse', '', 'edit') || is_admin()) { ?>
              <a href="#" onclick="edit_body_type(this,<?php echo html_entity_decode($body_type['body_type_id']); ?>); return false;" data-body_code="<?php echo html_entity_decode($body_type['body_code']); ?>" data-body_name="<?php echo html_entity_decode($body_type['body_name']); ?>"  data-order="<?php echo html_entity_decode($body_type['order']); ?>" data-display="<?php echo html_entity_decode($body_type['display']); ?>" data-note="<?php echo html_entity_decode($body_type['note']); ?>" class="btn btn-default btn-icon"><i class="fa fa-pencil-square-o"></i>
            </a>
            <?php } ?>

            <?php if (has_permission('warehouse', '', 'delete') || is_admin()) { ?> 
            <a href="<?php echo admin_url('warehouse/delete_body_type/'.$body_type['body_type_id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
             <?php } ?>
        </td>
    </tr>
    <?php } ?>
 </tbody>
</table>   

<div class="modal1 fade" id="body_type" tabindex="-1" role="dialog">
        <div class="modal-dialog setting-handsome-table" >
          <?php echo form_open_multipart(admin_url('warehouse/body_type'), array('id'=>'add_body_type')); ?>

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <span class="add-title"><?php echo _l('add_body_type'); ?></span>
                        <span class="edit-title"><?php echo _l('edit_body_type'); ?></span>
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                             <div id="body_type_id">
                             </div>   
                         <div class="form"> 
                            <div class="col-md-12" id="add_handsontable">

                              
                            </div>
                              <?php echo form_hidden('hot_body_type'); ?>
                        </div>
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                        
                         <button id="latch_assessor" type="button" class="btn btn-info intext-btn" onclick="add_body_type(this); return false;" ><?php echo _l('submit'); ?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div> 
</div>
<?php require 'modules/warehouse/assets/js/body_js.php';?>

</body>
</html>
