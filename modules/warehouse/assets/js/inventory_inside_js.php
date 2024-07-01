<script>
(function($) {
    "use strict";

    var ProposalServerParams = {
        "commodity_ft": "[name='commodity_filter[]']",
        "profit_rate_search": "[name='profit_rate_search']",
        "warehouse_filter": "[name='warehouse_filter[]']",
    };

    var table_inventory_inside = $('table.table-table_inventory_inside');
    var _table_api = initDataTable(table_inventory_inside, admin_url+'warehouse/table_inventory_inside', [0], [0], ProposalServerParams, [6, 'desc']);

    $.each(ProposalServerParams, function(i, obj) {
        $('select' + obj).on('change', function() {  
            table_inventory_inside.DataTable().ajax.reload()
                .columns.adjust()
                .responsive.recalc();
        });
    });

    $('#profit_rate_search').on('change', function() {
                 table_inventory_inside.DataTable().ajax.reload()
                .columns.adjust()
                .responsive.recalc();
      });

    $('#warehouse_filter').on('change', function() {
                 table_inventory_inside.DataTable().ajax.reload()
                .columns.adjust()
                .responsive.recalc();
      });




})(jQuery);

</script>