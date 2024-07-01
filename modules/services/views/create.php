<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body accounting-template">
                        <?php if (!isset($invoice_product)) { ?>
                            <h4 class="no-margin"><?php echo html_escape(_l('subscription_products')) ?></h4>
                            <hr>
                            <?php $this->load->view('form'); ?>
                        <?php } else { ?>
                            <h4 class="no-margin"><?php echo html_escape(_l('invoice_products')) ?></h4>
                            <hr>
                            <?php $this->load->view('invoic_product_form'); ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
init_tail();
require(module_dir_path('services', 'assets/services.php'));
?>
<script>
    init_editor("#long_description");
</script>