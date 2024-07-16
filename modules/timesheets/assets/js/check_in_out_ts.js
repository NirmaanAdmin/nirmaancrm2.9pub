  (function(){
   "use strict";
   $(document).on("click",".btn-edit-datetime",function() {
    $(this).addClass('hide');
    $('.btn-close-edit-datetime').removeClass('hide');
    $("#clock_attendance_modal .curr_date .form-group").slideDown(500);
  });
   $(document).on("click",".btn-close-edit-datetime",function() {
     $(this).addClass('hide');
     $('.btn-edit-datetime').removeClass('hide');
     $('#clock_attendance_modal input[name="edit_date"]').val('');
     $("#clock_attendance_modal .curr_date .form-group").slideUp(500);
     var staff_id = $('#clock_attendance_modal input[name="staff_id"]').val();
     get_data_attendance(staff_id, get_date());
     $('#clock_attendance_modal input[name="edit_date"]').val('');
   });
   $(window).on('load', function() {
     var hour_attendance = $('input[name="hour_attendance"]').val();
     var minute_attendance = $('input[name="minute_attendance"]').val();
     var second_attendance = $('input[name="second_attendance"]').val();
     server_time(hour_attendance,minute_attendance,second_attendance);
     get_route_point();
   });
 })(jQuery);
 var run_time;
 /**
  * set date
  */
  function setDate(hour, minute, second){
   "use strict";
   var secondDeg = ((second / 60) * 360) + 360; 
   $("#clock_attendance_modal #secondHand").css('transform','rotate('+secondDeg+'deg)');
   var minuteDeg = ((minute / 60) * 360); 
   $("#clock_attendance_modal #minuteHand").css('transform','rotate('+minuteDeg+'deg)');
   var hourDeg = ((hour / 12 ) * 360 ); 
   $("#clock_attendance_modal #hourHand").css('transform','rotate('+hourDeg+'deg)');
 }
 /**
  * open check in out
  */
  function open_check_in_out(){
   "use strict";
   getLocation();
   $("#clock_attendance_modal .curr_date .form-group").slideUp(1);
   $('#clock_attendance_modal').modal('show');
   appValidateForm($('#timesheets-form-check-in'), {
     staff_id: 'required',
     date: 'required'
   })
   appValidateForm($('#timesheets-form-check-out'), {
     staff_id: 'required',
     date: 'required'
   })   
   $(".btn-close-edit-datetime").click();
 }
/**
 * update Clock
 */
 function updateClock() {
   "use strict";
   var currentTime = new Date();
   var currentHoursAP = currentTime.getHours();
   var currentHours = currentTime.getHours();
   var currentMinutes = currentTime.getMinutes();
   var currentSeconds = currentTime.getSeconds();
   currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
   currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
   var timeOfDay = (currentHours < 12) ? "AM" : "PM";
   currentHoursAP = (currentHours > 12) ? currentHours - 12 : currentHours;
   currentHoursAP = (currentHoursAP == 0) ? 12 : currentHoursAP;
   var currentTimeString =  currentHours + ":" + currentMinutes + ":" + currentSeconds;
   $('.time_script').text(currentTimeString);
   $('input[name="hours"]').val(currentTimeString);
 }
 /**
  * change date
  */
  function changedate(el){
   "use strict";
   var date = $(el).val();
   $('#clock_attendance_modal input[name="edit_date"]').val(date);
   var staff_id = $('#clock_attendance_modal input[name="staff_id"]').val();
   get_data_attendance(staff_id, get_date());
   get_route_point();
 }
 /**
  * changestaff id
  */
  function changestaff_id(el){
   "use strict";
   var staff_id = $(el).val();
   $('#clock_attendance_modal input[name="staff_id"]').val(staff_id);
   get_data_attendance(staff_id, get_date());
   get_route_point();
 }
 /**
  * get data attendance 
  */
  function get_data_attendance(staff_id, date){
   "use strict";
   if(staff_id != ''){
     var data = {};
     data.staff_id = staff_id;
     data.date = date;
     $.post(admin_url+'timesheets/get_data_attendance',data).done(function(response){
      response = JSON.parse(response);
      $('#attendance_history').html('');
      $('#attendance_history').html(response.html_list);
    });
   }
 }
/**
 * get date
 */
 function get_date(){
   "use strict";
   var val_date = $('#clock_attendance_modal input[name="edit_date"]').val();
   if(val_date == ''){
    val_date = $('input[name="date_attendance"]').val();
  }
  return val_date; 
}
/**
 * server time 
 */
 function server_time(hour, minute, second){
   "use strict";
   setDate(hour, minute, second);
   second++;
   if(second > 59){
    second = 0;
    minute++;
    if(minute > 59){
      minute = 0;
      hour++;
      if(hour > 23){
        hour = 0;
      }
    }
  }
  run_time = setTimeout(function() {
    server_time(hour, minute, second);
  }, 1000)
}

function get_route_point(){
 "use strict";
 var geolocation = $('input[name="location_user"]').eq(0).val();
 if(geolocation != ''){
  var split = geolocation.split(',');
  var data = {};
  data.lat = split[0];
  data.lng = split[1];
  data.staff = $('select[name="staff_id"]').val();
  data.date = $('#edit_date').val();

  $.post(admin_url+'timesheets/get_route_point_combobox',data).done(function(response){
    response = JSON.parse(response);
    if(response.point_id == '') {
      $('.route_point_combobox').addClass('hide');
    }
    else{
      $('.route_point_combobox').removeClass('hide');
      $('select[name="route_point"]').html(response.option).selectpicker('refresh');
    }
  });
}
}
function get_data(){
 "use strict";
 var route_point = $('#route_point').val();
 $('input[name="point_id"]').val(route_point);
 $('#timesheets-form-check-in .check_in').attr('disabled', 'disabled');
 $('#timesheets-form-check-out .check_out').attr('disabled', 'disabled');
}

function getLocation() {
 "use strict";
 function success(position) {
  const latitude  = position.coords.latitude;
  const longitude = position.coords.longitude;
  $('#clock_attendance_modal input[name="location_user"]').val(latitude+','+longitude);
  get_route_point();
}

function error() {
  alert('Unable to retrieve your location');
}

if (!navigator.geolocation) {
  alert('Geolocation is not supported by your browser');
} else {
  navigator.geolocation.getCurrentPosition(success, error);
}
}

