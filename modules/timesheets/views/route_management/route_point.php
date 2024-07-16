<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div>
	<div class="_buttons">
		<?php if(is_admin() || has_permission('route_management','','view') || (get_timesheets_option('allow_employees_to_create_work_points') == 1)) {?>
			<a href="#" onclick="new_route_point(); return false;" class="btn btn-info pull-left display-block">
				<?php echo _l('add'); ?>
			</a>
		<?php } ?>
	</div>
	<div class="clearfix"></div>
	<br>
	<div class="row">

		<div class="col-md-3">
			<?php
			echo render_select('customer_fillter[]', $client, array('userid', 'company'), 'customer','',array('multiple' => true, 'data-actions-box' => true)); 
			?>
		</div>
		<div class="col-md-3">
			<?php
			echo render_select('workplace_fillter[]', $workplace, array('id', 'name'), 'workplace','',array('multiple' => true, 'data-actions-box' => true)); 
			?>
		</div>
		<div class="col-md-3"></div>
		<div class="col-md-3"></div>
	</div>
</div>
<br>
<table class="table table-table_route_point scroll-responsive">
	<thead>
		<th><?php echo _l('route_point'); ?></th>
		<th><?php echo _l('related_to'); ?></th>
		<th><?php echo _l('route_point_address'); ?></th>
		<th><?php echo _l('latitude'); ?></th>
		<th><?php echo _l('longitude'); ?></th>
		<th><?php echo _l('distance'); ?></th>
		<th><?php echo _l('options'); ?></th>
	</thead>
	<tbody></tbody>
	<tfoot>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tfoot>
</table>
<div class="modal" id="route_point" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<?php echo form_open(admin_url('timesheets/add_route_point'), array('id' => 'add_route_point' )); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					<span class="edit-title"><?php echo _l('edit_route_point'); ?></span>
					<span class="add-title"><?php echo _l('new_route_point'); ?></span>
				</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<div id="additional_route_point"></div>   
						<div class="form">     
							<?php 
							echo render_input('name','name','','text', array('onblur' => 'check_route_ppoint_name(this)')); ?>
						</div>
					</div>
					<div class="col-md-12 select_related">
						<?php
						$related_to = [
							['id' => '3', 'label' => ''],
							['id' => '1', 'label' => _l('customer')],
							['id' => '2', 'label' => _l('workplace')]
						];
						echo render_select('related_to', $related_to, array('id', 'label'), 'related_to','customer', array('onchange' => 'get_ui_relate()'),[],'','', false); ?>
					</div>
					<div class="col-md-6 related_client mtop5 hide">
						<br>
						<?php
						echo render_select('related_id', $client, array('userid', 'company'), '',''); ?>
					</div>
					<div class="col-md-6 related_workplace mtop5 hide">
						<br>
						<?php
						echo render_select('related_id2', $workplace, array('id', 'name'), '',''); ?>
					</div>
					<div class="col-md-12">
						<?php echo render_textarea('route_point_address', 'route_point_address') ?>
					</div>
					<div class="col-md-12">
						<button class="btn btn-default" type="button" onclick="get_coordinates();" id="get_coordinates_btn"><i class="fa fa-location-arrow"></i> <?php echo _l('get_coordinates'); ?></button>
					</div>
					<div class="clearfix"></div>
					<br>
					<div class="col-md-6">
						<?php echo render_input('latitude', 'latitude', '') ?>
					</div>
					<div class="col-md-6">
						<?php echo render_input('longitude', 'longitude', '') ?>
					</div>
					<div class="col-md-6">
						<?php echo render_input('distance', 'distance', '', 'number') ?>
					</div>
					<div class="col-md-6">
					</div>
				</div>
				<input type="hidden" name="id" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" data-dismiss="modal"><?php echo _l('close'); ?></button>
				<button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
			</div>
		</div><!-- /.modal-content -->
		<?php echo form_close(); ?>
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>

</body>
</html>
