Dropzone.autoDiscover = false;
var expenseDropzone;
(function($) {
  "use strict"; 

  if ($('#advance_payment_update-form').length > 0) {
    expenseDropzone = new Dropzone("#advance_payment_update-form", appCreateDropzoneOptions({
      autoProcessQueue: false,
      clickable: '#dropzoneDragArea',
      previewsContainer: '.dropzone-previews',
      addRemoveLinks: true,
      maxFiles: 1,
      success: function(file, response) {
        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
          window.location.reload();
        }
      }
    }));
  }

  appValidateForm($('#expense-category-form'), {
   'name': 'required'
 })
  appValidateForm($('#advance_payment_update-form'), {
    category: 'required',
    date: 'required',
    amount: 'required'
  }, projectExpenseSubmitHandler);


})(jQuery);

function projectExpenseSubmitHandler(form) {
  "use strict";
  $.post(form.action, $(form).serialize()).done(function(response) {
    response = JSON.parse(response);
    if (response.expenseid) {
      if (typeof(expenseDropzone) !== 'undefined') {
        if (expenseDropzone.getQueuedFiles().length > 0) {
          expenseDropzone.options.url = admin_url + 'expenses/add_expense_attachment/' + response.expenseid;
          expenseDropzone.processQueue();
        } else {
          window.location.assign(response.url);
        }
      } else {
        window.location.assign(response.url);
      }
    } else {
      window.location.assign(response.url);
    }
  });
  return false;
}

