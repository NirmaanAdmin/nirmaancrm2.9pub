(function(){
	"use strict";
	appValidateForm($('#add_type_of_leave-form'), {
		type_name: 'required',
		symbol:  'required'
	});

	$('.add_type_of_leave').on('click', function(){
		var val = $('input[name="type_name"]').val();
		var symbol = $('input[name="symbol"]').val();
		if(val.trim() && symbol.trim()){

			var list_exist_symbol = new Array("AL", "W", "U", "HO", "E", "L", "B", "SI", "M", "ME", "NS", "P");
			let i, duplicate = 0;

			for(i = 0; i<list_exist_symbol.length; i++){
				if(list_exist_symbol[i] == symbol){
					duplicate = 1;
				}
			}

			if(duplicate != 0){
				alert_float('warning', $('input[name="character_already_exists"]').val());
				return false; 
			}
			$('#add_new_type_of_leave').modal('hide');
		}
	});

})(jQuery);

function edit_type_of_leave(el, id){
	$('#add_new_type_of_leave').modal('show');
	$('#add_new_type_of_leave input[name="id"]').val(id);
	$('#add_new_type_of_leave input[name="type_name"]').val($(el).data('type_name'));
	$('#add_new_type_of_leave input[name="symbol"]').val($(el).data('symbol'));
	$('.add-title').addClass('hide');
	$('.edit-title').removeClass('hide');
}
function new_type_leave(){
	$('#add_new_type_of_leave').modal('show');
	$('#add_new_type_of_leave input[name="id"]').val('');
	$('#add_new_type_of_leave input[name="type_name"]').val('');
	$('#add_new_type_of_leave input[name="symbol"]').val('');
	$('.add-title').removeClass('hide');
	$('.edit-title').addClass('hide');
}