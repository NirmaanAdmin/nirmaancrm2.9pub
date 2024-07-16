<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
    <div class="_buttons">
        <?php 
        if (has_permission('table_workplace_management', '', 'view') || is_admin()) {
         ?>
         <a href="#" onclick="new_workplace_assign(); return false;" class="btn btn-info pull-left display-block">
          <?php echo _l('add'); ?>
      </a>
  <?php } ?>
</div>
<div class="clearfix"></div>
<br>

<a href="#" onclick="staff_bulk_actions(); return false;"  data-table=".table-workplace_assign" data-target="#workplace_assign" class=" hide bulk-actions-btn table-btn"><?php echo _l('bulk_actions'); ?></a>                   
<?php
$disabled = '';
if(!(is_admin() || has_permission('table_workplace_management', '', 'view'))){
    $disabled = ' disabled="disabled"';
}
$table_data = array(
    '<input type="checkbox" id="mass_select_all" data-to-table="workplace_assign" '.$disabled.'>',
    _l('staff'),
    _l('workplace'),
    _l('options')
);
render_datatable($table_data,'workplace_assign',
  array('customizable-table'),
  array(
    'proposal_sm' => 'proposal_sm',
    'id'=>'table-workplace_assign',
    'data-last-order-identifier'=>'workplace_assign',
    'data-default-order'=>get_table_last_order('workplace_assign'),
)); ?>

<div class="modal" id="workplace_assign" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <?php echo form_open(admin_url('timesheets/add_workplace_assign'), array('id' => 'add_workplace_assign' )); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <span class="edit-title"><?php echo _l('edit_workplace_assign'); ?></span>
                    <span class="add-title"><?php echo _l('new_workplace_assign'); ?></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo render_select('staffid[]', $staffs, array('staffid', array('firstname', 'lastname')),'staff', '',array('multiple' => true, 'data-live-search' => true, 'data-actions-box' => true), [], '', '', false);
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php
                        $workplace = $this->timesheets_model->get_workplace(); 
                        echo render_select('workplace_id',$workplace,array('id', array('name', 'workplace_address')),'workplace','');
                        ?>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
            </div>
        </div><!-- /.modal-content -->
        <?php echo form_close(); ?>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal workplace_assign" id="product-workplace_assign" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <?php echo form_open(admin_url('timesheets/delete_mass_workplace_assign'), array('id' => 'delete_mass_workplace_assign' )); ?>
    <div class="modal-content">
        <div class="modal-header">
         <h4 class="modal-title"><?php echo _l('bulk_actions'); ?></h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     </div>
     <div class="modal-body">
      <div class="checkbox checkbox-danger">
        <?php echo form_hidden('check_id'); ?>
        <input type="checkbox" name="mass_delete" id="mass_delete">
        <label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
    </div>
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
 <button type="submit" class="btn btn-primary"><?php echo _l('confirm'); ?></button>
</div>

</div>
<?php echo form_close(); ?>
</div>
</div>

</div>

</body>
</html>
