var AddEvent = false;
var activeEventsSelected = [];


$(document).ready(function () {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var dateClick;
    $('#myModal').modal('hide');
    $('#btnRemove').click(open_Dialog_With_uesr);

    var calendar;
    calendar = $('#calendar').fullCalendar({
        header: {
            left: 'next,prev today',
            center: 'title',
            right: 'month, agendaWeek, year'
        },

        select: function( start, end, jsEvent, view) {
             $('#myModal').modal('show');
            alert(start);
            alert(end);
            // dateClick = new Date(date);
            // var houre = dateClick.getHours() - 3;
            // var day = dateClick.getDate();
            // var month = dateClick.getMonth();
            // var min = dateClick.getMinutes();
            // var year = dateClick.getFullYear();
            // dateClick = new Date(year, month, day, houre, min);

            //alert("date is " + dateClick);

        },
        slotDuration: '00:30:00',
        lang: 'he',
        isRTL: true,
        minTime: "06:00:00",
        maxTime: "22:00:00",
        hiddenDays: [6],
        firstHour: 8,
        allDaySlot: false,
        height: 600,
        axisFormat: "HH:mm",
        defaultView: "agendaWeek",
        weekends: true,
        selectable: true,
        selectHelper: true,
        weekNumbers: true,
        allDayDefault: true,

        eventClick: function (calEvent, jsEvent, view) {
            alert("event clicked! ");
        },

        editable: false,
        eventSources: [
            // your event source
            {
                events: [ // put the array in the `events` property
                    {
                        title: 'test',
                        start: new Date(y, m, d, 8, 0),
                        end: new Date(y, m, d, 9, 0),
                        allDay: false
                    }
                ],
                color: '#3300FF',
                textColor: 'white'
            },
            {
                events: [],
                color: '#6699FF',
                textColor: 'black'
            }
        ]
    });


    // function open_Dialog_With_uesr() {
    //     $('#myModal').modal('hide');
		//
    //     var text = $("#endhour").val();
    //     var hours = text.split(":")[0];
    //     var minutes = text.split(":")[1];
    //
    //
    //     var day = dateClick.getDate();
    //     var month = dateClick.getMonth();
    //     var year = dateClick.getFullYear();
    //     text = $("#event_input").val();
    //     alert("the hours is "+ hours);
    //     alert("the minute is "+ minutes);
    //     alert("the event_input is "+ text);
    //
    //     AddEvent = true;
    //     // for (var i = 0; i < activeEventsSelected.length; i++) if (text == activeEventsSelected[i]) {
    //     //     $("#calendar").fullCalendar('removeEventSource', {
    //     //         title: activeEventsSelected[i]
    //     //     });
    //     //     activeEventsSelected[i] = "null";
    //     //     AddEvent = false;
    //     // }
    //     var endDate = new Date(year, month, day, hours, minutes);
    //     if (dateClick.getHours() >= endDate.getHours()) {
    //         alert("uston we have a problem");
    //         return;
    //     }
    //     if (AddEvent) {
    //         var add = activeEventsSelected.length; // add the event to array of active events
    //         activeEventsSelected.length++;
    //         activeEventsSelected[add] = text;
    //         calendar.fullCalendar('renderEvent',
    //             {
    //                 title: text,
    //                 start: dateClick,
    //                 end: endDate,
    //                 allDay: false
    //             },
    //             true // make the event "stick"
    //         );
    //         console.log(activeEventsSelected);
    //     }
    //
    //
    // }

});