  <div class="col-md-12">
     <?php echo form_open_multipart(admin_url('warehouse/stock_summary_report_pdf'), array('id'=>'print_report')); ?>
<div class="row">
    <div class="col-md-12 pull-right">
      <div class=" col-md-4">
          <label><?php echo _l('warehouse_name') ?></label>
          <select name="warehouse_filter[]" id="warehouse_filter" class="selectpicker" multiple="true" data-live-search="true" data-width="100%" data-none-selected-text="" data-actions-box="true">

              <?php foreach($warehouse_filter as $warehouse) { ?>
                <option value="<?php echo html_entity_decode($warehouse['warehouse_id']); ?>"><?php echo html_entity_decode($warehouse['warehouse_name']); ?></option>
                <?php } ?>
            </select>
        </div>

      <div class="col-md-3">
        <?php echo render_date_input('from_date','from_date',date('Y-m-d',strtotime('-7 day',strtotime(date('Y-m-d'))))); ?>
      </div>
      <div class="col-md-3">
        <?php echo render_date_input('to_date','to_date',date('Y-m-d')); ?>
      </div>

      <div class="col-md-2" >
        <a href="#" onclick="get_data_inventory_valuation_report(); return false;" class="btn btn-info display-block button-pdf-margin-top" ><?php echo _l('_filter'); ?></a>
      </div>

    </div>
  </div>

    <?php echo form_close(); ?>
  </div>
<hr class="hr-panel-heading" />
  <div class="col-md-12" id="report">
      <div class="panel panel-info col-md-12 panel-padding">

        <div class="panel-body" id="stock_s_report">
            <p><h3 class="bold text-center"><?php echo mb_strtoupper(_l('inventory_valuation_report')); ?></h3></p>
        
            <div class="col-md-12">
             <table class="table table-bordered">
              <tbody>
               <tr>
                 <th colspan="1"><?php echo _l('_order') ?></th>
                 <th colspan="1"><?php echo _l('commodity_code') ?></th>
                 <th colspan="1"><?php echo _l('commodity_name') ?></th>
                 <th colspan="1"><?php echo _l('unit_name') ?></th>
                 <th colspan="1" class="text-center"><?php echo _l('inventory_number') ?></th>
                 <th colspan="1" class="text-center"><?php echo _l('rate') ?></th>
                 <th colspan="1" class="text-center"><?php echo _l('purchase_price') ?></th>
                 <th colspan="1" class="text-center"><?php echo _l('amount_sold') ?></th>
                 <th colspan="1" class="text-center"><?php echo _l('amount_purchased') ?></th>
                 <th colspan="1" class="text-center"><?php echo _l('expected_profit') ?></th>
                </tr>
                

                <tr>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                  <td>.....</td>
                </tr>
                <tr>
                 <th colspan="4" class="text-right"><?php echo _l('total') ?> : </th>
                 
                 <th colspan="1"></th>
                 <th colspan="1"></th>
                 <th colspan="1"></th>
                 <th colspan="1"></th>
                 <th colspan="1"></th>
                 <th colspan="1"></th>
                 
                </tr>
              </tbody>
            </table>
          </div>


            <br>


            <br>
            <br>
            <br>
            <br>

        </div>
      </div>
  </div>
