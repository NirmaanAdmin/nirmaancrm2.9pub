
(function(){
    "use strict";
  $('.exits_show').on('click', function(){ $('body').find('.show').removeClass('show'); })

	$(window).on('load', function() {
	    $('#all_product').click();
      $('#tab1').html($('#tab_content_template').html());
	});
  $('input[name="keyword"]').keypress(function(event) {
        if (event.keyCode == 13) {
           $('.search_btn').click();
        }
  });
})(jQuery);

function add_cart(el){
  "use strict";
  var id = $(el).data('id');
  var gid = $(el).data('gid');
  var title = $(el).find('.title').text();
  var price = $(el).find('.price').data('price');
  var price_discount = $(el).find('.price').data('price_discount');
  var discount_percent = $(el).find('.price').data('discount_percent');
  var percent_tax = $(el).data('percent-tax');
  var total_tax = $(el).data('total-tax');
  var w_quantity = $(el).data('w_quantity');
  if(w_quantity<=0){
    $('#alert').modal('show').find('.alert_content').text('This product is out of stock');
    setTimeout(function(){ $('#alert').modal('hide'); },1500);
   return false;
  } 

  var list_id = $('.tab-pane.active').find('input[name="list_id_product"]').val();
  var list_qty = $('.tab-pane.active').find('input[name="list_qty_product"]').val();
  var list_price = $('.tab-pane.active').find('input[name="list_price_product"]').val();
  var list_price_discount = $('.tab-pane.active').find('input[name="list_price_discount_product"]').val();
  var list_percent_discount = $('.tab-pane.active').find('input[name="list_percent_discount_product"]').val();
  var list_price_tax = $('.tab-pane.active').find('input[name="list_price_tax"]').val();


        var new_value = 1;
        if(list_id != ''){
          var id_list = JSON.parse('['+list_id+']');
          var qty_list = JSON.parse('['+list_qty+']');
          var index_id = -1;
            $.each(id_list, function( key, value ) {
              if(value == id){
                index_id = key;
              }
            }); 

           if(index_id == -1){
                if(id != '' && price != ''){
                  list_id = list_id+','+id;
                  list_qty = list_qty+',1';
                  list_price = list_price+','+price;
                  list_price_discount = list_price_discount+','+price_discount;
                  list_price_tax = list_price_tax+','+total_tax;
                  list_percent_discount = list_percent_discount+','+discount_percent;
                  add_cart_data(list_id,list_qty,list_price,list_price_discount,list_price_tax,list_percent_discount);
                  add_item_cart(title, price,price_discount,discount_percent, id, percent_tax,w_quantity,gid);
                }
           }
           else{
                var new_list_qty = '';
                $.each(qty_list, function( key, value ) {
                    if(index_id == key){
                      var val = (parseInt(value)+1);
                        if(w_quantity < val){
                          val  = val - 1;
                          $('#alert').modal('show').find('.alert_content').text('The quantity limit is only from 1 to '+w_quantity);
                          setTimeout(function(){ $('#alert').modal('hide'); },1500);
                        }
                        new_list_qty += val+',';
                        new_value = val;
                    }
                    else{
                      new_list_qty += value+',';
                   }
                });


            add_cart_data(list_id,new_list_qty.replace(/,+$/, ''),list_price,list_price_discount, list_price_tax,list_percent_discount);

            var list_input = $('.tab-pane.active').find('.quantity');
            for (var i = 0; i < list_input.length; i++) {
              if(list_input.eq(i).data('id') == id){
                list_input.eq(i).val(new_value);
              }
             }         
            }
         }
         else{
            add_cart_data(id,1,price,price_discount,total_tax,discount_percent);
            add_item_cart(title, price,price_discount,discount_percent, id, percent_tax,w_quantity,gid);
        }
        total_cart();

}

