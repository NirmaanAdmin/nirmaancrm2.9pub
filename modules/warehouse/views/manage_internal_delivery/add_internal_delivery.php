<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">

       <?php echo form_open_multipart(admin_url('warehouse/add_update_internal_delivery'), array('id'=>'add_update_internal_delivery')); ?>

			<div class="col-md-12">
        <div class="panel_s accounting-template estimate">
        <div class="panel-body">
                  <?php 
                    $id = '';
                    if(isset($internal_delivery)){
                      $id = $internal_delivery->id;
                    }
                   ?>
                <input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">

          <div class="row">
             <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <?php $internal_delivery_name = (isset($internal_delivery) ? $internal_delivery->internal_delivery_name : '');
                    echo render_input('internal_delivery_name','internal_delivery_name',$internal_delivery_name); ?>
          
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-12">
                    
                    <?php $prefix = get_warehouse_option('internal_delivery_number_prefix');
                          $next_number = get_warehouse_option('next_internal_delivery_mumber')+1;

                    $internal_delivery_code = (isset($internal_delivery) ? $internal_delivery->internal_delivery_code : $next_number);
                    
                    $internal_delivery_code = (isset($internal_delivery) ? $internal_delivery->internal_delivery_code : $next_number);
                    echo form_hidden('internal_delivery_code',$internal_delivery_code); ?> 
                    
                    <label for="internal_delivery_code"><?php echo _l('internal_delivery_note_number'); ?></label>
                    <div class="input-group" id="discount-total"><div class="input-group-addon">
                          <div class="dropdown">
                             <span class="discount-type-selected">
                              <?php echo html_entity_decode($prefix) ;?>
                             </span>
                          </div>
                       </div>
                        <input type="text" readonly class="form-control" name="internal_delivery_code" value="<?php echo html_entity_decode($internal_delivery_code); ?>">
                    </div>

                  </div>

                </div>
             </div>

             <div class="col-md-6">

                <div class="col-md-6">
                  <?php $date_c = isset($internal_delivery) ? $internal_delivery->date_c : $current_day ;?>
                    
                    <?php echo render_date_input('date_c','accounting_date', _d($date_c)) ?>
                </div>

                <div class="col-md-6">
                  <?php $date_add = isset($internal_delivery) ? $internal_delivery->date_add : $current_day ;?>
                  <?php echo render_date_input('date_add','day_vouchers', _d($date_add)) ?>
                </div>


                <div class="col-md-12">
                     <?php
                    $selected = '';
                    foreach($staff as $member){
                     if(isset($internal_delivery)){
                       if($internal_delivery->staff_id == $member['staffid']) {
                         $selected = $member['staffid'];
                       }
                     }
                    }
                    echo render_select('staff_id',$staff,array('staffid',array('firstname','lastname')),'deliver_name',$selected);
                    ?>
                </div>

             </div>  

            <div class=" col-md-12">
                <?php $description = (isset($internal_delivery) ? $internal_delivery->description : '');
                echo render_textarea('description','note_',$description) ?>
            </div>
               
          </div>
        </div>
        <div class="panel-body mtop10">
        <div class="row col-md-12">
        <p class="bold p_style"><?php echo _l('internal_delivery_note_detail'); ?></p>
        <hr class="hr_style"/>

         <div class="form"> 
            <div id="hot_internal_delivery" class="hot handsontable htColumnHeaders">
            </div>

          <?php echo form_hidden('hot_internal_delivery'); ?>
        </div>
        <br/>
        <br/>

         <div class="col-md-6 col-md-offset-6">
            <table class="table text-right">
               <tbody>
                 
                  <tr>
                     <td class="td_style"><span class="bold"><?php echo _l('into_money'); ?></span>
                     </td>
                     <td width="55%" id="total_td">
                      
                       <div class="input-group" id="total_amount">
                            <?php $total_amount = (isset($internal_delivery) ? $internal_delivery->total_amount : ''); ?>
                            <?php echo form_hidden('total_amount', $total_amount); ?>

                             <input type="text" disabled="true" class="form-control text-right" name="total_amount" value="<?php if(isset($internal_delivery)){ echo app_format_money($internal_delivery->total_amount,''); } ?>">

                             <div class="input-group-addon">
                                <div class="dropdown">
                                   
                                   <span class="discount-type-selected">
                                    <?php echo html_entity_decode($base_currency->name) ;?>
                                   </span>
                                   
                                   
                                </div>
                             </div>

                          </div>
                     </td>

                  </tr>
               </tbody>
            </table>
         </div> 
        </div>
        </div>
        <div class="row">
          <div class="col-md-12 mtop15">
             <div class="panel-body bottom-transaction">
                
                <div class="btn-bottom-toolbar text-right">
                  
                  <button type="button" class="btn btn-info mleft10 btn_add_internal_delivery ">
                  <?php echo _l('save'); ?>
                  </button>
                </div>
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
</body>
</html>
<?php require 'modules/warehouse/assets/js/add_edit_internal_delivery_js.php';?>
