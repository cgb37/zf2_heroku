/**
 * Created by charlesbrown-roberts on 10/19/15.
 */
$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
        // put your options and callbacks here
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultView: 'month',
        editable: true,
        events: [
            {"title":"weekend","start":"2015-01-25"},{"title":"weekend","start":"2015-02-08"},{"title":"weekend","start":"2015-02-22"},{"title":"weekend","start":"2015-03-08"},{"title":"weekend","start":"2015-03-22"},{"title":"weekend","start":"2015-04-05"},{"title":"weekend","start":"2015-04-19"},{"title":"weekend","start":"2015-05-03"},{"title":"weekend","start":"2015-05-17"},{"title":"weekend","start":"2015-05-31"},{"title":"weekend","start":"2015-06-14"},{"title":"weekend","start":"2015-06-28"},{"title":"weekend","start":"2015-07-12"},{"title":"weekend","start":"2015-07-26"},{"title":"weekend","start":"2015-08-09"},{"title":"weekend","start":"2015-08-23"},{"title":"weekend","start":"2015-09-06"},{"title":"weekend","start":"2015-09-20"},{"title":"weekend","start":"2015-10-04"},{"title":"weekend","start":"2015-10-18"},{"title":"weekend","start":"2015-11-01"},{"title":"weekend","start":"2015-11-15"},{"title":"weekend","start":"2015-11-29"},{"title":"weekend","start":"2015-12-13"},{"title":"weekend","start":"2015-12-27"}
        ]
    });

    $('#calendar').fullCalendar('gotoDate', currentDate);


});