
<div role="tabpanel" class="tab-pane" id="product_services">
         
            <?php if (has_permission('items', '', 'create') || has_permission('items', '', 'edit')) { ?>
            <a href="#" class="btn btn-info mbot30" data-toggle="modal" data-target="#sales_item_modals"><?php echo _l('new_invoice_item'); ?></a>
            <?php } ?>
        
           
              <table class="table dt-table invoice-items"  data-order-type="desc">
                  <thead>
                    <tr>
                      <th class="th-invoice-items-description"><?php echo _l('invoice_items_list_description'); ?></th>
                      <th class="th-invoice-items-long_description"><?php echo _l('invoice_item_long_description'); ?></th>
                      <th class="th-invoice-items-rate"><?php echo _l('invoice_items_list_rate'); ?></th>
                      <th class="th-invoice-items-tax_1"><?php echo _l('tax_1'); ?></th>
                      <th class="th-invoice-items-tax_2"><?php echo _l('tax_2'); ?></th>
                      <th class="th-invoice-items-unit"><?php echo _l('unit'); ?></th>
                      <th class="th-invoice-items-group_name"><?php echo _l('item_group_name'); ?></th>
                      
                    </tr>
                  </thead>
                <tbody>
                    <?php foreach($items as $item){
                        ?>
               <tr>
                 
                  <td>
                     <a href="#" data-toggle="modal" data-target="#sales_item_modals" data-id="<?php echo $item['itemid']?>"><?php echo $item['description'];?></a>
                     <div class="row-options"><a href="#" data-toggle="modal" data-target="#sales_item_modals" data-id="<?php echo $item['itemid']?>">Edit </a> | <a href="<?php echo admin_url();?>supplier/delete_item/<?php echo $item['itemid']?>/<?php echo $client->userid?>" class="text-danger _delete">Delete </a></div>
                  </td>
                  <td><?php echo $item['long_description'];?></td>
                  <td><?php echo $item['rate'];?></td>
                  <td><span data-toggle="tooltip" title="" data-taxid=""><?php echo $item['taxname'] ? $item['taxname'].'%' : '0%';?></span></td>
                  <td><span data-toggle="tooltip" title="" data-taxid=""><?php echo $item['taxname_2'] ? $item['taxname_2'].'%' : '0%';?></span></td>
                  <td><?php echo $item['unit'];?></td>
                  <td><?php echo $item['group_name'];?></td>
               </tr>
            <?php } ?>
            </tbody>
            </table>
         </div>
         <?php $CI->load->view(MODULE_SUPPLIER . '/admin/suppliers/items/items'); ?>
         <div class="checkbox checkbox-primary no-mtop checkbox-inline task-add-edit-public" style=" display:none;">
                     <input type="checkbox" id="is_supplier" name="is_supplier" checked>
                     <label for="is_supplier"><?= _l('is_supplier') ?></label>
          </div>
          