<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php echo form_open(admin_url('resource_workload/add_standard_workload')); ?>

<div class="hot handsontable htColumnHeaders" id="staff_shiftings"></div>
 <?php echo form_hidden('staff_shifting_data'); ?>
<br/>
<div class="modal-footer">
    <button type="submit" class="btn btn-info staff-shifting-form-submiter"><?php echo _l('submit'); ?></button>
</div>
<?php echo form_close(); ?>