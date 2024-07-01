<script>
  var purchase;
  var warehouses;

(function($) {
"use strict";  
 
  appValidateForm($('#add_update_internal_delivery'), {
     internal_delivery_name: 'required',
     date_add: 'required',
    
   }); 

<?php if(!isset($internal_delivery)){ ?>
  var warehouses ={};
  //hansometable for purchase
  var row_global;
  var dataObject_pu = [];
  var
    hotElement1 = document.getElementById('hot_internal_delivery');

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

    colWidths: [110, 100,120,80, 100,100, 100,100,100],
    rowHeights: 30,
    rowHeaderWidth: [44],

    columns: [
                {
                  type: 'text',
                  data: 'commodity_code',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  chosenOptions: {
                      data: <?php echo json_encode($commodity_code_name); ?>
                  }
                },
                 {
                  type: 'text',
                  data: 'from_stock_name',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  chosenOptions: {
                      data: <?php echo json_encode($units_warehouse_name); ?>
                  }
                  
                },
                {
                  type: 'text',
                  data: 'to_stock_name',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  chosenOptions: {
                      data: <?php echo json_encode($units_warehouse_name); ?>
                  }
                  
                },
                {
                  
                  type: 'text',
                  data: 'unit_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  chosenOptions: {
                      data: <?php echo json_encode($units_code_name); ?>
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
                  type: 'numeric',
                  data:'quantities',
                  numericFormat: {
                    pattern: '0,00',
                  }
                },

                {
                  type: 'numeric',
                  data:'unit_price',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true,
                },
                
               
                {
                  type: 'numeric',
                  data: 'into_money',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true

                      
                },
                           
                {
                  type: 'text',
                  data: 'note',
                },
             
                
              ],

          colHeaders: [
        '<?php echo _l('commodity_code'); ?>',
        '<?php echo _l('from_stock_name'); ?>',
        '<?php echo _l('to_stock_name'); ?>',
        '<?php echo _l('unit_id'); ?>',
        '<?php echo _l('available_quantity'); ?>',
        '<?php echo _l('quantity_export'); ?>',
        '<?php echo _l('unit_price'); ?>',
        
        '<?php echo _l('into_money'); ?>',
        '<?php echo _l('note'); ?>',
        
      ],
   
    data: dataObject_pu,
  });

<?php }else{ ?>

 
  <?php if(isset($internal_delivery_detail)){?>
    var dataObject_pu = <?php echo html_entity_decode($internal_delivery_detail); ?>;
  <?php }else{ ?>
    var dataObject_pu = [];
  <?php } ?>

  var warehouses ={};
  //hansometable for purchase
  var row_global;
  var hotElement1 = document.getElementById('hot_internal_delivery');

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

    colWidths: [110, 100,120,80, 80,100, 100,120],
    rowHeights: 30,
    rowHeaderWidth: [44],

    hiddenColumns: {
      columns: [9,10],
      indicators: true
    },

    columns: [
                
                
                {
                  type: 'text',
                  data: 'commodity_code',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  chosenOptions: {
                      data: <?php echo json_encode($commodity_code_name); ?>
                  }
                },
                 {
                  type: 'text',
                  data: 'from_stock_name',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  chosenOptions: {
                      data: <?php echo json_encode($units_warehouse_name); ?>
                  }
                  
                },
                {
                  type: 'text',
                  data: 'to_stock_name',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  chosenOptions: {
                      data: <?php echo json_encode($units_warehouse_name); ?>
                  }
                  
                },
                {
                  
                  type: 'text',
                  data: 'unit_id',
                  renderer: customDropdownRenderer,
                  editor: "chosen",
                  chosenOptions: {
                      data: <?php echo json_encode($units_code_name); ?>
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
                  type: 'numeric',
                  data:'quantities',
                  numericFormat: {
                    pattern: '0,00',
                  }
                },

                {
                  type: 'numeric',
                  data:'unit_price',
                  numericFormat: {
                    pattern: '0,00',
                  },
                  readOnly: true,
                },
                
               
                {
                  type: 'numeric',
                  data: 'into_money',
                  numericFormat: {
                    pattern: '0,00',
                  },
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
                {
                  type: 'text',
                  data: 'internal_delivery_id',
                },
             
                
              ],

          colHeaders: [
        
        '<?php echo _l('commodity_code'); ?>',
        '<?php echo _l('from_stock_name'); ?>',
        '<?php echo _l('to_stock_name'); ?>',
        '<?php echo _l('unit_id'); ?>',
        '<?php echo _l('available_quantity'); ?>',
        '<?php echo _l('quantity_export'); ?>',
        '<?php echo _l('unit_price'); ?>',
        
        '<?php echo _l('into_money'); ?>',
        '<?php echo _l('note'); ?>',
        '<?php echo _l('id_internal_delivery_detail'); ?>',
        '<?php echo _l('id_internal_delivery'); ?>',
        
      ],
   
    data: dataObject_pu,
  });

<?php } ?>


 })(jQuery);


