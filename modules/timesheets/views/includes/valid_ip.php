<?php defined('BASEPATH') or exit('No direct script access allowed');
$timekeeping_enable_valid_ip = 0;
$value = get_timesheets_option('timekeeping_enable_valid_ip');
if($value){
  $timekeeping_enable_valid_ip = $value;
}
?>
<div class="row">

  <div class="col-md-12">
    <?php echo form_open(admin_url('timesheets/set_valid_ip'), array('id' => 'set_valid_ip-form')); ?>

    <div class="checkbox">              
      <input type="checkbox" class="capability" name="timekeeping_enable_valid_ip" <?php echo (($timekeeping_enable_valid_ip == 1) ? 'checked' : '') ?> value="1">
      <label><?php echo _l('ts_enable_check_valid_ip'); ?></label>
    </div>

    <div class="clearfix"></div>
    <?php echo form_hidden('list_ip_data'); ?>
    <div class="hot handsontable htColumnHeaders" id="example">
    </div>
    <div class="clearfix"></div>
    <hr>
    <div class="col-md-12 mtop5">
     <button class="btn btn-primary save_leave_table pull-right" onclick="get_data_hanson();" ><?php echo _l('save'); ?></button>
   </div>
   <?php echo form_close(); ?>
 </div>






</div>



