(function(){
  "use strict";
  $('.change_status').click(function(){
   		var status = $(this).data('status'), order_number;
   		order_number = $('input[name="order_number"]').val();
   		if(status == 7){
   			$('#chosse').modal();
   			return false;
   		}
   		var data = {};
   		data.cancelReason = '';
   		data.status = status;
   		change_status(order_number, data);   		
  }); 
$('.cancell_order').click(function(){
		$('#chosse').modal('hide');
		var status = $(this).data('status'), order_number;
		order_number = $('input[name="order_number"]').val();
		var data = {};
		data.cancelReason = $('textarea[name="cancel_reason"]').val();
		data.status = status;
		change_status(order_number, data);
});  
})(jQuery);
function change_status(order_number,data){
	"use strict";
	$.post(admin_url+'omni_sales/admin_change_status/'+order_number,data).done(function(response){
                   response = JSON.parse(response);
                if(response.success == true) {
                    alert_float('success','Status changed');
                    setTimeout(function(){location.reload();},1500);
                }
                    
    });
}



