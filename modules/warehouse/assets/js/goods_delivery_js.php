<script>
  var purchase;
  var warehouses;

(function($) {
"use strict";  
 
  appValidateForm($('#add_goods_delivery'), {
     date_c: 'required',
     date_add: 'required',
     // invoice_id: 'required',
     <?php  /* if($pr_orders_status == true && get_warehouse_option('goods_delivery_required_po') == 1){  ?>
      pr_order_id: 'required',
     <?php } ?> */ ?>
    
   }); 

<?php if(!isset($goods_delivery)){ ?>
  var warehouses ={};
  //hansometable for purchase
  var row_global;
  var dataObject_pu = [];
  var
    hotElement1 = document.getElementById('hot_purchase');

  purchase = new Handsontable(hotElement1, {
    licenseKey: 'non-commercial-and-evaluation',

    contextMenu: true,
    manualRowMove: true,
    manualColumnMove: true,
    stretchH: 'all',
    autoWrapRow: true,
    rowHeights: 30,
    defaultRowHeight: 100,
    minRows: 20,
    maxRows: 40,
    width: '100%',
    height: 330,

    rowHeaders: true,
    colHeaders: true,
    autoColumnSize: {
      samplingRatio: 23
    },
   
    filters: true,
    manualRowResize: true,
    manualColumnResize: true,
    allowInsertRow: true,
    allowRemoveRow: true,
    columnHeaderHeight: 40,

    colWidths: [110, 100,120,80, 100,80, 100,120,120,120,120,120,120,150],
    rowHeights: 30,
    rowHeaderWidth: [44],

    columns: [
                {
                  type: 'text',
                  data: 'commodity_code',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($commodity_code_name); ?>
                  }
                },
                 {
                  type: 'text',
                  data: 'warehouse_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($units_warehouse_name); ?>
                  }
                  
                },
                {
                  type: 'numeric',
                  data:'available_quantity',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true
                },
                {
                  
                  type: 'text',
                  data: 'unit_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($units_code_name); ?>
                  },
                  readOnly: true

                },
                {
                  type: 'numeric',
                  data:'quantities',
                  numericFormat: {
                    pattern: '0,00',
                  }
                },
                {
                  type: 'numeric',
                  data: 'rate',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  
                      
                },
               {
                  data: 'tax_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($taxes); ?>
                  }
                },
                {
                  type: 'numeric',
                  data: 'total_money',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true

                      
                },
                {
                  data: 'discount',
                  type: 'numeric',
                  renderer: customRenderer
                },             
                {
                  data: 'discount_money',
                  type: 'numeric',
                  numericFormat: {
                    pattern: '0,0'
                  },
                  readOnly: true
                },
                {
                  data: 'total_after_discount',
                  type: 'numeric',
                  numericFormat: {
                    pattern: '0,0'
                  },
                  readOnly: true
                },
                {
                  type: 'text',
                  data: 'guarantee_period',
                  readOnly: true
                },
                {
                  type: 'text',
                  data: 'note',
                },
             
                
              ],

          colHeaders: [
        '<?php echo _l('commodity_code'); ?>',
        '<?php echo _l('warehouse_name'); ?>',
        '<?php echo _l('available_quantity'); ?>',
        '<?php echo _l('unit_id'); ?>',
        '<?php echo _l('quantity'); ?>',
        '<?php echo _l('rate'); ?>',
        '<?php echo _l('tax_rate')._l(' %'); ?>',
        '<?php echo _l('subtotal'); ?>',
        '<?php echo _l('discount(%)').'(%)'; ?>',
        '<?php echo _l('discount(money)'); ?>',
        '<?php echo _l('total_money'); ?>',
        '<?php echo _l('guarantee_period'); ?>',
        '<?php echo _l('note'); ?>',
        
      ],
   
    data: dataObject_pu,
  });

