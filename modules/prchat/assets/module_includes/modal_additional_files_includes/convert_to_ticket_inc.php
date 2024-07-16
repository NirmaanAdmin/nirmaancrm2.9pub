<script>
     $('#convert_to_ticket_modal').on('show.bs.modal', function(e) {
          if ($('.modal-backdrop.fade').hasClass('in')) {
               $('.modal-backdrop.fade').remove();
          }
     });

     var filteredTicketMessages = [];

     $('body').on('change', '#convert_to_ticket_modal input[type="checkbox"]', function() {

          var message_id = $(this).parents('.chat_ticket_messages').children('input').attr('id').replace('message_', '');
          var user_id = $(this).parents('.chat_ticket_messages').data('user');
          var client_id = $('.client_messages').attr('id');
          var ticket_message = $(this).parents('.chat_ticket_messages').children('label').text();
          var user_name = $(this).parents('.chat_ticket_messages').children('span').children('strong').text();

          var message_content = {
               'user_id': user_id,
               'message_id': message_id,
               'message': ticket_message,
               'client_id': client_id,
               'user_name': user_name
          };

          if ($(this).prop('checked')) {
               // Add the new ticket message if checked:
               if (filteredTicketMessages.indexOf(message_content.message_id) < 0) {
                    filteredTicketMessages.push(message_content);
               }
          } else {
               // Remove from array if ticket message is unchecked
               filteredTicketMessages = filteredTicketMessages.filter(function(item, index) {
                    return item.message_id !== message_content.message_id;
               });
          }
     });

     $('body').on('click', '#convertToTicket', function() {
          var csrf = (typeof csrfData == 'undefined') ? '' : csrfData.formatted.csrf_token_name;
          var department = $('select[name="department"] option:selected').val();

          if (filteredTicketMessages.length === 0) {
               alert_float('warning', '<?= _l('chat_at_least_one_message_required'); ?>');
               return;
          }

          var subject = prompt('<?= _l('chat_type_in_ticket_subject'); ?>');

          if (subject == null) {
               return;
          } else if ($.trim(subject) == '') {
               alert_float('warning', '<?= _l('chat_ticket_subject_empty'); ?>');
               return;
          }

          subject = escapeHtml(subject);

          if (subject !== '') {
               $.post('createNewSupportTicket', {
                    content: filteredTicketMessages,
                    department: department,
                    subject: subject,
                    csrf: csrf,
                    assigned: chat_ticket_assigned,
                    beforeSend: function() {
                         $('body').prepend('<div class="ticket_form_loading_spinner"></div>');
                         $('#convertToTicket').html('<?= _l('chat_please_wait_creating_ticket'); ?> <i class="fa fa-refresh fa-spin fa-fw"></i>');
                    }
               }).done(function(r) {

                    r = JSON.parse(r);
                    console.log(r)
                    if (r.message == 'no_message') {
                         alert_float('warning', "<?= _l('chat_at_least_one_message_required'); ?>");
                         return;
                    }

                    if (r.message == 'success') {
                         $('.ticket_form_loading_spinner').remove();
                         $('#convert_to_ticket_modal').modal('hide');

                         alert_float('success', "<?= _l('chat_new_ticket_created'); ?>" + subject);

                         setTimeout(function() {
                              $('.client_chatbox').val('<?= _l('chat_client_created_new_support_ticket'); ?><a class="chat_ticket_link" href="' + location.origin + '/clients/ticket/' + r.ticket_id + '" target="_blank"><?= _l('support_ticket'); ?></a>');

                              $('.client_chatbox').trigger($.Event("keypress", {
                                   which: 13
                              }));
                         }, 1000);
                    }
                    $.post("<?= site_url('prchat/Prchat_ClientsController/trigger_ticket_event'); ?>", {
                         client_id: r.client_id,
                         ticket_id: r.ticket_id
                    }).done(function(r) {
                         filteredTicketMessages = [];
                    });
               }).fail(function(error) {
                    // Ticket is created but due to email templates sending emails adds and error sometimes
                    alert_float('success', '<?= _l('chat_new_ticket_created'); ?>' + subject);
                    $('#convert_to_ticket_modal').modal('hide');
                    $('.ticket_form_loading_spinner').remove();
                    filteredTicketMessages = [];
                    return;
               });
          }
     });
</script>