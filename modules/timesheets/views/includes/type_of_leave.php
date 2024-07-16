<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if(is_admin()){ ?>
 <a href="#" onclick="new_type_leave(); return false;" class="btn btn-info"><?php echo _l('new'); ?></a>
<?php } ?>
<br/><br/>
<div class="clearfix"></div>
<br>
<div id="unexpected_break">
  <table class="table dt-table">
   <thead>
    <tr>
      <th><?php echo _l('ts_type_name'); ?></th>
      <th><?php echo _l('ts_character'); ?></th>
      <th><?php echo _l('options'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php          
    foreach($type_of_leave as $leave) {?>
      <tr>
        <td><?php echo $leave['type_name']; ?></td>
        <td><?php echo $leave['symbol']; ?></td>
        <td>
          <a href="#" class="btn btn-primary btn-icon" onclick="edit_type_of_leave(this,<?php echo html_entity_decode($leave['id']); ?>); return false" data-id="<?php echo html_entity_decode($leave['id']); ?>" data-type_name="<?php echo html_entity_decode($leave['type_name']); ?>" data-symbol="<?php echo html_entity_decode($leave['symbol']); ?>">
            <i class="fa fa-pencil-square-o"></i>
          </a>
          <a href="<?php echo admin_url('timesheets/delete_type_of_leave/'.$leave['id']); ?>" class="btn btn-danger btn-icon _delete"><i class="fa fa-remove"></i></a>
        </td>
      </tr>
    <?php } ?>

  </tbody>
</table>
</div>

<div class="modal fade" id="add_new_type_of_leave" tabindex="1" role="dialog">
  <div class="modal-dialog">
    <?php echo form_open(admin_url('timesheets/add_type_of_leave'),array('id'=>'add_type_of_leave-form')); ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="add-title">
          <?php echo _l('ts_input_new_type_of_leave'); ?>
        </h4>
        <h4 class="edit-title hide">
          <?php echo _l('ts_edit_type_of_leave'); ?>
        </h4>
      </div>
      <div class="modal-body">
       <div class="col-md-6">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="is_setting" value="1">
        <?php echo render_input('type_name', 'type_of_leave') ?>
      </div>
      <div class="col-md-6">
        <?php echo render_input('symbol', _l('ts_character').' <i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="'._l('ts_it_will_be_displayed_on_the_timesheet').'"></i>') ?>         
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="modal-footer">
      <button type="" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
      <button class="btn btn-info add_type_of_leave"><?php echo _l('ts_save'); ?></button>
    </div>
    <?php echo form_close(); ?>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>


<input type="hidden" name="character_already_exists" value="<?php echo _l('ts_this_character_already_exists') ?>">



