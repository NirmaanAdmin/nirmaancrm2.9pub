<?php defined('BASEPATH') or exit('No direct script access allowed');
if (!isset($invoice)) {
  $table_data = array(
    '#',
    _l('name'),
    _l('plan'),
    _l('for'),
    _l('product_group'),
    _l('description'),
    _l('link'),
	);
  render_datatable($table_data, 'subscriptionProducts ');
  //add script to load table
  hooks()->add_action('app_admin_footer', function () {
?>
    <script>
      $(function() {
        initDataTable('.table-subscriptionProducts', admin_url + "services/products/table/subscription", undefined, undefined);
      });
    </script>
<?php
  });
} else {
	$table_data = array(
		'#',
    _l('name'),
    _l('price'),
    _l('for'),
    _l('product_group'),
    _l('description'),
    _l('link')
	  );
	  render_datatable($table_data, 'invoiceProducts ');
	  //add script to load table
	  hooks()->add_action('app_admin_footer', function () {
	?>
		<script>
		  $(function() {
			initDataTable('.table-invoiceProducts', admin_url + "services/products/table/invoice", undefined, undefined);
		  });
		</script>

<?php }); } ?>
