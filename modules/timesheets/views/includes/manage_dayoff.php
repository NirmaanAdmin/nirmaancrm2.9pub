<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if(is_admin() || has_permission('timesheets_timekeeping','','create')){ ?>
 <a href="#" onclick="new_leave(); return false;" class="btn btn-info" data-toggle="sidebar-right" data-target=".leave_modal-add-edit-modal"><?php echo _l('new'); ?></a>
<?php } ?>
<br/><br/>
<div class="clearfix"></div>
<br>
<div id="unexpected_break">
  <table class="table dt-table holiday-data-table" id="holiday-data-table">
   <thead>
    <tr>
      <th>ID</th>
      <th><?php echo _l('break_date'); ?></th>
      <th><?php echo _l('ts_leave_reason'); ?></th>
      <th><?php echo _l('ts_leave_type'); ?></th>
      <th><?php echo _l('department'); ?></th>
      <th><?php echo _l('role'); ?></th>
      <th><?php echo _l('repeat_by_year'); ?></th>
      <th><?php echo _l('add_from'); ?></th>
      <th><?php echo _l('options'); ?></th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
</div>
<div class="modal fade" id="leave_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          <span class="edit-title"><?php echo _l('edit_break_date'); ?></span>
          <span class="add-title"><?php echo _l('new_break_date'); ?></span>
        </h4>
      </div>
      <?php echo form_open(admin_url('timesheets/day_off'),array('id'=>'leave_modal-form')); ?>     
      <input type="hidden" name="id">         
      <div class="modal-body">
        <div id="additional_leave"></div> 
        <div class="row">
          <div class="col-md-6">
            <?php echo render_date_input('break_date','break_date',''); ?> 
          </div>                          
          <div class="col-md-6">
            <?php 
            $list_off_type = [
              ['id' => 'holiday', 'label' => _l('holiday')],
              ['id' => 'event_break', 'label' => _l('event_break')],
              ['id' => 'unexpected_break', 'label' => _l('unexpected_break')]
            ];
            echo render_select('leave_type', $list_off_type, array('id', 'label'), 'ts_leave_type');
            ?>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <?php echo render_textarea('leave_reason','ts_leave_reason','') ?> 
          </div>
        </div>

        <div class="row">
         <div class="col-md-6">
          <label for="department[]"><?php echo _l('department'); ?></label>
          <select name="department[]" id="department[]" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('all'); ?>" multiple data-hide-disabled="true">  
            <?php foreach($department as $dpm){ ?>
              <option value="<?php echo html_entity_decode($dpm['departmentid']); ?>"><?php echo html_entity_decode($dpm['name']); ?></option>
            <?php } ?>
          </select>
        </div> 
        <div class="col-md-6">
          <label for="position[]"><?php echo _l('role'); ?></label>
          <select name="position[]" id="position[]" class="selectpicker" multiple data-width="100%" data-none-selected-text="<?php echo _l('all'); ?>" data-hide-disabled="true">
            <?php
            foreach($role as $dpm){ ?>
              <option value="<?php echo html_entity_decode($dpm['roleid']); ?>"><?php echo html_entity_decode($dpm['name']); ?></option>
            <?php } ?>   
          </select>
        </div> 
      </div>
      <div class="row">
        <div class="col-md-12">
          <br>
          <div class="checkbox">              
            <input type="checkbox" class="capability" name="repeat_by_year" value="1">
            <label><?php echo _l('automatically_repeat_by_year'); ?></label>
          </div>
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



