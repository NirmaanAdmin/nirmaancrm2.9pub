<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">               
                        <div class="clearfix"></div>
                           <h4>
                              <?php echo html_entity_decode($warehouse_item->warehouse_name); ?>
                           </h4>


                        <hr class="hr-panel-heading" /> 
                        <div class="clearfix"></div> 
                        <div class="col-md-12">

                         <div class="row col-md-12">

                            <h4 class="h4-color"><?php echo _l('general_infor'); ?></h4>
                            <hr class="hr-color">

                            
                            
                            <div class="col-md-12 panel-padding">
                              <table class="table border table-striped table-margintop">
                                  <tbody>

                                      <tr class="project-overview">
                                        <td class="bold" width="30%"><?php echo _l('warehouse_code'); ?></td>
                                        <td><?php echo html_entity_decode($warehouse_item->warehouse_code) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('warehouse_name'); ?></td>
                                        <td><?php echo html_entity_decode($warehouse_item->warehouse_name) ; ?></td>
                                     </tr>
                                     
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('warehouse_address'); ?></td>
                                        <td><?php echo html_entity_decode($warehouse_item->warehouse_address) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('note'); ?></td>
                                        <td><?php echo html_entity_decode($warehouse_item->note) ; ?></td>
                                     </tr>
                                    <tr class="project-overview">
                                        <td class="bold"><?php echo _l('display'); ?></td>
                                        <?php 
                                          if($warehouse_item->display == 0){?>

                                          <td><?php echo _l('not_display') ; ?></td>
                                      <?php }else{ ?>
                                          <td><?php echo _l('display') ; ?></td>

                                      <?php } ?>

                                          
                                         
                                     </tr>
                                    <tr class="project-overview">
                                        <td class="bold"><?php echo _l('order'); ?></td>
                                        <td><?php echo html_entity_decode($warehouse_item->order) ; ?></td>
                                     </tr>
                                    

                                    </tbody>
                              </table>
                          </div>

                            
                            <br>
                        </div>

                                   
                            <table class="table border table-striped ">
                               <tbody>  
                                   <tr class="project-overview">
                                     <td colspan="2">
                                        <div class="horizontal-scrollable-tabs preview-tabs-top">
                                          <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                                            <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                                            <div class="horizontal-tabs">
                                              <ul class="nav nav-tabs nav-tabs-horizontal mbot15" role="tablist">

                                                  <li role="presentation" class="active">
                                                     <a href="#out_of_stock" aria-controls="out_of_stock" role="tab" id="tab_out_of_stock" data-toggle="tab">
                                                        <?php echo _l('inventory_stock') ?>
                                                     </a>
                                                  </li>

                                                  <li role="presentation">
                                                     <a href="#custom_fields" aria-controls="custom_fields" role="tab" id="tab_custom_fields" data-toggle="tab">
                                                        <?php echo _l('custom_fields') ?>
                                                     </a>
                                                  </li>  
                                                                      
                                              </ul>
                                              </div>
                                          </div>

                                          <div class="tab-content col-md-12">

                                            <div role="tabpanel" class="tab-pane active row" id="out_of_stock">
                                              <table class="table dt-table border table-striped">
                                                 
                                                 <thead>
                                                    <th><?php echo _l('commodity_name'); ?></th>
                                                    <th><?php echo _l('inventory_number'); ?></th>
                                                    <th><?php echo _l('unit_name'); ?></th>
                                                    <th><?php echo _l('rate'); ?></th>
                                                    <th><?php echo _l('purchase_price'); ?></th>
                                                    <th><?php echo _l('tax'); ?></th>
                                                    <th><?php echo _l('status'); ?></th>
                                                 </thead>
                                                  <tbody>
                                                    <?php foreach($warehouse_inventory as $wh_inventory){ ?>

                                                      <!-- get item name, code, unit, tax -->
                                                      <?php 
                                                          $item_name='';
                                                          $item_code='';
                                                          $item_unit='';
                                                          $item_tax='';
                                                          $rate='';
                                                          $purchase_price='';

                                                          $status='';

                                                          $item =  get_commodity_name($wh_inventory['commodity_id']);
                                                          if(!is_array($item) && isset($item)){

                                                            $item_name .=$item->commodity_code.'_'.$item->description;

                                                            $rate .= $item->rate;
                                                            $purchase_price .= $item->purchase_price;

                                                            /*get unit*/
                                                            if($item->unit_id != 0 && $item->unit_id != ''){
                                                                $unit_value = get_unit_type($item->unit_id );
                                                                if($unit_value){
                                                                  $item_unit .= $unit_value->unit_name;
                                                                }

                                                            }

                                                            /*get tax*/
                                                            if($item->tax != 0 && $item->tax != ''){
                                                                $tax_value = get_tax_rate($item->tax);
                                                                if($tax_value){
                                                                  $item_tax .= $tax_value->name;
                                                                }

                                                            }
                                                            

                                                          }

                                                          if(get_status_inventory($wh_inventory['commodity_id'], $warehouse_item->warehouse_id)){
                                                              $status .='';
                                                          }else{
                                                              $status .= '<span class="label label-tag tag-id-1 label-tabus"><span class="tag">'._l('unsafe_inventory').'</span><span class="hide">, </span></span>&nbsp';
                                                          }

                                                       ?>

                                                  <?php if(!is_array($item) && isset($item)){ ?> 
                                                    <tr>
                                                        <td><?php echo html_entity_decode($item_name); ?></td>
                                                        <td><?php echo html_entity_decode($wh_inventory['inventory_number']); ?></td>
                                                        <td><?php echo html_entity_decode($item_unit); ?></td>
                                                        <td><?php echo html_entity_decode( app_format_money((float)$rate,'')); ?></td>
                                                        <td><?php echo html_entity_decode(app_format_money((float)$purchase_price,'')); ?></td>
                                                        <td><?php echo html_entity_decode($item_tax); ?></td>

                                                        <td><?php echo html_entity_decode($status); ?></td>

                                                    </tr>
                                                  <?php } ?>

                                                    <?php } ?>
                                                 </tbody>
                                                </table>   
                                                
                                            </div>


                                            <div role="tabpanel" class="tab-pane row" id="custom_fields">
                                              <?php echo wh_render_custom_fields('warehouse_name',$warehouse_item->warehouse_id,[],['warehouse_name' => true]); ?>
                                            </div>
                                                            
                                          </div>                                    
                                     </td>
                                   </tr>
                                   
  
                            
                                </tbody>
                            </table>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php init_tail(); ?>
</body>
</html>

