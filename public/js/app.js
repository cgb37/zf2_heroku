/**
 * Created by charlesbrown-roberts on 10/19/15.
 */
$(document).ready(function() {

    var due_date_result = $('#due_date_result').text();


    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        // put your options and callbacks here
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'month',
        events: [
            {
                title  : 'Due Date',
                start  : due_date_result
            }
        ]
    });


    $('#first_due_date_submit').on('click', function() {

        $('#calendar').fullCalendar('gotoDate', moment(due_date_result));
        
    })

});