<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

  
  <div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12" id="small-table">
            <div class="panel_s">
               <div class="panel-body">

                  <div class="row">
                     <div class="col-md-12">
                      <h4 class="no-margin font-bold h4-color"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo _l($title); ?></h4>
                      <hr class="hr-color">
                    </div>
                  </div>

                  <?php echo form_open_multipart(admin_url('warehouse/goods_delivery'), array('id'=>'add_goods_delivery')); ?>
                    <?php 
                    $id = '';
                    if(isset($goods_delivery)){
                      $id = $goods_delivery->id;
                    }
                   ?>
                <input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">

                <input type="hidden" name="edit_approval" value="<?php echo html_entity_decode($edit_approval); ?>">

                <input type="hidden" name="save_and_send_request" value="false">

                <!-- start -->
                <div class="row" >
                  <div class="col-md-12">
                     <div class="panel panel-primary">
                      <div class="panel-heading"><?php echo _l('general_infor') ?></div>
                      <div class="panel-body">

                        <div class="col-md-6">
                          <?php $goods_delivery_code = isset($goods_delivery)? $goods_delivery->goods_delivery_code: (isset($goods_code) ? $goods_code : '');?>
                          <?php echo render_input('goods_delivery_code', 'document_number',$goods_delivery_code,'',array('disabled' => 'true')) ?>
                        </div>

                        <div class="col-md-3">
                          <?php $date_c = isset($goods_delivery) ? $goods_delivery->date_c : $current_day ;?>
                            <?php $disabled=[]; ?>

                            <?php if($edit_approval == 'true'){ 
                                $disabled['disabled'] = 'true' ;
                             } ?>
                            <?php echo render_date_input('date_c','accounting_date', _d($date_c), $disabled) ?>

                        </div>
                        <div class="col-md-3">
                          <?php $date_add = isset($goods_delivery) ? $goods_delivery->date_add : $current_day ;?>
                          <?php echo render_date_input('date_add','day_vouchers', _d($date_add), $disabled) ?>
                        </div>

                        <br>

                        <div class="col-md-6 <?php if($pr_orders_status == false || get_warehouse_option('goods_delivery_required_po') == 0){ echo 'hide';} ;?>" >
                          <div class="form-group">
                             <label for="pr_order_id"><?php echo _l('reference_purchase_order'); ?></label>
                            <select onchange="pr_order_change(this); return false;" name="pr_order_id" id="pr_order_id" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>" <?php if($edit_approval == 'true'){ echo 'disabled';} ; ?> >
                              <option value=""></option>
                              <?php foreach($pr_orders as $pr_order) { ?>
                                <option value="<?php echo html_entity_decode($pr_order['id']); ?>" <?php if(isset($goods_delivery) && ($goods_delivery->pr_order_id == $pr_order['id'])){ echo 'selected' ;} ?>><?php echo html_entity_decode($pr_order['pur_order_number'].' - '.$pr_order['pur_order_name']); ?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 <?php if($pr_orders_status == true && get_warehouse_option('goods_delivery_required_po') == 1){ echo 'hide';} ;?> ">
                         <div class="form-group">
                          <label for="invoice_id"><?php echo _l('invoices'); ?></label>
                            <select onchange="invoice_change(this); return false;" name="invoice_id" id="invoice_id" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>" <?php if($edit_approval == 'true'){ echo 'disabled';} ; ?> >
                                <option value=""></option>
                                <?php foreach($invoices as $invoice) { ?>
                                <option value="<?php echo html_entity_decode($invoice['id']); ?>" <?php if(isset($goods_delivery) && $goods_delivery->invoice_id == $invoice['id']){ echo 'selected'; } ?>><?php echo format_invoice_number($invoice['id']).' - '.$invoice['company'].' - '.$invoice['name']; ?></option>
                                  <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6">

                          <div class="form-group">
                          <label for="customer_code"><?php echo _l('customer_name'); ?></label>
                            <select name="customer_code" id="vendor" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>" <?php if($edit_approval == 'true'){ echo 'disabled';} ; ?>  >
                                <option value=""></option>
                                <?php foreach($customer_code as $s) { ?>
                                <option value="<?php echo html_entity_decode($s['userid']); ?>" <?php if(isset($goods_delivery) && $goods_delivery->customer_code == $s['userid']){ echo 'selected'; } ?>><?php echo html_entity_decode($s['company']); ?></option>
                                  <?php } ?>
                            </select>
                          </div>

                        </div>


                      <div class=" col-md-6">
                          <?php $to = (isset($goods_delivery) ? $goods_delivery->to_ : '');
                          echo render_input('to_','receiver',$to, '',$disabled) ?>
                      </div>
                      <div class=" col-md-6">
                          <?php $address = (isset($goods_delivery) ? $goods_delivery->address : '');
                          echo render_input('address','address',$address,'', $disabled) ?>
                      </div>

                  <?php if(ACTIVE_PROPOSAL == true){ ?>

                    <div class="col-md-6 form-group <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
                      <label for="project"><?php echo _l('project'); ?></label>
                        <select name="project" id="project" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                          <option value=""></option>

                          <?php if(isset($projects)){ ?>
                            <?php foreach($projects as $s) { ?>
                              <option value="<?php echo html_entity_decode($s['id']); ?>" <?php if(isset($goods_delivery) && $s['id'] == $goods_delivery->project){ echo 'selected'; } ?>><?php echo html_entity_decode($s['name']); ?></option>
                              <?php } ?>
                          <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6 form-group <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
                      <label for="type"><?php echo _l('type_label'); ?></label>
                        <select name="type" id="type" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                          <option value=""></option>
                          <option value="capex" <?php if(isset($goods_delivery) && $goods_delivery->type == 'capex'){ echo 'selected';} ?>><?php echo _l('capex'); ?></option>
                          <option value="opex" <?php if(isset($goods_delivery) && $goods_delivery->type == 'opex'){ echo 'selected';} ?>><?php echo _l('opex'); ?></option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
                      <label for="department"><?php echo _l('department'); ?></label>
                        <select name="department" id="department" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                          <option value=""></option>
                            <?php if(isset($departments)){ ?>
                              <?php foreach($departments as $s) { ?>
                                <option value="<?php echo html_entity_decode($s['departmentid']); ?>" <?php if(isset($goods_delivery) && $s['departmentid'] == $goods_delivery->department){ echo 'selected'; } ?>><?php echo html_entity_decode($s['name']); ?></option>
                              <?php } ?>

                            <?php } ?>

                        </select>
                    </div>

                    <div class="col-md-6 form-group <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
                      <label for="requester"><?php echo _l('requester'); ?></label>
                        <select name="requester" id="requester" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                          <option value=""></option>
                            <?php if(isset($staffs)){ ?>

                              <?php foreach($staffs as $s) { ?>
                              <option value="<?php echo html_entity_decode($s['staffid']); ?>" <?php if(isset($goods_delivery) && $s['staffid'] == $goods_delivery->requester){ echo 'selected'; } ?>><?php echo html_entity_decode($s['lastname'] . ' '. $s['firstname']); ?></option>
                              <?php } ?>

                            <?php }?>

                        </select>
                    </div>

                  <?php } ?>

                    <div class="col-md-6">
                      <a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle skucode-tooltip"  data-toggle="tooltip" title="" data-original-title="<?php echo _l('goods_delivery_warehouse_tooltip'); ?>"></i></a>

                      <div class="form-group">
                          <label for="warehouse_id"><?php echo _l('warehouse_name'); ?></label>
                            <select name="warehouse_id" id="warehouse_id" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>" <?php if($edit_approval == 'true'){ echo 'disabled';} ; ?> >

                                <option value=""></option>
                                <?php foreach($warehouses as $wh_value) { ?>
                                <option value="<?php echo html_entity_decode($wh_value['warehouse_id']); ?>" <?php if(isset($goods_delivery) && $goods_delivery->warehouse_id == $wh_value['warehouse_id']){ echo 'selected'; } ?>><?php echo ($wh_value['warehouse_name']); ?></option>
                                  <?php } ?>
                            </select>
                      </div>

                    </div>

                    
                     
                      <div class=" col-md-6">
                        <div class="form-group">
                          <label for="staff_id" class="control-label"><?php echo _l('salesman'); ?></label>
                            <select name="staff_id" class="selectpicker" id="staff_id" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>" <?php if($edit_approval == 'true'){ echo 'disabled';} ; ?>> 
                              <option value=""></option> 
                              <?php foreach($staff as $s){ ?>
                            <option value="<?php echo html_entity_decode($s['staffid']); ?>" <?php if(isset($goods_delivery) && $goods_delivery->staff_id == $s['staffid']){ echo 'selected' ;} ?>> <?php echo html_entity_decode($s['firstname']).''.html_entity_decode($s['lastname']); ?></option>                  
                            <?php }?>
                            </select>

                          </div>
                      </div>

                 
                    <div class="col-md-6 form-group" >
                      <?php $invoice_no = (isset($goods_delivery) ? $goods_delivery->invoice_no : '');
                          echo render_input('invoice_no','invoice_no',$invoice_no, '',$disabled) ?>

                    </div>

                      <div class=" col-md-12">
                          <?php $description = (isset($goods_delivery) ? $goods_delivery->description : '');
                          echo render_textarea('description','note_',$description) ?>
                      </div>


                      </div>
                    </div>
                  </div>

                  
                  </div>
                    
                    <!-- start  -->
                    <div class="col-md-12 ">
                        <h5 class="no-margin font-bold h4-color" ><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo _l('stock_export_detail'); ?></h5>
                        <hr class="hr-color">

                          <div class="panel-body ">
                            <div class="horizontal-scrollable-tabs preview-tabs-top">
                             <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                             <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                             <div class="horizontal-tabs">
                             <ul class="nav nav-tabs nav-tabs-horizontal mbot15" role="tablist">
                               <li role="presentation" class="active">
                                   <a href="#commodity" aria-controls="commodity" role="tab" data-toggle="tab" aria-controls="commodity" id="ac_commodity">
                                   <span class="glyphicon glyphicon-align-justify"></span>&nbsp;<?php echo _l('commodity'); ?>
                                   </a>
                                </li>
                              </ul>
                             </div>
                            </div>

                            <div class="tab-content">
                              <div role="tabpanel" class="tab-pane active" id="commodity">
                                <div class="form"> 
                           
                                    <div id="hot_purchase" class="hot handsontable htColumnHeaders">
                                        
                                    </div>
                        
                                  <?php echo form_hidden('hot_purchase'); ?>
                                </div>

                              </div>
                            </div>

                            <div class="row">
                             <div class="col-md-3 pull-right panel-padding">
                                <table class="table border table-striped table-margintop">
                                    <tbody>

                                       <tr class="project-overview">
                                        <?php $total_money = (isset($goods_delivery) ? $goods_delivery->total_money : ''); ?>
                                          <td ><?php echo render_input('total_money','subtotal',app_format_money((float)$total_money,''),'',array('disabled' => 'true')) ?>
                                            <?php echo form_hidden('total_money', $total_money); ?>
                                            
                                          </td>

                                       </tr>
                                       <tr class="project-overview">
                                        <?php $total_discount = (isset($goods_delivery) ? $goods_delivery->total_discount : ''); ?>
                                          <td ><?php echo render_input('total_discount','total_discount',app_format_money((float)$total_discount,''),'',array('disabled' => 'true')) ?>
                                            <?php echo form_hidden('total_discount', $total_discount); ?>
                                            
                                          </td>

                                       </tr>
                                       <tr class="project-overview">
                                        <?php $after_discount = (isset($goods_delivery) ? $goods_delivery->after_discount : ''); ?>
                                          <td ><?php echo render_input('after_discount','total_money', app_format_money((float)$after_discount,''),'',array('disabled' => 'true')) ?>
                                            <?php echo form_hidden('after_discount', $after_discount ); ?>
                                            
                                          </td>

                                       </tr>

                                        </tbody>
                                </table>
                              </div>
                            </div>
                              

                          </div>

                          </div>

                  <hr>
                 <div class="modal-footer">
                  
                  <?php if (is_admin() || has_permission('warehouse', '', 'edit') || has_permission('warehouse', '', 'create')) { ?>


                  <a href="#"class="btn btn-info pull-right mright10 display-block add_goods_delivery" ><?php echo _l('submit'); ?></a>
                  <?php } ?>

                    <?php if(wh_check_approval_setting('2') != false) { ?>
                      <?php if(isset($goods_delivery) && $goods_delivery->approval != 1){ ?>
                    <a href="#"class="btn btn-info pull-right mright10 display-block add_goods_delivery_send" ><?php echo _l('save_send_request'); ?></a>
                  <?php }elseif(!isset($goods_delivery)){ ?>
                    <a href="#"class="btn btn-info pull-right mright10 display-block add_goods_delivery_send" ><?php echo _l('save_send_request'); ?></a>
                  <?php } ?>
                  <?php } ?>

                    <a href="<?php echo admin_url('warehouse/manage_delivery'); ?>"class="btn btn-default pull-right mright10 display-block"><?php echo _l('close'); ?></a>


                </div>

                     
                      </div>

                    </div>
                   

                  </div>
               


                  <?php echo form_close(); ?>

               </div>
            </div>
          </div>
      </div>
    </div>
  </div>


<?php init_tail(); ?>
<?php require 'modules/warehouse/assets/js/goods_delivery_js.php';?>
</body>
</html>



