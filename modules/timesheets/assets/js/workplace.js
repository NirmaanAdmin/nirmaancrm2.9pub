(function(){
  "use strict";
  appValidateForm($('#add_workplace'), {
   'name': 'required',
   'workplace_address': 'required',
   'latitude': 'required',
   'distance': 'required',
   'longitude': 'required'
 })
})(jQuery);
/**
 * new workplace
 */
 function new_workplace(){
  'use strict';
  $('#additional_workplace').html('');
  $('#workplace input[name="id"]').val('');
  $('#workplace input[name="name"]').val('');
  $('#workplace textarea[name="workplace_address"]').val('');
  $('#workplace input[name="latitude"]').val('');
  $('#workplace input[name="longitude"]').val('');
  $('#workplace').modal('show');
  $('.edit-title').addClass('hide');
  $('.add-title').removeClass('hide');
}

/**
 * edit workplace 
 */
 function edit_workplace(invoker,id){
  'use strict';
  $('#additional_workplace').html('');
  $('#workplace input[name="id"]').val($(invoker).data('id'));
  $('#workplace input[name="name"]').val($(invoker).data('name'));
  $('#workplace textarea[name="workplace_address"]').val($(invoker).data('workplace_address'));
  $('#workplace input[name="latitude"]').val($(invoker).data('latitude'));
  $('#workplace input[name="longitude"]').val($(invoker).data('longitude'));
  $('#workplace input[name="distance"]').val($(invoker).data('distance'));
  if($(invoker).data('default') == 1){
    $('#workplace input[name="default"]').prop('checked', true);
  }
  else{
    $('#workplace input[name="default"]').prop('checked', false);    
  }
  $('#workplace').modal('show');
  $('.add-title').addClass('hide');
  $('.edit-title').removeClass('hide');
}
/**
 * getLocation
 */
 function getMyLocation() {
  'use strict';
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showMyPosition);
  } else { 
    alert("Geolocation is not supported by this browser.");
  }
}
/**
 * show position
 */
function showMyPosition(position) {
  'use strict';
  $('#workplace input[name="latitude"]').val(position.coords.latitude);
  $('#workplace input[name="longitude"]').val(position.coords.longitude);
}