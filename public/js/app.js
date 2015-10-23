/**
 * Created by charlesbrown-roberts on 10/19/15.
 */
$(document).ready(function() {



    if($('#due_date_result').empty()) {
        var title = "Today";
        var due_date_result = moment();
    }


    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        // put your options and callbacks here
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        theme: true,
        defaultView: 'month',
        events: [
            {
                'title': title,
                'start': due_date_result
            }
        ]
    });



    $('#first_due_date_submit').on('click', function(event) {

        event.preventDefault();

        var fund_date_input =  $("#fund_date_input").val();  //'2015-02-12';
        //console.log(fund_date_input);

        var pay_span = $("#pay_span_input").val();
        //console.log($("#pay_span_input").val());

        var direct_deposit = $("#direct_deposit_input").val();
        //console.log(direct_deposit)

        $.get("calculate?fund_date_input=" + fund_date_input + "&pay_span=" + pay_span + "&direct_deposit=" + direct_deposit, null,
            function(data){
                if(data.response == true){

                    $("#due_date_result").empty();
                    //console.log(data.due_date);

                    // print success message
                    $("#due_date_result").append(
                        "<p>Your next due date is: " + data.due_date + "<br>" +
                        "Timestamp: " + data.due_date_timestamp + "</p>"
                    );

                    $('#calendar').fullCalendar('gotoDate', data.due_date);


                } else {
                    // print error message
                    //console.log('could not calculate due date');
                    $("#due_date_result").append("<p>Could not calculate due date</p>");
                }
            }, 'json');



    });



});