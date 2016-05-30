$(document).ready(function () {
    var availableRooms = [["A100", "1", "adamRoomSelector"], ["A101", "2", "adamRoomSelector"],
        ["A102", "3", "adamRoomSelector"], ["B100", "1", "adamRoomSelector"],
        ["B101", "2", "adamRoomSelector"], ["B102", "3", "adamRoomSelector"],
        ["C100", "2", "adamRoomSelector"], ["C101", "1", "adamRoomSelector"],
        ["C102", "3", ""]];
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var timeStart;
    var timeEnd;

    var hideDays = [];
    getHideDays();
    var dateClick;

    $('#btnAddRoom').click(addEvent);
    $('#btnFindRoom').click(ShowAvailableRoom);
    $('#roomHide').hide();

    $('#datePicker').change(makeChange);
    $('#stepExample1').change(makeChange);
    $('#stepExample2').change(makeChange);
    $('#roomSelect').change(setPicture);

    var duartionInMin = windowTimeLength;
    var minimumTime = fromTime;
    var maximumTime = toTime;

    var servicesArry = ["11111", "222222", "3333333", "444444", "555", "666666", "77777", "88888",
        "99999", "10000", "200000", "300"];
    displayCheckboxes();
    displayServicesDescription();
    var calendar;
    calendar = $('#calendar').fullCalendar({
        header: {
            left: 'next,prev today',
            center: 'title',
            right: ''
        },

        select: function (start, end, jsEvent, view) {
            $('#roomHide').hide();
            $('#btnFindRoom').show();
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

            var strTimeStart = convertTime(timeStart.getHours(), timeStart.getMinutes());
            var strTimeEnd = convertTime(timeEnd.getHours(), timeEnd.getMinutes());
            var strStartTime = dayStart + "/" + monthStart + "/" + yearStart;

            $('#datePicker').val(strStartTime);
            $('#stepExample1').val(strTimeStart);
            $('#stepExample2').val(strTimeEnd);

        },
        slotDuration: '00:' + duartionInMin + ':00',
        lang: 'he',
        isRTL: true,
        minTime: minimumTime + ":00",
        maxTime: maximumTime + ":00",
        hiddenDays: hideDays,
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


    /*addEvent function
     create event if the time of event is bigger the Current Time
     client can create event only in the future
     */
    function addEvent() {
        var nowTime = new Date();
        if (timeStart.getYear() <= nowTime.getYear())
            if (timeStart.getMonth() <= nowTime.getMonth()) {
                if (timeStart.getDate() < nowTime.getDate())
                    return;
                else if (timeStart.getDate() == nowTime.getDate())
                    if (timeStart.getHours() <= nowTime.getHours())
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
            'minTime': minimumTime,
            'maxTime': maximumTime,
            'timeFormat': 'H:i',
            'step': duartionInMin,

        });
        $('#stepExample2').timepicker({
            'minTime': minimumTime,
            'maxTime': maximumTime,
            'timeFormat': 'H:i',
            'step': duartionInMin,
        });
    });


    ///for a date picker
    $('#datePicker').datepicker({
        'format': 'd/m/yyyy',
        'autoclose': true
    });

    $('#datePicker').datepicker();
    ;

    /*
     convertTime this function get hour, min
     and return time.
     eg convertTime(6,7) = 06:07 .convertTime(12,10) = 12:10
     */
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
        var j, i;
        var y = document.getElementById("roomSelect");
        $('#roomSelect').append("<option>" + "בחר חדר:" + "</option>");
        for (i = 0; i < availableRooms.length + 1; i++) {
            y.remove(y.childNodes);
        }
        if ($('#stepExample1').val() != "" && $('#stepExample2').val() != "" && $('#datePicker').val() != ""
            && $('#stepExample1').val() < $('#stepExample2').val()) {
            for (i = 0; i < availableRooms.length; i++) {
                $('#roomSelect').append("<option>" + availableRooms[i] + "</option>");
                //.attr("value",key).text(value))
            }
            $('#roomHide').show();
            $('#btnFindRoom').hide();

        }
        else {
            var x = document.getElementById("roomSelect");
            for (i = 0; i < availableRooms.length + 1; i++) {
                x.remove(x.childNodes);
            }
            $('#roomHide').hide();
            $('#btnFindRoom').show();
        }
    }

    function setPicture() {
        var name = $('#roomSelect').val();
        var i;
        for (i = 0; i < availableRooms.length; i++)
            if (name == availableRooms[i])
                break;
        var imgstring = "./img/" + availableRooms[i][2] + ".jpg";
        var style = "width:304px;height:228px;";

        $('#img').replaceWith("<img id = 'img' src=" + imgstring + " style=" + style + ">");

    }

    function displayCheckboxes() {
        var checkboxes = "<tr class='col-sm-12'>";

        for (var i = 0; i < servicesArry.length; i++) {
            if (i % 3 == 0 && i > 0)
                checkboxes += "</tr><tr class='col-sm-12'>"
            checkboxes += "<td class='checkbox-inline checkbox'> <label><input type='checkbox' value = '0' >" +
                " <span class='cr'><i class='cr-icon glyphicon glyphicon-ok'></i></span>" +
                servicesArry[i] +
                " </label></td>";

        }
        checkboxes += "</tr>"
        $('#checkboxes').append(checkboxes);
    }


    //Returns the days should not present in the calendar
    function getHideDays() {
        var i, j = 0;
        for (i = 0; i < activeDays.length; i++) {
            if (activeDays[i] == '') {
                hideDays[j] = i;
                j++;
            }
        }
    }

    //display services in description
    function displayServicesDescription() {
        var services = "<ul>";
        for (var i = 0; i < servicesArry.length; i++)
            services += "<li>" + servicesArry[i] + "</li>"
        services += "</ul>"
        $('#services').append(services);
    }

    function makeChange() {
        $('#roomHide').hide();
        $('#btnFindRoom').show();

        var i;
        var day = "";
        var month = "";
        var year = "";
        var hourStart = "";
        var minStart = "";
        var hourEnd = "";
        var minEnd = "";
        var startTime = $("#stepExample1").val();
        var endTime = $("#stepExample2").val();
        var dateTime = $("#datePicker").val();

        for (i = 0; (dateTime[i] != '/') ; i++) {
            if( i > dateTime.length )
                return;
            day += dateTime[i];
        }
        i++;
        for (; dateTime[i] != '/'; i++) {
            if (i > dateTime.length)
                return;
            month += dateTime[i];
        }
        i++;
        for (; i != dateTime.length ; i++)
            year += dateTime[i];

        if (day == "" || month == "")
            return;

        for (i = 0; startTime[i] != ':'; i++) {
            if( i > startTime.length )
                return;
            hourStart += startTime[i];
        }
        i++;
        for (; i < startTime.length ; i++)
            minStart += startTime[i];

        for (i = 0; endTime[i] != ':'; i++) {
            if( i > endTime.length )
                return;
            hourEnd += endTime[i];
        }
        i++;
        for (; i < endTime.length ; i++)
            minEnd += endTime[i];

        if (minEnd == "" || hourEnd == "" || minStart == "" || hourStart == "")
            return;

        timeStart = new Date(year, month - 1, day, hourStart, minStart);
        timeEnd = new Date(year, month - 1, day, hourEnd, minEnd);
    }
});