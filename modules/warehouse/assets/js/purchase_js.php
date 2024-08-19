
<script>
  var purchase;
(function($) {
  "use strict";

  appValidateForm($('#add_goods_receipt'), {
     date_c: 'required',
     date_add: 'required',
     pr_order_id: 'required',
     project: 'required',
    //  <?php //if($pr_orders_status == true && get_warehouse_option('goods_receipt_required_po') == 1 ){ ?>
    //  pr_order_id: 'required',

    //  <?php //} ?>
    
   }); 


<?php if(!isset($goods_receipt)){ ?>

  var dataObject_pu = [];
  var hotElement1 = document.querySelector('#hot_purchase');
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
    autoColumnSize: {
      samplingRatio: 23
    },
   
    filters: true,
    manualRowResize: true,
    manualColumnResize: true,
    allowInsertRow: true,
    allowRemoveRow: true,
    columnHeaderHeight: 40,

    colWidths: [110, 100,80, 100,80, 100,120,120,120,120,120,120,150,150],
    rowHeights: 30,
    rowHeaderWidth: [44],

    hiddenColumns: {
      columns: [8,9],
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
                  data: 'tax',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($taxes); ?>
                  }
                },

                {
                  type: 'numeric',
                  data: 'goods_money',
                  numericFormat: {
                    pattern: '0,00',
                  },
                readOnly: true

                      
                },
                {
                  type: 'numeric',
                  data: 'tax_money',
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
                  }
                },
                {
                  type: 'text',
                  data: 'lot_number',
                },

                {
                  type: 'date',
                  dateFormat: 'YYYY-MM-DD',
                  correctFormat: true,
                  defaultDate: "<?php echo _d(date('Y-m-d')) ?>"
                },
                {
                  type: 'date',
                  dateFormat: 'YYYY-MM-DD',
                  correctFormat: true,
                  defaultDate: "<?php echo _d(date('Y-m-d')) ?>"
                },
                {
                  type: 'text',
                  data: 'note',
                },
             
                
              ],

          colHeaders: [
        '<?php echo _l('commodity_code'); ?>',
        '<?php echo _l('warehouse_name'); ?>',
        '<?php echo _l('unit_id'); ?>',
        '<?php echo _l('quantity'); ?>',
        '<?php echo _l('unit_price'); ?>',
        '<?php echo _l('tax_rate')._l(' %'); ?>',
        '<?php echo _l('goods_money'); ?>',
        '<?php echo _l('tax_money'); ?>',
        '<?php echo _l('discount(%)').'(%)'; ?>',
        '<?php echo _l('discount(money)'); ?>',
        '<?php echo _l('lot_number'); ?>',
        '<?php echo _l('date_manufacture'); ?>',
        '<?php echo _l('expiry_date'); ?>',
        '<?php echo _l('note'); ?>',
        
      ],
   
    data: dataObject_pu,

    cells: function (row, col, prop, value, cellProperties) {
        var cellProperties = {};
        var data = this.instance.getData();
        cellProperties.className = 'htMiddle ';
        
        return cellProperties;
      }


  });

