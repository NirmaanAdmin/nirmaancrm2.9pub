<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">

			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<h4>
									<?php echo html_entity_decode($title); ?>									
								</h4>
								<hr>
							</div>
							<div class="col-md-6">								
								<?php
								echo render_select('staff[]', $staff, array('staffid', array('firstname', 'lastname')), 'staff','',array('multiple' => true, 'data-actions-box' => true), [], '', '', false); ?>
							</div>
						</div>
						<br>
						<div class="col-md-12" id="example">
						</div>
						<br>
						<?php echo form_open(admin_url('timesheets/add_route'), array('id' => 'add_route' )); ?>
						<input type="hidden" name="data_hanson">
						<button type="submit" class="btn btn-info pull-right save_detail">
							<?php echo _l('submit'); ?>								
						</button>				
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>

			<div class="clearfix"></div>
		</div>
		<div class="btn-bottom-pusher"></div>
	</div>
</div>
<div class="modal" id="route" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					<span class="add-title"></span>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">	
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<label class="mtop4"><?php echo _l('route_point'); ?></label>
								<div class="checkbox mtop1 pull-right">							
									<input type="checkbox" class="capability" name="not_to_be_in_order" value="not_to_be_in_order">
									<label><?php echo _l('not_to_be_in_order'); ?></label>
								</div>
							</div>
						</div>
						<hr>
						<table id="route_point_table" width="100%">
							<tbody>
								<tr>
									<td width="50">
										<a class="btn" href="javascript:void(0)">
											<i class="fa fa-bars"></i>
										</a>
									</td>
									<td>
										<?php echo render_select('route_point[]', $route_point, array('name', 'name'), ''); ?>
									</td>
									<td width="50">
										<button type="button" class="btn btn-danger remove_row mleft10" onclick="remove_row(this)">
											<i class="fa fa-minus"></i>
										</button>
									</td>
								</tr>
							</tbody>
						</table>

					</div>				
				</div>
				<input type="hidden" name="id" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default add_new_row pull-left">
					<i class="fa fa-plus"></i>
					<?php echo _l('add_new_row'); ?>
				</button>
				<button type="button" class="btn btn-success" data-dismiss="modal"><?php echo _l('close'); ?></button>
				<button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="new_version"></div>
<?php init_tail(); ?>
<?php require 'modules/timesheets/assets/js/route_js.php'; ?>
</body>
</html>
