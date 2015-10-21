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
        theme: true,
        defaultView: 'month',
        events: [
            {
                title  : 'Due Date',
                start  : due_date_result
            }
        ]
    });


    $('#first_due_date_submit').on('click', function(e) {

        e.preventDefault();

        clickMe(this);

        $('#calendar').fullCalendar('gotoDate', moment(due_date_result));

    })

    function getHtmlResponse(obj){
        jQuery.ajax({
            url : '/calculator',
            type: 'POST',
            data: {'fund_date_input': jQuery('#fund_date_input').val()},
            beforeSend : function() {
                /* Logic before ajax request sent */
            },
            success: function(data, status){

                if(status){
                    jQuery("#response").html(data);
                }else{
                    jQuery("#response").html('There was some error. Try again.');
                }
            },
            error : function(xhr, textStatus, errorThrown) {
                if (xhr.status === 0) {
                    alert('Not connect.\n Verify Network.');
                } else if (xhr.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (xhr.status == 500) {
                    alert('Server Error [500].');
                } else if (errorThrown === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (errorThrown === 'timeout') {
                    alert('Time out error.');
                } else if (errorThrown === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('There was some error. Try again.');
                }
            },
            complete: function(){
                // Perform any operation need on success/error
            }
        });
    }



    function clickMe(obj){
        jQuery.ajax({
            url : '/calculator',
            type: 'GET',
            dataType: 'JSON',
            data: {'pay_span_input': jQuery('#pay_span_input').val()},
            beforeSend : function() {
                /* Logic before ajax request sent */
                console.log($('#pay_span_input').val());
            },
            success: function(data, status){
                alert(data.message);
                if(data.status == 'error'){
                    // Perform any operation on error
                }else{
                    // Perform any operation on success
                }
            },
            error : function(xhr, textStatus, errorThrown) {
                if (xhr.status === 0) {
                    alert('Not connect.\n Verify Network.');
                } else if (xhr.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (xhr.status == 500) {
                    alert('Server Error [500].');
                } else if (errorThrown === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (errorThrown === 'timeout') {
                    alert('Time out error.');
                } else if (errorThrown === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('There was some error. Try again.');
                }
            },
            complete: function(){
                // Perform any operation need on success/error
            }
        });
    }





});