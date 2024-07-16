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
								<h4><i class="fa fa-map-signs menu-icon"></i> <?php echo html_entity_decode($title) ?></h4>
							</div>
						</div>
						<div class="horizontal-scrollable-tabs preview-tabs-top">
							<div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
							<div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
							<div class="horizontal-tabs">
								<ul class="nav nav-tabs nav-tabs-horizontal mbot15" role="tablist">

									<li role="presentation" <?php if($tab == 'route'){echo " class='active'"; } ?>>
										<a href="<?php echo admin_url('timesheets/route_management?tab=route'); ?>"><i class="fa fa-road"></i> <?php echo _l('route'); ?></a>
									</li>
									<li role="presentation" <?php if($tab == 'map'){echo " class='active'"; } ?>>
										<a href="<?php echo admin_url('timesheets/route_management?tab=map'); ?>"><i class="fa fa-map"></i> <?php echo _l('map'); ?></a>
									</li>
									<li role="presentation" <?php if($tab == 'route_point'){echo " class='active'"; } ?>>
										<a href="<?php echo admin_url('timesheets/route_management?tab=route_point'); ?>"><i class="fa fa-map-marker"></i> <?php echo _l('route_point'); ?></a>
									</li>

								</ul>
							</div>
						</div>
						<br>
						<?php $this->load->view($tab); ?>
					</div>
				</div>
			</div>

			<div class="clearfix"></div>
		</div>
		<?php echo form_close(); ?>
		<div class="btn-bottom-pusher"></div>
	</div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>
<?php
hooks()->do_action('settings_tab_footer', $tab); ?>
<?php
	if($tab == 'route'){
		require 'modules/timesheets/assets/js/route_js.php'; 	
	} 	
?>

</body>
</html>
