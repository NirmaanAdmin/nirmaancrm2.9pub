<script>
      (function($) {
"use strict";

     var ProposalServerParams = {
        "warehouse_ft": "[name='warehouse_filter[]']",
        "commodity_ft": "[name='commodity_filter[]']",
        "status_ft": "[name='status[]']",
        "validity_start_date": "input[name='validity_start_date']",
        "validity_end_date": "input[name='validity_end_date']",
        
    };

  var  table_warehouse_history = $('table.table-table_warehouse_history');
   var  _table_api = initDataTable(table_warehouse_history, admin_url+'warehouse/table_warehouse_history',[], [], ProposalServerParams, [0, 'desc']);

   $('.table-table_warehouse_history').DataTable().columns([0]).visible(false, false);

    $.each(ProposalServerParams, function(i, obj) {
        $('select' + obj).on('change', function() {  
            table_warehouse_history.DataTable().ajax.reload()
                .columns.adjust()
                .responsive.recalc();
        });
    });

     $('#validity_start_date').on('change', function() {
                    table_warehouse_history.DataTable().ajax.reload().columns.adjust().responsive.recalc();
                    });
    $('#validity_end_date').on('change', function() {
                    table_warehouse_history.DataTable().ajax.reload().columns.adjust().responsive.recalc();
                });
    $('#status').on('change', function() {
                    table_warehouse_history.DataTable().ajax.reload().columns.adjust().responsive.recalc();
                });

})(jQuery);
</script>