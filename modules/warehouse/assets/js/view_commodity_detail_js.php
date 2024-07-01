 <script>
   (function($) {
    "use strict";

  $('input[name="commodity_id"]').val("<?php echo html_entity_decode($commodity_item->id) ;?>");

    //inventory stock
    var ProposalServerParams = {
        "warehouse_ft": "[name='warehouse_filter[]']",
        "commodity_ft": "[name='commodity_id']",
        "alert_filter": "[name='alert_filter']",
    };
    var table_inventory_stock = $('table.table-table_inventory_stock');
   var  _table_api = initDataTable(table_inventory_stock, admin_url+'warehouse/table_inventory_stock', [], [], ProposalServerParams, [0, 'desc']);

   $('.table-table_inventory_stock').DataTable().columns([0]).visible(false, false);

    $.each(ProposalServerParams, function(i, obj) {
        $('select' + obj).on('change', function() {  
            table_inventory_stock.DataTable().ajax.reload()
                .columns.adjust()
                .responsive.recalc();
        });
    });

    //expriry date
    var ProposalServerParams = {
        "warehouse_ft": "[name='warehouse_filter[]']",
        "commodity_ft": "[name='commodity_id']",
        "alert_filter": "[name='alert_filter']",
    };
    var table_view_commodity_detail = $('table.table-table_view_commodity_detail');
   var  _table_api = initDataTable(table_view_commodity_detail, admin_url+'warehouse/table_view_commodity_detail', [], [], ProposalServerParams);
    $.each(ProposalServerParams, function(i, obj) {
        $('select' + obj).on('change', function() {  
            table_view_commodity_detail.DataTable().ajax.reload()
                .columns.adjust()
                .responsive.recalc();
        });
    });



//transaction, history
var ProposalServerParams = {
        "warehouse_ft": "[name='warehouse_filter[]']",
        "commodity_ft": "[name='commodity_id']",
        
    };

  var   table_warehouse_history = $('table.table-table_warehouse_history');
   var  _table_api = initDataTable(table_warehouse_history, admin_url+'warehouse/table_warehouse_history', [], [], ProposalServerParams, [0, 'desc']);

   $('.table-table_warehouse_history').DataTable().columns([0]).visible(false, false);

    $.each(ProposalServerParams, function(i, obj) {
        $('select' + obj).on('change', function() {  
            table_warehouse_history.DataTable().ajax.reload()
                .columns.adjust()
                .responsive.recalc();
        });
    });


})(jQuery);

</script>