var purchase_value = purchase;
(function($) {
"use strict";  
 
  purchase.addHook('afterChange', function(changes, src) {
    if(changes !== null){
      changes.forEach(([row, col, prop, oldValue, newValue]) => {
       
          var row_global = row;

          console.log(oldValue);
          if(col == 'commodity_code' && oldValue != '' && oldValue != null)
          {
            $.post(admin_url + 'warehouse/commodity_code_change/'+oldValue ).done(function(response){
            var  response = JSON.parse(response);

              purchase.setDataAtCell(row,3, response.value.unit_id);
              purchase.setDataAtCell(row,4, '');
              purchase.setDataAtCell(row,6, response.value.purchase_price);
              purchase.setDataAtCell(row,8, '');
              purchase.setDataAtCell(row,9, '');

            });
          }

          if(col == 'commodity_code' && (oldValue == '' || oldValue == null))
          {
            purchase.setDataAtCell(row,1,'');
            purchase.setDataAtCell(row,2,'');
            purchase.setDataAtCell(row,3,'');
            purchase.setDataAtCell(row,4,'');
            purchase.setDataAtCell(row,5,'');
            purchase.setDataAtCell(row,6,'');
            purchase.setDataAtCell(row,7,'');
            purchase.setDataAtCell(row,8,'');
            purchase.setDataAtCell(row,9,'');
          }

          if(col == 'from_stock_name' && oldValue != '' && oldValue != null ){
            if(purchase.getDataAtCell(row_global,0) != '' && purchase.getDataAtCell(row_global,0) != null){
              //get inventory number by warehouse
              var data={};
                  data.commodity_id = purchase.getDataAtCell(row, 0);
                  data.warehouse_id = purchase.getDataAtCell(row, 1);
                  data.check_available = 0;


              $.post(admin_url + 'warehouse/get_quantity_inventory', data).done(function(response){
                response = JSON.parse(response);

                if(response.value != 0){
                   
                    purchase.setDataAtCell(row,4,response.value);
                    purchase.render()

                  }else{
                    purchase.setDataAtCell(row,4,0);
                    purchase.render()
                  }

              });
            }else{
              //alert
              alert_float('danger', "<?php echo _l('choose commodity name') ; ?>");
            }

          }

          if(col == 'quantities'  && $.isNumeric(oldValue) && oldValue != null && oldValue != 0){
              //check quantity export with avalable quantity

              var data={};
                  data.commodity_id = purchase.getDataAtCell(row, 0);
                  data.warehouse_id = purchase.getDataAtCell(row, 1);
                  data.quantity_export = purchase.getDataAtCell(row, 5);
                  data.check_available = 1;

              $.post(admin_url + 'warehouse/get_quantity_inventory_t', data).done(function(response){
                response = JSON.parse(response);

                if(response.message == true){
                   
                    purchase.setDataAtCell(row,7, purchase.getDataAtCell(row,5)*purchase.getDataAtCell(row,6));
                    purchase.render()

                  }else{
                    alert_float('danger', response.message);

                    purchase.setDataAtCell(row,5,'');
                    purchase.render()
                  }

              });


          }else if(col == 'quantities' && (oldValue != '' || oldValue == 0)){
              purchase.setDataAtCell(row,7, '');

          }


           if(col == 'into_money'){
          
              var into_money    =  0;

               for (var row_index = 0; row_index <= 40; row_index++) {
                  if(parseFloat(purchase.getDataAtCell(row_index, 7)) > 0){

                    into_money += (parseFloat(purchase.getDataAtCell(row_index, 7)));
                  }

                }

                $('input[name="total_amount"]').val((into_money).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                
          }

        
      });
    }
  })
})(jQuery);


(function($) {
"use strict";  


   $('.btn_add_internal_delivery').on('click', function() {
      "use strict";
      var valid_warehouse_type = $('#hot_internal_delivery').find('.border').html();

      if(valid_warehouse_type){
        alert_float('danger', "<?php echo _l('data_invalid') ; ?>");
      }else{
          var datasubmit = {};
              datasubmit.intenal_delivery = purchase_value.getData();
            
             $.post(admin_url + 'warehouse/check_internal_delivery_onsubmit', datasubmit).done(function(responsec){
              responsec = JSON.parse(responsec);
                console.log('response', responsec);
              if(responsec.message){
                $('input[name="hot_internal_delivery"]').val(JSON.stringify(purchase_value.getData()));  

                $('#add_update_internal_delivery').submit(); 
              }else{
                alert_float('danger', responsec.str_error);
              }

            });

      }
        
    });


  })(jQuery);


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

  
</script>