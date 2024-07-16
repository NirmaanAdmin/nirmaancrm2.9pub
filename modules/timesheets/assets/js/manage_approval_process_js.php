<script>
(function(){ 
  "use strict";
     var addMoreVendorsInputKey = $('.list_approve select[name*="approver"]').length;
    $("body").on('click', '.new_vendor_requests', function() {
         if ($(this).hasClass('disabled')) { return false; }   
        
        var newattachment = $('.list_approve').find('#item_approve').eq(0).clone().appendTo('.list_approve');
        newattachment.find('button[role="button"]').remove();
        newattachment.find('select').selectpicker('refresh');

        newattachment.find('button[data-id="approver[0]"]').attr('data-id', 'approver[' + addMoreVendorsInputKey + ']');
        newattachment.find('label[for="approver[0]"]').attr('for', 'approver[' + addMoreVendorsInputKey + ']');
        newattachment.find('select[name="approver[0]"]').attr('data-id', addMoreVendorsInputKey);
        newattachment.find('select[name="approver[0]"]').attr('name', 'approver[' + addMoreVendorsInputKey + ']');
        newattachment.find('select[id="approver[0]"]').attr('id', 'approver[' + addMoreVendorsInputKey + ']').selectpicker('refresh');

        newattachment.find('button[data-id="staff[0]"]').attr('data-id', 'staff[' + addMoreVendorsInputKey + ']');
        newattachment.find('label[for="staff[0]"]').attr('for', 'staff[' + addMoreVendorsInputKey + ']');
        newattachment.find('select[name="staff[0]"]').attr('name', 'staff[' + addMoreVendorsInputKey + ']');
        newattachment.find('select[id="staff[0]"]').attr('id', 'staff[' + addMoreVendorsInputKey + ']').selectpicker('refresh');

        newattachment.find('#is_staff_0').attr('id', 'is_staff_' + addMoreVendorsInputKey).addClass('hide');
        newattachment.find('button[name="add"] i').removeClass('fa-plus').addClass('fa-minus');
        newattachment.find('button[name="add"]').removeClass('new_vendor_requests').addClass('remove_vendor_requests').removeClass('btn-success').addClass('btn-danger');

        $('select[name="approver[' + addMoreVendorsInputKey + ']"]').change(function(){
            if($(this).val() == 'staff'){
              $('#is_staff_' + $(this).attr('data-id')).removeClass('hide');
            }else{

              $('#is_staff_' + $(this).attr('data-id')).addClass('hide');
            }
        });

        addMoreVendorsInputKey++;
    });
    $("body").on('click', '.remove_vendor_requests', function() {
        $(this).parents('#item_approve').remove();
    });
})(jQuery);

function edit_approval_setting(invoker,id){
    appValidateForm($('#approval-setting-form'),{name:'required', related:'required'});
    var name = $(invoker).data('name');
    var related = $(invoker).data('related');
    var setting = $(invoker).data('setting');    
    $('input[name="approval_setting_id"]').val(id);
    $('#approval_setting_modal input[name="name"]').val(name);
    $('select[name="related"]').val(related).change();    
    $.post(admin_url + 'hrm/get_html_approval_setting/'+ id).done(function(response) {
       response = JSON.parse(response);
        $('.list_approve').html('');
        $('.list_approve').append(response);
    });    
    $('#approval_setting_modal').modal('show');
    $('#approval_setting_modal .add-title').addClass('hide');
    $('#approval_setting_modal .edit-title').removeClass('hide');
 }

 function new_approval_setting(){
    appValidateForm($('#approval-setting-form'),{name:'required', related:'required'});
    $('#approval_setting_modal input[name="name"]').val('');
    $('select[name="related"]').val('').change();    
    $.post(admin_url + 'hrm/get_html_approval_setting').done(function(response) {
       response = JSON.parse(response);
        $('.list_approve').html(response);
        init_selectpicker();
    });
    $('#approval_setting_modal').modal('show');
    $('#approval_setting_modal .add-title').removeClass('hide');
    $('#approval_setting_modal .edit-title').addClass('hide');
    $('select[name="approver[0]"]').change(function(){
      if($(this).val() == 'staff'){
        $('#is_staff_0').removeClass('hide');
      }else{
        $('#is_staff_0').addClass('hide');
      }
    });
 }

</script>