<?php }else{ ?>

  <?php if(isset($goods_receipt_detail)){?>
    var dataObject_pu = <?php echo html_entity_decode($goods_receipt_detail); ?>;
  <?php }else{ ?>
    var dataObject_pu = [];
  <?php } ?>

  var hotElement1 = document.querySelector('#hot_purchase');
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
    autoColumnSize: {
      samplingRatio: 23
    },
   
    filters: true,
    manualRowResize: true,
    manualColumnResize: true,
    allowInsertRow: true,
    allowRemoveRow: true,
    columnHeaderHeight: 40,

    colWidths: [110, 100,80, 100,80, 100,120,120,120,120,120,120,150,150],
    rowHeights: 30,
    rowHeaderWidth: [44],

    hiddenColumns: {
      columns: [8,9],
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
                  data: 'tax',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($taxes); ?>
                  }
                },

                {
                  type: 'numeric',
                  data: 'goods_money',
                  numericFormat: {
                    pattern: '0,00',
                  },
                readOnly: true

                      
                },
                {
                  type: 'numeric',
                  data: 'tax_money',
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
                  }
                },
                {
                  type: 'text',
                  data: 'lot_number',
                },

                {
                  type: 'date',
                  dateFormat: 'YYYY-MM-DD',
                  correctFormat: true,
                  defaultDate: "<?php echo _d(date('Y-m-d')) ?>",
                  data:'date_manufacture'
                },
                {
                  type: 'date',
                  dateFormat: 'YYYY-MM-DD',
                  correctFormat: true,
                  defaultDate: "<?php echo _d(date('Y-m-d')) ?>",
                  data:'expiry_date',
                },
                {
                  type: 'text',
                  data: 'note',
                },
             
                
              ],

          colHeaders: [
        '<?php echo _l('commodity_code'); ?>',
        '<?php echo _l('warehouse_name'); ?>',
        '<?php echo _l('unit_id'); ?>',
        '<?php echo _l('quantity'); ?>',
        '<?php echo _l('unit_price'); ?>',
        '<?php echo _l('tax_rate')._l(' %'); ?>',
        '<?php echo _l('goods_money'); ?>',
        '<?php echo _l('tax_money'); ?>',
        '<?php echo _l('discount(%)').'(%)'; ?>',
        '<?php echo _l('discount(money)'); ?>',
        '<?php echo _l('lot_number'); ?>',
        '<?php echo _l('date_manufacture'); ?>',
        '<?php echo _l('expiry_date'); ?>',
        '<?php echo _l('note'); ?>',
        
      ],
   
    data: dataObject_pu,

    cells: function (row, col, prop, value, cellProperties) {
        var cellProperties = {};
        var data = this.instance.getData();
        cellProperties.className = 'htMiddle ';
        
        return cellProperties;
      }


  });

