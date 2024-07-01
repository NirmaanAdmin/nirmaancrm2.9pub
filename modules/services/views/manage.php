<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
            <div class="_buttons">
              <?php if (has_permission('subscriptions', '', 'create')) { ?>
                <?php if(isset($invoice)) { ?>
                  <a href="<?php echo admin_url('services/products/create/invoice'); ?>" class="btn btn-info pull-left display-block">
                  <?php echo _l('stripe_new_product'); ?>
                </a>
                <?php } else {?>
                  <a href="<?php echo admin_url('services/products/create/subscription'); ?>" class="btn btn-info pull-left display-block">
                  <?php echo _l('stripe_new_product'); ?>
                </a>
                <?php } ?>
              <?php } ?>
            </div>
            <div class="clearfix"></div>
            <hr class="hr-panel-heading" />
            <?php $this->load->view('table_html'); ?>
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