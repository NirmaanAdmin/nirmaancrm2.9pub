(function(){
	"use strict";
	$('.reset_data').click(function(){
		var r = confirm($('input[name="confirm_text"]').val());
		if (r == true) {
			$.get(admin_url+'timesheets/reset_data').done(function(response){
				response = JSON.parse(response);
				console.log(response);
				if(response.success == true) {
					alert_float('success', response.message);
				}
				else{
					alert_float('danger', response.message);
				}
				location.reload();
			});
		}
	});	

})(jQuery);

