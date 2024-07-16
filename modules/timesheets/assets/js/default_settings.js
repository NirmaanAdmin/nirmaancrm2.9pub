(function(){
	"use strict";
	$('input[name="auto_checkout"]').click(function(){
		var obj = $(this);
		var checked = obj.is(":checked");
		if(checked == true){
			$('.auto_checkout_more_option').removeClass('hide');
		}
		else{
			$('.auto_checkout_more_option').addClass('hide');
		}
	});
	$('input[name="send_notification_if_check_in_forgotten"]').click(function(){
		var obj = $(this);
		var checked = obj.is(":checked");
		if(checked == true){
			$('.auto_send_notification_if_check_in_forgotten').removeClass('hide');
		}
		else{
			$('.auto_send_notification_if_check_in_forgotten').addClass('hide');
		}
	});
	
})(jQuery);