<?php }else{ ?>

 
  <?php if(isset($goods_delivery_detail)){?>
    var dataObject_pu = <?php echo html_entity_decode($goods_delivery_detail); ?>;
  <?php }else{ ?>
    var dataObject_pu = [];
  <?php } ?>

  var warehouses ={};
  //hansometable for purchase
  var row_global;
  var hotElement1 = document.getElementById('hot_purchase');

  //edit note affter approval
  <?php if($edit_approval == 'true'){ ?>

    purchase = new Handsontable(hotElement1, {
    licenseKey: 'non-commercial-and-evaluation',

    contextMenu: true,
    manualRowMove: true,
    manualColumnMove: true,
    stretchH: 'all',
    autoWrapRow: true,
    rowHeights: 30,
    defaultRowHeight: 100,
    minRows: 20,
    maxRows: 40,
    width: '100%',
    height: 330,

    rowHeaders: true,
    colHeaders: true,
    autoColumnSize: {
      samplingRatio: 23
    },
   
    filters: true,
    manualRowResize: true,
    manualColumnResize: true,
    allowInsertRow: true,
    allowRemoveRow: true,
    columnHeaderHeight: 40,

    colWidths: [110, 100,120,80, 100,80, 100,120,120,120,120,120,120,150],
    rowHeights: 30,
    rowHeaderWidth: [44],

    hiddenColumns: {
      columns: [13],
      indicators: true
    },

    columns: [
                {
                  type: 'text',
                  data: 'commodity_code',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($commodity_code_name); ?>
                  },
                  readOnly: true
                },
                 {
                  type: 'text',
                  data: 'warehouse_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($units_warehouse_name); ?>
                  },
                  readOnly: true
                  
                },
                {
                  type: 'numeric',
                  data:'available_quantity',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true
                },
                {
                  
                  type: 'text',
                  data: 'unit_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($units_code_name); ?>
                  },
                  readOnly: true

                },
                {
                  type: 'numeric',
                  data:'quantities',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true
                },
                {
                  type: 'numeric',
                  data: 'unit_price',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true
                      
                },
               {
                  data: 'tax_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($taxes); ?>
                  },
                  readOnly: true

                },
                {
                  type: 'numeric',
                  data: 'total_money',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true

                      
                },
                {
                  data: 'discount',
                  type: 'numeric',
                  renderer: customRenderer,
                  readOnly: true

                },             
                {
                  data: 'discount_money',
                  type: 'numeric',
                  numericFormat: {
                    pattern: '0,0'
                  },
                  readOnly: true
                },
                {
                  data: 'total_after_discount',
                  type: 'numeric',
                  numericFormat: {
                    pattern: '0,0'
                  },
                  readOnly: true
                },
                {
                  type: 'text',
                  data: 'guarantee_period',
                  readOnly: true
                },
                {
                  type: 'text',
                  data: 'note',
                },
                {
                  type: 'text',
                  data: 'id',
                },
             
                
              ],

          colHeaders: [
        '<?php echo _l('commodity_code'); ?>',
        '<?php echo _l('warehouse_name'); ?>',
        '<?php echo _l('available_quantity'); ?>',
        '<?php echo _l('unit_id'); ?>',
        '<?php echo _l('quantity'); ?>',
        '<?php echo _l('rate'); ?>',
        '<?php echo _l('tax_rate')._l(' %'); ?>',
        '<?php echo _l('subtotal'); ?>',
        '<?php echo _l('discount(%)').'(%)'; ?>',
        '<?php echo _l('discount(money)'); ?>',
        '<?php echo _l('total_money'); ?>',
         '<?php echo _l('guarantee_period'); ?>',
        '<?php echo _l('note'); ?>',
        '<?php echo _l('id_delivery_detail'); ?>',
        
      ],
   
    data: dataObject_pu,
  });
  <?php }else{ ?>

  purchase = new Handsontable(hotElement1, {
    licenseKey: 'non-commercial-and-evaluation',

    contextMenu: true,
    manualRowMove: true,
    manualColumnMove: true,
    stretchH: 'all',
    autoWrapRow: true,
    rowHeights: 30,
    defaultRowHeight: 100,
    minRows: 20,
    maxRows: 40,
    width: '100%',
    height: 330,

    rowHeaders: true,
    colHeaders: true,
    autoColumnSize: {
      samplingRatio: 23
    },
   
    filters: true,
    manualRowResize: true,
    manualColumnResize: true,
    allowInsertRow: true,
    allowRemoveRow: true,
    columnHeaderHeight: 40,

    colWidths: [110, 100,120,80, 100,80, 100,120,120,120,120,120,120,150],
    rowHeights: 30,
    rowHeaderWidth: [44],

    columns: [
                {
                  type: 'text',
                  data: 'commodity_code',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($commodity_code_name); ?>
                  }
                },
                 {
                  type: 'text',
                  data: 'warehouse_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($units_warehouse_name); ?>
                  }
                  
                },
                {
                  type: 'numeric',
                  data:'available_quantity',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true
                },
                {
                  
                  type: 'text',
                  data: 'unit_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($units_code_name); ?>
                  },
                  readOnly: true

                },
                {
                  type: 'numeric',
                  data:'quantities',
                  numericFormat: {
                    pattern: '0,00',
                  }
                },
                {
                  type: 'numeric',
                  data: 'unit_price',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  
                      
                },
               {
                  data: 'tax_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($taxes); ?>
                  }
                },
                {
                  type: 'numeric',
                  data: 'total_money',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true

                      
                },
                {
                  data: 'discount',
                  type: 'numeric',
                  renderer: customRenderer
                },             
                {
                  data: 'discount_money',
                  type: 'numeric',
                  numericFormat: {
                    pattern: '0,0'
                  },
                  readOnly: true
                },
                {
                  data: 'total_after_discount',
                  type: 'numeric',
                  numericFormat: {
                    pattern: '0,0'
                  },
                  readOnly: true
                },
                {
                  type: 'text',
                  data: 'guarantee_period',
                  readOnly: true
                },
                {
                  type: 'text',
                  data: 'note',
                },
             
                
              ],

          colHeaders: [
        '<?php echo _l('commodity_code'); ?>',
        '<?php echo _l('warehouse_name'); ?>',
        '<?php echo _l('available_quantity'); ?>',
        '<?php echo _l('unit_id'); ?>',
        '<?php echo _l('quantity'); ?>',
        '<?php echo _l('rate'); ?>',
        '<?php echo _l('tax_rate')._l(' %'); ?>',
        '<?php echo _l('subtotal'); ?>',
        '<?php echo _l('discount(%)').'(%)'; ?>',
        '<?php echo _l('discount(money)'); ?>',
        '<?php echo _l('total_money'); ?>',
         '<?php echo _l('guarantee_period'); ?>',
        '<?php echo _l('note'); ?>',
        
      ],
   
    data: dataObject_pu,
  });

  <?php } ?>

