<script>
(function($) {
"use strict";

  <?php if(!isset($loss_adjustment_detailt)){ ?>	
  var dataObject = [];
  var hotElement = document.querySelector('#example');
  var hotElementContainer = hotElement.parentNode;
  var hotSettings = {
      data: dataObject,
      columns: [
        {
          data: 'items',
          renderer: customDropdownRenderer,
          editor: "chosen",
          width: 150,
          chosenOptions: {            
              data: <?php echo json_encode($items); ?>
          }
        },
        {
          data: 'unit',
          renderer: customDropdownRenderer,
          editor: "chosen",
          width: 50,
          chosenOptions: {            
              data: <?php echo json_encode($unit); ?>
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
          data:'expiry_date',
        },
        {
          data: 'current_number',
          type: 'numeric',         
          readOnly: true
        },
        {
          data: 'updates_number',
          type: 'numeric',
      
        }
      ],
      contextMenu: true,
    manualRowMove: true,
    manualColumnMove: true,
    stretchH: 'all',
    autoWrapRow: true,
    rowHeights: 30,
    defaultRowHeight: 100,
    headerTooltips: true,
    maxRows: 22,
    minHeight:'100%',
    maxHeight:'500px',

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
    
      licenseKey: 'non-commercial-and-evaluation',
      stretchH: 'all',
      width: '100%',
      autoWrapRow: true,
      rowHeights: 30,
      columnHeaderHeight: 40,
      minRows: 10,
      maxRows: 40,
      rowHeaders: true,
      colWidths: [200,50,80,80],
      colHeaders: [
        '<?php echo _l('items'); ?>',
        '<?php echo _l('unit'); ?>',
        '<?php echo _l('lot_number'); ?>',
        '<?php echo _l('expiry_date'); ?>',
        '<?php echo _l('available_quantity'); ?>',
        '<?php echo _l('stock_quantity'); ?>'
      ],
       columnSorting: {
        indicator: true
      },
      autoColumnSize: {
        samplingRatio: 23
      },
      dropdownMenu: true,
      mergeCells: true,
      contextMenu: true,
      manualRowMove: true,
      manualColumnMove: true,
      multiColumnSorting: {
        indicator: true
      },
      filters: true,
      manualRowResize: true,
      manualColumnResize: true
    };
  var hot = new Handsontable(hotElement, hotSettings);
  hot.addHook('afterChange', function(changes, src) {
  	if(changes !== null){
	    changes.forEach(([row, prop, oldValue, newValue]) => {
	      if(prop == 'items' || prop == 'lot_number' || prop == 'expiry_date'){
          var data = {};
          data.warehouse_id = $('select[id="warehouses"]').val();
          data.commodity_id = hot.getDataAtCell(row,0);
          data.lot_number = hot.getDataAtCell(row,2);
          data.expiry_date = hot.getDataAtCell(row,3);

          console.log('data',data);

          if(data.warehouse_id != ''){
            $.post(admin_url + 'warehouse/quantity_inventory',data).done(function(response){
              response = JSON.parse(response);
               hot.setDataAtCell(row,1,response.unit);
              hot.setDataAtCell(row,4,response.value);
            });
          }else{
            alert_float('warning','<?php echo _l('please_select_warehouse'); ?>')
          }
        }
	    });
  	}
  });
  $('.save_detail').on('click', function() {

      //check before save
      var datasubmit = {};
          datasubmit.hot_delivery = hot.getData();
          datasubmit.warehouse_id = $('select[name="warehouses"]').val();

      $.post(admin_url+'warehouse/check_lost_adjustment_before_save', datasubmit).done(function(response){
        response = JSON.parse(response);
        if(response.success == true) {

          $('input[name="pur_order_detail"]').val(hot.getData());   
          $('#pur_order-form').submit(); 

        }else{

          alert_float('warning', response.message);

        }
      });


  });
<?php } else{ ?>
	var dataObject = <?php echo html_entity_decode($loss_adjustment_detailt); ?>;
  var hotElement = document.querySelector('#example');
  var hotElementContainer = hotElement.parentNode;
  var hotSettings = {
    data: dataObject,
       columns: [
      {
        data: 'items',
        renderer: customDropdownRenderer,
        editor: "chosen",
        width: 150,
        chosenOptions: {            
            data: <?php echo json_encode($items); ?>
        }
      },
      {
        data: 'unit',
        renderer: customDropdownRenderer,
        editor: "chosen",
        width: 50,
        chosenOptions: {            
            data: <?php echo json_encode($unit); ?>
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
        data:'expiry_date',
      },
     
      {
        data: 'current_number',
        type: 'numeric',         
        readOnly: true
      },
      {
        data: 'updates_number',
        type: 'numeric',
    
      }, 
      {
        data: 'loss_adjustment',
        type: 'numeric',
    
      }  
    ],
    licenseKey: 'non-commercial-and-evaluation',
    stretchH: 'all',
    width: '100%',
    autoWrapRow: true,
    rowHeights: 30,
    columnHeaderHeight: 40,
    minRows: 10,
    maxRows: 40,
    height: 330,
    rowHeaders: true,
    colWidths: [5,200,50,80,80,80],
    colHeaders: [
      '<?php echo _l('items'); ?>',
      '<?php echo _l('unit'); ?>',
      '<?php echo _l('lot_number'); ?>',
      '<?php echo _l('expiry_date'); ?>',
      '<?php echo _l('available_quantity'); ?>',
      '<?php echo _l('stock_quantity'); ?>',
      '<?php echo _l('loss_adjustment_id'); ?>',
    ],
    columnSorting: {
      indicator: true
    },
    autoColumnSize: {
      samplingRatio: 23
    },
    dropdownMenu: true,
    mergeCells: true,
    contextMenu: true,
    manualRowMove: true,
    manualColumnMove: true,
    multiColumnSorting: {
      indicator: true
    },
    hiddenColumns: {
      columns: [6],
      indicators: true
    },
    filters: true,
    manualRowResize: true,
    manualColumnResize: true
  };

  var hot = new Handsontable(hotElement, hotSettings);
  hot.addHook('afterChange', function(changes, src) {
  	if(changes !== null){
      changes.forEach(([row, prop, oldValue, newValue]) => {
        if(prop == 'items' || prop == 'lot_number' || prop == 'expiry_date'){
          var data = {};
          data.warehouse_id = $('select[id="warehouses"]').val();
          data.commodity_id = hot.getDataAtCell(row,0);
          data.lot_number = hot.getDataAtCell(row,2);
          data.expiry_date = hot.getDataAtCell(row,3);

          if(data.warehouse_id != ''){
            $.post(admin_url + 'warehouse/quantity_inventory',data).done(function(response){
              response = JSON.parse(response);
              hot.setDataAtCell(row,1,response.unit);
              hot.setDataAtCell(row,4,response.value);
            });
          }else{
            alert_float('warning','<?php echo _l('please_select_warehouse'); ?>')
          }
        }
      });
    }
  });
  $('.save_detail').on('click', function() {

            //check before save
      var datasubmit = {};
          datasubmit.hot_delivery = hot.getData();
          datasubmit.warehouse_id = $('select[name="warehouses"]').val();

      $.post(admin_url+'warehouse/check_lost_adjustment_before_save', datasubmit).done(function(response){
        response = JSON.parse(response);
        if(response.success == true) {

          $('input[name="pur_order_detail"]').val(hot.getData());   
          $('#pur_order-form').submit(); 

        }else{

          alert_float('warning', response.message);

        }
      });


  });

  var total_money = 0;
  for (var row_index = 0; row_index <= 40; row_index++) {
    if(parseInt(hot.getDataAtCell(row_index, 11)) > 0){
      total_money += (parseInt(hot.getDataAtCell(row_index, 11))); 
    }
  }
  
  $('input[name="total_mn"]').val(numberWithCommas(total_money));
<?php } ?>

  $('#adjusted').click(function(){
    var id= $(this).data('id');
    $.post(admin_url+'warehouse/adjust/'+id).done(function(response){
      response = JSON.parse(response);
      if(response.success == true) {
         alert_float('success','<?php echo _l('adjusted'); ?>');
         setTimeout(function(){ location.reload(true); }, 2000);           
      }else{
        alert_float('warning','<?php echo _l('adjust_fail'); ?>');
      }
    });
  });
})(jQuery); 

function customRenderer(instance, td, row, col, prop, value, cellProperties) {
  "use strict";
    Handsontable.renderers.TextRenderer.apply(this, arguments);
    if(td.innerHTML != ''){
      td.innerHTML = td.innerHTML + '%'
      td.className = 'htRight';
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

function removeCommas(str) {
  "use strict";
  return(str.replace(/,/g,''));
}

function numberWithCommas(x) {
  "use strict";
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
</script>