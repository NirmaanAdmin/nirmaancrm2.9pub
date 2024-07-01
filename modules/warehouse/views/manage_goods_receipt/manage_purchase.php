<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12" id="small-table">
                <div class="panel_s">
                    <div class="panel-body">
                         <?php echo form_hidden('purchase_id',$purchase_id); ?>
                        <div class="row">
                         <div class="col-md-12">
                          <h4 class="no-margin font-bold"><i class="fa fa-shopping-basket" aria-hidden="true"></i> <?php echo _l($title); ?></h4>
                          <hr />
                         </div>
                        </div>
                        <div class="row">    
                            <div class="_buttons col-md-3">
                                <?php if (has_permission('warehouse', '', 'create') || is_admin()) { ?>
                                <a href="<?php echo admin_url('warehouse/manage_goods_receipt'); ?>"class="btn btn-info pull-left mright10 display-block">
                                    <?php echo _l('stock_received_docket'); ?>
                                </a>
                                <?php } ?>
                            </div>
                             <div class="col-md-1 pull-right">
                                <a href="#" class="btn btn-default pull-right btn-with-tooltip toggle-small-view hidden-xs" onclick="toggle_small_view_proposal('.purchase_sm','#purchase_sm_view'); return false;" data-toggle="tooltip" title="<?php echo _l('invoices_toggle_table_tooltip'); ?>"><i class="fa fa-angle-double-left"></i></a>
                            </div>

                        </div>
                        <br/>
                        <div class="row">
                            <div  class="col-md-3 pull-right">
                                <?php 
                                 $input_attr_e = [];
                                 $input_attr_e['placeholder'] = _l('day_vouchers');

                             echo render_date_input('date_add','','',$input_attr_e ); ?>
                            </div> 

                        </div>
                    <br/>
                    <?php render_datatable(array(
                        _l('id'),
                        _l('stock_received_docket_code'),
                        _l('supplier_name'),
                        _l('Buyer'),
                        _l('reference_purchase_order'),
                        _l('day_vouchers'),
                        _l('total_tax_money'),
                        _l('total_goods_money'),
                        _l('value_of_inventory'),
                        _l('total_money'),
                        _l('status_label'),
                        ),'table_manage_goods_receipt',['purchase_sm' => 'purchase_sm']); ?>
                        
                    </div>
                </div>
            </div>

        <div class="col-md-7 small-table-right-col">
            <div id="purchase_sm_view" class="hide">
            </div>
        </div>

        </div>
    </div>
</div>

<div class="modal fade" id="send_goods_received" tabindex="-1" role="dialog">
  <div class="modal-dialog">
      <?php echo form_open_multipart(admin_url('warehouse/send_goods_received'),array('id'=>'send_goods_received-form')); ?>
      <div class="modal-content modal_withd">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">
                  <span><?php echo _l('send_received_note'); ?></span>
              </h4>
          </div>
          <div class="modal-body">
              <div id="additional_goods_received"></div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="vendor"><span class="text-danger">* </span><?php echo _l('vendor'); ?></label>
                    <select name="vendor[]" id="vendor" class="selectpicker" required multiple="true"  data-live-search="true" data-width="100%" data-none-selected-text="<?php echo _l('ticket_settings_none_assigned'); ?>" >
                        <?php foreach($vendors as $s) { ?>
                        <option value="<?php echo html_entity_decode($s['userid']); ?>"><?php echo html_entity_decode($s['company']); ?></option>
                          <?php } ?>
                    </select>
                    <br>
                </div>     
                
                <div class="col-md-12">
                  <label for="subject"><span class="text-danger">* </span><?php echo _l('subject'); ?></label>
                  <?php echo render_input('subject','','','',array('required' => 'true')); ?>
                </div>
                <div class="col-md-12">
                  <label for="attachment"><span class="text-danger">* </span><?php echo _l('attachment'); ?></label>
                  <?php echo render_input('attachment','','','file',array('required' => 'true')); ?>
                </div>
                <div class="col-md-12">
                  <?php echo render_textarea('content','content','',array(),array(),'','tinymce') ?>
                </div>     
                <div id="type_care">
                  
                </div>        
              </div>
          </div>
          <div class="modal-footer">
              <button type=""class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
              <button id="sm_btn" type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
          </div>
      </div><!-- /.modal-content -->
          <?php echo form_close(); ?>
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<script>var hidden_columns = [3,4,5];</script>
<?php init_tail(); ?>
</body>
</html>

