



$(document).ready(function () {
    var availableRooms = ["A100","A101","A102","B100","B101","B102","C100","C101","C102"];
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var timeStart;
    var timeEnd;
    var dateClick;
    $('#btnAddRoom').click(addEvent);


    var calendar;
    calendar = $('#calendar').fullCalendar({
        header: {
            left: 'next,prev today',
            center: 'title',
            right: 'month, agendaWeek, year'
        },

        select: function( start, end, jsEvent, view) {
            var dateStart = new Date(start);
            var dateEnd = new Date(end);

            var houreStart = dateStart.getHours() - 3;
            var dayStart = dateStart.getDate();
            var monthStart = dateStart.getMonth() + 1;
            var minStart = dateStart.getMinutes();
            var yearStart = dateStart.getFullYear();

            timeStart = new Date(yearStart, monthStart-1, dayStart, houreStart ,minStart);


            var houreEnd = dateEnd.getHours() - 3;
            var dayEnd = dateEnd.getDate();
            var monthEnd = dateEnd.getMonth() + 1;
            var minEnd = dateEnd.getMinutes();
            var yearEnd = dateEnd.getFullYear();

            timeEnd = new Date(yearEnd, monthEnd - 1, dayEnd, houreEnd ,minEnd);

            var strStartTime = dayStart+"/"+monthStart + "/" +yearStart;

            $('#datePicker').val(strStartTime);

            var strTimeStart = convertTime(houreStart,minStart);
            var strTimeEnd = convertTime(houreEnd,minEnd);

            $('#stepExample1').val(strTimeStart);
            $('#stepExample2').val(strTimeEnd);
            $('#sel1').change(ShowAvailableRoom());


            // alert(houreStart);
            // alert(minStart)
            // alert(houreEnd);
            // alert(minEnd);


        },
        slotDuration: '01:00:00',
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
                textColor: 'black'
            }
        ]
    });


    function addEvent() {
        var nowTime = new Date();
        if( timeStart.getYear() <= nowTime.getYear())
            if(timeStart.getMonth() <= nowTime.getMonth())
                if( timeStart.getDate() <= nowTime.getDate() && timeStart.getHours() < nowTime.getHours())
                    return;

        calendar.fullCalendar('renderEvent',
            {
                title: "רשום לחדר A107",
                start: timeStart,
                end: timeEnd,
                color: '#3300FF',
                textColor: 'white'
            },
            {
                events: [],
                color: '#6699FF',
                        allDay: false
                    },
                    true // make the event "stick"
                );
    }
    // function addEvent() {
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


    ///duration of time start/end
    $(function() {
        $('#stepExample1').timepicker({
            'timeFormat': 'H:i',
            'step': 15 });
        $('#stepExample2').timepicker({
            'timeFormat': 'H:i',
            'step': function(i) {
                return (i%2) ? 15 : 45;
            }
        });
    });



     ///for a date picker


     $('#datepairExample .date').datepicker({
         'format': 'd/m/yyyy',
         'autoclose': true
     });

     $('#datepairExample').datepair();

    function convertTime(houreStart, minStart){
        var strTimeStart;
        if(houreStart<10)
            if(minStart < 10)
                strTimeStart = '0'+houreStart+':'+minStart+'0';
            else
                strTimeStart = '0'+houreStart+':'+minStart;
        else
        if(minStart < 10)
            strTimeStart = houreStart+':'+minStart+'0';
        else
            strTimeStart = houreStart+':'+minStart;

        return strTimeStart;
    }
    function ShowAvailableRoom(startTime, endTime) {
        var i, j;
        if ($('#stepExample1').val() == "06:00" && $('#stepExample2').val() == "08:00" && $('#datePicker').val() != "") {
            for (i = 0; i < availableRooms.length; i++) {
                $('#sel1').append("<option>" + availableRooms[i] + "</option>");
                //.attr("value",key).text(value))
            }
        }
        else {
            var x = document.getElementById("sel1");
            for (i = 0; i < availableRooms.length; i++) {
                x.remove(x.childNodes);
            }
        }
    }

});