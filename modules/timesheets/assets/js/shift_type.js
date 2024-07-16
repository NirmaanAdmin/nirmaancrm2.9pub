(function(){
  "use strict";
  
  var fnServerParams = {
  }

  initDataTable('.table-shift_type', admin_url + 'timesheets/table_shift_type', false, false, fnServerParams, [0, 'desc']);

    appValidateForm($('#shift_type'), {
           'shift_type_name': 'required',
           'color': 'required',
           'time_start': 'required',
           'time_end': 'required',
           'time_start_work': 'required',
           'time_end_work': 'required',
          
  })
})(jQuery);

function new_shift_type(){
  "use strict";

		$('input[name="id"]').val('');
		$('input[name="shift_type_name"]').val('');
    $('.colorpicker-input').colorpicker('setValue', '');
		$('input[name="time_start"]').val('');
		$('input[name="time_end"]').val('');
		$('input[name="time_start_work"]').val('');
		$('input[name="time_end_work"]').val('');
		$('input[name="start_lunch_break_time"]').val('');
		$('input[name="end_lunch_break_time"]').val('');
		$('textarea[name="description"]').val('');
    $('.edit-title').addClass('hide');
    $('.add-title').removeClass('hide');
    $('#shift').modal('show');
}

function edit_shift_type(invoker){
  "use strict";
  
    $('input[name="id"]').val($(invoker).data('id'));
		$('input[name="shift_type_name"]').val($(invoker).data('shift_type_name'));
    $('.colorpicker-input').colorpicker('setValue', $(invoker).data('color'));
		$('input[name="time_start"]').val($(invoker).data('time_start'));
		$('input[name="time_end"]').val($(invoker).data('time_end'));
		$('input[name="time_start_work"]').val($(invoker).data('time_start_work'));
		$('input[name="time_end_work"]').val($(invoker).data('time_end_work'));
		$('input[name="start_lunch_break_time"]').val($(invoker).data('start_lunch_break_time'));
		$('input[name="end_lunch_break_time"]').val($(invoker).data('end_lunch_break_time'));
		$('textarea[name="description"]').val($(invoker).data('description'));

    $('.add-title').addClass('hide');
    $('.edit-title').removeClass('hide');
    $('#shift').modal('show');
}