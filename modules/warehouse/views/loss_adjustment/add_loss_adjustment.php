<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?php
			echo form_open($this->uri->uri_string(),array('id'=>'pur_order-form','class'=>'_transaction_form'));
			
			?>
      <?php 
        $id = '';
        if(isset($loss_adjustment)){
          $id = $loss_adjustment->id;
        }
       ?>
      <input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">
			<div class="col-md-12">
        <div class="panel_s accounting-template estimate">
         <div class="panel-body">
         <div class="col-md-12">
           <h4><?php echo _l('loss_adjustment'); ?></h4>
           <hr>
         </div>
         <div class="row">
               <div class="col-md-4">
                 <?php
                  $time = (isset($loss_adjustment) ? _dt($loss_adjustment->time) : _dt(date('Y-m-d H:i:s')));
                  echo render_datetime_input('time','_time',$time);
                    $type = '';
                    $reason = '';
                    $prescription_id = '';
                    if(isset($loss_adjustment)){
                      $type = $loss_adjustment->type;
                      $reason = $loss_adjustment->reason;
                    }
                   ?>
               </div>
               <div class="col-md-4 form-group">
                 <label for="vendor"><span class="text-danger">* </span><?php echo _l('type_label'); ?></label>
                  <select name="type" class="selectpicker" id="type" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" required="true"> 
                        <option value=""></option>
                        <option value="loss" <?php if($type == 'loss'){ echo 'selected'; } ?>><?php echo _l('loss'); ?></option>
                        <option value="adjustment" <?php if($type == 'adjustment'){ echo 'selected'; } ?>><?php echo _l('adjustment'); ?></option>
                  </select>
                 <br><br>
               </div>

               <div class="col-md-4 form-group">
                 <label for="vendor"><span class="text-danger">* </span><?php echo _l('_warehouse'); ?></label>
                  <select name="warehouses" class="selectpicker" id="warehouses" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" required="true"> 
                        <option value=""></option>
                        <?php foreach($warehouses as $wh){ ?>
                          <option value="<?php echo html_entity_decode($wh['id']); ?>" <?php if(isset($loss_adjustment) && $loss_adjustment->warehouses == $wh['id']){ echo 'selected';} ?> ><?php echo html_entity_decode($wh['label']); ?></option>
                        <?php } ?>
                  </select>
                 <br><br>
               </div>                  
                            
         </div>
       </div>
        <div class="panel-body mtop10">
        <div class="col-md-12">
        <p class="bold" ><?php echo _l('loss_adjustment_detail'); ?></p>
        <hr />
        <div class="row">
         <div class="mleft10 hot handsontable htColumnHeaders" id="example">
          </div>
         </div>
         <?php echo form_hidden('pur_order_detail'); ?>
         <div class="clearfix"></div>
         <br><br>
         <div class="row">
              <div class="col-md-12">
                <?php echo render_textarea('reason','reason',$reason) ?>
            </div>
         </div>
           
         <div class="col-md-4 col-md-offset-8">

         </div> 
        </div>
        </div>
        <div class="row">
          <div class="col-md-12 mtop15">
                <div class="btn-bottom-toolbar text-right">
                  <a href="<?php echo admin_url('warehouse/loss_adjustment'); ?>" class="btn btn-danger"><?php echo _l('close'); ?></a>&nbsp;&nbsp;&nbsp;
                  <?php if(isset($loss_adjustment) && $loss_adjustment->status == 0){ ?>
                    <?php  ?>
<!--                       <?php if (is_admin() || has_permission('warehouse', '', 'edit')) { ?>

                      <button type="button" id="adjusted" data-id="<?php echo html_entity_decode($loss_adjustment->id); ?>" class="btn btn-primary"><?php echo _l('adjustment'); ?></button>
                    <?php } ?> -->

                    <?php  ?>

                    <?php if (has_permission('warehouse', '', 'create') || is_admin() || has_permission('warehouse', '', 'edit')) { ?>
                    <button type="button" class="btn-tr save_detail btn btn-info mleft10 ">
                    <?php echo _l('submit'); ?>
                    </button>
                     <?php } ?>

                  <?php }  ?>
                  <?php 
                    if(!isset($loss_adjustment)){ ?>
                      <?php if (has_permission('warehouse', '', 'create') || is_admin() || has_permission('warehouse', '', 'edit')) { ?>
                       <button type="button" class="btn-tr save_detail btn btn-info mleft10 ">
                                <?php echo _l('submit'); ?>
                       </button>
                     <?php } ?>
                  <?php } ?>
                </div>
             <div class="btn-bottom-pusher"></div>
          </div>
        </div>
        </div>

			</div>
			<?php echo form_close(); ?>
			
		</div>
	</div>
</div>
</div>

<?php init_tail(); ?>

<?php require 'modules/warehouse/assets/js/add_loss_adjustment_js.php';?>
</body>
</html>
