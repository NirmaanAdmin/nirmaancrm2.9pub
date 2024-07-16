<?php defined('BASEPATH') or exit('No direct script access allowed');?>
<div>
	<?php echo form_open(admin_url('timesheets/default_settings'),array('id'=>'default_settings-form')); ?>
	<div class="col-md-12">
		<?php 
		$data_attendance_notice_recipient = [];
		$data_attendance = get_timesheets_option('attendance_notice_recipient');
		if($data_attendance){
			$data_attendance_notice_recipient = explode(',', $data_attendance);
		}

		$allows_updating_check_in_time = 0;
		$data_allows_updating = get_timesheets_option('allows_updating_check_in_time');
		if($data_allows_updating){
			$allows_updating_check_in_time = $data_allows_updating;
		}

		$allows_to_choose_an_older_date = 0;
		$data_older_date = get_timesheets_option('allows_to_choose_an_older_date');
		if($data_older_date){
			$allows_to_choose_an_older_date = $data_older_date;
		}

		$allow_attendance_by_coordinates = 0;
		$data_by_coordinates = get_timesheets_option('allow_attendance_by_coordinates');
		if($data_by_coordinates){
			$allow_attendance_by_coordinates = $data_by_coordinates;
		}	

		$allow_attendance_by_route = 0;
		$data_by_route = get_timesheets_option('allow_attendance_by_route');
		if($data_by_route){
			$allow_attendance_by_route = $data_by_route;
		}

		$send_email_check_in_out_customer_location = 0;
		$data_send_email_check_in_out = get_timesheets_option('send_email_check_in_out_customer_location');
		if($data_send_email_check_in_out){
			$send_email_check_in_out_customer_location = $data_send_email_check_in_out;
		}

		$allow_employees_to_create_work_points = 0;
		$data_allow_create_work_point = get_timesheets_option('allow_employees_to_create_work_points');
		if($data_allow_create_work_point){
			$allow_employees_to_create_work_points = $data_allow_create_work_point;
		}

		$auto_checkout = 0;
		$data_auto_checkout = get_timesheets_option('auto_checkout');
		if($data_auto_checkout){
			$auto_checkout = $data_auto_checkout;
		}

		$auto_checkout_type = 1;
		$data_auto_checkout_type = get_timesheets_option('auto_checkout_type');
		if($data_auto_checkout_type){
			$auto_checkout_type = $data_auto_checkout_type;
		}

		$auto_checkout_value = 1;
		$data_auto_checkout_value = get_timesheets_option('auto_checkout_value');
		if($data_auto_checkout_value){
			$auto_checkout_value = $data_auto_checkout_value;
		}

		$auto_checkout_value = 1;
		$data_auto_checkout_value = get_timesheets_option('auto_checkout_value');
		if($data_auto_checkout_value){
			$auto_checkout_value = $data_auto_checkout_value;
		}

		$send_notification_if_check_in_forgotten = 0;
		$data_notification_forgotten = get_timesheets_option('send_notification_if_check_in_forgotten');
		if($data_notification_forgotten){
			$send_notification_if_check_in_forgotten = $data_notification_forgotten;
		}

		$send_notification_if_check_in_forgotten_value = 30;
		$data_send_notification_forgotten_value = get_timesheets_option('send_notification_if_check_in_forgotten_value');
		if($data_send_notification_forgotten_value){
			$send_notification_if_check_in_forgotten_value = $data_send_notification_forgotten_value;
		}
		
		?>
		<h4>
			<?php echo _l('attendance'); ?>
		</h4>
		<hr>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<?php echo render_select('attendance_notice_recipient[]', $staff, array('staffid', array('firstname', 'lastname')),'attendance_notice_recipient', $data_attendance_notice_recipient, array('multiple'=>true,'data-actions-box'=>true),array(),'','',false);
					?>   	  	
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="checkbox">							
						<input type="checkbox" class="capability" name="allows_updating_check_in_time" value="1" <?php if($allows_updating_check_in_time == 1){ echo "checked"; } ?>>
						<label><?php echo _l('allows_updating_check_in_time'); ?></label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="checkbox">							
						<input type="checkbox" class="capability" name="allows_to_choose_an_older_date" value="1" <?php if($allows_to_choose_an_older_date == 1){ echo "checked"; } ?>>
						<label><?php echo _l('allows_to_choose_an_older_date'); ?></label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="checkbox">							
						<input type="checkbox" class="capability" name="allow_attendance_by_coordinates" value="1" <?php if($allow_attendance_by_coordinates == 1){ echo "checked"; } ?>>
						<label><?php echo _l('allow_attendance_by_coordinates'); ?></label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="checkbox">							
						<input type="checkbox" class="capability" name="allow_attendance_by_route" value="1" <?php if($allow_attendance_by_route == 1){ echo "checked"; } ?>>
						<label><?php echo _l('allow_attendance_by_route'); ?></label>
					</div>
				</div>
			</div>			
			<div class="row">
				<div class="col-md-12">
					<div class="checkbox">							
						<input type="checkbox" class="capability" name="auto_checkout" value="1" <?php if($auto_checkout == 1){ echo "checked"; } ?>>
						<label><?php echo _l('auto_checkout'); ?></label>
					</div>
					<div class="row">
						<div class="col-md-12 auto_checkout_more_option <?php if($auto_checkout == 0){ echo "hide"; } ?>">
							<div class="checkbox">
								<input type="radio" name="auto_checkout_type" id="auto_checkout_type_1" value="1" <?php if($auto_checkout_type == 1){ echo 'checked'; } ?> >
								<label for="auto_checkout_type_1"><?php echo _l('after_x_hours_of_end_shift'); ?></label>
							</div> 
							<div class="checkbox">
								<input type="radio" name="auto_checkout_type" id="auto_checkout_type_3" value="3" <?php if($auto_checkout_type == 3){ echo 'checked'; } ?> >
								<label for="auto_checkout_type_3"><?php echo _l('login_time_x_hour'); ?></label>
							</div>
							<div class="checkbox">
								<input type="radio" name="auto_checkout_type" id="auto_checkout_type_2" value="2" <?php if($auto_checkout_type == 2){ echo 'checked'; } ?> >
								<label for="auto_checkout_type_2"><?php echo _l('after_checkin_x_hour'); ?></label>
							</div>  
							<div class="col-md-2 x_value">
								<div class="form-group">
									<label for="gst"><?php echo _l('x_value'); ?></label>					 	
									<div class="input-group">
										<input type="number" min="1" max="12" class="form-control" name="auto_checkout_value" value="<?php echo html_entity_decode($auto_checkout_value); ?>">
										<span class="input-group-addon"><?php echo _l('hour'); ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="checkbox">							
						<input type="checkbox" class="capability" name="send_notification_if_check_in_forgotten" value="1" <?php if($send_notification_if_check_in_forgotten == 1){ echo "checked"; } ?>>
						<label><?php echo _l('send_notification_if_check_in_forgotten'); ?></label>
					</div>
					<div class="row">
						<div class="col-md-12 auto_send_notification_if_check_in_forgotten <?php if($send_notification_if_check_in_forgotten == 0){ echo "hide"; } ?>">
							<div class="col-md-12 x_value">
								<div class="form-group">
									<label for="gst"><?php echo _l('after'); ?></label>					 	
									<div class="input-group">
										<input type="number" min="1" max="59" class="form-control" name="send_notification_if_check_in_forgotten_value" value="<?php echo html_entity_decode($send_notification_if_check_in_forgotten_value); ?>">
										<span class="input-group-addon"><?php echo _l('minute'); ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="checkbox">							
						<input type="checkbox" class="capability" name="send_email_check_in_out_customer_location" value="1" <?php if($send_email_check_in_out_customer_location == 1){ echo "checked"; } ?>>
						<label><?php echo _l('send_email_to_customer_when_staff_check_in_out_at_customer_location'); ?></label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="checkbox">							
						<input type="checkbox" class="capability" name="allow_employees_to_create_work_points" value="1" <?php if($allow_employees_to_create_work_points == 1){ echo "checked"; } ?>>
						<label><?php echo _l('allow_employees_to_create_work_points'); ?></label>
					</div>
				</div>
			</div>
		</div>

		<br>
		<h4>
			<?php echo _l('route_management'); ?>
		</h4>
		<hr>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<?php
					$googlemap_api_key = '';
					$api_key = get_timesheets_option('googlemap_api_key');
					if($api_key){
						$googlemap_api_key = $api_key;
					}	
					echo render_input('googlemap_api_key', 'googlemap_api_key', $googlemap_api_key) ?>
				</div>
			</div>
		</div>

		<br>
		<h4>
			<?php echo _l('manage_leave'); ?>
		</h4>
		<hr>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<?php
					$start_month_for_annual_leave_cycle = '1';
					$start_month = get_timesheets_option('start_month_for_annual_leave_cycle');
					if($start_month){
						$start_month_for_annual_leave_cycle = $start_month;
					}	

					$month = [
						1 => ['id' => '1', 'name' => _l('January')],
						2 => ['id' => '2', 'name' => _l('February')],
						3 => ['id' => '3', 'name' => _l('March')],
						4 => ['id' => '4', 'name' => _l('April')],
						5 => ['id' => '5', 'name' => _l('May')],
						6 => ['id' => '6', 'name' => _l('June')],
						7 => ['id' => '7', 'name' => _l('July')],
						8 => ['id' => '8', 'name' => _l('August')],
						9 => ['id' => '9', 'name' => _l('September')],
						10 => ['id' => '10', 'name' => _l('October')],
						11 => ['id' => '11', 'name' => _l('November')],
						12 => ['id' => '12', 'name' => _l('December')],
					];
					echo render_select('start_month_for_annual_leave_cycle', $month, array('id', 'name'), 'ts_start_month_for_annual_leave_cycle', $start_month_for_annual_leave_cycle, array(), array(), '', '', false); 
					?>
				</div>
			</div>
		</div>

		<br>
		<h4>
			<?php echo _l('ts_cron_job'); ?>
		</h4>
		<hr>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<?php
					$hour_notification_approval_exp = '3';
					$start_month = get_timesheets_option('hour_notification_approval_exp');
					if($start_month){
						$hour_notification_approval_exp = $start_month;
					}	
					echo render_input('hour_notification_approval_exp', 'ts_hour_automatic_to_send_notification_of_approval_expiration', $hour_notification_approval_exp, 'number', array('required' => 'required')); 
					?>
				</div>
			</div>
		</div>

		<hr>

	</div>
	<br>
	<div class="clearfix"></div>

	<div class="col-md-12">
		<?php if(is_admin() || has_permission('timesheets_default_settings','','edit')){ ?>
			<button class="btn btn-info pull-right save_time_sheet"><?php echo _l('submit'); ?></button>
		<?php } ?>
	</div>
	<?php echo form_close(); ?>
</body>
</html>
