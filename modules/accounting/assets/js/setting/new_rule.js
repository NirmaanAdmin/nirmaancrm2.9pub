(function(){
  "use strict";
    appValidateForm($('#rule-form'),{name:'required'});
    var addMoreVendorsInputKey = $('.list_approve select[name^="type"]').length+1;
    $("body").on('click', '.new_vendor_requests', function() {

         if ($(this).hasClass('disabled')) { return false; }    
        var newattachment = $('.list_approve').find('#item_approve').eq(0).clone().appendTo('.list_approve');
        newattachment.find('button[role="combobox"]').remove();
        newattachment.find('select').selectpicker('refresh');

        newattachment.find('button[data-id="type[0]"]').attr('data-id', 'type[' + addMoreVendorsInputKey + ']');
        newattachment.find('label[for="type[0]"]').attr('for', 'type[' + addMoreVendorsInputKey + ']');
        newattachment.find('select[name="type[0]"]').attr('name', 'type[' + addMoreVendorsInputKey + ']');
        newattachment.find('select[id="type[0]"]').attr('data-index', addMoreVendorsInputKey);
        newattachment.find('select[id="type[0]"]').attr('id', 'type[' + addMoreVendorsInputKey + ']').val('description').selectpicker('refresh');


        newattachment.find('button[data-id="subtype[0]"]').attr('data-id', 'subtype[' + addMoreVendorsInputKey + ']');
        newattachment.find('label[for="subtype[0]"]').attr('for', 'subtype[' + addMoreVendorsInputKey + ']');
        newattachment.find('select[name="subtype[0]"]').attr('name', 'subtype[' + addMoreVendorsInputKey + ']');
        newattachment.find('select[id="subtype[0]"]').attr('id', 'subtype[' + addMoreVendorsInputKey + ']').selectpicker('refresh');

        newattachment.find('button[data-id="subtype_amount[0]"]').attr('data-id', 'subtype_amount[' + addMoreVendorsInputKey + ']');
        newattachment.find('label[for="subtype_amount[0]"]').attr('for', 'subtype_amount[' + addMoreVendorsInputKey + ']');
        newattachment.find('select[name="subtype_amount[0]"]').attr('name', 'subtype_amount[' + addMoreVendorsInputKey + ']');
        newattachment.find('select[id="subtype_amount[0]"]').attr('id', 'subtype_amount[' + addMoreVendorsInputKey + ']').selectpicker('refresh');

        newattachment.find('label[for="text[0]"]').attr('for', 'text[' + addMoreVendorsInputKey + ']');
        newattachment.find('input[name="text[0]"]').attr('name', 'text[' + addMoreVendorsInputKey + ']');
        newattachment.find('input[id="text[0]"]').attr('id', 'text[' + addMoreVendorsInputKey + ']').val('');

        newattachment.find('#div_subtype_amount_0').addClass('hide').attr('id', 'div_subtype_amount_' + addMoreVendorsInputKey).val('');
        newattachment.find('#div_subtype_0').removeClass('hide').attr('id', 'div_subtype_' + addMoreVendorsInputKey).val('');

        newattachment.find('button[name="add"] i').removeClass('fa-plus').addClass('fa-minus');
        newattachment.find('button[name="add"]').removeClass('new_vendor_requests').addClass('remove_vendor_requests').removeClass('btn-success').addClass('btn-danger');

        $('select[name="approver[' + addMoreVendorsInputKey + ']"]').change(function(){
            if($(this).val() == 'specific_personnel'){
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

    $("body").on('change', 'select[name="then"]', function() {
        if($('select[name="then"]').val() == 'assign'){
            $('#then_assign').removeClass('hide');
        }else{
            $('#then_assign').addClass('hide');
        }
    });

    $("body").on('change', 'select[name^="type"]', function() {
        if($(this).val() == 'amount'){
            $('#div_subtype_amount_'+$(this).attr('data-index')).removeClass('hide');
            $('#div_subtype_'+$(this).attr('data-index')).addClass('hide');
        }else{
            $('#div_subtype_amount_'+$(this).attr('data-index')).addClass('hide');
            $('#div_subtype_'+$(this).attr('data-index')).removeClass('hide');
        }
    });
})(jQuery);
    