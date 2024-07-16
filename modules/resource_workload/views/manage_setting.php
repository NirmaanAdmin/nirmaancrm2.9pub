<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
 <div class="content">
    <div class="row">
  <div class="col-md-12">
    <div class="panel_s">
     <div class="panel-body">
    <div class="horizontal-scrollable-tabs  mb-5">
      <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
      <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>

      <div class="horizontal-tabs mb-4">
        <ul class="nav nav-tabs nav-tabs-horizontal">
          <?php
          $i = 0;
          foreach($tab as $gr){
            ?>
            <li<?php if($i == 0){echo " class='active'"; } ?>>
            <a href="<?php echo admin_url('resource_workload/setting?group='.$gr); ?>" data-group="<?php echo html_entity_decode($gr); ?>">
              <?php 
              if($gr == 'payroll'){
                echo _l('_salary_form'); 
              }elseif($gr == 'permission'){
                echo _l('hrm_permission'); 
              }else{
                echo _l($gr); 
              }

              ?></a>

            </li>
            <?php $i++; } ?>
          </ul>
      </div>

        <?php $this->load->view($tabs['view']); ?>
        
     </div>
  </div>
</div>
<div class="clearfix"></div>
</div>
<?php echo form_close(); ?>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require 'modules/resource_workload/assets/js/resource_workload_setting_js.php';?>
</body>
</html>
