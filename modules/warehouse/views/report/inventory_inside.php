
  <div class="row row-margin-bottom">

    <!-- update filter by warehouse -->
    <div class=" col-md-3 pull-right">
        <label><?php echo _l('warehouse_name') ?></label>
        <select name="warehouse_filter[]" id="warehouse_filter" class="selectpicker" multiple="true" data-live-search="true" data-width="100%" data-none-selected-text="" data-actions-box="true">

            <?php foreach($warehouse_filter as $warehouse) { ?>
              <option value="<?php echo html_entity_decode($warehouse['warehouse_id']); ?>"><?php echo html_entity_decode($warehouse['warehouse_name']); ?></option>
              <?php } ?>
          </select>
    </div>

   <div class=" col-md-3 pull-right">
    <div class="form-group">
      <label><?php echo _l('commodity'); ?>  </label>
      <select name="commodity_filter[]" id="commodity_filter" class="selectpicker" data-live-search="true" multiple="true" data-width="100%" data-none-selected-text="" data-actions-box="true">

          <?php foreach($commodity_filter as $commodity) { ?>
            <option value="<?php echo html_entity_decode($commodity['id']); ?>"><?php echo html_entity_decode($commodity['description']); ?></option>
            <?php } ?>
        </select>
    </div>
  </div>

    <div class=" col-md-3 pull-right">
      <?php echo render_input('profit_rate_search','exchange_profit_margin_differences_','',''); ?>
    </div>
    
  </div>
  <br/>

  <div class="row">
    <div class="col-md-12">
    <?php 
    $table_data = array(
                        _l('commodity_name'),
                        _l('_profit_rate_p'),
                        _l('purchase_price'),
                        _l('rate'),
                        _l('average_price_of_inventory'),
                        _l('profit_rate_inventory'),
                        _l('exchange_profit_margin_differences'),
                                                 
                      );
    render_datatable($table_data,'table_inventory_inside',
        array('customizable-table')
        ); ?>

    </div>
  </div>


</body>
</html>