<?php } ?>


 })(jQuery);


var purchase_value = purchase;
(function($) {
"use strict";  
 
  purchase.addHook('afterChange', function(changes, src) {
    if(changes !== null){
      changes.forEach(([row, col, prop, oldValue, newValue]) => {
       
          var row_global = row;
          if(col == 'commodity_code' && oldValue != '')
          {
            $.post(admin_url + 'warehouse/commodity_goods_delivery_change/'+oldValue ).done(function(response){
            var  response = JSON.parse(response);
                    console.log(response);
              purchase.setDataAtCell(row,3, response.value.unit_id);
              purchase.setDataAtCell(row,4, '');
              purchase.setDataAtCell(row,5, response.value.rate);
              purchase.setDataAtCell(row,6, response.value.tax);
              purchase.setDataAtCell(row,7, '');
              purchase.setDataAtCell(row,8, '');
              purchase.setDataAtCell(row,9, '');
              purchase.setDataAtCell(row,11, response.guarantee_new);

              warehouses = response.warehouse_inventory;
            });

            //get available quantity
            row_global = row;
            var data={};
            var warehouse_id = $('select[name="warehouse_id"]').val();
            if($.isNumeric(warehouse_id)){

              data.warehouse_id = $('select[name="warehouse_id"]').val();
            }else{
              data.warehouse_id = purchase.getDataAtCell(row, 1);

            }

            data.commodity_id = purchase.getDataAtCell(row, 0);
            data.quantity = purchase.getDataAtCell(row, 4);

            $.post(admin_url + 'warehouse/check_quantity_inventory', data).done(function(response){
              response = JSON.parse(response);
              
              purchase.setDataAtCell(row,2,response.value);

            });

          }

          if(col == 'commodity_code' && oldValue == '')
          {
            purchase.setDataAtCell(row,1,'');
            purchase.setDataAtCell(row,2,'');
            purchase.setDataAtCell(row,3,'');
            purchase.setDataAtCell(row,4,'');
            purchase.setDataAtCell(row,5,'');
            purchase.setDataAtCell(row,6,'');
            purchase.setDataAtCell(row,7,'');
            purchase.setDataAtCell(row,11,'');
          }

          if(col == 'quantities' && $.isNumeric(oldValue) && purchase.getDataAtCell(row_global,0) != '' && purchase.getDataAtCell(row_global,0) != 'null' && purchase.getDataAtCell(row_global,0) != null )
          {

            row_global = row;
            var data={};
            var warehouse_id = $('select[name="warehouse_id"]').val();
            if($.isNumeric(warehouse_id)){

              data.warehouse_id = $('select[name="warehouse_id"]').val();
            }else{
              data.warehouse_id = purchase.getDataAtCell(row, 1);

            }

            data.commodity_id = purchase.getDataAtCell(row, 0);
            data.quantity = purchase.getDataAtCell(row, 4);

            $.post(admin_url + 'warehouse/check_quantity_inventory', data).done(function(response){
              response = JSON.parse(response);
              if(response.message != true){
                if(response.value != 0){
                  alert_float('danger', response.message+response.value+' <?php echo _l('product') ?>');
                  
                  purchase.setCellMeta(row_global, 4, 'className', 'border');
                  purchase.render()

                }else{
                  alert_float('danger', response.message);

                  purchase.setCellMeta(row_global, 4, 'className', 'border');
                  purchase.render()
                }
              }else{
                  purchase.setCellMeta(row_global, 4, 'className', 'border-none');
                  purchase.render()
                  //set value
                  var total_money =0;

                   //get tax value
                  var tax_id = purchase.getDataAtCell(row,6);

                  if(tax_id){

                    $.post(admin_url + 'warehouse/tax_change/'+tax_id).done(function(response){
                        response = JSON.parse(response);

                      purchase.setDataAtCell(row,7, (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)));

                      purchase.setDataAtCell(row,9, ((purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 +(purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)))*purchase.getDataAtCell(row,8)/100 );

                      purchase.setDataAtCell(row,10, (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)) - ((purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)))*purchase.getDataAtCell(row,8)/100);                   

                    });
                  }else{

                    purchase.setDataAtCell(row,7,oldValue*purchase.getDataAtCell(row,5));
                    purchase.setDataAtCell(row,9,oldValue*purchase.getDataAtCell(row,5)*purchase.getDataAtCell(row,8)/100);
                    purchase.setDataAtCell(row,10,oldValue*purchase.getDataAtCell(row,5)-(purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5))*purchase.getDataAtCell(row,8)/100);
                  }

                  for (var row_index = 0; row_index <= 40; row_index++) {
                    total_money += purchase.getDataAtCell(row_index, 4)*purchase.getDataAtCell(row_index, 5);
                  }

                  $('input[name="total_money"]').val((total_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
              }
              purchase.setDataAtCell(row,2,response.value);

            });
          }else if(col == 'warehouse_id' && oldValue != '' && $.isNumeric(oldValue) && purchase.getDataAtCell(row_global,0) != null )
          {

            row_global = row;
            var data={};
            var warehouse_id = $('select[name="warehouse_id"]').val();
            if($.isNumeric(warehouse_id)){

              data.warehouse_id = $('select[name="warehouse_id"]').val();
            }else{
              data.warehouse_id = purchase.getDataAtCell(row, 1);

            }

            data.commodity_id = purchase.getDataAtCell(row, 0);
            data.quantity = purchase.getDataAtCell(row, 4);

            $.post(admin_url + 'warehouse/check_quantity_inventory', data).done(function(response){
              response = JSON.parse(response);
              
              purchase.setDataAtCell(row,2,response.value);

            });

          }
          else if(col == 'rate' && purchase.getDataAtCell(row_global,0) != null && purchase.getDataAtCell(row_global,1) != null  )
          {
            row_global = row;
            var data={};
            var warehouse_id = $('select[name="warehouse_id"]').val();
            if($.isNumeric(warehouse_id)){

              data.warehouse_id = $('select[name="warehouse_id"]').val();
            }else{
              data.warehouse_id = purchase.getDataAtCell(row, 1);

            }

            data.commodity_id = purchase.getDataAtCell(row, 0);
            data.quantity = purchase.getDataAtCell(row, 4);

            $.post(admin_url + 'warehouse/check_quantity_inventory', data).done(function(response){
              response = JSON.parse(response);
              if(response.message != true){
                if(response.value != 0){
                  alert_float('danger', response.message+response.value+' <?php echo _l('product') ?>');
                  
                  purchase.setCellMeta(row_global, 4, 'className', 'border');
                  purchase.render()

                }else{
                  alert_float('danger', response.message);

                  purchase.setCellMeta(row_global, 4, 'className', 'border');
                  purchase.render()
                }
              }else{
                  purchase.setCellMeta(row_global, 4, 'className', 'border-none');
                  purchase.render()
                  //set value
                  var total_money =0;

                   //get tax value
                  var tax_id = purchase.getDataAtCell(row,6);

                  if(tax_id){

                    $.post(admin_url + 'warehouse/tax_change/'+tax_id).done(function(response){
                        response = JSON.parse(response);

                      purchase.setDataAtCell(row,7, (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)));

                      purchase.setDataAtCell(row,9, ((purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 +(purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)))*purchase.getDataAtCell(row,8)/100 );

                      purchase.setDataAtCell(row,10, (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)) - ((purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)))*purchase.getDataAtCell(row,8)/100);                   

                    });
                  }else{

                    purchase.setDataAtCell(row,7,oldValue*purchase.getDataAtCell(row,5));
                    purchase.setDataAtCell(row,9,oldValue*purchase.getDataAtCell(row,5)*purchase.getDataAtCell(row,8)/100);
                    purchase.setDataAtCell(row,10,oldValue*purchase.getDataAtCell(row,5)-(purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5))*purchase.getDataAtCell(row,8)/100);
                  }


                  
                  for (var row_index = 0; row_index <= 20; row_index++) {
                    total_money += purchase.getDataAtCell(row_index, 4)*purchase.getDataAtCell(row_index, 5);
                  }

                  $('input[name="total_money"]').val((total_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
              }
            });

          }

          else if(col == 'unit_price' && purchase.getDataAtCell(row_global,0) != null && purchase.getDataAtCell(row_global,1) != null  )
          {
            row_global = row;
            var data={};
            var warehouse_id = $('select[name="warehouse_id"]').val();
            if($.isNumeric(warehouse_id)){

              data.warehouse_id = $('select[name="warehouse_id"]').val();
            }else{
              data.warehouse_id = purchase.getDataAtCell(row, 1);

            }

            data.commodity_id = purchase.getDataAtCell(row, 0);
            data.quantity = purchase.getDataAtCell(row, 4);

            $.post(admin_url + 'warehouse/check_quantity_inventory', data).done(function(response){
              response = JSON.parse(response);
              if(response.message != true){
                if(response.value != 0){
                  alert_float('danger', response.message+response.value+' <?php echo _l('product') ?>');
                  
                  purchase.setCellMeta(row_global, 4, 'className', 'border');
                  purchase.render()

                }else{
                  alert_float('danger', response.message);

                  purchase.setCellMeta(row_global, 4, 'className', 'border');
                  purchase.render()
                }
              }else{
                  purchase.setCellMeta(row_global, 4, 'className', 'border-none');
                  purchase.render()
                  //set value
                  var total_money =0;
                
                   //get tax value
                  var tax_id = purchase.getDataAtCell(row,6);

                  if(tax_id){

                    $.post(admin_url + 'warehouse/tax_change/'+tax_id).done(function(response){
                        response = JSON.parse(response);

                      purchase_value.setDataAtCell(row,7, (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)));

                      purchase.setDataAtCell(row,9, ((purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 +(purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)))*purchase.getDataAtCell(row,8)/100 );

                      purchase.setDataAtCell(row,10, (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)) - ((purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)))*purchase.getDataAtCell(row,8)/100);                   

                    });
                  }else{

                    purchase.setDataAtCell(row,7,oldValue*purchase.getDataAtCell(row,5));
                    purchase.setDataAtCell(row,9,oldValue*purchase.getDataAtCell(row,5)*purchase.getDataAtCell(row,8)/100);
                    purchase.setDataAtCell(row,10,oldValue*purchase.getDataAtCell(row,5)-(purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5))*purchase.getDataAtCell(row,8)/100);
                  }


                  
                  for (var row_index = 0; row_index <= 20; row_index++) {
                    total_money += purchase.getDataAtCell(row_index, 4)*purchase.getDataAtCell(row_index, 5);
                  }

                  $('input[name="total_money"]').val((total_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
              }
            });

          }
          else if(col == 'tax_id' && oldValue != ''){
                  //get tax
                  var tax_value = 0;
                  console.log(oldValue);
                $.post(admin_url + 'warehouse/tax_change/'+oldValue).done(function(response){
                    response = JSON.parse(response);
                    
                    purchase.setDataAtCell(row,7, (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)));
                    
                    purchase.setDataAtCell(row,9, ((purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 +(purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)))*purchase.getDataAtCell(row,8)/100 );


                    purchase.setDataAtCell(row,10, (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)) - ((purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)*response.tax_rate)/100 + (purchase.getDataAtCell(row,4)*purchase.getDataAtCell(row,5)))*purchase.getDataAtCell(row,8)/100);  

                    tax_value = response.tax_rate;


                    

                  });




          }
          else  if(col == 'quantities' && oldValue != '' && !$.isNumeric(oldValue))
          {
            alert_float('danger', "<?php echo _l('data_invalid') ; ?>");
            purchase.setCellMeta(row_global, 4, 'className', 'border');
            purchase.render()
          }else if(col == 'quantities' && $.isNumeric(oldValue))
          {
            purchase.setCellMeta(row_global, 4, 'className', 'border-none');
            purchase.render()
          }
          else if(col == 'discount'  && $.isNumeric(oldValue))
          {
             purchase.setDataAtCell(row,9,(oldValue*purchase.getDataAtCell(row,7))/100);
             //total payment after sub discount
             purchase.setDataAtCell(row,10, (purchase.getDataAtCell(row,7)-((oldValue*purchase.getDataAtCell(row,7))/100)));

             var total_discount = 0;
             var after_discount = 0;
             var total_money    =  0;

             for (var row_index = 0; row_index <= 40; row_index++) {

                total_discount += (purchase.getDataAtCell(row_index, 7)*purchase.getDataAtCell(row_index, 8))/100;

                total_money    +=  purchase.getDataAtCell(row_index, 7);
              }

              after_discount = parseFloat(total_money) - parseFloat(total_discount);

              $('input[name="total_discount"]').val((total_discount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
              $('input[name="after_discount"]').val((after_discount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            
          }else if(col == 'total_money'){
          
              var total_discount = 0;
              var after_discount = 0;
              var total_money    =  0;

               for (var row_index = 0; row_index <= 40; row_index++) {
                  if(parseFloat(purchase.getDataAtCell(row_index, 7)) > 0){
                    total_discount += (purchase.getDataAtCell(row_index, 7)*purchase.getDataAtCell(row_index, 8))/100;
                    total_money += (parseFloat(purchase.getDataAtCell(row_index, 7)));
                  }

                }
                

                after_discount = parseFloat(total_money) - parseFloat(total_discount);

                $('input[name="total_money"]').val((total_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                $('input[name="total_discount"]').val((total_discount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                $('input[name="after_discount"]').val((after_discount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
          }
          

          if(col == 'warehouse_id' && oldValue != '' && purchase.getDataAtCell(row_global,4) != '' && purchase.getDataAtCell(row_global,0) != null)
          {
            row_global = row;

            var data={};
            var warehouse_id = $('select[name="warehouse_id"]').val();
            if($.isNumeric(warehouse_id)){

              data.warehouse_id = $('select[name="warehouse_id"]').val();
            }else{
              data.warehouse_id = purchase.getDataAtCell(row, 1);

            }
            data.commodity_id = purchase.getDataAtCell(row, 0);
            data.quantity = purchase.getDataAtCell(row, 4);
           
            $.post(admin_url + 'warehouse/check_quantity_inventory', data).done(function(response){
              response = JSON.parse(response);
              if(response.message != true){
                if(response.value != 0){
                  alert_float('danger', response.message+response.value+' <?php echo _l('product') ?>');
                  purchase.setCellMeta(row_global, 4, 'className', 'border');
                  purchase.render();
                }else{
                  alert_float('danger', response.message);
                  purchase.setCellMeta(row_global, 4, 'className', 'border');
                  purchase.render();
                }
              }else{
                purchase.setCellMeta(row_global, 4, 'className', 'border-none');
                purchase.render();
              }
            });
          }

          if(col == 'quantities' && oldValue == '')
          {
            $('input[name="total_goods_money"]').val(0);
            $('input[name="value_of_inventory"]').val(0);
            $('input[name="total_money"]').val(0);
          }
        
      });
    }
  })
})(jQuery);


(function($) {
"use strict";  


   $('.add_goods_delivery').on('click', function() {
      "use strict";
      var valid_warehouse_type = $('#hot_purchase').find('.border').html();

      $('input[name="save_and_send_request"]').val('false');

      if(valid_warehouse_type){
        alert_float('danger', "<?php echo _l('data_invalid') ; ?>");
      }else{
        var datasubmit = {};

        datasubmit.hot_delivery = purchase_value.getData();
         datasubmit.warehouse_id = $('select[name="warehouse_id"]').val();

         var edit_approval = $('input[name="edit_approval"]').val();

         if(edit_approval == 'true'){
             $('input[name="hot_purchase"]').val(JSON.stringify(purchase_value.getData()));  
              $('#add_goods_delivery').submit(); 

         }else{

             $.post(admin_url + 'warehouse/check_quantity_inventory_onsubmit', datasubmit).done(function(responsec){
              responsec = JSON.parse(responsec);

              if(responsec.message){
                $('input[name="hot_purchase"]').val(JSON.stringify(purchase_value.getData()));  

                $('#add_goods_delivery').submit(); 
              }else{
                  var av;
                  for (av = 0; av < responsec.arr_available_quantity.length; ++av) {

                      purchase.setDataAtCell(av,2,responsec.arr_available_quantity[av]);
                  }

                alert_float('danger', responsec.str_error);
              }

            });
        
         }

      }
        
    });

      $('.add_goods_delivery_send').on('click', function() {
      "use strict";
      var valid_warehouse_type = $('#hot_purchase').find('.border').html();

      $('input[name="save_and_send_request"]').val('true');

      if(valid_warehouse_type){
        alert_float('danger', "<?php echo _l('data_invalid') ; ?>");
      }else{
        var datasubmit = {};

        datasubmit.hot_delivery = purchase_value.getData();
         datasubmit.warehouse_id = $('select[name="warehouse_id"]').val();

         var edit_approval = $('input[name="edit_approval"]').val();

         if(edit_approval == 'true'){
             $('input[name="hot_purchase"]').val(JSON.stringify(purchase_value.getData()));  
              $('#add_goods_delivery').submit(); 

         }else{

             $.post(admin_url + 'warehouse/check_quantity_inventory_onsubmit', datasubmit).done(function(responsec){
              responsec = JSON.parse(responsec);

              if(responsec.message){
                $('input[name="hot_purchase"]').val(JSON.stringify(purchase_value.getData()));  

                $('#add_goods_delivery').submit(); 
              }else{
                  var av;
                  for (av = 0; av < responsec.arr_available_quantity.length; ++av) {

                      purchase.setDataAtCell(av,2,responsec.arr_available_quantity[av]);
                  }

                alert_float('danger', responsec.str_error);
              }

            });
        
         }

      }
        
    });



  })(jQuery);

  function pr_order_change(){
     "use strict";

    var pr_order_id = $('select[name="pr_order_id"]').val();

    if(pr_order_id != ''){
      alert_float('warning', '<?php echo _l('stock_received_docket_from_purchase_request'); ?>')
      $.post(admin_url + 'warehouse/goods_delivery_copy_pur_order/'+pr_order_id).done(function(response){
            response = JSON.parse(response);
            console.log(response);
            purchase.updateSettings({
            data: response.result,
            maxRows: response.total_row,
          });
            $('input[name="total_money"]').val((response.total_tax_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('input[name="total_discount"]').val((response.total_discount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
            $('input[name="after_discount"]').val((response.total_payment).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));




          });
      $.post(admin_url + 'warehouse/copy_pur_vender/'+pr_order_id).done(function(response){
       var response_vendor = JSON.parse(response);

        $('select[name="buyer_id"]').val(response_vendor.buyer).change();

        $('select[name="project"]').val(response_vendor.project).change();
        $('select[name="type"]').val(response_vendor.type).change();
        $('select[name="department"]').val(response_vendor.department).change();
        $('select[name="requester"]').val(response_vendor.requester).change();

      });
      
    }else{
      purchase.updateSettings({
            data: [],
            maxRows: 22,
          });
    }

  }

function customDropdownRenderer(instance, td, row, col, prop, value, cellProperties) {
   "use strict";
    var selectedId;
    var optionsList = cellProperties.chosenOptions.data;
    
    if(typeof optionsList === "undefined" || typeof optionsList.length === "undefined" || !optionsList.length) {
        Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
        return td;
    }

    var values = (value + "").split("|");
    value = [];
    for (var index = 0; index < optionsList.length; index++) {

        if (values.indexOf(optionsList[index].id + "") > -1) {
            selectedId = optionsList[index].id;
            value.push(optionsList[index].label);
        }
    }
    value = value.join(", ");

    Handsontable.cellTypes.text.renderer(instance, td, row, col, prop, value, cellProperties);
    return td;
}

function customRenderer(instance, td, row, col, prop, value, cellProperties) {
  "use strict";
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    if(td.innerHTML != ''){
      td.innerHTML = td.innerHTML + '%'
      td.className = 'htRight';
    }
}



function invoice_change(){
    "use strict";

    var invoice_id = $('select[name="invoice_id"]').val();

    if(invoice_id != ''){
     
      $.post(admin_url + 'warehouse/copy_invoices/'+invoice_id).done(function(response){
            response = JSON.parse(response);
            console.log(response.goods_delivery.addedfrom);
          if(response.status == true){

              purchase.updateSettings({
                data: response.result,

              });

              $('select[name="staff_id"]').val((response.goods_delivery.addedfrom)).change();
              $('textarea[name="description"]').val((response.goods_delivery.description)).change();
              $('input[name="address"]').val((response.goods_delivery.address));
              $('select[name="customer_code"]').val((response.goods_delivery.customer_code)).change();

              $('input[name="total_money"]').val((response.goods_delivery.total_money));
              $('input[name="total_discount"]').val((response.goods_delivery.total_discount));
              $('input[name="after_discount"]').val((response.goods_delivery.after_discount));

          }else{

              purchase.updateSettings({
                data: [],
                maxRows: 22,
              });

          }

        });
      
    }else{
      purchase.updateSettings({
            data: [],
            maxRows: 22,
          });

      $('select[name="staff_id"]').val('').change();
      $('textarea[name="description"]').val('').change();
      $('input[name="address"]').val('');
      $('select[name="customer_code"]').val('').change();

      $('input[name="total_money"]').val('');
      $('input[name="total_discount"]').val('');
      $('input[name="after_discount"]').val('');

    }
}

  /*change warehouse, handsome table unactive warehouse name*/

$('select[name="warehouse_id"]').change(function(){
  "use strict";
    var warehouse_value = $('select[name="warehouse_id"]').val();

    var readOnly_warehouse_name;

    if($.isNumeric(warehouse_value)){
      readOnly_warehouse_name = true;
    }else{
      readOnly_warehouse_name = false;

    }

  purchase.updateSettings({
           columns: [
                {
                  type: 'text',
                  data: 'commodity_code',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($commodity_code_name); ?>
                  }
                },
                 {
                  type: 'text',
                  data: 'warehouse_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($units_warehouse_name); ?>
                  },
                  readOnly: readOnly_warehouse_name,
                  
                },
                {
                  type: 'numeric',
                  data:'available_quantity',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true
                },
                {
                  
                  type: 'text',
                  data: 'unit_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($units_code_name); ?>
                  },
                  readOnly: true

                },
                {
                  type: 'numeric',
                  data:'quantities',
                  numericFormat: {
                    pattern: '0,00',
                  }
                },
                {
                  type: 'numeric',
                  data: 'rate',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  
                      
                },
               {
                  data: 'tax_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($taxes); ?>
                  }
                },
                {
                  type: 'numeric',
                  data: 'total_money',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true

                      
                },
                {
                  data: 'discount',
                  type: 'numeric',
                  renderer: customRenderer
                },             
                {
                  data: 'discount_money',
                  type: 'numeric',
                  numericFormat: {
                    pattern: '0,0'
                  },
                  readOnly: true
                },
                {
                  data: 'total_after_discount',
                  type: 'numeric',
                  numericFormat: {
                    pattern: '0,0'
                  },
                  readOnly: true
                },
                {
                  type: 'text',
                  data: 'guarantee_period',
                  readOnly: true
                },
                {
                  type: 'text',
                  data: 'note',
                },
             
                
              ],
          });
});


  
</script>