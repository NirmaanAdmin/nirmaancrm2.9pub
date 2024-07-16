(function(){
  "use strict";
  appValidateForm($('#add_workplace_assign'), {
   'staffid[]': 'required'
 })
  var fnServerParams = {

  }
  initDataTable('.table-workplace_assign', admin_url + 'timesheets/table_workplace_assign', [0], [0], fnServerParams, [1, 'desc']);
})(jQuery);

function new_workplace_assign(){
  'use strict';
  $('#workplace_assign select[name="staffid[]"]').val('').change();
  $('#workplace_assign select[name="workplace_id"]').val('').change();
  $('#workplace_assign').modal('show');
  $('.edit-title').addClass('hide');
  $('.add-title').removeClass('hide');
}

function edit_workplace_assign(invoker){
  'use strict';
  $('#workplace_assign select[name="staffid[]"]').val([$(invoker).data('staffid')]).change();
  $('#workplace_assign select[name="workplace_id"]').val($(invoker).data('workplace_id')).change();
  $('#workplace_assign').modal('show');
  $('.add-title').addClass('hide');
  $('.edit-title').removeClass('hide');
}

function staff_bulk_actions(){
  "use strict";
  $('#product-workplace_assign').modal('show');
}

function checked_add(el){
    var id = $(el).data("id");
    var id_product = $(el).data("product");
    if ($(".wp-assign").length == $(".wp-assign:checked").length) {
        $("#mass_select_all").attr("checked", "checked");
        var value = $("input[name='check_id']").val();
        if(value != ''){
          value = value + ',' + id;
        }else{
          value = id;
        }
    } else {
        $("#mass_select_all").removeAttr("checked");
        var value = $("input[name='check_id']").val();
        var arr_val = value.split(',');
        if(arr_val.length > 0){
          $.each( arr_val, function( key, value ) {
            if(value == id){
              arr_val.splice(key, 1);
              value = arr_val.toString();
              $("input[name='check_id']").val(value);
            }
          });
        }
    }
    if($(el).is(':checked')){
      var value = $("input[name='check_id']").val();
      if(value != ''){
        value = value + ',' + id;
      }else{
        value = id;
      }
      $("input[name='check_id']").val(value);
    }else{
      var value = $("input[name='check_id']").val();
      var arr_val = value.split(',');
      if(arr_val.length > 0){
        $.each( arr_val, function( key, value ) {
          if(value == id){
            arr_val.splice(key, 1);
            value = arr_val.toString();
            $("input[name='check_id']").val(value);
          }
        });
      }
    }
}