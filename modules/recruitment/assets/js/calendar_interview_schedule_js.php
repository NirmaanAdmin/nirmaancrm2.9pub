<script>
(function($) {
"use strict";

    $('#start_time').datetimepicker();
    $('#end_time').datetimepicker();

    if(get_url_param('eventid')) {
    	view_event(get_url_param('eventid'));
    }

    _validate_form($('#add_edit_booking-form'),{purpose:'required',resource_group:'required',resource:'required',start_time:'required',end_time:'required'});
    $('#resource_group').on('change', function(){
      $.post(admin_url+'resource_booking/get_resource_by_group/'+this.value).done(function(response){
         response = JSON.parse(response);
         $("#resource").html('');
         $html = '<option value=""></option>';
         $.each(response.cont,function(){
            $html += '<option value="'+ this.id +'">'+ this.resource_name +'</option>';
         });
         $("#resource").html($html);
         $("#resource").selectpicker('refresh');
      });
    });

    var calendar_selector = $('#calendars');
    if (calendar_selector.length > 0) {
        validate_calendar_form();
        var calendar_settings = {
            themeSystem: 'bootstrap3',
            customButtons: {},
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,viewFullCalendar,calendarFilter'
            },
            editable: false,
            eventLimit: parseInt(app.options.calendar_events_limit) + 1,

            views: {
                day: {
                    eventLimit: false
                }
            },
            defaultView: app.options.default_view_calendar,
            isRTL: (isRTL == 'true' ? true : false),
            eventStartEditable: false,
            timezone: app.options.timezone,
            firstDay: parseInt(app.options.calendar_first_day),
            year: moment.tz(app.options.timezone).format("YYYY"),
            month: moment.tz(app.options.timezone).format("M"),
            date: moment.tz(app.options.timezone).format("DD"),
            loading: function(isLoading, view) {
                isLoading && $('#calendars .fc-header-toolbar .btn-default').addClass('btn-info').removeClass('btn-default').css('display', 'block');
                !isLoading ? $('.dt-loader').addClass('hide') : $('.dt-loader').removeClass('hide');
            },
            eventSources: [{
                url: admin_url + 'recruitment/get_calendar_interview_schedule_data',
                data: function() {
                    var params = {};
                    $('#calendar_filters').find('input:checkbox:checked').map(function() {
                        params[$(this).attr('name')] = true;
                    }).get();
                    if (!jQuery.isEmptyObject(params)) {
                        params['calendar_filters'] = true;
                    }
                    return params;
                },
                type: 'POST',
                error: function() {
                    console.error('There was error fetching calendar data');
                },
            }, ],
            eventLimitClick: function(cellInfo, jsEvent) {
                $('#calendars').fullCalendar('gotoDate', cellInfo.date);
                $('#calendars').fullCalendar('changeView', 'basicDay');
            },
            eventRender: function(event, element) {
                element.attr('title', event._tooltip);
                element.attr('onclick', event.onclick);
                element.attr('data-toggle', 'tooltip');
                if (!event.url) {
                    element.click(function() { view_event(event.eventid); });
                }
            },
            dayClick: function(date, jsEvent, view) {
                var d = date.format();
                if (!$.fullCalendar.moment(d).hasTime()) {
                    d += ' 00:00';
                }
                var vformat = (app.options.time_format == 24 ? app.options.date_format + ' H:i' : app.options.date_format + ' g:i A');
                var fmt = new DateFormatter();
                var d1 = fmt.formatDate(new Date(d), vformat);
                $("input[name='interview_day'].datetimepicker").val(d1);
                $('#interview_schedules_modal').modal('show');
                return false;
            }
        };
       

        if (app.user_is_staff_member == 1) {
            if (app.options.google_api !== '') {
                calendar_settings.googleCalendarApiKey = app.options.google_api;
            }
            if (app.calendarIDs !== '') {
                app.calendarIDs = JSON.parse(app.calendarIDs);
                if (app.calendarIDs.length != 0) {
                    if (app.options.google_api !== '') {
                        for (var i = 0; i < app.calendarIDs.length; i++) {
                            var _gcal = {};
                            _gcal.googleCalendarId = app.calendarIDs[i];
                            calendar_settings.eventSources.push(_gcal);
                        }
                    } else {
                        console.error('You have setup Google Calendar IDs but you dont have specified Google API key. To setup Google API key navigate to Setup->Settings->Google');
                    }
                }
            }
        }
        // Init calendar
        calendar_selector.fullCalendar(calendar_settings);
        var new_event = get_url_param('new_event');
        if (new_event) {
            $("input[name='interview_day'].datetimepicker").val(get_url_param('date'));
            $('#interview_schedules_modal').modal('show');
        }

    }


})(jQuery);

function check_resource_booking(){
    "use strict";

    var resource = $('#resource').val();
    var start_time = $('#start_time').val();
    var end_time = $('#end_time').val();
      $.post(admin_url+'resource_booking/check_resource_booking/'+resource+'/'+start_time+'/'+end_time).done(function(response){
         response = JSON.parse(response);
         if(response.check == true){
            $("#add_edit_booking-form").submit();
            $('#interview_schedules_modal').modal('hide');
            location.reload();
         }else{
            $('.notification').html('');
            $('.notification').append('<label class="danger"><?php echo _l('notification_check_resource_booking'); ?></label');
         }
      });
}


function validate_calendar_form() {
     "use strict";

    appValidateForm($("body").find('._event form'), {
        title: 'required',
        start: 'required',
        reminder_before: 'required'
    }, calendar_form_handler);

    appValidateForm($("body").find('#viewEvent form'), {
        title: 'required',
        start: 'required',
        reminder_before: 'required'
    }, calendar_form_handler);
}

function calendar_form_handler(form) {
    "use strict";

    $.post(form.action, $(form).serialize()).done(function(response) {
        response = JSON.parse(response);
        if (response.success === true || response.success == 'true') {
            alert_float('success', response.message);
            setTimeout(function() {
                var location = window.location.href;
                location = location.split('?');
                window.location.href = location[0];
            }, 500);
        }
    });

    return false;
}

</script>