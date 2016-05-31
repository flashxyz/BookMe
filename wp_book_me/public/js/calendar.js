$(document).ready(function () {


    //notice!
    //this fake array has been changed to -> roomsArray
    // var availableRooms = [["A100", "1", "RoomSelect"], ["A101", "2", "RoomSelect"],
    //     ["A102", "3", "RoomSelect"], ["B100", "1", "RoomSelect"],
    //     ["B101", "2", "RoomSelect"], ["B102", "3", "RoomSelect"],
    //     ["C100", "2", "RoomSelect"], ["C101", "1", "RoomSelect"],
    //     ["C102", "3", ""]];
    
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
    $('#changeOrderTime').hide();
    $('#myModal').modal('hide');


    $('#datePicker').change(makeChange);
    $('#stepExample1').change(makeChange);
    $('#stepExample2').change(makeChange);
    $('#roomSelect').change(setPicture);

    $(':checkbox').checkboxpicker();

    var duartionInMin = windowTimeLength;
    var minimumTime = fromTime;
    var maximumTime = toTime;

    var servicesArry = ["מיקרוגל", "מיקרופון", "הסרטת וידאו", "מחשב", "רמקולים", "666666", "77777", "88888",
        "99999", "10000", "מקרן", "300"];
    displayCheckboxes("checkboxes");
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
            $('#changeOrderTime').hide();
            $('#myModal').modal('show');
            $(document).on("click", "#changeOrderTimeButton", function(event){
                openEditRoom();
                displayCheckboxes("checkboxes1");
            });
            // $('#myCalendar').fullCalendar('removeEvents',event._id);
            $(document).on("click", "#deleteOrderButton", function(event){
                $('#calendar').fullCalendar('removeEvents', function (event) {
                    return event == calEvent;
                });
            });
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
        var roomName = $('#roomSelect').val();
        if( roomName == "בחר חדר:")
            return;
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

    /*
     convertTime this function get hour, min
     and return time.
     eg convertTime(6,7) = 06:07 .convertTime(12,10) = 12:10
     */
    function convertTime(houreStart, minStart) {
        var strTimeStart;
        if (houreStart < 10) {
            if (minStart < 10)
                strTimeStart = '0' + houreStart + ':' + minStart + '0';
            else
                strTimeStart = '0' + houreStart + ':' + minStart;
        }
        else {
            if (minStart < 10)
                strTimeStart = houreStart + ':' + minStart + '0';
            else
                strTimeStart = houreStart + ':' + minStart;
        }
        return strTimeStart;
    }

    //showing the availabil rooms before elections user and availability room
    function ShowAvailableRoom(startTime, endTime) {
        var j, i;
        var y = document.getElementById("roomSelect");

        for (i = 0; i < roomsArray.length + 1; i++) {
            y.remove(y.childNodes);
        }

        $('#roomSelect').append("<option>" + "בחר חדר:" + "</option>");
        if ($('#stepExample1').val() != "" && $('#stepExample2').val() != "" && $('#datePicker').val() != ""
            && $('#stepExample1').val() < $('#stepExample2').val() )
        {

            for (i = 0; i < roomsArray.length; i++) {
                $('#roomSelect').append("<option>" + roomsArray[i] + "</option>");
                //.attr("value",key).text(value))
            }
            $('#roomHide').show();
            $('#btnFindRoom').hide();
        }
        else {
            var x = document.getElementById("roomSelect");
            for (i = 0; i < roomsArray.length + 1; i++) {
                x.remove(x.childNodes);
            }
            $('#roomHide').hide();
            $('#btnFindRoom').show();
        }
    }


    function setPicture() {
        $('#roomPictureSelect').html( "חדר נבחר: <br>"  + $('#roomSelect').val() +"<br>  <div id='img'></div>" );
        var name = $('#roomSelect').val();
        var i;
        for (i = 0; i < availableRooms.length; i++)
            if (name == availableRooms[i])
                break;
        var imgstring = "./img/" + availableRooms[i][2] + ".jpg";
        var style = "width:304px;height:228px;";

        $('#img').replaceWith("<img id = 'img' src=" + imgstring + " style=" + style + ">");


    }

    //change the services to checkboxes and display them in services div
    function displayCheckboxes(whichId) {


        var checkboxes = "<table class='table table-sm'  align='right' ><thead> <tr> <th data-halign='right'>שירות</th> <th>סמן</th></tr>"


        if(servicesArry.length == 0)
            return;

        for (var i = 0; i < servicesArry.length; i++) {
            checkboxes += "<tr> <td data-halign='right' class ='tdCheckboxe'>" + servicesArry[i].toString() +"</td> <td><input type='checkbox' data-group-cls='btn-group-sm'></td><td></tr>" ;
        }
        checkboxes+= "</table>";
        if(whichId == "checkboxes") {
            $('#checkboxes').append(checkboxes);
            $(':checkbox').checkboxpicker();
        }
        if(whichId == "checkboxes1") {
            $('#checkboxes1').append(checkboxes);
            $(':checkbox').checkboxpicker();
        }
    }


    //Returns the days should not present in the calendar
    // e.g [1,2,3,4,5] is the arry of the hide days in week calendar
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

    function openEditRoom() {
        $('#changeOrderTime').show();
    }


    //change timeStart timEnd fo user changes in labels
    // e.g timeEnd = ( "Mon May 30 2016 16:00:00 GMT+03:00(שעון קיץ ירושלים)" )
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

        for (i = 0; (dateTime[i] != '/'); i++) {
            if (i > dateTime.length)
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
        for (; i != dateTime.length; i++)
            year += dateTime[i];

        if (day == "" || month == "")
            return;

        for (i = 0; startTime[i] != ':'; i++) {
            if (i > startTime.length)
                return;
            hourStart += startTime[i];
        }
        i++;
        for (; i < startTime.length; i++)
            minStart += startTime[i];

        for (i = 0; endTime[i] != ':'; i++) {
            if (i > endTime.length)
                return;
            hourEnd += endTime[i];
        }
        i++;
        for (; i < endTime.length; i++)
            minEnd += endTime[i];

        if (minEnd == "" || hourEnd == "" || minStart == "" || hourStart == "")
            return;

        timeStart = new Date(year, month - 1, day, hourStart, minStart);
        timeEnd = new Date(year, month - 1, day, hourEnd, minEnd);
    }
});