function delete_item(el,id){
	"use strict";
	delete_element(id);
	$(el).closest('.ritem').remove();
}
function add_cart_data(list_id, list_qty, list_price, price_discount, list_price_tax,list_percent_discount){
	"use strict";
	$('.tab-pane.active').find('input[name="list_id_product"]').val(list_id);
	$('.tab-pane.active').find('input[name="list_qty_product"]').val(list_qty);
	$('.tab-pane.active').find('input[name="list_price_product"]').val(list_price);
  $('.tab-pane.active').find('input[name="list_price_discount_product"]').val(price_discount);
  $('.tab-pane.active').find('input[name="list_price_tax"]').val(list_price_tax);
  $('.tab-pane.active').find('input[name="list_percent_discount_product"]').val(list_percent_discount);
}
function add_item_cart(title, price,price_discount, discount, id, percent_tax, w_quantity, group_id){
	"use strict";
		var price_html = '';

			price_html += '<div class="price_w2 hide"><span class="new_prices"></span></br><span class="old_prices">'+numberWithCommas(price)+'</span></div>';

			price_html += '<div class="price_w1"><span class="new_prices">'+numberWithCommas(price)+'</span></div>';
	
    var qty = 1;
    if(w_quantity<=0){
      qty = 0;
    }
		var html = '<div class="col-md-12 ritem items" data-id="'+id+'" data-gid="'+group_id+'">';
      html +='<div class="col-md-12 items">';
      html +='<div class="row row_item_cart">';
          html +='<div class="col-md-12 title">'+title+' <div class="pull-right">Tax: '+percent_tax+' %</div></div>';
          html +='<div class="clearfix"></div>';
          html +='<div class="clearfix"></div>';
          html +='<div class="co-md-12 w-100"><br>';
              html +='<div class="row m-0">';
                  html +='<div class="col-md-5 m-0 prices p-2 p-0">'+price_html+'</div>';
                  html +='<input type="hidden" name="productid" >';
                  html +='<div class="col-md-5 m-0">';
                        html +='<div class="input_groups">';
                          html +='<span class="append_left minus" onclick="change_qty('+id+',-1);">';
                            html +='<i class="fa fa-minus"></i>';
                          html +='</span>';
                          html +='<input name="quantity" data-id="'+id+'" class="form-control input-md text-center quantity" type="text" data-w_quantity="'+w_quantity+'" value="'+qty+'">';
                          html +='<span class="append_right plus" onclick="change_qty('+id+',1);">';
                            html +='<i class="fa fa-plus"></i>';
                          html +='</span>';
                        html +='</div>';
                  html +='</div>';
                  html +='<div class="col-md-2 m-0 p-0 delete_item">';
                      html +='<span onclick="delete_item(this,'+id+');">&#10008;</span>';
                  html +='</div>';
              html +='</div>';
          html +='</div>';
          html +='<br>';
          
          html +='</div>';

          html +='<div class="clearfix"></div>';
          html +='</div>';




	$('.tab-pane.active').find('.content_cart .list_item').prepend(html);
}
function total_cart(){  
	"use strict";
	var list_qty = $('.tab-pane.active').find('input[name="list_qty_product"]').val();
	var list_price = $('.tab-pane.active').find('input[name="list_price_product"]').val();
  var list_price_discount = $('.tab-pane.active').find('input[name="list_price_discount_product"]').val();
  var list_price_tax = $('.tab-pane.active').find('input[name="list_price_tax"]').val();
	var discount_voucher = $('.tab-pane.active').find('input[name="discount_voucher"]').val();
  var discount_type = $('.tab-pane.active').find('input[name="discount_type"]').val();                  
  var discount_auto = $('.tab-pane.active').find('input[name="discount_auto"]').val();                  

	var qty = JSON.parse('['+list_qty+']');
	var prices = JSON.parse('['+list_price+']');
	var price_discount = JSON.parse('['+list_price_discount+']');  
  var total_tax = JSON.parse('['+list_price_tax+']');

	var total = 0;
	var discount = 0;  
  var tax = 0;
	  $.each(qty, function( key, value ) {
              total += parseFloat(value)*prices[key];
              tax += parseFloat(value)*parseFloat(total_tax[key]);
    });
    var new_discount_customer = 0;
    var new_discount_voucher = 0;
    if(discount_type == 1){
      new_discount_voucher = total * discount_voucher / 100;
    }
    if(discount_type == 2){
      new_discount_voucher = discount_voucher;      
    }
    var discount_client = get_discount_client(total);
    discount +=round(parseFloat(new_discount_voucher) + parseFloat(new_discount_customer) + parseFloat(discount_client));

    $('.tab-pane.active').find('input[name="discount_total"]').val(discount);
    $('.tab-pane.active').find('.discount-total').text('-'+numberWithCommas(discount));
    $('.tab-pane.active').find('.subtotal').text(numberWithCommas(total));
    $('.tab-pane.active').find('.total').text(numberWithCommas(total-discount+tax));
    $('.tab-pane.active').find('.promotions_tax_price').text(numberWithCommas(tax));
    $('.tab-pane.active').find('input[name="sub_total_cart"]').val(total);
    $('.tab-pane.active').find('input[name="total_cart"]').val(total - discount + tax);   
    $('.tab-pane.active').find('input[name="tax"]').val(tax);        
    $('.tab-pane.active').find('input[name="discount_auto_event"]').val(new_discount_customer);    
    $('.tab-pane.active').find('input[name="discount_voucher_event"]').val(discount_voucher); 


    var customers_pay = $('.tab-pane.active').find('input[name="customers_pay"]').val(); 
    if(customers_pay!=''){      
        var val = customers_pay.replace(new RegExp(',', 'g'),"");
        var total = $('.tab-pane.active').find('input[name="total_cart"]').val();  
        $('.tab-pane.active').find('input[name="amount_returned"]').val(numberWithCommas(parseFloat(val) - parseFloat(total))); 
    }

}
function numberWithCommas(x) {
  "use strict";
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
var length = 2;
function general_tab(el){
	"use strict";
		 var html = '<li role="presentation" onclick="open_tab(this);" onmouseleave="active_customer();" class="tab_cart wtab_'+length+'">';
		     html += '<a href="#tab'+length+'" class="exits_show" aria-controls="tab'+length+'" role="tab" data-toggle="tab">';
		     html += length;
		     html += '</a>';
         html += '<span class="exit_tab" onclick="remove_tab(this);">&#10006;</span>';
		  	 html += '</li>';
		 	 html += '<li role="presentation" onclick="general_tab(this);" class="tab">';
		     html += '<a href="#" role="tab">';
		     html += '<i class="fa fa-plus"></i>';
		     html += '</a>';
		     html += '</li>';
	$(el).remove();
  $('.exits_show').on('click', function(){ $('body').find('.show').removeClass('show'); })
	$('.gen_cart').append(html);
	var content = $('.cart-tab');
	var tab_content = $('#tab_content_template').html();
	content.append('<div role="tab'+length+'" class="tab-pane item-tab exits_show client_tab_content client_tab_content_'+length+'" id="tab'+length+'">'+tab_content+'</div>');

  length++;
}
function change_qty(id, val){
	"use strict";
	var list_input = $('.tab-pane.active').find('.quantity');
    for (var i = 0; i < list_input.length; i++) {
    	if(list_input.eq(i).data('id') == id){
        var w_quantity = parseInt(list_input.eq(i).data('w_quantity'));
    		var quantity = parseInt(list_input.eq(i).val())+val;
          if(quantity<=0){
            quantity = 1;
            $('#alert').modal('show').find('.alert_content').text('The quantity limit is only from 1 to '+w_quantity);
            setTimeout(function(){ $('#alert').modal('hide'); },1500);
           return false;
          }
          if(w_quantity < quantity){
            quantity = quantity-1;
            $('#alert').modal('show').find('.alert_content').text('The quantity limit is only from 1 to '+w_quantity);
            setTimeout(function(){ $('#alert').modal('hide'); },1500);
           return false;
          }
    		list_input.eq(i).val(quantity);
    		update_quantity(id, quantity);
    	}
    }  
}
function update_quantity(id,qty){
	"use strict";
	var list_id = $('.tab-pane.active').find('input[name="list_id_product"]').val();
	var list_qty = $('.tab-pane.active').find('input[name="list_qty_product"]').val();
    if(list_id != ''){
    	var id_list = JSON.parse('['+list_id+']');
    	var qty_list = JSON.parse('['+list_qty+']');
  		var index_id = -1;
        $.each(id_list, function( key, value ) {
          if(value == id){
            index_id = key;
          }
        }); 

        var new_list_qty = '';
        $.each(qty_list, function( key, value ) {
            if(index_id == key){
            	new_list_qty += qty+',';
            }
            else{
              new_list_qty += value+',';
           }
        });
		$('.tab-pane.active').find('input[name="list_qty_product"]').val(new_list_qty.replace(/,+$/, ''));
		total_cart();
  }  
}
function delete_element(id){
	"use strict";
	var list_id = $('.tab-pane.active').find('input[name="list_id_product"]').val();
	var list_qty = $('.tab-pane.active').find('input[name="list_qty_product"]').val();
	var list_price = $('.tab-pane.active').find('input[name="list_price_product"]').val();
  var list_price_discount = $('.tab-pane.active').find('input[name="list_price_discount_product"]').val();
  var list_percent_discount = $('.tab-pane.active').find('input[name="list_percent_discount_product"]').val();
  var list_price_tax = $('.tab-pane.active').find('input[name="list_price_tax"]').val();
    if(list_id != ''){
    	var id_list = JSON.parse('['+list_id+']');
    	var qty_list = JSON.parse('['+list_qty+']');
      var price_list = JSON.parse('['+list_price+']');
      var price_discount_list = JSON.parse('['+list_price_discount+']');     
    	var percent_discount_list = JSON.parse('['+list_percent_discount+']');     
      var price_tax = JSON.parse('['+list_price_tax+']');

  		var index_id = -1;
        $.each(id_list, function( key, value ) {
          if(value == id){
            index_id = key;
          }
        }); 

        var new_list_id = '';
        $.each(id_list, function( key, value ) {
            if(index_id != key){
            	new_list_id += value+',';
            }           
        });

        var new_list_qty = '';
        $.each(qty_list, function( key, value ) {
            if(index_id != key){
            	new_list_qty += value+',';
            }           
        });

        var new_list_prices = '';
        $.each(price_list, function( key, value ) {
            if(index_id != key){
            	new_list_prices += value+',';
            }           
        });

        var new_list_prices_discount = '';
        $.each(price_discount_list, function( key, value ) {
            if(index_id != key){
              new_list_prices_discount += value+',';
            }           
        });
        var new_price_tax = '';
        $.each(price_tax, function( key, value ) {
            if(index_id != key){
              new_price_tax += value+',';
            }           
        });
        var new_list_percent_discount = '';
        $.each(percent_discount_list, function( key, value ) {
            if(index_id != key){
              new_list_percent_discount += value+',';
            }           
        });
    		add_cart_data(new_list_id.replace(/,+$/, ''),new_list_qty.replace(/,+$/, ''),new_list_prices.replace(/,+$/, ''),new_list_prices_discount.replace(/,+$/, ''),new_price_tax.replace(/,+$/, ''),new_list_percent_discount.replace(/,+$/, ''));
    		total_cart();
     }  
}
function cal_price(el){
"use strict";
	var val = $(el).val().replace(new RegExp(',', 'g'),"");
	var total = $('input[name="total_cart"]').val();  
	$('input[name="amount_returned"]').val(numberWithCommas(parseInt(val) - parseInt(total)));
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
function open_tab(el){
  "use strict";
  var tab_id = $(el).find('a').attr('href'); 
  var obj   = $(el).closest('.right_pos').find(tab_id);
  var customer_id = $(obj).find('input[name="customer_id"]').val();
  $('select[name="client_id"]').val(customer_id);
  $('.cart-tab .tab-pane').removeClass('show');
}
function remove_tab(el){
  "use strict";
  var href = $(el).closest('li').find('a').attr('href');
  $(href).remove();
  $(el).parent('li').remove();
}
function change_result(el){
  "use strict";
  if($(el).val() == ''){
    $('.search_btn').click();
  }
}
function get_discount_client(total){
    "use strict";
   var result = 0;
   var customers_id = $('select[name="client_id"]').val();
   $('.price_w2').addClass('hide');
   $('.price_w1').removeClass('hide'); 
   if(customers_id!=''){
        $.each(list_discount[customers_id], function( key, value ) {

            if(value['item']!=''){

                var array = value['item'].split(',');
                var array_group = value['group_list'].split(',');
                var list_id_product_cart =  $('.tab-pane.active').find('.ritem.items'); 
                for(var i = 0;i<list_id_product_cart.length;i++){
                  var obj = list_id_product_cart.eq(i);
                  var id = obj.data('id').toString();
                  var gid = obj.data('gid').toString();                  
                   if(array.includes(id) || array_group.includes(gid)){
                        
                      var data_info_item = get_infor_item(parseInt(id));
                      var price_discount = 0;
                          if(parseFloat(value['minimum_order_value'])>0){
                            if(total>=parseFloat(value['minimum_order_value'])){
                                if(parseInt(value['formal']) == 1){
                                  var discount_item = parseFloat(data_info_item.prices * value['discount'] / 100);
                                  price_discount = parseFloat(data_info_item.prices) - discount_item; 
                                  result += discount_item * parseInt(data_info_item.qty);
                                }
                                else{
                                  price_discount = parseFloat(data_info_item.prices) - value['discount'];                                  
                                  result += parseFloat(value['discount']) * parseInt(data_info_item.qty);
                                }
                            }
                          }
                          else{
                                if(parseInt(value['formal']) == 1){
                                  var discount_item = parseFloat(data_info_item.prices * value['discount'] / 100);
                                  price_discount = parseFloat(data_info_item.prices) - discount_item; 
                                  result += discount_item * parseInt(data_info_item.qty);
                                }
                                else{
                                  price_discount = parseFloat(data_info_item.prices) - value['discount'];                                  
                                  result += parseFloat(value['discount']) * parseInt(data_info_item.qty);
                                }
                          }
                          if(parseFloat(price_discount) > 0){
                             obj.find('.price_w2').removeClass('hide'); 
                             var new_price = numberWithCommas(price_discount);
                             obj.find('.price_w2 .new_prices').text(new_price); 
                             obj.find('.price_w1').addClass('hide');
                          }

                   }
                }
            }
            else{

               if(parseFloat(value['minimum_order_value'])>0){
                    if(total>=parseFloat(value['minimum_order_value'])){
                        if(parseInt(value['formal']) == 1){
                          result += parseFloat(total * value['discount'] / 100);
                        }
                        else{
                          result += parseFloat(value['discount']);
                        }
                    }                    
                }
                else{
                        if(parseInt(value['formal']) == 1){
                          result += parseFloat(total * value['discount'] / 100);
                        }
                        else{
                          result += parseFloat(value['discount']);
                         
                        }
                }
            }        
        });  
      }    
      else{
        $('.price_w2').addClass('hide');
        $('.price_w1').removeClass('hide');  
      }
    return result;
}
function get_infor_item(id){
    "use strict";
    var data_result = {};
    var list_id = $('.tab-pane.active').find('input[name="list_id_product"]').val();
    var list_qty = $('.tab-pane.active').find('input[name="list_qty_product"]').val();
    var list_price = $('.tab-pane.active').find('input[name="list_price_product"]').val();  
    if(list_id != ''){
        var id_list = JSON.parse('['+list_id+']');
        var qty_list = JSON.parse('['+list_qty+']');
        var price_list = JSON.parse('['+list_price+']');

        var index_id = -1;
          $.each(id_list, function( key, value ) {
            if(value == id){
              index_id = key;
            }
        }); 
        var qty = 0;
          $.each(qty_list, function( key, value ) {
              if(index_id == key){
                qty = value;
                return false;
              }           
          });

        var prices = 0;
          $.each(price_list, function( key, value ) {
              if(index_id == key){
                prices = value;
                return false;
              }           
        });
        data_result.qty = qty;
        data_result.prices = prices;
        return data_result;
    }
    return false;
}
function active_customer(){
    "use strict";
  $('select[name="client_id"]').change();
}
var index_scroll = 0;
function scroll_list(val){
  "use strict";
   const slider = document.querySelector('.header-tab-group ul');
   index_scroll = index_scroll + (val*100);
   if(index_scroll<0){
      index_scroll = 0;
   }
   slider.scrollLeft = index_scroll;
}
function round(val){
  "use strict";
  return Math.round(val * 100) / 100;
}