<?php } ?>

})(jQuery);

  (function($) {
  "use strict";
      
      var purchase_value = purchase;

    purchase.addHook('afterChange', function(changes, src) {
      "use strict";

        if(changes !== null){
        changes.forEach(([row, col, prop, oldValue, newValue]) => {

            if(col == 'commodity_code' && oldValue != ''&& oldValue != ''){

              $.post(admin_url + 'warehouse/commodity_code_change/'+oldValue ).done(function(response){
                response = JSON.parse(response);
                  purchase.setDataAtCell(row,2, response.value.unit_id);
                  purchase.setDataAtCell(row,3, '');
                  purchase.setDataAtCell(row,4, response.value.purchase_price);
                  purchase.setDataAtCell(row,5, response.value.tax);
                  purchase.setDataAtCell(row,8, '');
                  purchase.setDataAtCell(row,9, '');

              });
            }
            if(col == 'commodity_code' && oldValue == null){
                purchase.setDataAtCell(row,2,'');
                purchase.setDataAtCell(row,3,'');
                purchase.setDataAtCell(row,4,'');
                purchase.setDataAtCell(row,5,'');
                purchase.setDataAtCell(row,6,'');
                purchase.setDataAtCell(row,7,'');
                purchase.setDataAtCell(row,8,'');
                purchase.setDataAtCell(row,9,'');
            }
            if(col == 'quantities' && oldValue != ''){
              //get tax value
              var tax_id = purchase.getDataAtCell(row,5);

              if(tax_id){

                $.post(admin_url + 'warehouse/tax_change/'+tax_id).done(function(response){
                    response = JSON.parse(response);

                    purchase.setDataAtCell(row,6, (purchase.getDataAtCell(row,3)*purchase.getDataAtCell(row,4)*response.tax_rate)/100 + (purchase.getDataAtCell(row,3)*purchase.getDataAtCell(row,4)));

                    purchase.setDataAtCell(row,7, ((purchase.getDataAtCell(row,3)*purchase.getDataAtCell(row,4)*response.tax_rate)/100));                   

                });
              }else{

                purchase.setDataAtCell(row,6,oldValue*purchase.getDataAtCell(row,4));
                purchase.setDataAtCell(row,7,oldValue*purchase.getDataAtCell(row,4)*(purchase.getDataAtCell(row,5)/100));
              }

                  var total_tax_money =0;
                  var total_goods_money =0;
                  var value_of_inventory =0;
                  var total_money =0;

                

                for (var row_index = 0; row_index <= 40; row_index++) {

                  total_tax_money += (purchase.getDataAtCell(row_index, 3)*purchase.getDataAtCell(row_index, 4))*purchase.getDataAtCell(row_index, 5)/100;
                  total_goods_money += purchase.getDataAtCell(row_index, 3)*purchase.getDataAtCell(row_index, 4);
                  value_of_inventory += purchase.getDataAtCell(row_index, 3)*purchase.getDataAtCell(row_index, 4);

                }

                  total_money = total_tax_money + total_goods_money;

                  $('input[name="total_tax_money"]').val((total_tax_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                  $('input[name="total_goods_money"]').val((total_goods_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                  $('input[name="value_of_inventory"]').val((value_of_inventory).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                  $('input[name="total_money"]').val((total_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

            }else if(col == 'quantities' && oldValue == ''){
                purchase.setDataAtCell(row,6,0);
                purchase.setDataAtCell(row,7,0);
                $('input[name="total_goods_money"]').val(0);
                $('input[name="value_of_inventory"]').val(0);
                $('input[name="total_money"]').val(0);

            }else if(col == 'tax' && oldValue != ''){

                $.post(admin_url + 'warehouse/tax_change/'+oldValue).done(function(response){
                    response = JSON.parse(response);
     
                    purchase.setDataAtCell(row,6, (purchase.getDataAtCell(row,3)*purchase.getDataAtCell(row,4)*response.tax_rate)/100 + (purchase.getDataAtCell(row,3)*purchase.getDataAtCell(row,4)));

                    purchase.setDataAtCell(row,7, ((purchase.getDataAtCell(row,3)*purchase.getDataAtCell(row,4)*response.tax_rate)/100));                   

                  });

            }else if(col == 'goods_money'){

                  var total_tax_money =0;
                  var total_goods_money =0;
                  var value_of_inventory =0;
                  var total_money =0;                

                for (var row_index = 0; row_index <= 40; row_index++) {
                  if(parseFloat(purchase.getDataAtCell(row_index, 6)) > 0){

                    total_money += parseFloat(purchase.getDataAtCell(row_index, 6));
                  }

                }

                  $('input[name="total_money"]').val((total_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

               

            }else if(col == 'tax_money'){

                  var total_tax_money =0;
                  var total_goods_money =0;
                  var value_of_inventory =0;
                  var total_money =0;                

                for (var row_index = 0; row_index <= 40; row_index++) {
                  if(parseFloat(purchase.getDataAtCell(row_index, 7)) > 0){

                    total_tax_money += parseFloat(purchase.getDataAtCell(row_index, 7));
                  }

                }

                  $('input[name="total_tax_money"]').val((total_tax_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

            }

             if(col == 'unit_price' ){
                  var total_tax_money =0;
                  var total_goods_money =0;
                  var value_of_inventory =0;
                  var total_money =0;

              //get tax value
              var tax_id = purchase.getDataAtCell(row,5);
              if(tax_id){

                $.post(admin_url + 'warehouse/tax_change/'+tax_id).done(function(response){
                    response = JSON.parse(response);

                    purchase.setDataAtCell(row,6, (purchase.getDataAtCell(row,3)*purchase.getDataAtCell(row,4)*response.tax_rate)/100 + (purchase.getDataAtCell(row,3)*purchase.getDataAtCell(row,4)));

                    purchase.setDataAtCell(row,7, ((purchase.getDataAtCell(row,3)*purchase.getDataAtCell(row,4)*response.tax_rate)/100));                   

                });
              }else{
                purchase.setDataAtCell(row,6,oldValue*purchase.getDataAtCell(row,3));
                purchase.setDataAtCell(row,7,oldValue*purchase.getDataAtCell(row,3)*(purchase.getDataAtCell(row,5)/100));
               
              }

                

                for (var row_index = 0; row_index <= 40; row_index++) {

                  total_tax_money += (purchase.getDataAtCell(row_index, 3)*purchase.getDataAtCell(row_index, 4))*purchase.getDataAtCell(row_index, 5)/100;
                  
                  total_goods_money += purchase.getDataAtCell(row_index, 3)*purchase.getDataAtCell(row_index, 4);
                  value_of_inventory += purchase.getDataAtCell(row_index, 3)*purchase.getDataAtCell(row_index, 4);

                }

                  total_money = total_tax_money + total_goods_money;

                  $('input[name="total_tax_money"]').val((total_tax_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                  $('input[name="total_goods_money"]').val((total_goods_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                  $('input[name="value_of_inventory"]').val((value_of_inventory).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                  $('input[name="total_money"]').val((total_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));


             }
          

        });
      }
    });

   
      $('.add_goods_receipt').on('click', function() {
        var valid_warehouse_type = $('#hot_purchase').find('.htInvalid').html();

        $('input[name="save_and_send_request"]').val('false');

        if(valid_warehouse_type){
          alert_float('danger', "<?php echo _l('data_must_number') ; ?>");

        }else{
          
          var warehouse_id = $('select[name="warehouse_id"]').val();

          var datasubmit = {};
          datasubmit.hot_delivery = purchase_value.getData();
          datasubmit.warehouse_id = warehouse_id;

            $.post(admin_url + 'warehouse/check_warehouse_onsubmit', datasubmit).done(function(responsec){
              responsec = JSON.parse(responsec);
                console.log('response', responsec);

              if(responsec.message){
                
                $('input[name="hot_purchase"]').val(JSON.stringify(purchase_value.getData()));   
                $('#add_goods_receipt').submit(); 

              }else{
                $('#warehouse_id-error').empty();
                $('#warehouse_id').parent().parent().append('<p id="project-error" class="text-danger">This field is required.</p>');
              }

            });



        }
      });

      $('.add_goods_receipt_send').on('click', function() {
        var valid_warehouse_type = $('#hot_purchase').find('.htInvalid').html();

        $('input[name="save_and_send_request"]').val('true');
        if(valid_warehouse_type){
          alert_float('danger', "<?php echo _l('data_must_number') ; ?>");

        }else{
          
          var warehouse_id = $('select[name="warehouse_id"]').val();

          var datasubmit = {};
          datasubmit.hot_delivery = purchase_value.getData();
          datasubmit.warehouse_id = warehouse_id;

            $.post(admin_url + 'warehouse/check_warehouse_onsubmit', datasubmit).done(function(responsec){
              responsec = JSON.parse(responsec);
                console.log('response', responsec);

              if(responsec.message){
                
                $('input[name="hot_purchase"]').val(JSON.stringify(purchase_value.getData()));   
                $('#add_goods_receipt').submit(); 

              }else{
                $('#warehouse_id-error').empty();
                $('#warehouse_id').parent().parent().append('<p id="project-error" class="text-danger">This field is required.</p>');
              }

            });



        }
      });

        

   })(jQuery);

  function pr_order_change(){
    "use strict";

    var pr_order_id = $('select[name="pr_order_id"]').val();

    if(pr_order_id != ''){
      alert_float('warning', '<?php echo _l('stock_received_docket_from_purchase_request'); ?>')
      $.post(admin_url + 'warehouse/coppy_pur_request/'+pr_order_id).done(function(response){
            response = JSON.parse(response);
            console.log(response);
            purchase.updateSettings({
            data: response.result,
            maxRows: response.total_row,
          });
            $('input[name="total_tax_money"]').val((response.total_tax_money));
            $('input[name="total_goods_money"]').val((response.total_goods_money));
            $('input[name="value_of_inventory"]').val((response.value_of_inventory));
            $('input[name="total_money"]').val((response.total_money));



          });
      $.post(admin_url + 'warehouse/copy_pur_vender/'+pr_order_id).done(function(response){
       var response_vendor = JSON.parse(response);

        $('select[name="supplier_code"]').val(response_vendor.userid).change();
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
                  data: 'tax',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  width: 150,
                  chosenOptions: {
                      data: <?php echo json_encode($taxes); ?>
                  }
                },

                {
                  type: 'numeric',
                  data: 'goods_money',
                  numericFormat: {
                    pattern: '0,00',
                  },
                readOnly: true

                      
                },
                {
                  type: 'numeric',
                  data: 'tax_money',
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
                  }
                },
                {
                  type: 'text',
                  data: 'lot_number',
                },

                {
                  type: 'date',
                  dateFormat: 'YYYY-MM-DD',
                  correctFormat: true,
                  defaultDate: "<?php echo _d(date('Y-m-d')) ?>",
                  data:'date_manufacture'
                },
                {
                  type: 'date',
                  dateFormat: 'YYYY-MM-DD',
                  correctFormat: true,
                  defaultDate: "<?php echo _d(date('Y-m-d')) ?>",
                  data:'expiry_date',
                },
                {
                  type: 'text',
                  data: 'note',
                },
             
                
              ],
          });
});


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

  
</script>
