
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
								
								<h4><?php echo html_entity_decode($title); ?></h4>
								<hr>
								<div class="clearfix"></div>
								<div>
									<div class="_buttons">
										<?php if (has_permission('table_shiftwork_management', '', 'view') || is_admin()) { ?>
											<a href="<?php echo admin_url('timesheets/add_allocation_shiftwork'); ?>" class="btn btn-info pull-left btn-new_shift">
												<?php echo _l('new'); ?>
											</a>
										<?php } ?>
									</div>
									<div class="clearfix"></div>
									<br>
									<div class="clearfix"></div>
									<table class="table table-shift scroll-responsive">
										<thead>
											<th><?php echo _l('from_date'); ?></th>
											<th><?php echo _l('to_date'); ?></th>  
											<th><?php echo _l('department'); ?></th>
											<th><?php echo _l('role'); ?></th>
											<th><?php echo _l('staff'); ?></th>
											<th><?php echo _l('date_create'); ?></th>
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
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php init_tail(); ?>

</body>
</html>

