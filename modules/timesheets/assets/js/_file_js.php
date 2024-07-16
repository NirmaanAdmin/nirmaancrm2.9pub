<script>
(function(){
  "use strict";
  $('body').on('shown.bs.modal', '._project_file', function() {
     var content_height = ($('body').find('._project_file .modal-content').height() - 165);
     if($('iframe').length > 0){
       $('iframe').css('height',content_height);
     }
     if(!is_mobile()){
      $('.project_file_area,.project_file_discusssions_area').css('height',content_height);
    }
   });
   $('body').find('._project_file').modal({show:true, backdrop:'static', keyboard:false});

})(jQuery);
</script>