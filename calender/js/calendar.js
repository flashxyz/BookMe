$(document).ready(function () {
    var availableRooms = [["A100","1"], ["A101","2"], ["A102", "3"], ["B100", "1"],["B101" ,"2"], ["B102","3"],[ "C100","2"],["C101","1"], ["C102","3"]];
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var timeStart;
    var timeEnd;
    var dateClick;
    $('#btnAddRoom').click(addEvent);

    var duartionInMin = 90;
    var minimumTime = 6;
    var maximumTime = 22;
    var services = ["1", "2", "3"];
    displayCheckboxes();

    var calendar;
    calendar = $('#calendar').fullCalendar({
        header: {
            left: 'next,prev today',
            center: 'title',
            right: 'month, agendaWeek, year'
        },

        select: function (start, end, jsEvent, view) {
            var dateStart = new Date(start);
            var dateEnd = new Date(end);

            var houreStart = dateStart.getHours() - 3;
            var dayStart = dateStart.getDate();
            var monthStart = dateStart.getMonth() + 1;
            var minStart = dateStart.getMinutes();
            var yearStart = dateStart.getFullYear();

            var houreEnd = dateEnd.getHours() - 3;
            var dayEnd = dateEnd.getDate();
            var monthEnd = dateEnd.getMonth() + 1;
            var minEnd = dateEnd.getMinutes();
            var yearEnd = dateEnd.getFullYear();

            timeEnd = new Date(yearEnd, monthEnd - 1, dayEnd, houreEnd, minEnd);
            timeStart = new Date(yearStart, monthStart - 1, dayStart, houreStart, minStart);


            alert(timeStart.getHours() + "  " + timeEnd.getHours());
            var strTimeStart = convertTime(timeStart.getHours(), timeStart.getMinutes());
            var strTimeEnd = convertTime(timeEnd.getHours(), timeEnd.getMinutes());
            var strStartTime = dayStart + "/" + monthStart + "/" + yearStart;

            $('#datePicker').val(strStartTime);
            $('#stepExample1').val(strTimeStart);
            $('#stepExample2').val(strTimeEnd);
            $('#sel1').change(ShowAvailableRoom());
        },
        slotDuration: '00:' + duartionInMin + ':00',
        lang: 'he',
        isRTL: true,
        minTime: "0" + minimumTime + ":00:00",
        maxTime: maximumTime + ":00:00",
        hiddenDays: [6],
        // firstHour: 8,
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


    function addEvent() {
        var nowTime = new Date();
        if (timeStart.getYear() <= nowTime.getYear())
            if (timeStart.getMonth() <= nowTime.getMonth()) {
                if (timeStart.getDate() < nowTime.getDate())
                    return;
                else if (timeStart.getDate() == nowTime.getDate())
                    if (timeStart.getHours()  <= nowTime.getHours() )
                        return;
            }
        calendar.fullCalendar('renderEvent',
            {
                title: "רשום לחדר " + $('#roomSelect').val(),
                start: timeStart,
                end: timeEnd,
                color: '#3300FF',
                textColor: 'white',
                allDay: false

            },
            true // make the event "stick"
        );

    }


    ///duration of time start/end
    $(function () {
        $('#stepExample1').timepicker({
            'minTime': "0" + minimumTime + ":00",
            'maxTime': maximumTime + ":00",
            'timeFormat': 'H:i',
            'step': function (i) {
                return (i % 2) ? duartionInMin : duartionInMin;
            }

        });
        $('#stepExample2').timepicker({
            'minTime': "0" + minimumTime + ":00",
            'maxTime': maximumTime + ":00",
            'timeFormat': 'H:i',
            'step': function (i) {
                return (i % 2) ? duartionInMin : duartionInMin;
            }
        });
    });


    ///for a date picker
    $('#datepairExample .date').datepicker({
        'format': 'd/m/yyyy',
        'autoclose': true
    });

    $('#datepairExample').datepair();

    function convertTime(houreStart, minStart) {
        var strTimeStart;
        if (houreStart < 10)
            if (minStart < 10)
                strTimeStart = '0' + houreStart + ':' + minStart + '0';
            else
                strTimeStart = '0' + houreStart + ':' + minStart;
        else if (minStart < 10)
            strTimeStart = houreStart + ':' + minStart + '0';
        else
            strTimeStart = houreStart + ':' + minStart;

        return strTimeStart;
    }

    function ShowAvailableRoom(startTime, endTime) {
        var i, j;
        if ($('#stepExample1').val() != "" && $('#stepExample2').val() != "" && $('#datePicker').val() != "") {
            for (i = 0; i < availableRooms.length; i++) {
                $('#roomSelect').append("<option>" + availableRooms[i] + "</option>");
                //.attr("value",key).text(value))
            }
        }
        else {
            var x = document.getElementById("roomSelect");
            for (i = 0; i < availableRooms.length; i++) {
                x.remove(x.childNodes);
            }
        }
    }

    function displayCheckboxes() {
        var checkboxes = "<div class='col-sm-12 '>";

        for (var i = 0; i < services.length; i++) {
            checkboxes += "<div class='checkbox-inline checkbox'><label><input type='checkbox' value=''> " +
                "<span class='cr'><i class='cr-icon glyphicon glyphicon-ok'></i></span>" +
                services[i] + " </label></div>";
        }
        checkboxes += "</div>"
        $('#checkboxes').append(checkboxes);
    }

});