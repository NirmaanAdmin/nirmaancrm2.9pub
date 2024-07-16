<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<input type="hidden" name="confirm_text" value="<?php echo _l('ts_are_you_sure_you_want_to_reset_the_data'); ?>">
<?php if(is_admin()){ ?>
<a href="#" class="btn btn-info reset_data"><?php echo _l('ts_reset_data'); ?></a>
<a href="#" class="input_method">
	<i class="fa fa-question-circle i_tooltip" data-toggle="tooltip" title="" data-original-title="<?php echo _l('ts_all_related_data_attendance_route_shift_leave_workplace_will_be_deleted') ?>">
	</i>
</a>
<?php } ?>
