<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php 
$id = '';
$shift_code = '';
$shift_name = '';
$department = [];
$position = [];
$add_from = '';
$staff = [];
$date_create = '';
$from_date = _d(date('Y-m').'-01');
$to_date = _d(date('Y-m').'-31');
$type_shiftwork = '';

if(isset($word_shift)){
  $id = $word_shift->id;
  $shift_code = $word_shift->shift_code;
  $shift_name = $word_shift->shift_name;
  $department = explode(',', $word_shift->department);
  $position = explode(',', $word_shift->position);
  $add_from = $word_shift->add_from;

  $staff = explode(',', $word_shift->staff);
  $date_create = $word_shift->date_create;
  $from_date = _d($word_shift->from_date);
  $to_date = _d($word_shift->to_date);
  $type_shiftwork = $word_shift->type_shiftwork;
}

?>
<div id="wrapper">
  <div class="content">
   <div class="row">
    <div class="panel_s">
      <div class="panel-body">
        <div class="clearfix"></div>
        <hr class="hr-panel-heading" />
        <div class="clearfix"></div>      


        <div id="shift_setting">
          <?php echo form_open(admin_url('timesheets/shifts'),array('id'=>'shift_f-form')); ?>
          <h4 class="modal-title">
            <?php echo html_entity_decode($title); ?>
          </h4>
          <hr>
          <div class="row">
            <div class="col-md-12">
              <div class="row mbot15">
               <div class="col-md-6">
                <label for="department"><?php echo _l('department'); ?></label>
                <select name="department[]" id="department" onchange="dpm_change(this); return false;" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('all'); ?>" data-hide-disabled="true" data-live-search="true" multiple="true">  
                 <?php foreach($departments as $dpm){
                  $selected = '';
                  if(in_array($dpm['departmentid'], $department)){
                    $selected = 'selected';
                  }
                  ?>
                  <option <?php echo html_entity_decode($selected); ?> value="<?php echo html_entity_decode($dpm['departmentid']); ?>"><?php echo html_entity_decode($dpm['name']); ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="col-md-6">
              <label for="role"><?php echo _l('role'); ?></label>
              <select name="role[]" id="role" onchange="role_change(this); return false;" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('all'); ?>" data-hide-disabled="true" data-live-search="true" multiple="true">
                <?php foreach($roles as $dpm){
                  $selected = '';
                  if(in_array($dpm['roleid'], $position)){
                    $selected = 'selected';
                  }
                  ?>
                  <option <?php echo html_entity_decode($selected); ?> value="<?php echo html_entity_decode($dpm['roleid']); ?>"><?php echo html_entity_decode($dpm['name']); ?></option>
                <?php } ?>   
              </select>
            </div>
          </div>

          <div class="row">
           <div class="col-md-12">
            <label for="position"><?php echo _l('staff'); ?></label>
            <select name="staff[]" id="staff" class="selectpicker" data-width="100%" data-none-selected-text="<?php echo _l('all'); ?>" data-hide-disabled="true" data-live-search="true" multiple="true">

             <?php foreach($staffs as $dpm){
              $selected = '';
              if(in_array($dpm['staffid'], $staff)){
                $selected = 'selected';
              }
              ?>
              <option <?php echo html_entity_decode($selected); ?>  value="<?php echo html_entity_decode($dpm['staffid']); ?>"><?php echo html_entity_decode($dpm['firstname']) . ' '.$dpm['lastname']; ?></option>
            <?php } ?>   
          </select>
        </div>
        <div class="clearfix"></div>
        <br>
        <div class="clearfix"></div>

        <div class="col-md-6"> 								                    	  
          <?php echo render_date_input('from_date','from_date',$from_date); ?>           
        </div>
        <div class="col-md-6">
          <?php echo render_date_input('to_date','to_date',$to_date); ?>                                                   
        </div>
      </div>

      <div class="col-md-12">
        <input type="radio" id="repeat_periodically" class="type_shift" <?php if($type_shiftwork == 'repeat_periodically' || !isset($word_shift)){ echo 'checked'; } ?> name="type_shiftwork" value="repeat_periodically">
        <label for="repeat_periodically"><?php echo _l('repeat_weekly'); ?></label><br>
        <input type="radio" id="by_absolute_time" class="type_shift" <?php if($type_shiftwork == 'by_absolute_time'){ echo 'checked'; } ?> name="type_shiftwork" value="by_absolute_time">
        <label for="by_absolute_time"><?php echo _l('specific_time_period'); ?></label><br>
      </div>
      <div class="col-md-12">
       <h4><?php echo _l('shifts_detail'); ?></h4>
       <hr/>
       <small>Shift + Mouse scroll to scroll horizontally</small>
     </div>
     <div class="col-md-12" id="example">
     </div>
     <?php echo form_hidden('shifts_detail'); ?>

   </div>
 </div>
 <hr>
 <div class="row">
  <div class="col-md-12">
   <button class="btn btn-info pull-right save_detail_shift"><?php echo _l('submit'); ?></button>       
 </div>
</div>
<input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>" >
<?php echo form_close(); ?>
</div>

</div>
</div>
</div>
</div>
</div>
<?php init_tail(); ?>
<?php require 'modules/timesheets/assets/js/add_edit_allocation_shiftwork_js.php'; ?>
</body>
</html>
