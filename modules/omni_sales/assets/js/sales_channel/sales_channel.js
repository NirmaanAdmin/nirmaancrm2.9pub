(function(){
    "use strict";   
    $('.channel a').click(function(event){
    	var status = $(this).closest('.channel').hasClass('active');
    	if(status == false){
    		event.preventDefault();
    	}
    });

  var fnServerParams = {
      "product_filter": "[name='product_filter']",
      "id_channel": "[name='sales_channel_id']",
      "channel": "[name='channel']"
  }
 initDataTable('.table-add_product_management', admin_url + 'omni_sales/add_product_management_table', false, false, fnServerParams, [0, 'desc']);

 $("input[data-type='currency']").on({
    keyup: function() {        
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
 });

  appValidateForm($('#form_add_product'), {
           'product_id[]': 'required',
  })

$(".channel").each(function(i, obj) {
  $(obj).on("contextmenu",function(){
     return false;
  }); 
});
})(jQuery);

function change_active_ch(el){
	"use strict";
	var channel = $(el).data('channel') , status;
	if($(el).is(':checked')){
		$(el).closest('.channel').addClass('active');
		status = 'active';
    }
    else{
		$(el).closest('.channel').removeClass('active'); 
		status = 'deactivate';   	
    }
    var data = {};
    data.channel = channel;
    data.status = status;
    $.post(admin_url+'omni_sales/change_active_channel',data).done(function(response){
        response = JSON.parse(response);
        if(response.success == true) {
        	var message = '';
        	if(status == 'active'){
        		message = 'Activated';
        	}
        	if(status == 'deactivate'){
        		message = 'Deactivated';
        	}
           alert_float('success',message);
        }
    });
}
function add_product(){
	"use strict";
    $('input[name="id"]').val('');
	$('#chose_product').modal();
    $('input[name="temp_id"]').val('');
    $('.pricefr').addClass('hide');
}
function get_list_product(el){
	"use strict";
	var id = $(el).val();
	$.post(admin_url+'omni_sales/get_list_product/'+id).done(function(response){
        response = JSON.parse(response);
        if(response.success == true) {
        	$('select[name="product_id[]"]').html(response.html);
        	$('select[name="product_id[]"]').selectpicker('refresh');
        }
    });
}
function formatNumber(n) {
  "use strict";
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}
function formatCurrency(input, blur) {
  "use strict";
  var input_val = input.val();
  if (input_val === "") { return; }
  var original_len = input_val.length;
  var caret_pos = input.prop("selectionStart");
  if (input_val.indexOf(".") >= 0) {
    var decimal_pos = input_val.indexOf(".");
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);
    left_side = formatNumber(left_side);

    right_side = formatNumber(right_side);
    right_side = right_side.substring(0, 2);
    input_val = left_side + "." + right_side;

  } else {
    input_val = formatNumber(input_val);
    input_val = input_val;
  }
  input.val(input_val);
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}
function update_product(el){
     "use strict";

     $('input[name="id"]').val($(el).data('id'));
     $('.pricefr').removeClass('hide');
     $('select[name="group_product_id"]').val($(el).data('groupid')).change();

    $.post(admin_url+'omni_sales/get_list_product/'+$(el).data('groupid')).done(function(response){
        response = JSON.parse(response);
        if(response.success == true) {
            $('select[name="product_id[]"]').html(response.html);
            $('select[name="product_id[]"]').selectpicker('refresh');
            $('select[name="product_id[]"]').val([$(el).data('productid')]).change();
            var prices = $(el).data('prices').substring(0,$(el).data('prices').length - 3);
            $('input[name="prices"]').val(prices);
        }
    });    
     $('#chose_product').modal($(el).data('productid'));
}
