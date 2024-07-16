<script>
	var salesChart;
	var groupsChart;
	var paymentMethodsChart;
	var customersTable;
	var report_from = $('input[name="report-from"]');
	var report_to = $('input[name="report-to"]');

	var report_leave_statistics = $('#leave-statistics');

	var date_range = $('#date-range');
	var report_from_choose = $('#report-time');
	var fnServerParams = {
		"report_months": '[name="months-report"]',
		"report_from": '[name="report-from"]',
		"report_to": '[name="report-to"]',
		"role_filter": "[name='role[]']",
		"department_filter": "[name='department[]']",
		"staff_filter": "[name='staff[]']",
		"rel_type": "[name='rel_type[]']",
		"months_filter": "[name='months-report']",
		"year_requisition": "[name='year_requisition']",

		"staff_fillter": "[name='staff_fillter']",
		"months_2_report": "[name='months_2_report']",



		"staff_2_fillter": "[name='staff_2_fillter[]']",
		"roles_2_fillter": "[name='roles_2_fillter[]']",
		"department_2_fillter": "[name='department_2_fillter[]']",
		"workplace_2_fillter": "[name='workplace_2_fillter[]']",
		"route_point_2_fillter": "[name='route_point_2_fillter[]']",
		"word_shift_2_fillter": "[name='word_shift_2_fillter[]']",
		"type_2_fillter": '[name="type_2_fillter"]',
		"type_22_fillter": '[name="type_22_fillter"]',
	};
	(function(){
		"use strict";
		init_datepicker();
		report_from.on('change', function() {
			var val = $(this).val();
			var report_to_val = report_to.val();
			if (val != '') {
				report_to.attr('disabled', false);
				if (report_to_val != '') {
					gen_reports();
				}
			} else {
				report_to.attr('disabled', true);
			}
		});

		report_to.on('change', function() {
			var val = $(this).val();
			if (val != '') {
				gen_reports();
			}
		});

		$('select[name="months-report"]').on('change', function() {
			var val = $(this).val();
			report_to.attr('disabled', true);
			report_to.val('');
			report_from.val('');
			if (val == 'custom') {
				date_range.addClass('fadeIn').removeClass('hide');
				return;
			} else {
				if (!date_range.hasClass('hide')) {
					date_range.removeClass('fadeIn').addClass('hide');
				}
			}
			gen_reports();
		});
		$('select[name="staff_2_fillter[]"],select[name="department_2_fillter[]"],select[name="workplace_2_fillter[]"],select[name="route_point_2_fillter[]"],select[name="word_shift_2_fillter[]"],select[name="type_2_fillter"],select[name="type_22_fillter"],select[name="roles_2_fillter[]"],select[name="role[]"],select[name="department[]"],select[name="staff[]"],select[name="rel_type[]"],select[name="year_requisition"],select[name="role[]"], select[name="months_2_report"]').on('change', function() {
			gen_reports();
		});
	})(jQuery);
	var current_type = '';
	var list_fillter = {};
	function init_report(e, type) {
		"use strict";
		current_type = type;
		var report_wrapper = $('#report');

		if (report_wrapper.hasClass('hide')) {
			report_wrapper.removeClass('hide');
		}

		$('head title').html($(e).text());
		$('.leave-statistics-gen').addClass('hide');

		report_leave_statistics.addClass('hide');

		report_from_choose.addClass('hide');
		$('#bs-select-2-8').removeClass('hide');
		$('select[name="months-report"]').selectpicker('val', 'this_month');
		report_to.val('');
		report_from.val('');
		$('.reports_fr').addClass('hide');
		$('#report-time').removeClass('hide');
		$('.title_table').text('');
		$('.sorting_table').addClass('hide');
		$('select[name="role[]"]').closest('.col-md-4').removeClass('hide');
		$('select[name="staff[]"]').closest('.col-md-4').removeClass('hide');
		date_range.addClass('hide');
		$('.working-hours-gen').addClass('hide');
		$('.report_of_leave').addClass('hide');
		$('#leave-reports').addClass('hide');
		$('#year_requisition').addClass('hide');
		$('#history_check_in_out').addClass('hide');
		$('#check_in_out_progress_according_to_the_route').addClass('hide');
		$('#general_public_report').addClass('hide');
		$('.leave_by_department').addClass('hide');
		$('.ratio_check_in_out_by_workplace').addClass('hide');

		$('#report-time').addClass('hide');
		$('#requisition_report').addClass('hide');

		$('.rel-type-fillter').addClass('hide');
		$('.working-hours-gen').addClass('hide');
		$('#leave-reports').addClass('hide');
		$('#report_the_employee_quitting').addClass('hide');
		$('#list_of_employees_with_salary_change').addClass('hide');
		$('.table-fillter').addClass('col-md-4').removeClass('col-md-3');
		$('.sorting_2_table').addClass('hide');
		$('.filter_fr_2').addClass('hide').removeClass('col-md-4').addClass('col-md-3');
		$('#report-month').addClass('hide');

		if(type == 'working_hours'){
			$('.working-hours-gen').removeClass('hide');
			$('#report-time').removeClass('hide');
		} 
		else if(type == 'annual_leave_report'){
			$('.sorting_table').removeClass('hide');
			$('#leave-reports').removeClass('hide');
			$('#year_requisition').removeClass('hide');
		} 
		else if(type == 'general_public_report'){   
			$('.sorting_table').removeClass('hide');
			$('#general_public_report').removeClass('hide');
			$('#report-time').removeClass('hide');
		}
		else if(type == 'requisition_report'){
			$('.sorting_table').removeClass('hide');
			$('#requisition_report').removeClass('hide');
			$('#report-time').removeClass('hide');   
			$('.table-fillter').addClass('col-md-3').removeClass('col-md-4');
			$('.rel-type-fillter').removeClass('hide');
		} 
		else if(type == 'history_check_in_out'){
			$('.filter_fr_2').removeClass('hide');
			$('#report-time').removeClass('hide');   
			$('.sorting_2_table').removeClass('hide');
			$('#history_check_in_out').removeClass('hide');
		}  
		else if(type == 'check_in_out_progress_according_to_the_route'){
			$('.department_2_fr').removeClass('hide');
			$('.staff_2_fr').removeClass('hide');
			$('.route_point_2_fr').removeClass('hide');
			$('.roles_2_fr').removeClass('hide');

			$('.sorting_2_table').removeClass('hide');
			$('#check_in_out_progress_according_to_the_route').removeClass('hide');
			$('#report-month').removeClass('hide');
			$('#year_requisition').removeClass('hide');
		} 
		else if(type == 'check_in_out_progress'){
			$('.department_2_fr').removeClass('hide');
			$('.staff_2_fr').removeClass('hide');
			$('.type_22_fr').removeClass('hide');
			$('.roles_2_fr').removeClass('hide');
			$('.type_22_fr').removeClass('hide');
			$('.sorting_2_table').removeClass('hide');

			$('#check_in_out_progress_according_to_the_route').removeClass('hide');
			$('#report-month').removeClass('hide');
			$('#year_requisition').removeClass('hide');
		} 
		else if(type == 'report_of_leave'){
			$('.report_of_leave').removeClass('hide');
			$('select[name="months-report"]').selectpicker('refresh');
			$('#bs-select-2-8').addClass('hide');
			$('#report-time').removeClass('hide');
		} 
		else if(type == 'leave_by_department'){
			$('.leave_by_department').removeClass('hide');
			$('#report-time').removeClass('hide');
		} 
		else if(type == 'ratio_check_in_out_by_workplace'){
			$('.ratio_check_in_out_by_workplace').removeClass('hide');
			$('#report-time').removeClass('hide');
		} 
		gen_reports();
	}


	function report_by_working_hours() {
		"use strict";
		if (typeof(groupsChart) !== 'undefined') {
			groupsChart.destroy();
		}
		var data = {};
		data.months_report = $('select[name="months-report"]').val();
		data.report_from = report_from.val();
		data.report_to = report_to.val();


		$.post(admin_url + 'timesheets/report_by_working_hours', data).done(function(response) {
			response = JSON.parse(response);
			 //get data for hightchart
			 Highcharts.setOptions({
			 	chart: {
			 		style: {
			 			fontFamily: 'inherit !important',
			 			fill: 'black'
			 		}
			 	},
			 	colors: [ '#119EFA','#ef370dc7','#15f34f','#791db2d1', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263','#6AF9C4','#50B432','#0d91efc7','#ED561B']
			 });
			 Highcharts.chart('working-hours-gen', {
			 	chart: {
			 		type: 'column'
			 	},
			 	title: {
			 		text: '<?php echo _l('working_hours'); ?>'
			 	},
			 	credits: {
			 		enabled: false
			 	},
			 	xAxis: {
			 		categories: response.categories,
			 		crosshair: true
			 	},
			 	yAxis: {
			 		min: 0,
			 		title: {
			 			text: ''
			 		}
			 	},
			 	tooltip: {
			 		headerFormat: '<span class="fontsize10">{point.key}</span><table>',
			 		pointFormat: '<tr><td style="color:{series.color};" class="padding0">{series.name}: </td>' +
			 		'<td class="padding0"><b>{point.y:.1f}</b></td></tr>',
			 		footerFormat: '</table>',
			 		shared: true,
			 		useHTML: true
			 	},
			 	plotOptions: {
			 		column: {
			 			pointPadding: 0.2,
			 			borderWidth: 0
			 		}
			 	},
			 	series: [ {
			 		name: '<?php echo _l('total_work_hours'); ?>',
			 		data: response.total_work_hours

			 	}, {
			 		name: '<?php echo _l('total_work_hours_approved'); ?>',
			 		data: response.total_work_hours_approved

			 	}]
			 });
			 

			});
	}

	function report_of_leave() {
		"use strict";
		if (typeof(groupsChart) !== 'undefined') {
			groupsChart.destroy();
		}
		var data = {};
		data.months_report = $('select[name="months-report"]').val();
		data.report_from = report_from.val();
		data.report_to = report_to.val();


		$.post(admin_url + 'timesheets/report_of_leave', data).done(function(response) {
			response = JSON.parse(response);
			 //get data for hightchart
			 Highcharts.setOptions({
			 	chart: {
			 		style: {
			 			fontFamily: 'inherit !important',
			 			fill: 'black'
			 		}
			 	},
			 	colors: [ '#119EFA','#ef370dc7','#15f34f','#791db2d1', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263','#6AF9C4','#50B432','#0d91efc7','#ED561B']
			 });
			 Highcharts.chart('report_of_leave', {
			 	chart: {
			 		type: 'column'
			 	},
			 	title: {
			 		text: '<?php echo _l('report_of_leave'); ?>'
			 	},
			 	credits: {
			 		enabled: false
			 	},
			 	xAxis: {
			 		categories: response.categories,
			 		crosshair: true
			 	},
			 	yAxis: {
			 		min: 0,
			 		title: {
			 			text: ''
			 		}
			 	},
			 	tooltip: {
			 		headerFormat: '<span class="fontsize10">{point.key}</span><table>',
			 		pointFormat: '<tr><td style="color:{series.color};" class="padding0">{series.name}: </td>' +
			 		'<td class="padding0"><b>{point.y:.1f}</b></td></tr>',
			 		footerFormat: '</table>',
			 		shared: true,
			 		useHTML: true
			 	},
			 	plotOptions: {
			 		column: {
			 			pointPadding: 0.2,
			 			borderWidth: 0
			 		}
			 	},
			 	series: response.series
			 });


			});
	}

	function leave_by_department() {
		"use strict";
		if (typeof(groupsChart) !== 'undefined') {
			groupsChart.destroy();
		}
		var data = {};
		data.months_report = $('select[name="months-report"]').val();
		data.report_from = report_from.val();
		data.report_to = report_to.val();


		$.post(admin_url + 'timesheets/leave_by_department', data).done(function(response) {
			response = JSON.parse(response);
			 //get data for hightchart
			 Highcharts.setOptions({
			 	chart: {
			 		style: {
			 			fontFamily: 'inherit !important',
			 			fill: 'black'
			 		}
			 	},
			 	colors: [ '#119EFA','#ef370dc7','#15f34f','#791db2d1', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263','#6AF9C4','#50B432','#0d91efc7','#ED561B']
			 });
			 Highcharts.chart('leave_by_department', {
			 	chart: {
			 		type: 'column'
			 	},
			 	title: {
			 		text: '<?php echo _l('leave_by_department'); ?>'
			 	},
			 	credits: {
			 		enabled: false
			 	},
			 	xAxis: {
			 		categories: response.categories,
			 		crosshair: true
			 	},
			 	yAxis: {
			 		min: 0,
			 		title: {
			 			text: ''
			 		}
			 	},
			 	tooltip: {
			 		headerFormat: '<span class="fontsize10">{point.key}</span><table>',
			 		pointFormat: '<tr><td style="color:{series.color};" class="padding0">{series.name}: </td>' +
			 		'<td class="padding0"><b>{point.y:.1f}</b></td></tr>',
			 		footerFormat: '</table>',
			 		shared: true,
			 		useHTML: true
			 	},
			 	plotOptions: {
			 		column: {
			 			pointPadding: 0.2,
			 			borderWidth: 0
			 		}
			 	},
			 	series: response.series
			 });


			});
	}

	function ratio_check_in_out_by_workplace() {
		"use strict";
		if (typeof(groupsChart) !== 'undefined') {
			groupsChart.destroy();
		}
		var data = {};
		data.months_report = $('select[name="months-report"]').val();
		data.report_from = report_from.val();
		data.report_to = report_to.val();


		$.post(admin_url + 'timesheets/ratio_check_in_out_by_workplace', data).done(function(response) {
			response = JSON.parse(response);
			 //get data for hightchart
			 Highcharts.setOptions({
			 	chart: {
			 		style: {
			 			fontFamily: 'inherit !important',
			 			fill: 'black'
			 		}
			 	},
			 	colors: [ '#119EFA','#ef370dc7','#15f34f','#791db2d1', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263','#6AF9C4','#50B432','#0d91efc7','#ED561B']
			 });
			 Highcharts.chart('ratio_check_in_out_by_workplace', {
			 	chart: {
			 		type: 'column'
			 	},
			 	title: {
			 		text: '<?php echo _l('ratio_check_in_out_by_workplace'); ?>'
			 	},
			 	credits: {
			 		enabled: false
			 	},
			 	xAxis: {
			 		categories: response.categories,
			 		crosshair: true
			 	},
			 	yAxis: {
			 		min: 0,
			 		title: {
			 			text: ''
			 		}
			 	},
			 	tooltip: {
			 		headerFormat: '<span class="fontsize10">{point.key}</span><table>',
			 		pointFormat: '<tr><td style="color:{series.color};" class="padding0">{series.name}: </td>' +
			 		'<td class="padding0"><b>{point.y:.1f}</b></td></tr>',
			 		footerFormat: '</table>',
			 		shared: true,
			 		useHTML: true
			 	},
			 	plotOptions: {
			 		column: {
			 			pointPadding: 0.2,
			 			borderWidth: 0
			 		}
			 	},
			 	series: response.series
			 });


			});
	}
	 // Main generate report function
	 function gen_reports() {
	 	"use strict";
	 	if(current_type != ''){
	 		switch(current_type){
	 			case 'annual_leave_report':
	 			leave_report();
	 			break;  
	 			case 'general_public_report':
	 			general_public_report();
	 			break;  
	 			case 'requisition_report':
	 			requisition_report();
	 			break;  
	 			case 'history_check_in_out':
	 			history_check_in_out_report();
	 			break;  
	 			case 'check_in_out_progress_according_to_the_route':
	 			check_in_out_progress_according_to_the_route_report();
	 			break;  
	 			case 'check_in_out_progress':
	 			check_in_out_progress_report();
	 			break; 
	 			case 'working_hours':
	 			report_by_working_hours();
	 			break;  
	 			case 'report_of_leave':
	 			report_of_leave();
	 			break;  
	 			case 'leave_by_department':
	 			leave_by_department();
	 			break;  
	 			case 'ratio_check_in_out_by_workplace':
	 			ratio_check_in_out_by_workplace();
	 			break;  
	 		}
	 	}
	 }



	 function leave_report(){
	 	"use strict";
	 	$('.title_table').text('<?php echo _l('annual_leave_report'); ?>');
	 	if ($.fn.DataTable.isDataTable('.table-leave-report')) {
	 		$('.table-leave-report').DataTable().destroy();
	 	} 
	 	initDataTable('.table-leave-report', admin_url + 'timesheets/leave_reports', false, false, fnServerParams, [0, 'desc']);
	 }
	 function general_public_report(){
	 	"use strict";
	 	$('.title_table').text('<?php echo _l('general_public_report'); ?>');
	 	if ($.fn.DataTable.isDataTable('.table-general_public_report')) {
	 		$('.table-general_public_report').DataTable().destroy();
	 	} 
	 	initDataTable('.table-general_public_report', admin_url + 'timesheets/general_public_report', false, false, fnServerParams, [0, 'desc']);
	 }
	 function report_the_employee_quitting(){
	 	"use strict";
	 	$('.title_table').text('<?php echo _l('report_the_employee_quitting'); ?>');
	 	if ($.fn.DataTable.isDataTable('.table-report_the_employee_quitting')) {
	 		$('.table-report_the_employee_quitting').DataTable().destroy();
	 	} 
	 	initDataTable('.table-report_the_employee_quitting', admin_url + 'timesheets/report_the_employee_quitting', false, false, fnServerParams, [0, 'desc']);
	 }

	 function list_of_employees_with_salary_change(){ 
	 	"use strict";
	 	$('.title_table').text('<?php echo _l('list_of_employees_with_salary_change'); ?>');
	 	if ($.fn.DataTable.isDataTable('.table-list_of_employees_with_salary_change')) {
	 		$('.table-list_of_employees_with_salary_change').DataTable().destroy();
	 	} 
	 	initDataTable('.table-list_of_employees_with_salary_change', admin_url + 'timesheets/list_of_employees_with_salary_change', false, false, fnServerParams, [0, 'desc']);
	 }
	 function attendance_report(){
	 	"use strict";
	 	$('.title_table').text('<?php echo _l('attendance_report'); ?>');
	 	if ($.fn.DataTable.isDataTable('.table-attendance_report')) {
	 		$('.table-attendance_report').DataTable().destroy();
	 	} 
	 	initDataTable('.table-attendance_report', admin_url + 'timesheets/attendance_report', false, false, fnServerParams, [0, 'desc']);
	 }
	 function requisition_report(){
	 	"use strict";
	 	$('.title_table').text('<?php echo _l('manage_requisition_report'); ?>');
	 	if ($.fn.DataTable.isDataTable('.table-requisition_report')) {
	 		$('.table-requisition_report').DataTable().destroy();
	 	} 
	 	initDataTable('.table-requisition_report', admin_url + 'timesheets/requisition_report', false, false, fnServerParams, [0, 'desc']);
	 }
	 function history_check_in_out_report(){
	 	"use strict";
	 	$('.title_table').text('<?php echo _l('history_check_in_out'); ?>');
	 	if ($.fn.DataTable.isDataTable('.table-history_check_in_out_report')) {
	 		$('.table-history_check_in_out_report').DataTable().destroy();
	 	} 
	 	initDataTable('.table-history_check_in_out_report', admin_url + 'timesheets/history_check_in_out_report', false, false, fnServerParams, [0, 'desc']);
	 }
	 function check_in_out_progress_according_to_the_route_report(){
	 	"use strict";
	 	$('#check_in_out_progress_according_to_the_route').html('<table class="table table-check_in_out_progress_according_to_the_route_report scroll-responsive"><thead><tr></tr></thead><tbody></tbody><tfoot><tr></tr></tfoot></table>');
	 	$('.title_table').text('<?php echo _l('check_in_out_progress_according_to_the_route'); ?>');
	 	var table = $('table.table-check_in_out_progress_according_to_the_route_report');
	 	$.get(admin_url+'timesheets/get_header_report_check_in_out/'+$('select[name="months_2_report"]').val()+'/'+$('select[name="year_requisition"]').val()).done(function(response){
	 		response = JSON.parse(response);
	 		table.find('thead tr').html(response.col_header);
	 		table.find('tfoot tr').html(response.col_footer);
	 		table.find('tbody').html('');
	 		list_fillter = response.list_fillter;
	 		initDataTable(table, admin_url + 'timesheets/check_in_out_progress_according_to_the_route_report', false, list_fillter , fnServerParams, [0, 'desc']);
	 	});
	 }
	 function check_in_out_progress_report(){
	 	"use strict";
	 	$('#check_in_out_progress_according_to_the_route').html('<table class="table table-check_in_out_progress_report scroll-responsive"><thead><tr></tr></thead><tbody></tbody><tfoot><tr></tr></tfoot></table>');
	 	$('.title_table').text('<?php echo _l('check_in_out_progress'); ?>');
	 	var table = $('table.table-check_in_out_progress_report');
	 	$.get(admin_url+'timesheets/get_header_report_check_in_out/'+$('select[name="months_2_report"]').val()+'/'+$('select[name="year_requisition"]').val()).done(function(response){
	 		response = JSON.parse(response);
	 		table.find('thead tr').html(response.col_header);
	 		table.find('tfoot tr').html(response.col_footer);
	 		table.find('tbody').html('');
	 		list_fillter = response.list_fillter;
	 		initDataTable(table, admin_url + 'timesheets/check_in_out_progress_report', false, list_fillter , fnServerParams, [0, 'desc']);
	 	});
	 }
	</script>
