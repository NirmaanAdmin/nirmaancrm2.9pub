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
                              <?php echo html_entity_decode($commodity_item->description); ?>
                           </h4>


                        <hr class="hr-panel-heading" /> 
                        <div class="clearfix"></div> 
                        <div class="col-md-12">

                         <div class="row col-md-12">

                            <h4 class="h4-color"><?php echo _l('general_infor'); ?></h4>
                            <hr class="hr-color">

                            
                            
                            <div class="col-md-7 panel-padding">
                              <table class="table border table-striped table-margintop">
                                  <tbody>

                                      <tr class="project-overview">
                                        <td class="bold" width="30%"><?php echo _l('commodity_code'); ?></td>
                                        <td><?php echo html_entity_decode($commodity_item->commodity_code) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('commodity_name'); ?></td>
                                        <td><?php echo html_entity_decode($commodity_item->description) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('commodity_group'); ?></td>
                                        <td><?php echo get_wh_group_name(html_entity_decode($commodity_item->group_id)) != null ? get_wh_group_name(html_entity_decode($commodity_item->group_id))->name : '' ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('commodity_barcode'); ?></td>
                                        <td><?php echo html_entity_decode($commodity_item->commodity_barcode) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('sku_code'); ?></td>
                                        <td><?php echo html_entity_decode($commodity_item->sku_code) ; ?></td>
                                     </tr>
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('sku_name'); ?></td>
                                        <td><?php echo html_entity_decode($commodity_item->sku_name) ; ?></td>
                                     </tr>
                                     
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('tags'); ?></td>
                                        <td>
                                          <div class="form-group">
                                            <div id="inputTagsWrapper">
                                               <input type="text" class="tagsinput" id="tags" name="tags" value="<?php echo (isset($commodity_item) ? prep_tags_input(get_tags_in($commodity_item->id,'item_tags')) : ''); ?>" data-role="tagsinput">
                                            </div>
                                          </div>

                                        </td>
                                     </tr>

                                    

                                    </tbody>
                              </table>
                          </div>

                            <div class="gallery">
                                <div class="wrapper-masonry">
                                  <div id="masonry" class="masonry-layout columns-3">
                                <?php if(isset($commodity_file) && count($commodity_file) > 0){ ?>
                                  <?php foreach ($commodity_file as $key => $value) { ?>

                                      <?php if(file_exists(WAREHOUSE_ITEM_UPLOAD .$value["rel_id"].'/'.$value["file_name"])){ ?>
                                          <a  class="images_w_table" href="<?php echo site_url('modules/warehouse/uploads/item_img/'.$value["rel_id"].'/'.$value["file_name"]); ?>"><img class="images_w_table" src="<?php echo site_url('modules/warehouse/uploads/item_img/'.$value["rel_id"].'/'.$value["file_name"]); ?>" alt="<?php echo html_entity_decode($value['file_name']) ?>"/></a>
                                           
                                        <?php }elseif(file_exists('modules/purchase/uploads/item_img/' . $value["rel_id"] . '/' . $value["file_name"])) { ?>
                                          <a  class="images_w_table" href="<?php echo site_url('modules/purchase/uploads/item_img/'.$value["rel_id"].'/'.$value["file_name"]); ?>"><img class="images_w_table" src="<?php echo site_url('modules/purchase/uploads/item_img/'.$value["rel_id"].'/'.$value["file_name"]); ?>" alt="<?php echo html_entity_decode($value['file_name']) ?>"/></a>
                                            

                                        <?php } ?>


                                <?php } ?>
                              <?php }else{ ?>

                                    <a  href="<?php echo site_url('modules/warehouse/uploads/nul_image.jpg'); ?>"><img class="images_w_table" src="<?php echo site_url('modules/warehouse/uploads/nul_image.jpg'); ?>" alt="nul_image.jpg"/></a>

                              <?php } ?>
                                <div class="clear"></div>
                              </div>
                            </div>
                            </div>
                            <br>
                        </div>


                         <h4 class="h4-color"><?php echo _l('infor_detail'); ?></h4>
                          <hr class="hr-color">
                          <div class="col-md-6 panel-padding" >
                            <table class="table border table-striped table-margintop" >
                                <tbody>
                                   <tr class="project-overview">
                                      <td class="bold td-width"><?php echo _l('origin'); ?></td>
                                        <td><?php echo html_entity_decode($commodity_item->origin) ; ?></td>
                                   </tr>
                                   <tr class="project-overview">
                                      <td class="bold"><?php echo _l('colors'); ?></td>
                                        <?php
                                    $color_value ='';
                                    if($commodity_item->color){
                                      $color = get_color_type($commodity_item->color);
                                      if($color){
                                        $color_value .= $color->color_code.'_'.$color->color_name;
                                      }
                                    }
                                     ?>
                                      <td><?php echo html_entity_decode($color_value) ; ?></td>
                                   </tr>
                                   <tr class="project-overview">
                                      <td class="bold"><?php echo _l('styles'); ?></td>
                                    <td><?php  if($commodity_item->style_id != null){ echo get_style_name(html_entity_decode($commodity_item->style_id)) != null ? get_style_name(html_entity_decode($commodity_item->style_id))->style_name : '';}else{echo '';} ?></td>
                                   </tr>

                                    <tr class="project-overview">
                                      <td class="bold"><?php echo _l('rate'); ?></td>
                                      <td><?php echo app_format_money((float)$commodity_item->rate,'') ; ?></td>
                                   </tr>

                                   <tr class="project-overview">
                                      <td class="bold"><?php echo _l('_profit_rate_p'); ?></td>
                                      <td><?php echo html_entity_decode($commodity_item->profif_ratio) ; ?></td>
                                   </tr>
                                   

                                </tbody>
                            </table>
                          </div>
                           
                          <div class="col-md-6 panel-padding" >
                            <table class="table table-striped table-margintop">
                                <tbody>
                                   <tr class="project-overview">
                                      <td class="bold" width="40%"><?php echo _l('model_id'); ?></td>
                                       <td><?php if($commodity_item->style_id != null){ echo get_model_name(html_entity_decode($commodity_item->model_id)) != null ? get_model_name(html_entity_decode($commodity_item->model_id))->body_name : ''; }else{echo '';}?></td>
                                   </tr>
                                   <tr class="project-overview">
                                      <td class="bold"><?php echo _l('size_id'); ?></td>

                                      <td><?php if($commodity_item->style_id != null){ echo get_size_name(html_entity_decode($commodity_item->size_id)) != null ? get_size_name(html_entity_decode($commodity_item->size_id))->size_name : ''; }else{ echo '';}?></td>
                                   </tr>
                                   
                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('unit_id'); ?></td>
                                        <td><?php echo  $commodity_item->unit_id != '' && get_unit_type($commodity_item->unit_id) != null ? get_unit_type($commodity_item->unit_id)->unit_name : ''; ?></td>
                                     </tr> 

                                     <tr class="project-overview">
                                        <td class="bold"><?php echo _l('purchase_price'); ?></td>
                                        <td><?php echo app_format_money((float)$commodity_item->purchase_price,'') ; ?></td>
                                     </tr>

                                      <tr class="project-overview">
                                        <td class="bold"><?php echo _l('guarantee'); ?></td>
                                        <td><?php echo html_entity_decode($commodity_item->guarantee) ._l('month_label'); ?></td>
                                      </tr>
                                     
                                  
                                  
                                  </tbody>
                                </table>
                          </div>
                          <div class=" row ">
                            <div class="col-md-12">
                             <h4 class="h4-color"><?php echo _l('description'); ?></h4>
                            <hr class="hr-color">
                            <h5><?php echo html_entity_decode($commodity_item->long_description) ; ?></h5>
                              
                            </div>
                              
                          </div>
                          
                          <div class=" row ">
                            <div class="col-md-12">
                             <h4 class="h4-color"><?php echo _l('long_description'); ?></h4>
                            <hr class="hr-color">
                            <h5><?php echo html_entity_decode($commodity_item->long_descriptions) ; ?></h5>
                              
                            </div>
                              
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

                                                  <li role="presentation" >
                                                     <a href="#expiry_date" aria-controls="expiry_date" role="tab" id="tab_expiry_date" data-toggle="tab">
                                                        <?php echo _l('expiry_date') ?>
                                                     </a>
                                                  </li>

                                                  <li role="presentation">
                                                     <a href="#history" aria-controls="history" role="tab" id="tab_history" data-toggle="tab">
                                                        <?php echo _l('transaction_history') ?>
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
                                                <?php render_datatable(array(
                                                 _l('id'),
                                                  _l('commodity_name'),
                                                  _l('expiry_date'),
                                                  _l('lot_number'),
                                                  _l('warehouse_name'),
                                              
                                                  _l('inventory_number'),
                                                  _l('unit_name'),
                                                  _l('rate'),
                                                  _l('purchase_price'),
                                                  _l('tax'),
                                                  _l('status_label'),
                                                 
                                                  ),'table_inventory_stock'); ?>
                                            </div>

                                            <div role="tabpanel" class="tab-pane  row" id="expiry_date">
                                                    <?php render_datatable(array(
                                                  _l('commodity_name'),
                                                  _l('expiry_date'),
                                                  _l('lot_number'),
                                                  _l('warehouse_name'),
                                              
                                                  _l('inventory_number'),
                                                  _l('unit_name'),
                                                  _l('rate'),
                                                  _l('purchase_price'),
                                                  _l('tax'),
                                                  _l('status_label'),
                                                 
                                                  ),'table_view_commodity_detail',['proposal_sm' => 'proposal_sm']); ?>
                                            </div>

                                            <div role="tabpanel" class="tab-pane row" id="history">
                                                <?php render_datatable(array(
                                              _l('id'),
                                              _l('form_code'),
                                              _l('commodity_code'),
                                              _l('description'),
                                              _l('warehouse_code'),
                                              _l('warehouse_name'),
                                              _l('day_vouchers'),
                                              _l('old_quantity'),
                                              _l('new_quantity'),
                                              _l('lot_number').'/'._l('quantity'),
                                              _l('expiry_date'),
                                              _l('note'),
                                              _l('status_label'),
                                              ),'table_warehouse_history'); ?>
                                            </div>  

                                            <div role="tabpanel" class="tab-pane row" id="custom_fields">
                                              <?php echo render_custom_fields('items',$commodity_item->id,[],['items_pr' => true]); ?>
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
<?php echo form_hidden('commodity_id'); ?>

<?php init_tail(); ?>
<?php require 'modules/warehouse/assets/js/view_commodity_detail_js.php';?>
<?php require 'modules/warehouse/assets/js/commodity_detail_js.php';?>
</body>
</html>

