<?php echo form_open(site_url('omni_sales/save_setting/notification_recipient'),array('id'=>'invoice-form','class'=>'_transaction_form invoice-form')); ?>
<?php echo render_select('staff',$staffs ,array('staffid', array('firstname','lastname')),'staff',$staff, array('multiple' => true, 'data-actions-box' => true),array(),'','',false);?>			 				
<hr>
<button class="btn btn-primary pull-right"><?php echo _l('save'); ?></button>
<?php echo form_close(); ?>
