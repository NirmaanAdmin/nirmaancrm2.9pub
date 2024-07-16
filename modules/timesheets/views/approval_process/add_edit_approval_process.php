<?php init_head(); ?>
<div id="wrapper">
 <div class="content">
  <div class="row">
   <div class="col-md-12" >
    <div class="panel_s">
     <div class="panel-body">
      <div class="row">
       <div class="col-md-12">
        <h4 class="no-margin font-bold"><i class="fa fa-address-card-o" aria-hidden="true"></i> <?php echo _l($title); ?></h4>
        <hr/>

      </div>
    </div>
    <?php 
    $has_hr = false;
    if(timesheet_get_status_modules('hr_profile') == true){ 
      $has_hr = true;
      $this->load->view('approval_process/includes/add_approve_with_hr.php');
    }
    else{ 
      $this->load->view('approval_process/includes/add_approve.php');
    } ?>

    <div class="modal-footer">
      <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
    </div>
  </div>
  <?php echo form_close(); ?>
</div>
</div>
</div>
</div>
</div>

<?php init_tail(); ?>

<?php
if(!$has_hr){
 require 'modules/timesheets/assets/js/add_edit_approval_process_js.php'; 
}
else{
  require 'modules/timesheets/assets/js/add_edit_approval_process_with_hr_js.php';
} ?>
</body>
</html>