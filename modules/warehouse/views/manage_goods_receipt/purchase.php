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

                  <?php echo form_open_multipart(admin_url('warehouse/manage_goods_receipt'), array('id'=>'add_goods_receipt')); ?>
                  <?php 
                    $id = '';
                    if(isset($goods_receipt)){
                      $id = $goods_receipt->id;
                    }
                   ?>
                <input type="hidden" name="id" value="<?php echo html_entity_decode($id); ?>">
                
                <input type="hidden" name="save_and_send_request" value="false">


                <!-- start-->
                <div class="row row-margin">
                  <div class="col-md-12">
                     <div class="panel panel-primary">
                      <div class="panel-heading"><?php echo _l('general_infor') ?></div>
                      <div class="panel-body">

                        <div class="col-md-6">
                          <?php $goods_receipt_code =isset($goods_receipt) ? $goods_receipt->goods_receipt_code : (isset($goods_code) ? $goods_code : '');?>
                          <?php echo render_input('goods_receipt_code', 'stock_received_docket_number',$goods_receipt_code,'',array('disabled' => 'true')) ?>
                        </div>
                         <div class="col-md-3">
                          <?php $date_c =  isset($goods_receipt) ? $goods_receipt->date_c : $current_day?>
                            <?php echo render_date_input('date_c','accounting_date', _d($date_c)) ?>
                          </div>
                          <div class="col-md-3">
                            <?php $date_add =  isset($goods_receipt) ? $goods_receipt->date_add : $current_day?>
                            <?php echo render_date_input('date_add','day_vouchers', _d($date_add)) ?>
                          </div>

                        <div class="col-md-6 <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
                          <div class="form-group">
                             <label for="pr_order_id"><?php echo _l('reference_purchase_order'); ?></label>
                            <select onchange="pr_order_change(this); return false;" name="pr_order_id" id="pr_order_id" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                              <option value=""></option>
                              <?php foreach($pr_orders as $pr_order) { ?>
                                <option value="<?php echo html_entity_decode($pr_order['id']); ?>" <?php if(isset($goods_receipt) && ($goods_receipt->pr_order_id == $pr_order['id'])){ echo 'selected' ;} ?>><?php echo html_entity_decode($pr_order['pur_order_number'].' - '.$pr_order['pur_order_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        </div>

                        <div class="col-md-6 <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
                          <div class="form-group">
                             <label for="supplier_code"><?php echo _l('supplier_name'); ?></label>
                            <select  name="supplier_code" id="supplier_code" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                              <option value=""></option>

                              <?php if(isset($vendors)){ ?>
                                 <?php foreach($vendors as $s) { ?>
                                <option value="<?php echo html_entity_decode($s['userid']); ?>" <?php if(isset($goods_receipt) && $goods_receipt->supplier_code == $s['userid']){ echo 'selected'; } ?>><?php echo html_entity_decode($s['company']); ?></option>
                                  <?php } ?>
                              <?php } ?>

                            </select>
                          </div>
                        </div>

                        <div class="col-md-6 <?php if($pr_orders_status == true){ echo 'hide';} ;?>" >

                           <?php $supplier_name =  isset($goods_receipt) ? $goods_receipt->supplier_name : ''?>
                          <?php 
                          echo render_input('supplier_name','supplier_name', $supplier_name) ?>
                        </div>



                      <div class=" col-md-6">
                        <div class="form-group">
                          <label for="buyer_id" class="control-label"><?php echo _l('Buyer'); ?></label>
                            <select name="buyer_id" class="selectpicker" id="buyer_id" data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>"> 
                              <option value=""></option> 
                              <?php foreach($staff as $s){ ?>
                            <option value="<?php echo html_entity_decode($s['staffid']); ?>" <?php if(isset($goods_receipt) && ($goods_receipt->buyer_id == $s['staffid'])){ echo 'selected' ;} ?>> <?php echo html_entity_decode($s['firstname'].''.$s['lastname']); ?></option>                  
                            <?php }?>
                            </select>
                        </div>
                      </div>

                  <?php if(ACTIVE_PROPOSAL == true){ ?>
                    <div class="col-md-6 form-group <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
                      <label for="project"><?php echo _l('project'); ?></label>
                        <select name="project" id="project" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                          <option value=""></option>

                          <?php if(isset($projects)){ ?>
                            <?php foreach($projects as $s) { ?>
                              <option value="<?php echo html_entity_decode($s['id']); ?>" <?php if(isset($goods_receipt) && $s['id'] == $goods_receipt->project){ echo 'selected'; } ?>><?php echo html_entity_decode($s['name']); ?></option>
                              <?php } ?>
                          <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6 form-group <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
                      <label for="type"><?php echo _l('type_label'); ?></label>
                        <select name="type" id="type" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                          <option value=""></option>
                          <option value="capex" <?php if(isset($goods_receipt) && $goods_receipt->type == 'capex'){ echo 'selected';} ?>><?php echo _l('capex'); ?></option>
                          <option value="opex" <?php if(isset($goods_receipt) && $goods_receipt->type == 'opex'){ echo 'selected';} ?>><?php echo _l('opex'); ?></option>
                        </select>
                    </div>

                    <div class="col-md-6 form-group <?php if($pr_orders_status == false){ echo 'hide';} ;?>" >
                      <label for="department"><?php echo _l('department'); ?></label>
                        <select name="department" id="department" class="selectpicker" data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>">
                          <option value=""></option>
                            <?php if(isset($departments)){ ?>
                              <?php foreach($departments as $s) { ?>
                                <option value="<?php echo html_entity_decode($s['departmentid']); ?>" <?php if(isset($goods_receipt) && $s['departmentid'] == $goods_receipt->department){ echo 'selected'; } ?>><?php echo html_entity_decode($s['name']); ?></option>
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
                              <option value="<?php echo html_entity_decode($s['staffid']); ?>" <?php if(isset($goods_receipt) && $s['staffid'] == $goods_receipt->requester){ echo 'selected'; } ?>><?php echo html_entity_decode($s['lastname'] . ' '. $s['firstname']); ?></option>
                              <?php } ?>

                            <?php }?>

                        </select>
                    </div>

                  <?php } ?>

                    <div class=" col-md-6">
                          <?php $deliver_name = (isset($goods_receipt) ? $goods_receipt->deliver_name : '');
                          echo render_input('deliver_name','deliver_name',$deliver_name) ?>
                    </div>

                    <div class="col-md-6 ">
                      <a href="#" class="pull-right display-block input_method"><i class="fa fa-question-circle skucode-tooltip"  data-toggle="tooltip" title="" data-original-title="<?php echo _l('goods_receipt_warehouse_tooltip'); ?>"></i></a>
                        <?php echo render_select('warehouse_id',$warehouses,array('warehouse_id','warehouse_name'),'warehouse_name'); ?>
                    </div>
                    
                  <?php if(ACTIVE_PROPOSAL == true){ ?>
                    <div class="col-md-6 <?php if($pr_orders_status == false){ echo 'hide';} ;?>">
                        <?php $expiry_date =  isset($goods_receipt) ? $goods_receipt->expiry_date : $current_day?>
                            <?php echo render_date_input('expiry_date','expiry_date', _d($expiry_date)) ?>
                    </div>

                   
                  <?php } ?>
                   <div class="col-md-6 form-group" >
                      <?php $invoice_no = (isset($goods_receipt) ? $goods_receipt->invoice_no : '');
                          echo render_input('invoice_no','invoice_no',$invoice_no) ?>
                    </div>


                      <div class="col-md-12">
                          <?php $description = (isset($goods_receipt) ? $goods_receipt->description : '');
                          echo render_textarea('description','note', $description) ?>
                      </div>

                      </div>
                    </div>
                  </div>

                    <div class="col-md-12 ">
                        <!-- <div class="col-md-1">
                          <div class="onoffswitch">
                              <input type="checkbox"  name="onoffswitch" class="onoffswitch-checkbox" id="switch_contract">
                              <label class="onoffswitch-label" for="switch_contract"></label>
                          </div>
                        </div>
 -->
                      <div class="col-md-11">
                        <h5 class="no-margin font-bold h4-color"><i class="fa fa-clone menu-icon menu-icon" aria-hidden="true"></i> <?php echo _l('stock_received_docket_detail'); ?></h5>
                      </div>


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
                              <div role="tabpanel" class="tab-pane" id="tax">
                              
                              </div>
                            </div>
                          
                            
                             <div class="col-md-3 pull-right panel-padding">
                                <table class="table border table-striped table-margintop">
                                    <tbody>
                                        <tr class="project-overview">
                                          <?php $total_goods_money = (isset($goods_receipt) ? $goods_receipt->total_goods_money : '');?>

                                          <td ><?php echo render_input('total_goods_money','total_goods_money',app_format_money((float)$total_goods_money,''),'',array('disabled' => 'true')) ?>
                                            <?php echo form_hidden('total_goods_money', $total_goods_money); ?>
                                          </td>
                                       </tr>

                                       <tr class="project-overview">
                                        <?php $total_money = (isset($goods_receipt) ? $goods_receipt->total_money : '');?>
                                          <td ><?php echo render_input('total_money','total_money',app_format_money((float)$total_money,''),'',array('disabled' => 'true')) ?>
                                            <?php echo form_hidden('total_money', $total_money); ?>
                                            
                                          </td>

                                       </tr>
                                        </tbody>
                                </table>
                            </div>

                          <div class="col-md-3 pull-right  panel-padding" >
                                <table class="table border table-striped table-margintop" >
                                  <tbody>
                                     <tr class="project-overview">
                                      <?php $total_tax_money = (isset($goods_receipt) ? $goods_receipt->total_tax_money : '');?>

                                        <td ><?php echo render_input('total_tax_money','total_tax_money',app_format_money((float)$total_tax_money,''),'',array('disabled' => 'true')) ?>
                                          <?php echo form_hidden('total_tax_money', $total_tax_money); ?>
                                          
                                        </td>

                                     </tr>
                                     <tr class="project-overview">
                                       <?php $value_of_inventory = (isset($goods_receipt) ? $goods_receipt->value_of_inventory : '');?>

                                        <td ><?php echo render_input('value_of_inventory','value_of_inventory',app_format_money((float)$value_of_inventory,''),'',array('disabled' => 'true')) ?>
                                          <?php echo form_hidden('value_of_inventory', $value_of_inventory); ?>
                                          
                                        </td>
                                     </tr>
                                     
                                      </tbody>
                              </table>
                          </div>
                        </div>
                      </div>

                  <hr>
                 <div class="modal-footer">
                  
                  <?php if (is_admin() || has_permission('warehouse', '', 'edit') || has_permission('warehouse', '', 'create')) { ?>
                    
                    <a href="#"class="btn btn-info pull-right mright10 display-block add_goods_receipt" ><?php echo _l('submit'); ?></a>
                    <?php } ?>

                  <?php if(wh_check_approval_setting('1') != false) { ?>
                      <?php if(isset($goods_receipt) && $goods_receipt->approval != 1){ ?>
                      <a href="#"class="btn btn-info pull-right mright10 display-block add_goods_receipt_send" ><?php echo _l('save_send_request'); ?></a>
                    <?php }elseif(!isset($goods_receipt)){ ?>
                      <a href="#"class="btn btn-info pull-right mright10 display-block add_goods_receipt_send" ><?php echo _l('save_send_request'); ?></a>
                    <?php } ?>
                  <?php } ?>


                    <a href="<?php echo admin_url('warehouse/manage_purchase'); ?>"class="btn btn-default pull-right mright10 display-block"><?php echo _l('close'); ?></a>
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
<?php require 'modules/warehouse/assets/js/purchase_js.php';?>
</body>
</html>

