<script>
  (function(){
    "use strict";
    appValidateForm($('#approval-setting-form'),{name:'required', related:'required'});
    var addMoreVendorsInputKey = $('.list_approve select[name*="approver"]').length;
    $("body").on('click', '.new_vendor_requests', function() {
      if ($(this).hasClass('disabled')) { return false; }    
      var newattachment = $('.list_approve').find('.item_approve').eq(0).clone().appendTo('.list_approve');
      newattachment.find('button[role="combobox"]').remove();
      newattachment.find('select').val('').change().selectpicker('refresh');

      newattachment.find('select[name="approver[0]"]').attr('name', 'approver[' + addMoreVendorsInputKey + ']');
      newattachment.find('select[id="approver[0]"]').attr('id', 'approver[' + addMoreVendorsInputKey + ']').selectpicker('refresh');
      newattachment.find('select[data-id="0"]').attr('data-id', addMoreVendorsInputKey);

      newattachment.find('button[data-id="approver[0]"]').attr('data-id', 'approver[' + addMoreVendorsInputKey + ']');
      newattachment.find('label[for="approver[0]"]').attr('for', 'approver[' + addMoreVendorsInputKey + ']');

      newattachment.find('input[name="approver[0]"]').attr('data-id', addMoreVendorsInputKey);
      newattachment.find('input[name="approver[0]"]').attr('name', 'approver[' + addMoreVendorsInputKey + ']');
      newattachment.find('input[id="approver[0]"]').attr('id', 'approver[' + addMoreVendorsInputKey + ']').selectpicker('refresh');

      newattachment.find('button[data-id="staff[0]"]').attr('data-id', 'staff[' + addMoreVendorsInputKey + ']');
      newattachment.find('label[for="staff[0]"]').attr('for', 'staff[' + addMoreVendorsInputKey + ']');
      newattachment.find('select[name="staff[0]"]').attr('name', 'staff[' + addMoreVendorsInputKey + ']');
      newattachment.find('select[id="staff[0]"]').attr('id', 'staff[' + addMoreVendorsInputKey + ']').selectpicker('refresh');

      newattachment.find('#is_staff_0').attr('id', 'is_staff_' + addMoreVendorsInputKey).addClass('hide');
      newattachment.find('button[name="add"] i').removeClass('fa-plus').addClass('fa-minus');
      newattachment.find('button[name="add"]').removeClass('new_vendor_requests').addClass('remove_vendor_requests').removeClass('btn-success').addClass('btn-danger');

      $('select[name="approver[' + addMoreVendorsInputKey + ']"]').change(function(){
        let index = $(this).attr('data-id');
        if($(this).val() == 'specific_personnel'){
          $('#is_staff_' + index).removeClass('hide');
          $('select[name="staff['+ index +']"').attr('required', 'required');
        }else{
          $('#is_staff_' + index).addClass('hide');
          $('select[name="staff['+ index +']"').removeAttr('required');
        }
      });

      addMoreVendorsInputKey++;
    });




    $("body").on('click', '.remove_vendor_requests', function() {
      $(this).parents('.item_approve').remove();
    });

    <?php if(isset($approval_setting)){ 
     $i = 0;
     ?>
     <?php 
     $setting = json_decode($approval_setting->setting);
     foreach ($setting as $key => $value): ?>
      $('select[name="approver[<?php echo html_entity_decode($i); ?>]"]').change(function(){
        if($(this).val() == 'specific_personnel'){
          $('#is_staff_<?php echo html_entity_decode($i); ?>').removeClass('hide');
          $('select[name="staff[<?php echo html_entity_decode($i); ?>]"').attr('required', 'required');
        }else{
          $('#is_staff_<?php echo html_entity_decode($i); ?>').addClass('hide');
          $('select[name="staff[<?php echo html_entity_decode($i); ?>]"').removeAttr('required');
        }
      });
      <?php 
      $i++;
    endforeach ?>
  <?php }else{ ?>
    $('select[name="approver[0]"]').change(function(){
      let index = 0;
      if($(this).val() == 'specific_personnel'){
        $('#is_staff_' + index).removeClass('hide');
        $('select[name="staff['+ index +']"').attr('required', 'required');
      }else{
        $('#is_staff_' + index).addClass('hide');
        $('select[name="staff['+ index +']"').removeAttr('required');
      }
    });
  <?php } ?>
  $('#choose_when_approving').click(function(){
    if($(this).is(':checked')){
      $('.list_approve').addClass('hide');
    } else {
      $('.list_approve').removeClass('hide');

    }
  });
})(jQuery);
</script>