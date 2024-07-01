(function(){
  "use strict";
  var fnServerParams = {
    "id_store" : "input[name='id']"
  }

  initDataTable('.table-channel-woocommerce', admin_url + 'omni_sales/table_channel_woocommerce', false, false, fnServerParams, [0, 'desc']);
  initDataTable('.table-product-woocommerce', admin_url + 'omni_sales/table_product_woocommerce', false, false, fnServerParams, [0, 'desc']);

  $('#add_channel_woocommerce').click(function(){
    $('.add-title').removeClass('hide');
    $('.update-title').addClass('hide');
    $('.test_connect').addClass('hide');
    $('#channel_woocommerce').modal('show');
    $('input[name="id"]').val('');
    $('input[name="name_channel"]').val('');
    $('input[name="consumer_key"]').val('')
    $('input[name="consumer_secret"]').val('');
  })
  appValidateForm($('#form_add_channel_woocommerce'), {
           'name_channel': 'required',
           'consumer_key': 'required',
           'consumer_secret': 'required',
           'url': 'required'
  });


  $('.sync_products_woo').click(function(){
    var id = $(this).data('id');
    var html = '';
    html += '<div class="Box">';
    html += '<span>';
    html += '<span></span>';
    html += '</span>';
    html += '</div>';
    $('#box-loadding').html(html);
    $.post(admin_url+'omni_sales/sync_products_to_store/'+id).done(function(response){
      response = JSON.parse(response);
      if(response){
        $('#box-loadding').html('');
        alert_float('success', 'Sync successfully');
      }else{
        $('#box-loadding').html('');
        alert_float('warning', 'Sync unsuccessful');
      }
    });
    
  })

  $('.sync_products_from_woo').click(function(){
    var id = $(this).data('id');
    var html = '';
    html += '<div class="Box">';
    html += '<span>';
    html += '<span></span>';
    html += '</span>';
    html += '</div>';
    $('#box-loadding').html(html);
    $.post(admin_url+'omni_sales/sync_products_from_store/'+id).done(function(response){
          $('#box-loadding').html('');
          $('.table-product-woocommerce').DataTable().ajax.reload();
          location.reload();  
    });
    
  })

  $('.sync_products_from_info_woo').click(function(){
    var id = $(this).data('id');
    var html = '';
    html += '<div class="Box">';
    html += '<span>';
    html += '<span></span>';
    html += '</span>';
    html += '</div>';
    $('#box-loadding').html(html);
    $.post(admin_url+'omni_sales/sync_products_from_info_woo/'+id).done(function(response){
      $('#box-loadding').html('');
      $('.table-product-woocommerce').DataTable().ajax.reload();
    });
    
  })

  $('.test_connect').click(function(){
    var url = $('input[name="url"]').val();
    var consumer_key = $('input[name="consumer_key"]').val();
    var consumer_secret = $('input[name="consumer_secret"]').val();
    var html = '';
    html += '<div class="Box">';
    html += '<span>';
    html += '<span></span>';
    html += '</span>';
    html += '</div>';
    $('#box-loadding').html(html);
    var data = {};
    data.url = url;
    data.consumer_key = consumer_key;
    data.consumer_secret = consumer_secret;
    $.post(admin_url+'omni_sales/test_connect', data).done(function(response){
      response = JSON.parse(response);
      if(response.check == true){
        alert_float('success', response.message);
      }else{
        alert_float('warning', response.message);
      }
      $('#box-loadding').html('');
    });
  })
$("input[data-type='currency']").on({
    keyup: function() {        
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
 });
//----- OPEN
    $('[data-popup-open]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-open');
        $('[data-popup="' + targeted_popup_class + '"]').fadeIn(350);
 
        e.preventDefault();
    });
 
    //----- CLOSE
    $('[data-popup-close]').on('click', function(e)  {
        var targeted_popup_class = jQuery(this).attr('data-popup-close');
        $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);
 
        e.preventDefault();
    });

})(jQuery);

function edit(el){
  "use strict";
  var id = $(el).data("id");
  var name = $(el).data("name");
  var key = $(el).data("key");
  var secret= $(el).data("secret");
  var url= $(el).data("url");
  
  $('.update-title').removeClass('hide');
  $('.add-title').addClass('hide');
  $('.test_connect').removeClass('hide');
  $('input[name="id"]').val(id);
  $('input[name="name_channel"]').val(name);
  $('input[name="consumer_key"]').val(key)
  $('input[name="consumer_secret"]').val(secret);
  $('input[name="url"]').val(url);
  $('#channel_woocommerce').modal('show');
}

function add_product(){
  "use strict";
  $('.update-title').addClass('hide');
  $('.add-title').removeClass('hide');
  $('#chose_product').modal();
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

function sync_store(el){
  "use strict";
  var id = $(el).data('id');
  var html = '';
  html += '<div class="Box">';
  html += '<span>';
  html += '<span></span>';
  html += '</span>';
  html += '</div>';
  $('#box-loadding').html(html);
  $.post(admin_url+'omni_sales/process_orders_woo/'+id).done(setTimeout(function(response){
    $('#box-loadding').html('');
      response = JSON.parse(response);
      if(response){
        $('#box-loadding').html('');
        alert_float('success', 'sync store successfully');
      }

  },5000));
}

function sync_inventory_synchronization(el){
  "use strict";
  var id = $(el).data('id');
  var html = '';
  html += '<div class="Box">';
  html += '<span>';
  html += '<span></span>';
  html += '</span>';
  html += '</div>';
  $('#box-loadding').html(html);
  $.post(admin_url+'omni_sales/process_inventory_synchronization/'+id).done(setTimeout(function(response){
          $('#box-loadding').html('');
      response = JSON.parse(response);
      if(response){
        $('#box-loadding').html('');
        alert_float('success', 'sync store successfully');
      }

  },5000));
}

function sync_decriptions_synchronization(el){
  "use strict";
  var id = $(el).data('id');
  var html = '';
  html += '<div class="Box">';
  html += '<span>';
  html += '<span></span>';
  html += '</span>';
  html += '</div>';
  $('#box-loadding').html(html);
  $.post(admin_url+'omni_sales/process_decriptions_synchronization/'+id).done(setTimeout(function(response){
      $('#box-loadding').html('');
      response = JSON.parse(response);
      if(response){
        $('#box-loadding').html('');
        alert_float('success', 'sync descriptions successfully');
      }

  },5000));
}

function sync_images_synchronization(el){
  "use strict";
  var id = $(el).data('id');
  var html = '';
  html += '<div class="Box">';
  html += '<span>';
  html += '<span></span>';
  html += '</span>';
  html += '</div>';
  $('#box-loadding').html(html);
  $.post(admin_url+'omni_sales/process_images_synchronization/'+id).done(setTimeout(function(response){
    $('#box-loadding').html('');
      response = JSON.parse(response);
      if(response){
        $('#box-loadding').html('');
        alert_float('success', 'sync descriptions successfully');
      }

  },5000));
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
     $('.update-title').removeClass('hide');
     $('.add-title').addClass('hide');
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
