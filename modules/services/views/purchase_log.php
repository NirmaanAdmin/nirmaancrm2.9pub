<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<?php
						$table_data = array(
							'#',
							_l('inv_sub'),
							_l('status'),
							_l('amount_or_plan'),
							_l('product_name'),
							_l('quantity'),
							_l('client'),
							// _l('contact'),
							_l('date'),
						);

						$custom_fields = get_custom_fields('products', array('show_on_table' => 1));
						foreach ($custom_fields as $field) {
							array_push($table_data, $field['name']);
						}

						echo render_datatable($table_data, 'purchaseLog');
						hooks()->add_action('app_admin_footer', function () {
						?>
							<script>
								$(function() {
									initDataTable('.table-purchaseLog', admin_url + "services/products/table/purchaseLog", undefined, [5, 6, 7]);
								});
							</script>
						<?php
						}); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="modal_wrapper"></div>
<?php
init_tail();
require(module_dir_path('services', 'assets/services.php'));
?>
</body>

</html>