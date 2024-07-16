<script>
  "use strict";
  var setHeader = <?php echo html_entity_decode($day_by_month); ?>;
  var setColumn = <?php echo html_entity_decode($list_data); ?>;
  var dataObject = <?php echo json_encode($data_object); ?>;
  var data_color = <?php echo json_encode($data_color); ?>;      
(function(){
  "use strict";

  var hotElement = document.querySelector('#example');
  var hotElementContainer = hotElement.parentNode;
  var hotSettings = { 
    data: dataObject,
    columns: setColumn,
    licenseKey: 'non-commercial-and-evaluation',
    stretchH: 'all',
    width: '100%',
    autoWrapRow: true,
    rowHeights: 40,
    colWidths: 170,
    height:600,
    rowHeaders: true,
    cells: function(row, col, prop) {
        var cellProperties = {};
        if (col > 1) {
          cellProperties.renderer = firstRowRenderer; 
        }
        return cellProperties;
      },
    colHeaders: <?php echo html_entity_decode($day_by_month); ?>,
     columnSorting: {
      indicator: true
    },
    autoColumnSize: {
      samplingRatio: 23
    },
    dropdownMenu: true,
    mergeCells: true,
    fixedColumnsLeft: 1,
    contextMenu: true,
    manualRowMove: true,
    manualColumnMove: true,
    fixedColumnsLeft: 2,
    multiColumnSorting: {
      indicator: true
    },
    hiddenColumns: {
          columns: [0],
          indicators: true
        },
    filters: true,
    manualRowResize: true,
    manualColumnResize: true
  };
  var hot = new Handsontable(hotElement, hotSettings);
$('.shift_work_filter').click(function(){
    var data = {};
    data.month = $('input[name="month_timesheets"]').val();
    data.staff = $('select[name="staff_timesheets_s[]"]').val();
    data.department = $('select[name="department_timesheets_s"]').val();
    data.role = $('select[name="role_timesheets_s"]').val();
    $.post(admin_url + 'timesheets/reload_shiftwork_byfilter', data).done(function(response) {
      response = JSON.parse(response);

      var setHeader = response.day_by_month;
      var setColumn = response.list_data;
      var dataObject = response.data_object;

      hot.updateSettings({
          data: dataObject,
          columns: setColumn,
          colHeaders: setHeader,
      })
    });
  });

})(jQuery);
function firstRowRenderer(instance, td, row, col, prop, value, cellProperties) {
  "use strict";
  Handsontable.renderers.TextRenderer.apply(this, arguments);
  td.style.background = '#fff';
  td.style.color = data_color[row][cellProperties.prop];
}



</script>