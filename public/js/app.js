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


    $('#first_due_date_submit').on('click', function(event) {

        event.preventDefault();
        var $due_date = $(this);

        $.get("calculator/calculate", null,
            function(data){
                if(data.response == true){

                    $("#due_date_result").empty();

                    // print success message
                    $("#due_date_result").append("<p>Your next due date is: </p>");
                } else {
                    // print error message
                    console.log('could not calculate due date');
                }
            }, 'json');






        $('#calendar').fullCalendar('gotoDate', moment(due_date_result));

    })

});