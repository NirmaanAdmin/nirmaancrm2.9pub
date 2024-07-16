<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css" rel="stylesheet">

<div>
<?php echo form_open(admin_url('timesheets/setting_timekeeper'),array('id'=>'setting_timekeeper-form')); ?>
 <div class="col-md-12">
 	<?php 
 		$data_timekeeping_form = get_timesheets_option('timekeeping_form');
 	 ?>
	  
	  <div class="col-md-12"><label><?php echo _l('timekeeping_form'); ?></label></div>
	  <div class="row">
		  <div class="col-md-6">
		  	<br>
		  	<div class="checkbox">
	          <input type="radio" name="timekeeping_form"  <?php if($data_timekeeping_form == 'timekeeping_manually'){ echo 'checked'; } ?> id="timekeeping_form1" value="timekeeping_manually"  >
	          <label for="timekeeping_form1"><?php echo _l('timekeeping_manually'); ?></label>
		    </div> 
		  </div>
		  <div class="col-md-6">
		    <?php 
		    $timekeeping_manually_role = explode(',', get_timesheets_option('timekeeping_manually_role')); ?>
		    <?php echo render_select('timekeeping_manually_role[]',$role,array('roleid', 'name'),'timekeeping_applicable_object',$timekeeping_manually_role,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);

		     ?>   	  	
		  </div>
	  </div>

	  <div class="row">
		  <div class="col-md-6">
		  	<br>
			  <div class="checkbox">
		          <input type="radio" name="timekeeping_form" <?php if($data_timekeeping_form == 'timekeeping_task'){ echo 'checked'; } ?> id="timekeeping_form2" value="timekeeping_task" >
		          <label for="timekeeping_form2"><?php echo _l('timekeeping_task'); ?></label>
			  </div> 
		  </div>
		  <div class="col-md-6">
		  	 <?php 
		    $timekeeping_task_role = explode(',', get_timesheets_option('timekeeping_task_role')); ?>
		    <?php echo render_select('timekeeping_task_role[]',$role,array('roleid', 'name'),'timekeeping_applicable_object',$timekeeping_task_role,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);

		     ?>   	
		  </div>
	  </div>

	  <div class="row">
		  <div class="col-md-6">
		  	<br>
			  <div class="checkbox">
		          <input type="radio" name="timekeeping_form" <?php if($data_timekeeping_form == 'csv_clsx'){ echo 'checked'; } ?> id="timekeeping_form3" value="csv_clsx" >
		          <label for="timekeeping_form3"><?php echo _l('csv_clsx'); ?></label>
			  </div> 
		  </div>
		  <div class="col-md-6">
		  	 <?php 
		    $csv_clsx_role = explode(',', get_timesheets_option('csv_clsx_role')); ?>
		    <?php echo render_select('csv_clsx_role[]',$role,array('roleid', 'name'),'timekeeping_applicable_object',$csv_clsx_role,array('multiple'=>true,'data-actions-box'=>true),array(),'','',false); ?>   	
		  </div>
	  </div>
	  <div class="row">
	</div>
</div>
<div class="clearfix"></div>
<br>
<div class="clearfix"></div>

<div class="col-md-12">
	<?php if(is_admin() || has_permission('timesheets_timekeeping','','edit')){ ?>
		    <button class="btn btn-info pull-right save_time_sheet"><?php echo _l('submit'); ?></button>
		  <?php } ?>
</div>
<?php echo form_close(); ?>

</body>
</html>
