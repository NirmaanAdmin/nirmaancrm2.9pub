<?php hooks()->do_action('head_element_client'); ?>
<div class="col-md-12">
    <div class="panel_s">
        <div class="panel-body">
        	<div class="col-md-12"></div>
          <div class="horizontal-scrollable-tabs mb-5">
            <div class="horizontal-tabs mb-4">
              <ul class="nav nav-tabs nav-tabs-horizontal">
              	 <li<?php if($tab == 'processing'){echo " class='active'"; } ?>>
                    <a href="<?php echo site_url('omni_sales/omni_sales_client/order_list/processing'); ?>" >
                    	<?php echo _l('processing'); ?>
                    </a>
                </li>
                              	 <li<?php if($tab == 'confirm'){echo " class='active'"; } ?>>
                    <a href="<?php echo site_url('omni_sales/omni_sales_client/order_list/confirm'); ?>" >
                    	<?php echo _l('confirm'); ?>
                    </a>
                </li>
                              	 <li<?php if($tab == 'being_transported'){echo " class='active'"; } ?>>
                    <a href="<?php echo site_url('omni_sales/omni_sales_client/order_list/being_transported'); ?>" >
                    	<?php echo _l('being_transported'); ?>
                    </a>
                </li>
                              	 <li<?php if($tab == 'finish'){echo " class='active'"; } ?>>
                    <a href="<?php echo site_url('omni_sales/omni_sales_client/order_list/finish'); ?>" >
                    	<?php echo _l('finish'); ?>
                    </a>
                </li>
                              	 <li<?php if($tab == 'cancelled'){echo " class='active'"; } ?>>
                    <a href="<?php echo site_url('omni_sales/omni_sales_client/order_list/cancelled'); ?>" >
                    	<?php echo _l('cancelled'); ?>
                    </a>
                </li>                              	 
              </ul>
            </div>          
 				<?php $this->load->view('client/cart/'.$tab); ?>
          </div>
        </div>
    </div>
</div>
