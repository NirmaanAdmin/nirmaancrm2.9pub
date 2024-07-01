 <script type="text/javascript">

  var group_id = 0;
  const slider = document.querySelector('.header-tab-group ul');
  let isDown = false;
  let startX;
  let scrollLeft;
  var walk = 0;
  var vchange = 0;
  var vschange1 = 0;
  var vschange2 = 0;
  slider.addEventListener('mousedown', (e) => {
    isDown = true;
    slider.classList.add('active');
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
    vchange = slider.scrollLeft;
  });
  slider.addEventListener('mouseleave', () => {
    isDown = false;
    slider.classList.remove('active');
  });
  slider.addEventListener('mouseup', () => {
    isDown = false;
    slider.classList.remove('active');
  });
  slider.addEventListener('mousemove', (e) => {
    if(!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    walk = (x - startX) * 1;
    slider.scrollLeft = scrollLeft - walk;
    vschange2 = slider.scrollLeft;
  });
  slider.addEventListener('click', (e) => {
    if(vchange == vschange2){
        get_list_group(group_id);
    }
    else{
        $('.item-group').removeClass('active');
    }
  });
$('.item-group').click(function(){
    "use strict";
    group_id = $(this).data('id_group');
    get_list_group(group_id);
});

function replacequote(text) {
    "use strict";
    var newText = "";
    for (var i = 0; i < text.length; i++) {
        if (text[i] == "'") {
            newText += "\\'";
        }
        else
            newText += text[i];
    }
    return newText;
};
function create_invoice(el){
    "use strict";
    var list_id = $(el).closest('.tab-pane.active').find('input[name="list_id_product"]').val();
    var list_qty = $(el).closest('.tab-pane.active').find('input[name="list_qty_product"]').val();
    var list_price = $(el).closest('.tab-pane.active').find('input[name="list_price_product"]').val();
    var list_price_discount = $(el).closest('.tab-pane.active').find('input[name="list_price_discount_product"]').val();
    var list_percent_discount = $(el).closest('.tab-pane.active').find('input[name="list_percent_discount_product"]').val();
    var voucher = $(el).closest('.tab-pane.active').find('input[name="voucher"]').val();
    var discount_total = $(el).closest('.tab-pane.active').find('input[name="discount_total"]').val();

    var subtotal = $(el).closest('.tab-pane.active').find('input[name="sub_total_cart"]').val();
    var total = $(el).closest('.tab-pane.active').find('input[name="total_cart"]').val();
    var tax = $(el).closest('.tab-pane.active').find('input[name="tax"]').val();
    var create_invoice = $(el).closest('.tab-pane.active').find('input[name="create_invoice"]').is(":checked");
    var stock_export = $(el).closest('.tab-pane.active').find('input[name="stock_export"]').is(":checked");
    if(stock_export == true){
        stock_export = 'on';
    }
    else{
        stock_export = 'off';
    }
    if(create_invoice == true){
        create_invoice = 'on';
    }
    else{
        create_invoice = 'off';
    }
    var customers_pay = $(el).closest('.tab-pane.active').find('input[name="customers_pay"]').val();
    var amount_returned = $(el).closest('.tab-pane.active').find('input[name="amount_returned"]').val();
    var customer = $('select[name="client_id"]').val();
    var seller = $('select[name="seller"]').val();

     if(customer!='' && seller!=''){
            $.ajax({
                 url: "create_invoice_pos/"+customer,
                 type: "post",
                 data: {'<?php echo html_entity_decode($this->security->get_csrf_token_name()); ?>':'<?php echo html_entity_decode($this->security->get_csrf_hash()); ?>','list_id_product':replacequote(list_id),'list_qty_product':replacequote(list_qty),'list_price_product':replacequote(list_price),'sub_total':replacequote(subtotal),'total':replacequote(total),'create_invoice':replacequote(create_invoice),'stock_export':replacequote(stock_export),'customers_pay':replacequote(customers_pay),'amount_returned':replacequote(amount_returned),'tax': replacequote(tax),'list_price_discount_product': replacequote(list_price_discount),'list_percent_discount_product': replacequote(list_percent_discount),'discount_total': replacequote(discount_total),'seller':replacequote(seller)},
                 success: function(){
                 },
                 error:function(){
                    $('#alert').modal('show').find('.alert_content').text('Failure');
                    setTimeout(function(){ $('#alert').modal('hide'); },1500);
                 }
              }).done(function(response) {
            response = JSON.parse(response);
            if(response.stock_export_number != ''){
                var link = '<a href="../warehouse/manage_delivery#'+response.stock_export_number+'" class="btn" target="blank">View export stock</a>';
                $('.tab-pane.active').find('.stock_export_fr').html(link);
            }
            if(response.number_invoice != ''){
                var link = '<a href="../invoices/pdf/'+response.number_invoice+'?print=true" class="btn btn-primary pull-right" target="blank">Print</a>';                
                link += '<a href="../invoices#'+response.number_invoice+'" class="btn pull-right" target="blank">View invoice</a>';
                $('.tab-pane.active').find('.create_invoice_fr').html(link);
            }
            $('#alert').modal('show').find('.alert_content').text('Created successfull');
            setTimeout(function(){ $('#alert').modal('hide'); },1500);
            $(el).closest('.tab-pane.active').find('.create_invoice').fadeOut(500);
        });  
    }
    else{
        $('#alert').modal('show').find('.alert_content').text('<?php echo _l('please_select_customers_and_sellers'); ?>');
        setTimeout(function(){ $('#alert').modal('hide'); },1500);
    }
    if(seller==''&&customer!=''){
            $('#alert').modal('show').find('.alert_content').text('<?php echo _l('please_select_a_seller'); ?>');
            setTimeout(function(){ $('#alert').modal('hide'); },1500);
    }
    if(seller!=''&&customer==''){
            $('#alert').modal('show').find('.alert_content').text('<?php echo _l('please_select_a_customer'); ?>');
            setTimeout(function(){ $('#alert').modal('hide'); },1500);
    }
}
function search(el){
    "use strict";
    var group_id = $(el).data('id_group');
    $('.content_list').html(''); 
    var key = $('input[name="keyword"]').val();
    var page = 1;
      if(page!=''){
        $.ajax({
             url: "get_product_by_group_pos_channel/"+page+'/'+group_id+'/'+key,
             type: "post",
             data: {'<?php echo html_entity_decode($this->security->get_csrf_token_name()); ?>':'<?php echo html_entity_decode($this->security->get_csrf_hash()); ?>'},
             success: function(){
             },
             error:function(){
                alert("failure");
             }
          }).done(function(response) {
        response = JSON.parse(response);
                $('.content_list').html(response.data);
         });  
    }
}
function get_list_group(group_id){
    "use strict";
    $('.search_btn').attr('data-id_group',group_id);
    $('.content_list').html(''); 
    var key = $('input[name="keyword"]').val();
    var page = 1;
      if(page!=''){
        $.ajax({
             url: "get_product_by_group_pos_channel/"+page+'/'+group_id+'/'+key,
             type: "post",
             data: {'<?php echo html_entity_decode($this->security->get_csrf_token_name()); ?>':'<?php echo html_entity_decode($this->security->get_csrf_hash()); ?>'},
             success: function(){
             },
             error:function(){
                $('#alert').modal('show').find('.alert_content').text('Failure');
                setTimeout(function(){ $('#alert').modal('hide'); },1500);
             }
          }).done(function(response) {
        response = JSON.parse(response);
                $('.content_list').html(response.data);
         });  
    }
}
function get_voucher(el){
  "use strict";
    var data = {};
    var voucher = $(el).val();
    var customer = $('select[name="client_id"]').val();
    var subtotal = $(el).closest('.tab-pane.active').find('input[name="sub_total_cart"]').val();
    if(voucher!=''){
     $.ajax({
             url: "voucher_apply",
             type: "post",
             data: {'<?php echo html_entity_decode($this->security->get_csrf_token_name()); ?>':'<?php echo html_entity_decode($this->security->get_csrf_hash()); ?>', 'voucher':replacequote(voucher), 'client':customer, 'channel':1},
             success: function(){
             },
             error:function(){
                    $('#alert').modal('show').find('.alert_content').text('Failure');
                    setTimeout(function(){ $('#alert').modal('hide'); },1500);
                    $(el).val('');
             }
          }).done(function(response) {
            response = JSON.parse(response);
            if(response[0] != null){
                  var  test = 0;
                  if(parseFloat(response[0].minimum_order_value)>0){
                    test = 1;
                    if(subtotal >= parseFloat(response[0].minimum_order_value)){
                      test = 0;
                    }
                  }
                  if(test == 0){
                     $('.tab-pane.active').find('input[name="discount_type"]').val(response[0].formal);
                     $('.tab-pane.active').find('input[name="discount_voucher"]').val(response[0].discount);                  
                     total_cart(); 
                      $('#alert').modal('show').find('.alert_content').text('Voucher applied');
                      setTimeout(function(){ $('#alert').modal('hide'); },2000);                   
                  }
                  else{
                      $('#alert').modal('show').find('.alert_content').text('Your order is not eligible for this code');
                      setTimeout(function(){ $('#alert').modal('hide'); },1500);
                      $(el).val('');
                  }
            }else{
                $('.tab-pane.active').find('input[name="discount_voucher"]').val('0');
                $('.tab-pane.active').find('input[name="discount_type"]').val('');
                total_cart();
                $('#alert').modal('show').find('.alert_content').text('Voucher does not exist');
                setTimeout(function(){ $('#alert').modal('hide'); },1500);
                $(el).val('');
            }
         }); 
    }
    else{
      $('.tab-pane.active').find('input[name="discount_voucher"]').val('0');
      var discount_auto = $('.tab-pane.active').find('input[name="discount_auto"]').val();
      if(discount_auto == 0){
          $('.tab-pane.active').find('input[name="discount_type"]').val('');
      }
      total_cart();
    }   
}
var list_discount = [];
function get_trade_discount(el){
  "use strict";
    var id = $(el).val();
    $('.tab-pane.active').find('input[name="customer_id"]').val(id);
    if(id != ''){
       $.ajax({
               url: "get_trade_discount",
               type: "post",
               data: {'<?php echo html_entity_decode($this->security->get_csrf_token_name()); ?>':'<?php echo html_entity_decode($this->security->get_csrf_hash()); ?>', 'id':id},
               success: function(){
               },
               error:function(){
                      $('#alert').modal('show').find('.alert_content').text('Failure');
                      setTimeout(function(){ $('#alert').modal('hide'); },1500);
               }
            }).done(function(response) {
              response = JSON.parse(response);
              if(response[0].length >= 1){
                list_discount[id] = [];
                for(var i = 0; i < response[0].length;i++){
                    list_discount[id].push({item:response[0][i]['items'], formal:response[0][i]['formal'],group_list:response[0][i]['group_items'], discount:response[0][i]['discount'], voucher:response[0][i]['voucher'], minimum_order_value:response[0][i]['minimum_order_value']});
                }
              }              
                total_cart(); 
           }); 
    } 
    else{
      $('.tab-pane.active').find('input[name="discount_auto"]').val('0');
      var discount_voucher = $('.tab-pane.active').find('input[name="discount_voucher"]').val();
      if(discount_voucher == 0){
          $('.tab-pane.active').find('input[name="discount_type"]').val('');
      }
      total_cart(); 
    } 
}

  function change_page(el){
    "use strict";
    $('.btn_page').removeClass('active');
    $(el).addClass('active');
    $('.product_list').html(''); 
    var page = $(el).data('page');
    var group_id = $('input[name="group_id"]').val();
    var keyword = $('input[name="keyword"]').val();
        $('.content_list').html(''); 
        var key = $('input[name="keyword"]').val();
          if(page!=''){
            $.ajax({
                 url: "get_product_by_group_pos_channel/"+page+'/'+group_id+'/'+key,
                 type: "post",
                 data: {'<?php echo html_entity_decode($this->security->get_csrf_token_name()); ?>':'<?php echo html_entity_decode($this->security->get_csrf_hash()); ?>'},
                 success: function(){
                 },
                 error:function(){
                    alert("failure");
                 }
              }).done(function(response) {
            response = JSON.parse(response);
                    $('.content_list').html(response.data);
             });  
        }
  }
</script>
