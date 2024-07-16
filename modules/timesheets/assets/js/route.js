(function(){
	"use strict";
	appValidateForm($('#add_route'), {
		'staffid': 'required',
		'route_point[]': 'required',
	})
	var table_route = $('table.table-table_route');	
	var  serverParams = {

	};
	initDataTable(table_route,admin_url + 'timesheets/table_route', [0], [0], serverParams, [1, 'desc']); 
})(jQuery);
/**
 * new route
 */
 function new_route(){
 	'use strict';
 	$('#route input[name="id"]').val('');
 	$('#route input[name="name"]').val('');
 	$('#route textarea[name="route_address"]').val('');
 	$('#route input[name="latitude"]').val('');
 	$('#route input[name="longitude"]').val('');

 	$('#route select[name="related_to"]').selectpicker('refresh');
 	$('#route select[name="related_id"]').selectpicker('refresh');
 	$('#route select[name="related_id2"]').selectpicker('refresh');

 	$('#route').modal('show');
 	$('.edit-title').addClass('hide');
 	$('.add-title').removeClass('hide');
 }

/**
 * edit route 
 */
 function edit_route(invoker,id){
 	'use strict';
 	$('#route input[name="id"]').val($(invoker).data('id'));
 	$('#route input[name="name"]').val($(invoker).data('name'));
 	$('#route textarea[name="route_address"]').val($(invoker).data('route_address'));
 	$('#route input[name="latitude"]').val($(invoker).data('latitude'));
 	$('#route input[name="longitude"]').val($(invoker).data('longitude'));
 	$('#route input[name="distance"]').val($(invoker).data('distance'));

 	$('#route select[name="related_to"]').val($(invoker).data('related_to')).change();
 	if($(invoker).data('related_to') == 1){
 		$('#route select[name="related_id"]').val($(invoker).data('related_id')).change();
 	}
 	else{
 		$('#route select[name="related_id2"]').val($(invoker).data('related_id')).change();
 	}

 	if($(invoker).data('default') == 1){
 		$('#route input[name="default"]').prop('checked', true);
 	}
 	else{
 		$('#route input[name="default"]').prop('checked', false);    
 	}
 	$('#route').modal('show');
 	$('.add-title').addClass('hide');
 	$('.edit-title').removeClass('hide');
 }

 function remove_row(el){
 	'use strict';
 	var list_remove = $('#route_point_table tr .remove_row');
 	if(list_remove.length > 1){
 		$(el).closest('tr').remove();
 	}
 }
