
<script>  
  function myRenderer(instance, td, row, col, prop, value, cellProperties) {
    "use strict";
    Handsontable.renderers.TextRenderer.apply(this, arguments);    
  }

  (function(){
    var hot;
    var setHeader = <?php echo json_encode($header); ?>;
    var dataObject = <?php echo json_encode($data_object); ?>;

    var staff = $('select[name="staff[]"]').val();
    var columns = [];
    "use strict";

    $.each(setHeader, function( index, value ) {
      columns.push({
       data: value,
       width: 250,
       type: 'text',
       readOnly: true                    
     });
    }); 



    var current_row, current_col, staffid, date;
    var hotElement = document.querySelector('#example');
    var hotElementContainer = hotElement.parentNode;
    var hotSettings = {
      data: dataObject,
      columns: columns
      ,
      contextMenu: true,
      manualRowMove: true,
      manualColumnMove: true,
      stretchH: 'all',
      autoWrapRow: true,
      rowHeights: 30,
      defaultRowHeight: 100,
      headerTooltips: true,
      maxRows: 200,
      minHeight:'100%',
      maxHeight:'500px',

      width: '100%',
      height: 1000,

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
      rowHeights: 40,
      columnHeaderHeight: 20,
      minRows: 1,
      rowHeaders: true,
      colHeaders: setHeader,
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
      fixedColumnsLeft: 2,
      filters: true,
      manualRowResize: true,
      manualColumnResize: true,
      afterSelection: function(r,c){
        var data = {};
        if(c  >= 2){
          current_row = r;
          current_col = c;
          staffname = hot.getDataAtCell(r, 1);
          var cell_value = hot.getDataAtCell(r, c);
          var array_route_point = cell_value.split(', ');
          var not_to_be_in_order = true;
          $('#route .remove_row').click();
          for(let i = 0; i < array_route_point.length; i++){
            var select_value = array_route_point[i];
            if(i == 0){
              var obj = get_content_between_character(select_value, '(', ')');
              if($.isNumeric(obj.content)){
                not_to_be_in_order = false;
              }
              $('#route select[name="route_point[]"]:eq(0)').val(select_value).change();
            }
            if(i > 0){
              $('.add_new_row').click();
            }
            if(not_to_be_in_order == true){
              $('#route select[name="route_point[]"]:eq('+i+')').val(select_value).change();
            }
            else{
              // with order
              var obj = get_content_between_character(select_value, '(', ')');              
              $('#route select[name="route_point[]"]:eq('+i+')').val(obj.remain).change();
            }
          }
          if(not_to_be_in_order == true){
            $('#route input[name="not_to_be_in_order"]').prop('checked', true);
          }
          else{
            $('#route input[name="not_to_be_in_order"]').prop('checked', false);            
          }
          $('#route').modal('show');
          $('.add-title').text(staffname);
        }
      }
    };
    hot = new Handsontable(hotElement, hotSettings);


    hot.updateSettings({
      hiddenColumns: {
        columns: [0],
        indicators: true
      },
      cells: function(row, col, prop) {
        var cellProperties = {};
        cellProperties.renderer = myRenderer;
        return cellProperties;
      }
    })  

    $('select[name="staff[]"], input[name="date_fillter"], select[name="route_point_fillter[]"], select[name="department_fillter[]"]').change(function() {
      var staff = $('select[name="staff[]"]').val();
      var date = $('input[name="date_fillter"]').val();
      var route_point = $('select[name="route_point_fillter[]"]').val();
      var department = $('select[name="department_fillter[]"]').val();
      var data = {};
      data.staff = staff;
      data.date = date;
      data.route_point = route_point;
      data.department = department;
      $.post(admin_url+'timesheets/get_ui_create_root',data).done(function(response){
        response = JSON.parse(response);
        columns = [];
        $.each(response.data_header, function( index, value ) {
          columns.push({
           data: value,
           width: 250,
           type: 'text',
           readOnly: true                    
         });
        }); 

        hot.updateSettings({
          columns: columns,
          data: response.data_object,
          colHeaders: response.data_header,
          hiddenColumns: {
            columns: [0],
            indicators: true
          }
        }) 
      });
    });


    $('.save_detail').on('click', function() {
      $('input[name="data_hanson"]').val(JSON.stringify(hot.getData()));
      $('input[name="month"]').val($('input[name="date_fillter"]').val());
    });
    $('table#route_point_table tbody').sortable();    
    
    $('#route .add_new_row').on('click', function() {
      var table = $('#route_point_table tbody');
      var row = table.find('tr:eq(0)').clone();
      row.find('.dropdown-menu.open').remove();
      row.find('button[role="combobox"]').remove();
      row.find('select[name="route_point[]"]').selectpicker('refresh');
      row.find('select[name="route_point[]"]').removeAttr('id');
      table.append(row); 
    });
    $('#route button[type="submit"]').on('click', function() {
      $('#route').modal('hide');
      var not_to_be_in_order = $('input[name="not_to_be_in_order"]').is(":checked");
      if(not_to_be_in_order == true){
        not_to_be_in_order = true;
      }
      else{
        not_to_be_in_order = false;
      }
      var list = $('#route select[name="route_point[]"]');
      var new_result = '';
      for(let i = 0;i < list.length; i++){
        var obj = list.eq(i);
        if(obj.val() != ''){
          new_result += ', '+obj.find('option:selected').text();
          if(not_to_be_in_order == false){
            new_result += ' ('+(i+1)+')';
          }
        }
      }
      if(new_result != ''){
        new_result = $.trim(new_result.replace(/^, /,''));
      }
      hot.setDataAtCell(current_row, current_col, new_result);
    });


  })(jQuery);
  function remove_row(el){
    'use strict';
    var list_remove = $('#route_point_table tr .remove_row');
    if(list_remove.length > 1){
      $(el).closest('tr').remove();
    }
  }
  function get_content_between_character(str, start_char, end_char){
    var start_index = '';
    var end_index = '';
    for (var i = (str.length - 1); i >= 0; i--) {
      if(start_index == ''){
        if(str.charAt(i) == end_char){
          start_index = i;
        }
      }
      else{
        if(str.charAt(i) == start_char){
          end_index = i;
        }
      }
    }
    if(end_index != '' && start_index != ''){
      var obj = {
        content:  str.slice((parseInt(end_index)+1), start_index),
        remain: $.trim(str.slice(0, end_index))
      };
      return obj;
    }
    return '';
  }
</script>