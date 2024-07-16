$(function() {
    
	$(document).on('click','[data-click]',function() {
		$this = $(this);
		action = $this.data('click');
		args = $this.data('args');
		if (typeof window[action] === 'function') {
			window[action](this,args);
		}
	});

$(document).on('click','.item-invoices',function(e) {
    e.preventDefault();
    var $itemModal = $('#sales_item_modals');
    $itemModal.find('.add-title').addClass('hide');
    $itemModal.find('.edit-title').removeClass('hide');
    if($('#description').val() == '' || $('#rate').val() == ''){
        console.log('in');
        validate_items_form();
    }else
    var formData = {};
    formData.description = $('#description').val();
    formData.long_description = $('#long_description').val();
    formData.rate = $('#rate').val();
    formData.rate_currency_2 = $('#rate_currency_2').val();
    formData.tax = $('select[name ="tax"]').val();
    formData.tax2 = $('select[name ="tax2"]').val();
    formData.unit = $('#unit').val();
    formData.group_id = $('#group_id').val();
    formData.userid = $('input[name="userid"]').val();
    formData.id = $('input[name="itemid"]').val();
    formData.itemid = $('input[name="itemid"]').val();
    $.ajax({
        type: 'POST',
        data: formData,
        url: admin_url + 'supplier/create_product_and_services',
    }).done(function(response){
        console.log(response);
           response = JSON.parse(response);
            if (response.success) {
                alert_float('success', response.message);
                $($itemModal).modal('hide');
                //location.href = admin_url+'supplier/client/16'+'?tab=product_services';
                

            }

    }).fail(function(error){
        alert_float('danger', JSON.parse(error.responseText));
    });
});
$("body").on('show.bs.modal', '#sales_item_modals', function (event) {
$('.affect-warning').addClass('hide');
    var url;
        var $itemModal = $('#sales_item_modals');
        $('input[name="itemid"]').val('');
        $itemModal.find('input').not('input[type="hidden"]').val('');
        $itemModal.find('textarea').val('');
        $itemModal.find('select').selectpicker('val', '').selectpicker('refresh');
        $('select[name="tax2"]').selectpicker('val', '').change();
        $('select[name="tax"]').selectpicker('val', '').change();
        $itemModal.find('.add-title').removeClass('hide');
        $itemModal.find('.edit-title').addClass('hide');

        var id = $(event.relatedTarget).data('id');
        // If id found get the text from the datatable
        if (typeof (id) !== 'undefined') {
            // $('#invoice_item_form').attr('action', '<?php echo base_url()?>supplier/product_services/items_create/'+id);
            $('.affect-warning').removeClass('hide');
            $('input[name="itemid"]').val(id);
            $itemModal.find('.add-title').addClass('hide');
            $itemModal.find('.edit-title').removeClass('hide');
            $('#item_site_url').val();
            if($('#item_site_url').val() == 1 ){
                url = site_url+'supplier/product_services/edit/' + id;
            }else if($('#item_site_url').val() == 'undefined'){
                url = admin_url+'supplier/edit/' + id;
            }else{
                 url = admin_url+'supplier/edit/' + id;
            }
            $.get(url).done(function (responsed) {
                console.log(responsed);
                var response  = JSON.parse(responsed);
               $('#sales_item_modals').find('input[name="description"]').val(response.description);
                $itemModal.find('textarea[name="long_description"]').val(response.long_description.replace(/(<|<)br\s*\/*(>|>)/g, " "));
                $itemModal.find('input[name="rate"]').val(response.rate);
                $itemModal.find('input[name="unit"]').val(response.unit);
                $('select[name="tax"]').selectpicker('val', response.taxid).change();
                $('select[name="tax2"]').selectpicker('val', response.taxid_2).change();
                $itemModal.find('#group_id').selectpicker('val', response.group_id);
                $.each(response, function (column, value) {
                    if (column.indexOf('rate_currency_') > -1) {
                        $itemModal.find('input[name="' + column + '"]').val(value);
                    }
                });

                $('#custom_fields_items').html(response.custom_fields_html);

                init_selectpicker();
                init_color_pickers();
                init_datepicker();

                $itemModal.find('.add-title').addClass('hide');
                $itemModal.find('.edit-title').removeClass('hide');
                //validate_item_form();
                //$($itemModal).modal('hide');
            });

        }
    });

    $("body").on("hidden.bs.modal", '#sales_item_modals', function (event) {
        $('#item_select').selectpicker('val', '');
    });



});
if (typeof modal !== 'function') {
	modal = function (title,body,footer,args) {
		args = typeof(args) == 'undefined' ? {} : args;
		var close_btn = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
		var modal_title = typeof title === 'undefined'?  'Title': title;
		var modal_body = typeof body === 'undefined'?  'one fine body': body;
		var modal_footer = typeof footer === 'undefined'||footer == '' ? close_btn:close_btn+footer;
		var size = typeof args.size === 'undefined' ? '': args.size;
		var date = new Date();
		var modal_id = 'modal-'+date.getSeconds();
		var modal = '<div class="modal fade" tabindex="-1" role="dialog" id="'+modal_id+'">';
		modal += '<div class="modal-dialog modal-'+size+'">';
		modal +=     '<div class="modal-content">';
		modal +=     	args.form_open !== undefined ? args.form_open : '';
		modal +=       '<div class="modal-header">';
		modal +=         '<h4 class="modal-title pull-left">'+modal_title+'</h4>';
		modal +=		'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
		modal +=       '</div>';
		modal +=       '<div class="modal-body">';
		modal +=       		modal_body;
		modal +=       '</div>';
		modal +=      '<div class="modal-footer">';
		modal +=      		modal_footer;
		modal +=      '</div>';
		modal += 	 typeof args.form_open == 'undefined' ? '' : '</form>';
		modal +=     '</div><!-- /.modal-content -->';
		modal +=   '</div><!-- /.modal-dialog -->';
		modal += '</div><!-- /.modal -->';
		$('body').append(modal);
		$modal = $('#'+modal_id);
		$($modal).modal('show');
		$($modal).on('hidden.bs.modal',function() {
			$(this).remove();
		});
		if (typeof args.callback !== 'undefined') {return args.callback($modal);}
	};
}
if (typeof ajxForm !== 'function') {
	ajxForm = function (form,callback) {
		form = $(form);
		$(form).ajaxForm({
			beforeSend: function() { //brfore sending form
				submitbutton = $(form).find('[type=submit]');
				btnHTML = submitbutton.html();
				submitbutton.attr('disabled', '').html('<i class="fa fa-spinner fa-pulse"></i>'); // disable upload button
			},
			uploadProgress: function(event, position, total, percentComplete) { //on progress
				// do something for upload events
			},
			complete: function(response) { // on complete
				data = JSON.parse(response.responseText);// get json format
				// form.resetForm();  // reset form
				submitbutton.removeAttr('disabled'); //enable submit button
				submitbutton.html(btnHTML);
				return callback(data,form);
			},
			fail:function(response,status,error) {
				data = JSON.parse(response.responseText);// get json format
				submitbutton.removeAttr('disabled'); //enable submit button
				submitbutton.html(btnHTML);
				return callback(data,form);
			}
		});
	};
}
// New call log function, various actions performed
function new_call_log(url, call_log_id) {
    url = typeof(url) != 'undefined' ? url : admin_url + 'calls/call';
    call_log_id = call_log_id !== undefined ? call_log_id : 0;

    var $callEditModal = $('#_call_modal');
    if ($callEditModal.is(':visible')) { $callEditModal.modal('hide'); }
    $.get(url,{'parent_id': call_log_id}).done(function(response) {
        $('#_call_log_edit').html(response);
        $("body").find('#_call_modal').modal({ show: true, backdrop: 'static' });
        $('#_call_modal').on('call-modal-open',function() {
            $(this).find('input[name=end_time]').datetimepicker('destroy');
        });
        if($('#_call_modal').find('#call-form').hasClass('edit-form')) {
        	$('#_call_modal').find('#call-form').removeClass('edit-form');
        }

        $('#_call_modal').trigger('call-modal-open');
    });
}
// Handles call add/edit form modal.
function call_form_handler(form) { 

    var formURL = form.action;
    var formData = new FormData($(form)[0]);

    $.ajax({
        type: $(form).attr('method'),
        data: formData,
        mimeType: $(form).attr('enctype'),
        contentType: false,
        cache: false,
        processData: false,
        url: formURL
    }).done(function(response) {
        response = JSON.parse(response);
        if ($('#accordion[data-followups]').length) {
            $('#accordion[data-followups]').html(response.call_folloups);
        }
        alert_float(response.type, response.message);
        if (!$("body").hasClass('project')) {
            $('#_call_modal').attr('data-task-created', true);
        }
        // if current call modal form
		if ($(form).data('form') === undefined) {
			$('#_call_modal').modal('hide');
		} else {
			// new call modal form
			$('#_call_modal').find('.modal-dialog').removeClass('modal-xl');
			$('#_call_modal .new_form_col').addClass('hidden');
			$('#_call_modal .first_form_col').removeClass('col-md-6').addClass('col-md-12');
			$('.first_form_col').find('.title_heading').text('On Going...');
		}
		// call logs table needs to b refreshed
        $('.table-call-logs').DataTable().ajax.reload();
    }).fail(function(error) {
        alert_float('danger', JSON.parse(error.responseText));
    });

    return false;
}


// Init call logs modal and get data from server
function init_call_modal(call_log_id) {
    var queryStr = '';
    var $callModal = $('#_call_modal_view');
    if ($callModal.is(':visible')) {
        $callModal.modal('hide');
    }
    requestGet('call_logs/get_call_data/' + call_log_id + queryStr).done(function(response) {
        var t = $("#_call_log").html(response);
	    setTimeout(function() {
	        t.find('#_call_modal_view').modal({ show: true, backdrop: 'static' });
	    }, 150);
        
    }).fail(function(data) {
        $('#general_modal').modal('hide');
        alert_float('danger', data.responseText);
    });
}


// Go to call edit view
function edit_call(call_id) {
    requestGet('call_logs/call/' + call_id).done(function(response) {
        $('#_call_log_edit').html(response).find('#_call_modal').modal({ show: true, backdrop: 'static' });
        $('#_call_modal').find('[name=type],[name=start_time],[name=end_time],[name=duration],[name=owner],[name=direction]').prop('disabled',true);
    	$('#_call_log_edit').find('.title_heading').addClass('hidden');
    	$('#_call_modal').find('#call-form').addClass('edit-form');
    	$('#_call_modal').find('button[type=submit]').text('Update');
    });
}
function fill_datetime(selector) {
    $( selector ).val(moment().format('Y-DD-MM HH:mm:ss'));
}
// Convert milliseconds to hours:minutes:seconds i.e. h:m:s
function convertMS(ms) {
    var d, h, m, s;
    s = Math.floor(ms / 1000);
    m = Math.floor(s / 60);
    s = s % 60;
    s = (s < 10) ? '0'+s : s;
    h = Math.floor(m / 60);
    m = m % 60;
    m = (m < 10) ? '0'+m : m;
    d = Math.floor(h / 24);
    h = h % 24;
    h += d * 24;
    h = (h < 10) ? '0'+h : h;
    return h + ':' + m + ':' + s;
}
function calculate_call_duration(form) {
    let start_time = moment($(form).find("input[name=start_time]").val(), 'Y-DD-MM HH:mm:ss');
    let end_time = moment($(form).find("input[name=end_time]").val(), 'Y-DD-MM HH:mm:ss');
    let difference = end_time.diff(start_time);
    return convertMS(difference);
}
// init actions on edit/new call log form
function init_actions_on_form(form) {
	$(form).find("input[name=end_time]").datetimepicker('destroy');
    if ($(form).hasClass('edit-form') === false) {
        fill_datetime($(form).find("input[name=start_time]"));
    }
    _validate_form($(form), {
        clientid: 'required',
        driver_id: 'required',
        caller_name: 'required',
        direction: 'required', 
        purpose_of_call: 'required',
        call_summary: 'required',
        followup: 'required',
        followup_time: {
            required: {
                depends: function() {
                    let followup_required = $(form).find( "input[name=followup]:checked" ).val();
                    if (followup_required === '1')
                        return true; 
                    else return false;
              }
          }
        },
        start_time: 'required',
        end_time: {
	        required: true, 
	        validate_end_time: true
   		},
    	duration: 'required', 
    	owner: 'required'
    },call_form_handler);

    jQuery.validator.addMethod("validate_end_time", function(value, element) {
        let start_time = $(form).find("input[name=start_time]").val();
        let end_time = $(form).find("input[name=end_time]").val();
        return !moment(moment(end_time,'Y-DD-MM HH:mm:ss')).isBefore(moment(start_time,'Y-DD-MM HH:mm:ss'));
    }, "End Time must be greater than Start Time.");
   
    $(form).find("input[name=followup]").on('click', () => {
    	var followupVal = $(form).find("input[name=followup]:checked" ).val();
        if (followupVal == 'no') {
            $(form).find('.followup').hide(200);
            $(form).find('input[name=followup_time],[name=followup_notes]').prop('disabled',true);
        } else { 
        	$(form).find('.followup').show(200);
        	$(form).find('input[name=followup_time],[name=followup_notes]').prop('disabled',false);
        }
    });

    $(form).find("input[name=type]").on('change', () => {
        fill_datetime($(form).find("input[name=start_time]"));
        if ($(form).find("input[name=type]:checked" ).val() == 'current') {
            $(form).find('.current_call').show(200);
            $(form).find("input[name=end_time]").val('');
            $(form).find("input[name=end_time]").attr('readonly', true);
            $(form).find('.btn-hold').show(200);
            $(form).find("input[name=end_time]").datetimepicker('destroy');
            $(form).find("input[name=duration]").val('00:00:00');
        } else {
            $(form).find("input[name=end_time]").attr('readonly', false).datetimepicker({
                defaultDate: new Date(), 
                format: 'Y-d-m H:m:s', 
                sideBySide: true
            });
            $(form).find('.btn-hold').hide(200);
            $(form).find('.current_call').hide(200);
            // $(form).find("input[name=duration]").val(calculate_call_duration(form));
        }
    });

    $(form).find('input[name=caller_type]').on('change', () => {
    	let _input_name = $(form).find('input[name=caller_type]:checked').val();
    	$(form).find('[name=clientid],[name=driver_id],[name=caller_name]').prop('disabled',true);
    	$(form).find('.caller_type').removeClass('show').addClass('hidden');
    	$(form).find('[name='+_input_name+']').closest('.caller_type').removeClass('hidden').addClass('show');

    	if (_input_name == 'driver_id' || _input_name == 'clientid') {
    		$(form).find('[name='+_input_name+']').prop('disabled',false);
    		$(form).find('[name='+_input_name+']').selectpicker('refresh');
    	} else {
    		$(form).find('[name='+_input_name+']').prop('disabled',false);
    	}
    	console.log($(form).find('input[name=caller_type]:checked').val());
    });
    $(form).find('.datetimepicker').datetimepicker({
        defaultDate: new Date(), 
        format: 'Y-d-m H:m:s', 
        sideBySide: true
    });

    $(form).find('[data-name="end_call"]').on('change', (e) => {
        // console.log(moment('2010-21-10 21:55:15', 'Y-DD-MM HH:mm:ss').isBefore(moment('2010-21-10 21:55:16', 'Y-DD-MM HH:mm:ss')));
        if($(form).find('[data-name="end_call"]').is(':checked')) {
            fill_datetime($(form).find("input[name=end_time]"));
            $(form).find("input[name=duration]").val(calculate_call_duration(form));
        }
        else {
            $(form).find("input[name=end_time]").val('');
            $(form).find("input[name=duration]").val('00:00:00');
        }
    });

    $(form).find("input[name=end_time]").on('change', () => {
        $(form).find("input[name=duration]").val(calculate_call_duration(form));
    });

    if ($(form).find('input[name="followup"]:checked').val() == 'no') {
    	$(form).find('.followup').hide();
    	$(form).find('input[name=followup_time],[name=followup_notes]').prop('disabled',true);
    }

    if ($(form).find('.btn_cancel').length) {
        $(form).find('.btn_cancel').on('click',function() {
            fill_datetime($(form).find("input[name=start_time]"));
        });
    }
    init_ajax_search('staff', $(form).find('[name="call_for"].ajax-search'));
    init_ajax_search('customer', $(form).find('[name="clientid"].ajax-search'));
    init_ajax_search('staff', $(form).find('[name="driver_id"].ajax-search'),{'role':'driver'});
}
function new_form_handler(form) {
	
}
function open_import_modal() {
	modal('Import Staff','Loading...','',{
		'callback': (modal) => {
			requestGet('call_logs/get_import_form').done((response) => {
				$(modal).find('.modal-body').html(response);
			});
		}
	});
}
function import_staff() {
	let form = $('#import-staff-form');
	$('#import-staff-form').ajaxForm({
		beforeSend: function() { //brfore sending form
			submitbutton = $(form).find('[type=submit]');
			btnHTML = submitbutton.html();
			submitbutton.attr('disabled', ''); // disable upload button
			submitbutton.html('<i class="fa fa-spinner fa-pulse"></i>');
			$(form).find('.progress').removeClass('hidden');
			$(form).find('.progress-bar').removeClass('progress-bar-success').addClass('progress-bar-warning').css('width','0px');
		},
		uploadProgress: function(event, position, total, percentComplete) { //on progress
			// do something for upload events
			$(form).find('.progress-bar').text(percentComplete+'%').attr('aria-valuenow',percentComplete).css('width',percentComplete+'%');
		},
		complete: function(response) { // on complete
			data = JSON.parse(response.responseText);// get json format
			
			submitbutton.removeAttr('disabled'); //enable submit button
			submitbutton.html(btnHTML);
			let msg = '';
			if (data.error) {
				$.each(data.msg,function(k,v) {
					msg += `<b class="text-uppercase"><i class="fa fa-times-circle"></i> `+k+`</b> `+v+``;
				});
				$(form).find('.progress-bar').removeClass('progress-bar-warning').addClass('progress-bar-danger');
			} else {
				msg = '<b class="fa fa-check"></b> '+data.msg;
				form.resetForm();  // reset form
				$(form).find('.progress-bar').removeClass('progress-bar-warning progress-bar-danger').addClass('progress-bar-success');
			}
			$(form).find('#error').html(`<div class="alert alert-`+data.type+`">`+msg+`</div>`);
		},
		fail:function(response,status,error) {
			data = JSON.parse(response.responseText);// get json format
			submitbutton.removeAttr('disabled'); //enable submit button
			submitbutton.html(btnHTML);
			return callback(data,form);
		}
	});
}

function init_call_modal_task(options) {
    $('body').on('shown.bs.modal', '#_task #_task_modal', function(e) {
        $(this).find('.modal-body #name').val(options.subject);
        $(this).find('.modal-body #description').val(options.description);
        $('#task-modal').on('shown.bs.modal', function(e) {
            // select value from selectpicker
            $(e.target).find('.modal-body .task-single-col-right')
            .find('select[name="select-assignees"]')
            .find(`[value=${options.assignee.staffid}]`).prop('selected',true).change();
            // refresh selectpicker
            $(e.target).find('.modal-body .task-single-col-right')
            .find('select[name="select-assignees"]').selectpicker('refresh');
        });
    });
}

function validate_items_form(){
    console.log('as');
    appValidateForm($('.client-form'), {
       description: 'required',
        rate: {
            required: true,
        }
    });
    $('.client-form').submit();
}

