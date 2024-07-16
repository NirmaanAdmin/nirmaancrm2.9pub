<script>
     $(function() {
          // Chat Statuses
          var _chat_statuses = '#status-online, #status-away, #status-busy, #status-offline';
          var _chat_string_status = 'online away busy offline';

          $("body").on('click', '#sidepanel #profile-img', function() {
               $("#status-options").toggleClass("active");
          });

          $("body").on('click', '#status-options ul li', function() {
               $("#sidepanel #profile-img").removeClass();
               $("#prchat-header-wrapper #chat_status_top_icon").removeClass(_chat_string_status);
               $(_chat_statuses).removeClass("active");
               $(this).addClass("active");
               var newStatus = '';
               var status = $(this).attr('id').replace('status-', '');

               $(this).parent('ul').children('li').each(function(i, element) {
                    if ($(element).hasClass('active')) {
                         newStatus = $(element).attr('id').replace('status-', '');
                    }
               });

               $('#sidepanel #profile-img, #prchat-header-wrapper #chat_status_top_icon').addClass(newStatus);

               handleChatStatusUpdatePost(status);

               $("#status-options").removeClass("active");
          });

          // Manage new status updates
          function updateCurrentUserChatStatus() {
               if (user_chat_status.length) {
                    $('#sidepanel #profile-img').removeClass().addClass(user_chat_status);
                    $('#prchat-header-wrapper #chat_status_top_icon').removeClass(_chat_string_status).addClass(user_chat_status);

                    $('#status-options ul li, #top_status-options ul li').each(function() {
                         $(this).removeClass();
                    });
                    $('#status-options ul li#status-' + user_chat_status + ', #top_status-options ul li#status-' + user_chat_status).addClass('active');
               }

               if (user_chat_status == '') {
                    $('.wrap #profile-img').addClass('online');
               }
          }

          updateCurrentUserChatStatus();

          // Event handler for chat update
          chat_status.bind('status-changed-event', function(user) {
               if (user.user_id !== userSessionId) {
                    var translated_status = '';
                    for (var status in chat_user_statuses) {
                         if (status == user.status) {
                              translated_status = chat_user_statuses[status];
                         }
                    }
                    var userPlaceholder = $('body').find('.chat_contacts_list li a#' + user.user_id + ' .wrap img');
                    userPlaceholder.attr('title', translated_status).attr('data-original-title', translated_status);
                    userPlaceholder.removeClass();
                    userPlaceholder.addClass('imgFriend ' + user.status + '');
                    $('body').find('.chat_contacts_list li a#' + user.user_id + ' .wrap span').removeClass().addClass(user.status);
               }
          });

          // Top header functionality
          $("#chat_status_top_icon").click(function() {
               $("#top_status-options").toggleClass("active");
          });

          $("#top_status-options ul li").click(function() {
               $('#top_status-options').find(_chat_statuses).removeClass("active");
               $(this).addClass("active");
               var status = $(this).attr('id').replace('status-', '');

               handleChatStatusUpdatePost(status);

               $("#top_status-options").removeClass("active");
          });

          function handleChatStatusUpdatePost(status) {
               $.post(
                    prchatSettings.handleChatStatus, {
                         user_id: userSessionId,
                         status: status
                    }).done(function(response) {
                    user_chat_status = response.status;
                    if (user_chat_status != 'same') {
                         updateCurrentUserChatStatus();
                    }
               });
          }
     });
</script>
<!-- Quick fix for non staff member chat status icon -->
<?php
if (!is_staff_member()) { ?>
     <style>
          body nav #prchat-header-wrapper svg#chat_status_top_icon {
               right: -45px;
               position: absolute;
          }
     </style>
<?php } ?>