(function(){
	"use strict";
	initDataTable('.table-hr-profile-permission', admin_url + 'timesheets/timesheet_permission_table');
		 //procedure update_permissions
		 appValidateForm($('#update_permissions'), {
		 	role: 'required',
		 });

		 $(document).on("change",'select[name="role"]',function() {
		 	var roleid = $(this).val();
		 	init_roles_permissions(roleid, true);
		 });
       	// Called when editing member profile
       	function init_roles_permissions(roleid, user_changed) {
       		'use strict';

       		roleid = typeof(roleid) == 'undefined' ? $('select[name="role"]').val() : roleid;
       		var isedit = $('.member > input[name="isedit"]');

		    // Check if user is edit view and user has changed the dropdown permission if not only return
		    if (isedit.length > 0 && typeof(roleid) !== 'undefined' && typeof(user_changed) == 'undefined') {
		    	return;
		    }

		    // Administrators does not have permissions
		    if ($('input[name="administrator"]').prop('checked') === true) {
		    	return;
		    }

		    // Last if the roleid is blank return
		    if (roleid === '') {
		    	return;
		    }

		    // Get all permissions
		    var permissions = $('table.roles').find('tr');
		    requestGetJSON('staff/role_changed/' + roleid).done(function(response) {

		    	permissions.find('.capability').not('[data-not-applicable="true"]').prop('checked', false).trigger('change');

		    	$.each(permissions, function() {
		    		var row = $(this);
		    		$.each(response, function(feature, obj) {
		    			if (row.data('name') == feature) {
		    				$.each(obj, function(i, capability) {
		    					row.find('input[id="' + feature + '_' + capability + '"]').prop('checked', true);
		    					if (capability == 'view') {
		    						row.find('[data-can-view]').change();
		    					} else if (capability == 'view_own') {
		    						row.find('[data-can-view-own]').change();
		    					}
		    				});
		    			}
		    		});
		    	});
		    });
		}

		$(document).on("change",'select[name="staff_id"]',function() {
			'use strict';
			var staff_id = $(this).val();
			if(staff_id){
				$('#additional_staff_permissions').html('');
				$('#additional_staff_permissions').append(hidden_input('id',staff_id));

				requestGetJSON('timesheets/staff_id_changed/' + staff_id).done(function(response) {
					if(response.status == 'true' || response.status == true){
						$('select[name="role"]').val(response.role_id).change();
					}else{
						$('select[name="role"]').val('').change();
					}

					$('.role_hide').removeClass('hide');
					init_selectpicker();
					$(".selectpicker").selectpicker('refresh');

				});
			}
		});

       	// Permissions change, apply necessary action to disable OWN or VIEW OWN
       	$(document).on("change","[data-can-view-own], [data-can-view]",function() {
       		var is_own_attr = $(this).attr('data-can-view-own');
       		var view_chk_selector = $(this).parents('tr').find('td input[' + (typeof is_own_attr !== typeof undefined && is_own_attr !== false ? 'data-can-view' : 'data-can-view-own') + ']');

       		if (view_chk_selector.data('not-applicable') == true) {
       			return;
       		}

       		view_chk_selector.prop('checked', false);
       		view_chk_selector.prop('disabled', $(this).prop('checked') === true);
       	}); 

       })(jQuery);

       function permissions_update(staff_id, role_id, add_new) {
       	"use strict";
       	$("#modal_wrapper").load(admin_url+"timesheets/permission_modal", {
       		slug: 'update',
       		staff_id: staff_id,
       		role_id: role_id,
       		add_new: add_new
       	}, function() {
       		init_selectpicker();
       		$(".selectpicker").selectpicker('refresh');
       		if ($('.modal-backdrop.fade').hasClass('in')) {
       			$('.modal-backdrop.fade').remove();
       		}
       		if ($('#appointmentModal').is(':hidden')) {
       			$('#appointmentModal').modal({
       				show: true
       			});
       		}
       	});
       }