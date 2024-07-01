<script>
var signaturePad;
var croppedCtx;

  (function($) {
    "use strict";

  var data_send_mail = {};
  <?php if(isset($send_mail_approve)){ 
    ?>
    data_send_mail = <?php echo json_encode($send_mail_approve); ?>;
    data_send_mail.rel_id = <?php echo html_entity_decode($goods_receipt->id); ?>;
    data_send_mail.rel_type = '1';
    
    data_send_mail.addedfrom = <?php echo html_entity_decode($goods_receipt->addedfrom); ?>;
    $.post(admin_url+'warehouse/send_mail', data_send_mail).done(function(response){
    });
  <?php } ?>

   SignaturePad.prototype.toDataURLAndRemoveBlanks = function() {
     var canvas = this._ctx.canvas;
       // First duplicate the canvas to not alter the original
       var croppedCanvas = document.createElement('canvas');
       croppedCtx = croppedCanvas.getContext('2d');

       croppedCanvas.width = canvas.width;
       croppedCanvas.height = canvas.height;
       croppedCtx.drawImage(canvas, 0, 0);

       // Next do the actual cropping
       var w = croppedCanvas.width,
       h = croppedCanvas.height,
       pix = {
         x: [],
         y: []
       },
       imageData = croppedCtx.getImageData(0, 0, croppedCanvas.width, croppedCanvas.height),
       x, y, index;

       for (y = 0; y < h; y++) {
         for (x = 0; x < w; x++) {
           index = (y * w + x) * 4;
           if (imageData.data[index + 3] > 0) {
             pix.x.push(x);
             pix.y.push(y);

           }
         }
       }
       pix.x.sort(function(a, b) {
         return a - b
       });
       pix.y.sort(function(a, b) {
         return a - b
       });
       var n = pix.x.length - 1;

       w = pix.x[n] - pix.x[0];
       h = pix.y[n] - pix.y[0];
       var cut = croppedCtx.getImageData(pix.x[0], pix.y[0], w, h);

       croppedCanvas.width = w;
       croppedCanvas.height = h;
       croppedCtx.putImageData(cut, 0, 0);

       return croppedCanvas.toDataURL();
     };

      var canvas = document.getElementById("signature");
      signaturePad = new SignaturePad(canvas, {
      maxWidth: 2,
      onEnd:function(){
        signaturePadChanged();
      }
    });

    $('#identityConfirmationForm').submit(function() {
       signaturePadChanged();
     });
    

  })(jQuery);


     function signaturePadChanged() {
      "use strict";

       var input = document.getElementById('signatureInput');
       var $signatureLabel = $('#signatureLabel');
       $signatureLabel.removeClass('text-danger');

       if (signaturePad.isEmpty()) {
         $signatureLabel.addClass('text-danger');
         input.value = '';
         return false;
       }

       $('#signatureInput-error').remove();
       var partBase64 = signaturePad.toDataURLAndRemoveBlanks();
       partBase64 = partBase64.split(',')[1];
       input.value = partBase64;
     }

  
  function signature_clear(){
    "use strict";
    var canvas = document.getElementById("signature");
    var signaturePad = new SignaturePad(canvas, {
      maxWidth: 2,
      onEnd:function(){
        
      }
    });
    signaturePad.clear();
    
  }

  function sign_request(id){
    "use strict";
    change_request_approval_status(id,1, true);
  }
  function approve_request(id){
    "use strict";
    change_request_approval_status(id,1);
  }
  function deny_request(id){
    "use strict";
      change_request_approval_status(id,-1);
  }

  function change_request_approval_status(id, status, sign_code){
    "use strict";

      var data = {};
      data.rel_id = id;
      data.rel_type = '1';
      
      data.approve = status;
      if(sign_code == true){
        data.signature = $('input[name="signature"]').val();
      }else{
        data.note = $('textarea[name="reason"]').val();
      }
      $.post(admin_url + 'warehouse/approve_request/' + id, data).done(function(response){
          response = JSON.parse(response); 
          if (response.success === true || response.success == 'true') {
              alert_float('success', response.message);
              window.location.reload();
          }
      });
  }

  function send_request_approve(id){
    "use strict";
      var data = {};
      data.rel_id = <?php echo html_entity_decode($goods_receipt->id); ?>;
      data.rel_type = '1';
     
      data.addedfrom = <?php echo html_entity_decode($goods_receipt->addedfrom); ?>;
    $("body").append('<div class="dt-loader"></div>');
      $.post(admin_url + 'warehouse/send_request_approve', data).done(function(response){
          response = JSON.parse(response);
          $("body").find('.dt-loader').remove();
          if (response.success === true || response.success == 'true') {
              alert_float('success', response.message);
              window.location.reload();
          }else{
            alert_float('warning', response.message);
              window.location.reload();
          }
      });
  }

function accept_action() {
  "use strict";
      $('#add_action').modal('show');
    }

 function send_goods_received(id) {
  "use strict"; 
  $('#additional_goods_received').html('');
  $('#additional_goods_received').append(hidden_input('po_id',id));
  $('#send_goods_received').modal('show');
 }

</script>

