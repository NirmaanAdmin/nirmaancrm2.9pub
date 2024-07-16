<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
           
             <a href="#" data-toggle="modal" data-table=".table-invoice-items" data-target="#items_bulk_actions" class="hide bulk-actions-btn table-btn"><?php echo _l('bulk_actions'); ?></a>
             <div class="modal fade bulk_actions" id="items_bulk_actions" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
               <div class="modal-content">
                <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title"><?php echo _l('bulk_actions'); ?></h4>
               </div>
               <div class="modal-body">
                 
                   <div class="checkbox checkbox-danger">
                    <input type="checkbox" name="mass_delete" id="mass_delete">
                    <label for="mass_delete"><?php echo _l('mass_delete'); ?></label>
                  </div>
                  <!-- <hr class="mass_delete_separator" /> -->
                
              </div>
              <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
               <a href="#" class="btn btn-info" onclick="items_bulk_action(this); return false;"><?php echo _l('confirm'); ?></a>
             </div>
           </div>
           <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
       </div>
       <!-- /.modal -->
    
     <?php hooks()->do_action('before_items_page_content'); ?>
 
       <div class="_buttons">
        <a href="#" class="btn btn-info pull-left" data-toggle="modal" data-target="#sales_item_modals"><?php echo _l('new_invoice_item'); ?></a>
      </div>
      <div class="clearfix"></div>
      <hr class="hr-panel-heading" />
   
    <?php
    $table_data = [];

   
      $table_data[] = '<span class="hide"> - </span><div class="checkbox mass_select_all_wrap"><input type="checkbox" id="mass_select_all" data-to-table="invoice-items"><label></label></div>';
    
  ?>
  <table class="table dt-table invoice-items" data-order-col="3" data-order-type="desc">
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
    	<?php foreach($items as $item){?>
   <tr>
     
      <td>
         <a href="#" data-toggle="modal" data-target="#sales_item_modals" data-id="<?php echo $item['itemid']?>"><?php echo $item['description'];?></a>
         <div class="row-options"><a href="#" data-toggle="modal" data-target="#sales_item_modals" data-id="<?php echo $item['itemid']?>">Edit </a> | <a href="<?php echo site_url();?>supplier/product_services/delete/<?php echo $item['itemid']?>" class="text-danger _delete">Delete </a></div>
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
</div>
</div>
</div>
</div>
</div>
<?php $this->load->view('client/item'); ?>


