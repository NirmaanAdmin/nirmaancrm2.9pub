(function(){
	"use strict";
	appValidateForm($('#add_route_point'), {
		'name': 'required',
		'route_point_address': 'required',
		'latitude': 'required',
		'distance': 'required',
		'longitude': 'required'
	})
	var table_route_point = $('table.table-table_route_point');	
	var  serverParams = {
		"customer_fillter": "[name='customer_fillter[]']",
		"workplace_fillter": "[name='workplace_fillter[]']"
	};
	initDataTable(table_route_point,admin_url + 'timesheets/table_route_point', [0], [0], serverParams, [1, 'desc']); 

	$('select[name="related_id"], select[name="related_id2"]').change(function() {
		var related_to = $('#route_point select[name="related_to"]').val();
		var related_id = '';
		if(related_to == 1){
 		// Related customer
 		related_id = $('#route_point select[name="related_id"]').val();
 	}
 	if(related_to == 2){
 		// Related workplace
 		related_id = $('#route_point select[name="related_id2"]').val();
 	}
 	if(related_id != ''){
 		$('#route_point button[type="submit"]').attr('disabled', 'disabled');
 		var data={};
 		data.related_id = related_id;
 		data.related_to = related_to;
 		$.post(admin_url+'timesheets/get_data_relate',data).done(function(response){
 			response = JSON.parse(response);
 			$('#route_point button[type="submit"]').removeAttr('disabled');
 			if(is_update == false){
 				$('#route_point textarea[name="route_point_address"]').val(response.route_point_address);
 				$('#route_point input[name="latitude"]').val(response.latitude);
 				$('#route_point input[name="longitude"]').val(response.longitude);
 				$('#route_point input[name="distance"]').val(response.distance);
 			}
 			is_update = false;
 		});
 	}  
 });
	$('select[name="customer_fillter[]"], select[name="workplace_fillter[]"]').on('change', function(){
		table_route_point.DataTable().ajax.reload()
		.columns.adjust()
		.responsive.recalc();
	})
})(jQuery);
var is_update = false;
/**
 * new route_point
 */
 function new_route_point(){
 	'use strict';
 	$('#route_point input[name="id"]').val('');
 	$('#route_point input[name="name"]').val('');
 	$('#route_point textarea[name="route_point_address"]').val('');
 	$('#route_point input[name="latitude"]').val('');
 	$('#route_point input[name="longitude"]').val('');

 	$('#route_point select[name="related_to"]').selectpicker('refresh');
 	$('#route_point select[name="related_to"]').val(3).change();
 	get_ui_relate();
 	$('#route_point').modal('show');
 	$('.edit-title').addClass('hide');
 	$('.add-title').removeClass('hide');
 }
/**
 * edit route_point 
 */
 function edit_route_point(invoker,id){
 	'use strict';
 	$('#route_point input[name="id"]').val($(invoker).data('id'));
 	$('#route_point input[name="name"]').val($(invoker).data('name'));
 	$('#route_point select[name="related_to"]').val($(invoker).data('related_to')).change();
 	if($(invoker).data('related_to') == 1){
 		$('#route_point select[name="related_id"]').val($(invoker).data('related_id')).change();
 	}
 	else{
 		$('#route_point select[name="related_id2"]').val($(invoker).data('related_id')).change();
 	}
 	$('#route_point textarea[name="route_point_address"]').val($(invoker).data('route_point_address'));
 	$('#route_point input[name="latitude"]').val($(invoker).data('latitude'));
 	$('#route_point input[name="longitude"]').val($(invoker).data('longitude'));
 	$('#route_point input[name="distance"]').val($(invoker).data('distance'));
 	$('#route_point').modal('show');
 	$('.add-title').addClass('hide');
 	$('.edit-title').removeClass('hide');
 	is_update = true;
 }
/**
 * getLocation
 */
 function get_coordinates() {
 	'use strict';
 	$('#get_coordinates_btn').attr('disabled', 'disabled');
 	var data = {};
 	data.address = $('textarea[name="route_point_address"]').val();
 	$.post(admin_url+'timesheets/get_coordinate',data).done(function(response){
 		response = JSON.parse(response);
 		$('#get_coordinates_btn').removeAttr('disabled'); 		
 		$('#route_point input[name="latitude"]').val(response.lat);
 		$('#route_point input[name="longitude"]').val(response.lng);
 	});
 }

 /**
 * get ui relate
 * @param object el 
 */
 function get_ui_relate(){
 	'use strict';
 	$('#route_point select[name="related_id"]').val('').change();
 	$('#route_point select[name="related_id2"]').val('').change();
 	$('#route_point textarea[name="route_point_address"]').val('');
 	$('#route_point input[name="latitude"]').val('');
 	$('#route_point input[name="longitude"]').val('');
 	$('#route_point input[name="distance"]').val('');
 	var type = $('#route_point select[name="related_to"]').val();
 	var validate = {
 		'name': 'required',
 		'route_point_address': 'required',
 		'latitude': 'required',
 		'distance': 'required',
 		'longitude': 'required'
 	};
 	switch(type){
 		case '1':
 		$('#route_point .related_client').removeClass('hide');
 		$('#route_point .related_workplace').addClass('hide');
 		$('#route_point .select_related').removeClass('col-md-12').addClass('col-md-6');
 		validate = {
 			'name': 'required',
 			'route_point_address': 'required',
 			'latitude': 'required',
 			'distance': 'required',
 			'related_id': 'required',
 			'longitude': 'required'
 		};
 		break;
 		case '2':
 		$('#route_point .related_client').addClass('hide');
 		$('#route_point .related_workplace').removeClass('hide');
 		$('#route_point .select_related').removeClass('col-md-12').addClass('col-md-6');
 		validate = {
 			'name': 'required',
 			'route_point_address': 'required',
 			'latitude': 'required',
 			'distance': 'required',
 			'related_id2': 'required',
 			'longitude': 'required'
 		};
 		break;
 		default:
 		$('#route_point .select_related').removeClass('col-md-6').addClass('col-md-12');
 		$('#route_point .related_client').addClass('hide');
 		$('#route_point .related_workplace').addClass('hide');
 	}
 	appValidateForm($('#add_route_point'), validate);
 }

 function check_route_ppoint_name(el){
 	$('#add_route_point button[type="submit"]').attr('disabled', 'disabled');
 	var name = $(el).val();
 	var id = $('#add_route_point input[name="id"]').val();
 	var data = {};
 	data.name = name;
 	data.id = id;
 	$.post(admin_url+'timesheets/check_route_point_name',data).done(function(response){
 		response = JSON.parse(response);
 		$(el).parent().find('#name-duplicate-error').remove();
 		if(response.result == true) {
 			$(el).parent().append('<p id="name-duplicate-error" class="text-danger">'+response.message+'</p>');
 		}
 		else{
 			$('#add_route_point button[type="submit"]').removeAttr('disabled');
 		}
 	});
 }