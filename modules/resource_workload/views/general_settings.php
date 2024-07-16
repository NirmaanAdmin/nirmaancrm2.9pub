<?php defined('BASEPATH') or exit('No direct script access allowed');

$standard_workload = get_option('standard_workload');
$staff_workload_monday = get_option('staff_workload_monday');
$staff_workload_tuesday = get_option('staff_workload_tuesday');
$staff_workload_thursday = get_option('staff_workload_thursday');
$staff_workload_wednesday = get_option('staff_workload_wednesday');
$staff_workload_friday = get_option('staff_workload_friday');
$staff_workload_saturday = get_option('staff_workload_saturday');
$staff_workload_sunday = get_option('staff_workload_sunday');

$staff_workload_monday_visible = get_option('staff_workload_monday_visible');
$staff_workload_tuesday_visible = get_option('staff_workload_tuesday_visible');
$staff_workload_thursday_visible = get_option('staff_workload_thursday_visible');
$staff_workload_wednesday_visible = get_option('staff_workload_wednesday_visible');
$staff_workload_friday_visible = get_option('staff_workload_friday_visible');
$staff_workload_saturday_visible = get_option('staff_workload_saturday_visible');
$staff_workload_sunday_visible = get_option('staff_workload_sunday_visible');

$staff_workload_exception = get_option('staff_workload_exception');

$integrated_timesheet_holiday = get_option('integrated_timesheet_holiday');
$integrated_timesheet_leave = get_option('integrated_timesheet_leave');

?>

<?php echo form_open(admin_url('resource_workload/update_setting')); ?>
<?php echo render_select('staff_workload_exception[]', $staffs, array('staffid', array('firstname', 'lastname')), 'staff_exception', explode(',', $staff_workload_exception), array('multiple' => true, 'data-actions-box' => true), array(), '', '', false); ?>
<?php echo render_input('standard_workload', 'standard_workload', $standard_workload, 'number', array('step'=> 0.5)); ?>

<div class="row">
    <div class="col-md-12">
		<label for="" class="control-label"><?php echo _l('working_days_of_the_week'); ?>:</label>
        <div class="form-group">
			<div class="col-md-2">
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_monday" <?php if($staff_workload_monday == '1'){echo 'checked';} ?> id="wd_monday" value="1">
					<label for="wd_monday"><?php echo _l('wd_monday'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_tuesday" <?php if($staff_workload_tuesday == '1'){echo 'checked';} ?> id="wd_tuesday" value="1">
					<label for="wd_tuesday"><?php echo _l('wd_tuesday'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_thursday" <?php if($staff_workload_thursday == '1'){echo 'checked';} ?> id="wd_thursday" value="1">
					<label for="wd_thursday"><?php echo _l('wd_thursday'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_wednesday" <?php if($staff_workload_wednesday == '1'){echo 'checked';} ?> id="wd_wednesday" value="1">
					<label for="wd_wednesday"><?php echo _l('wd_wednesday'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_friday" <?php if($staff_workload_friday == '1'){echo 'checked';} ?> id="wd_friday" value="1">
					<label for="wd_friday"><?php echo _l('wd_friday'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_saturday" <?php if($staff_workload_saturday == '1'){echo 'checked';} ?> id="wd_saturday" value="1">
					<label for="wd_saturday"><?php echo _l('wd_saturday'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_sunday" <?php if($staff_workload_sunday == '1'){echo 'checked';} ?> id="wd_sunday" value="1">
					<label for="wd_sunday"><?php echo _l('wd_sunday'); ?></label>
				</div>
			</div>
			<div class="col-md-2">
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_monday_visible" <?php if($staff_workload_monday_visible == '1'){echo 'checked';} ?> id="monday_visible" value="1">
					<label for="monday_visible"><?php echo _l('project_discussion_visible_to_customer_yes'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_tuesday_visible" <?php if($staff_workload_tuesday_visible == '1'){echo 'checked';} ?> id="tuesday_visible" value="1">
					<label for="tuesday_visible"><?php echo _l('project_discussion_visible_to_customer_yes'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_thursday_visible" <?php if($staff_workload_thursday_visible == '1'){echo 'checked';} ?> id="thursday_visible" value="1">
					<label for="thursday_visible"><?php echo _l('project_discussion_visible_to_customer_yes'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_wednesday_visible" <?php if($staff_workload_wednesday_visible == '1'){echo 'checked';} ?> id="wednesday_visible" value="1">
					<label for="wednesday_visible"><?php echo _l('project_discussion_visible_to_customer_yes'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_friday_visible" <?php if($staff_workload_friday_visible == '1'){echo 'checked';} ?> id="friday_visible" value="1">
					<label for="friday_visible"><?php echo _l('project_discussion_visible_to_customer_yes'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_saturday_visible" <?php if($staff_workload_saturday_visible == '1'){echo 'checked';} ?> id="saturday_visible" value="1">
					<label for="saturday_visible"><?php echo _l('project_discussion_visible_to_customer_yes'); ?></label>
				</div>
				<div class="checkbox checkbox-primary">
					<input type="checkbox" name="staff_workload_sunday_visible" <?php if($staff_workload_sunday_visible == '1'){echo 'checked';} ?> id="sunday_visible" value="1">
					<label for="sunday_visible"><?php echo _l('project_discussion_visible_to_customer_yes'); ?></label>
				</div>
			</div>
		</div>
    </div>
</div>
<div class="row mbot10">
    <div class="col-md-12">
        <strong><?php echo _l('capacity_total_week'); ?>:</strong> <strong id="capacity"></strong><strong><?php echo ' ('._l('hours').')'; ?></strong>
    </div>
</div>
<hr>
<?php $disabled = $check_timesheets ? '' : "disabled"; ?>
<div class="row mbot10">
    <div class="col-md-12">
		<label for="" class="control-label"><?php echo _l('integrated_timesheet_module'); ?>:</label>
		<div class="checkbox checkbox-primary">
			<input type="checkbox" name="integrated_timesheet_holiday" <?php if($integrated_timesheet_holiday == '1'){echo 'checked';} ?> id="integrated_holiday" value="1" <?php echo html_entity_decode($disabled); ?>>
			<label for="integrated_holiday"><?php echo _l('integrated_holiday'); ?></label>
		</div>
		<div class="checkbox checkbox-primary">
			<input type="checkbox" name="integrated_timesheet_leave" <?php if($integrated_timesheet_leave == '1'){echo 'checked';} ?> id="integrated_leave" value="1" <?php echo html_entity_decode($disabled); ?>>
			<label for="integrated_leave"><?php echo _l('integrated_leave'); ?></label>
		</div>
    </div>
</div>
  
<div class="modal-footer">
    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
</div>
<?php echo form_close(); ?>
