<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
   <div class="content">
      <div class="row">
         <div class="col-md-12" id="small-table">
            <div class="panel_s">
               <div class="panel-body">

                <div>
                    <div class="row row-margin-bottom">
                        <div class="col-md-4 ">
                            <?php if (has_permission('warehouse', '', 'create') || is_admin() ) { ?>

                            <a href="#" onclick="add_one_warehouse(); return false;" class="btn btn-info pull-left display-block mr-4 button-margin-r-b">
                                <?php echo _l('add_warehouse'); ?>

                            </a><a href="#" onclick="new_warehouse_type(); return false;" class="btn btn-primary pull-left display-block mr-4 button-margin-r-b">
                                <?php echo _l('add_warehouse_list'); ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>

                <div class="clearfix"></div>
                <hr class="hr-panel-heading" />
                <div class="clearfix"></div>

                                    <?php 
                                      $table_data = array(
                                                        
                                                          _l('warehouse_code'),
                                                          _l('warehouse_name'),
                                                          _l('warehouse_address'),
                                                          _l('order'),
                                                          _l('display'),
                                                          _l('note'),
                                                        );
                                       $cf = get_custom_fields('warehouse_name',array('show_on_table'=>1));

                                      foreach($cf as $custom_field) {
                                        array_push($table_data,$custom_field['name']);
                                      }

                                      render_datatable($table_data,'table_warehouse_name',
                                          array('customizable-table'),
                                          array(
                                            'proposal_sm' => 'proposal_sm',
                                             'id'=>'table-table_warehouse_name',
                                             'data-last-order-identifier'=>'table_warehouse_name',
                                             'data-default-order'=>get_table_last_order('table_warehouse_name'),
                                           )); ?>



                <div class="modal1 fade" id="warehouse_type" tabindex="-1" role="dialog">
                        <div class="modal-dialog setting-handsome-table">
                          <?php echo form_open_multipart(admin_url('warehouse/warehouse_'), array('id'=>'add_warehouse_type')); ?>

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">
                                        <span class="add-title"><?php echo _l('add_warehouse_type'); ?></span>
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                             <div id="warehouse_type_id">
                                             </div>   
                                         <div class="form"> 
                                            <div class="col-md-12" id="add_handsontable">

                                            </div>
                                              <?php echo form_hidden('hot_warehouse_type'); ?>
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                                        
                                         <button id="latch_assessor" type="button" class="btn btn-info intext-btn" onclick="add_warehouse_type(this); return false;" ><?php echo _l('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                    <!-- add one warehouse -->
                    <div class="modal1 fade" id="a_warehouse" tabindex="-1" role="dialog">
                        <div class="modal-dialog setting-handsome-table">
                          <?php echo form_open_multipart(admin_url('warehouse/add_warehouse'), array('id'=>'add_warehouse')); ?>

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">
                                        <span class="add-title"><?php echo _l('add_warehouse_type'); ?></span>
                                        <span class="edit-title"><?php echo _l('edit_warehouse_type'); ?></span>
                                    </h4>
                                </div>

                                <div id="warehouse_id"></div>

                                <div class="modal-body">
                                    <div class="horizontal-scrollable-tabs preview-tabs-top">
                                      <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                                      <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                                      <div class="horizontal-tabs">
                                      <ul class="nav nav-tabs nav-tabs-horizontal mbot15" role="tablist">
                                       <li role="presentation" class="active">
                                           <a href="#interview_infor" aria-controls="interview_infor" role="tab" data-toggle="tab" aria-controls="interview_infor">
                                           <span class="glyphicon glyphicon-align-justify"></span>&nbsp;<?php echo _l('general_infor'); ?>
                                           </a>
                                        </li>
                                        
                                        <li role="presentation">
                                           <a href="#custom_fields" aria-controls="custom_fields" role="tab" data-toggle="tab" aria-controls="custom_fields">
                                           <i class="fa fa-bars menu-icon"></i>&nbsp;<?php echo _l('custom_fields'); ?>
                                           </a>
                                        </li>
                                        
                                        
                                       </ul>
                                     </div>
                                   </div>

                            <div class="tab-content">
              
                            <!-- interview process start -->
                              <div role="tabpanel" class="tab-pane active" id="interview_infor">

                                    <div class="row">
                                        <div class="col-md-12">
                                             <div id="color_id_t"></div>   
                                          <div class="form"> 
                                            <div class="col-md-6">
                                              <?php echo render_input('warehouse_code', 'warehouse_code'); ?>
                                            </div>

                                            <div class="col-md-6">
                                              <?php echo render_input('warehouse_name', 'warehouse_name'); ?>
                                            </div>
                                            <div class="col-md-12">
                                              <?php $mint_point_f="1";
                                                        $min_p =[];
                                                        $min_p['min']='0';
                                                        $min_p['required']='true';

                                                     ?>
                                                <?php echo render_input('order','order',html_entity_decode($mint_point_f),'number', $min_p) ?>
                                            </div>
                                            
                                            <div class="col-md-6">
                                              <?php echo render_textarea('warehouse_address', 'warehouse_address', '', ['rows' =>5]); ?>
                                            </div>

                                            <div class="col-md-6">
                                              <?php echo render_input('city', 'city'); ?>
                                            </div>
                                            
                                            <div class="col-md-6">
                                              <?php echo render_input('state', 'state'); ?>
                                            </div>
                                            <div class="col-md-6">
                                              <?php echo render_input('zip_code', 'zip_code'); ?>
                                            </div>
                                            <div class="col-md-6">
                                              <?php $countries= get_all_countries();

                                               $customer_default_country = get_option('customer_default_country');
                                               $selected =( isset($client) ? $client->country : $customer_default_country);
                                               
                                               echo render_select( 'country',$countries,array( 'country_id',array( 'short_name')), 'clients_country',$selected,array('data-none-selected-text'=>_l('dropdown_non_selected_tex')));
                                               ?>

                                            </div>

                                            <div class="col-md-12">
                                              <?php echo render_textarea('note', 'note'); ?>

                                            </div>

                                            <div class="col-md-6">
                                              <input data-can-view="" type="checkbox" class="capability" name="display" checked>
                                              <label for="contracts_view" class="pt-2">
                                                      <?php echo _l('display'); ?>               
                                                    </label>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- custome fields -->
                                  <div role="tabpanel" class="tab-pane" id="custom_fields">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="form">
                                          <div id="custom_fields_items">
                                            <?php echo wh_render_custom_fields('warehouse_name'); ?>
                                          </div>

                                        </div>
                                     </div>
                                   </div>
                                 </div>


                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                                        
                                         <button type="submit" class="btn btn-info intext-btn"><?php echo _l('submit'); ?></button>
                                    </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div> 


                </div>

            </div>
        </div>
    </div>
</div>
</div>
</div>


<?php init_tail(); ?>
<?php require 'modules/warehouse/assets/js/warehouse_js.php';?>
</body>
</html>
