<script>
  var height_window = $(window).height();
  (function(){
    "use strict";
    var data_lack = <?php echo json_encode($data_lack); ?>;
    var dataObject = <?php echo json_encode($staff_row_tk); ?>;
    var dataCol = <?php echo html_entity_decode($set_col_tk); ?>;
    var dataHeader = <?php echo html_entity_decode($day_by_month_tk); ?>;

    var hotElement = document.querySelector('#example');
    var hotElementContainer = hotElement.parentNode;
    var hotSettings = { 
      data: dataObject,
      columns: dataCol,
      licenseKey: 'non-commercial-and-evaluation',
      stretchH: 'all',
      autoWrapRow: true,
      headerTooltips: true,
      minHeight:'100%',
      maxHeight:'500px',
      rowHeaders: true,
      cells: function(row, col, prop) {
        var cellProperties = {};

        if (col > 2) {
          cellProperties.renderer = firstRowRenderer;
          cellProperties.className = 'htCenter htMiddle';
        }
        return cellProperties;
      },

      width: '100%',
      rowHeights: 25,
      height:height_window-280,
      rowHeaders: true,
      colHeaders: dataHeader,
      columnSorting: {
        indicator: true
      },
      dropdownMenu: true,
      mergeCells: true,
      fixedColumnsLeft: 2,
      contextMenu: true,
      multiColumnSorting: {
        indicator: true
      },  
      hiddenColumns: {
        columns: [0],
        indicators: true
      },
      filters: true,
      afterSelection: function(r,c){
        var data = {};
        data.value = this.getValue();
        data.ColHeader = this.getColHeader(c);
        data.staffid = hot.getDataAtCell(r, 0);
        if(c > 1){
          show_detail_timesheets(data);
        }
      }
    };
    var hot = new Handsontable(hotElement, hotSettings);

    appValidateForm($('#import-timesheets-form'), {
     file_timesheets: 'required',
   })

    $('.timesheets_filter').on('click', function() {
      var data = {};
      data.month = $("#month_timesheets").val();
      data.staff = $('select[name="staff_timesheets[]"]').val();
      data.department = $('#department_timesheets').val();
      data.job_position = $('#job_position_timesheets').val();

      $.post(admin_url + 'timesheets/reload_timesheets_byfilter', data).done(function(response) {
        response = JSON.parse(response);
        dataObject = response.arr;
        dataCol = response.set_col_tk;
        dataHeader = response.day_by_month_tk;
        data_lack = response.data_lack;
        hot.updateSettings({
          data: dataObject,
          columns: dataCol,
          colHeaders: dataHeader,
        })
        $('input[name="month"]').val(response.month);
        if(response.check_latch_timesheet){
          $('#btn_unlatch').removeClass('hide');
          $('#btn_latch').addClass('hide');
          $('.edit_timesheets').addClass('hide');
          $('.exit_edit_timesheets').addClass('hide');
          $('.save_time_sheet').addClass('hide');
        }else{
          $('#btn_latch').removeClass('hide');
          $('#btn_unlatch').addClass('hide');
          $('.edit_timesheets').removeClass('hide');
          $('.exit_edit_timesheets').addClass('hide');
          $('.save_time_sheet').addClass('hide');
        }
      });
    });
    $('.save_time_sheet').on('click', function() {
     $('input[name="time_sheet"]').val(JSON.stringify(hot.getData()));
   });

    $('.latch_time_sheet').on('click', function() {
     $('input[name="latch"]').val(1);
     $('input[name="time_sheet"]').val(JSON.stringify(hot.getData()));
   });

    $('.unlatch_time_sheet').on('click', function() {
     $('input[name="unlatch"]').val(1);
     $('input[name="month"]').val($("#month_timesheets").val());
   });

    $('.edit_timesheets').on('click', function() {
     $('input[name="is_edit"]').val(1);
     $('.latch_time_sheet').addClass('hide');
     $('.edit_timesheets').addClass('hide');
     $('.exit_edit_timesheets').removeClass('hide');
     $('.save_time_sheet').removeClass('hide');
   });

    $('.exit_edit_timesheets').on('click', function() {
     $('input[name="is_edit"]').val(0);
     $('.latch_time_sheet').removeClass('hide');
     $('.edit_timesheets').removeClass('hide');
     $('.exit_edit_timesheets').addClass('hide');
     $('.save_time_sheet').addClass('hide');
   });
    $('.export_excel').click(function(){
     var data = {};
     data.month = $('input[name="month_timesheets"]').val();
     data.department = $('select[name="department_timesheets"]').val();
     data.role = $('select[name="job_position_timesheets"]').val();
     data.staff = $('select[name="staff_timesheets[]"]').val();
     $.post(admin_url+'timesheets/export_attendance_excel', data).done(function(response){
      response = JSON.parse(response);
      window.location.href = response.site_url+response.filename;
    });
   });
    $(window).load(function() {
      var d = new Date();
      var month = new Array();
      month[0] = "01";
      month[1] = "02";
      month[2] = "03";
      month[3] = "04";
      month[4] = "05";
      month[5] = "06";
      month[6] = "07";
      month[7] = "08";
      month[8] = "09";
      month[9] = "10";
      month[10] = "11";
      month[11] = "12";
      $('#month_timesheets').val(d.getFullYear()+'-'+month[d.getMonth()]);
    });
  })(jQuery);


  function firstRowRenderer(instance, td, row, col, prop, value, cellProperties) {
   "use strict";
   Handsontable.renderers.TextRenderer.apply(this, arguments);

 }
 function firstRowRenderer_2(instance, td, row, col, prop, value, cellProperties) {
   "use strict";
   Handsontable.renderers.TextRenderer.apply(this, arguments);
   td.style.fontWeight = 'bold';

 }

 function show_detail_timesheets(data){
   "use strict";
   if($('input[name="is_edit"]').val() == 0){
    var month = $("#month_timesheets").val();
    if(typeof month == 'undefined'){
      month = $('input[name="current_month"]').val();
    }
    data.month = month;
    $.post(admin_url + 'timesheets/show_detail_timesheets', data).done(function(response) {
      response = JSON.parse(response);
      $('#title_detail').html(response.title);
      $('#ul_timesheets_detail_modal').html('');
      $('#ul_timesheets_detail_modal').append(response.html);
      $('#timesheets_detail_modal').modal('show');
    });
  }
}

function import_timesheets(){
  "use strict";
  $('#timesheets_detail_modal').modal('show');
}
</script>