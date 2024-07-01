<?php hooks()->do_action('head_element_client'); ?>
<div id="wrapper" class="customer_profile">
   <div class="content">
      <div class="row">     

         <div class="col-md-12">
            <div class="panel_s">
               <div class="panel-body">
                  <?php if(isset($client)){ ?>
                  <?php echo form_hidden('isedit'); ?>
                  <?php echo form_hidden('userid', $client->userid); ?>
                  <div class="clearfix"></div>
                  <?php } ?>
                  <div>
                     <div class="tab-content">
                           <?php $this->load->view('client/cart/order_detailt_partial'); ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php hooks()->do_action('client_pt_footer_js'); ?>


