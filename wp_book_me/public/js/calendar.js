$(document).ready(function () {
    //this is a test array, for rooms offering functionality.
    var selectedRoomId = 0;

    //represent the start & end time of a specific room order request
    var eventStartTime;
    var eventEndTime;

    const ISRAEL_TIME_DIFF = 3;


    //this array represent the days that will be excluded from calendar given days
    var excludedDays = [];
    //parsing of the inactive days, to get the excluded days
    getExcludedDays();

    $('#btnReserveRoom').click(reserveRoom);
    $('#btnFindRoom').click(ShowAvailableRooms);
    
    //hide the room selection div 
    $('#roomHide').hide();
    $('#reservationDetailsDialog').modal('hide');

    $('#datePicker').change(labelsChangeEvent);
    $('#inputStartTime').change(labelsChangeEvent);
    $('#inputEndTime').change(labelsChangeEvent);
    
    //when a different room is chosen, the picture need to be updated using setRoomsPicture.
    $('#roomSelect').change(setRoomsPicture);


    var slotDurationInMinutes = windowTimeLength;
    var calendarBeginTime = fromTime;
    var calendarEndTime = toTime;
    var servicesArray = services;
    
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

            //the date objects of the user selection.
            var dateStart = new Date(start);
            var dateEnd = new Date(end);

            var startHour = dateStart.getHours() - ISRAEL_TIME_DIFF;
            var dayStart = dateStart.getDate();
            //the months begin from zero index so we add 1
            var monthStart = dateStart.getMonth() + 1;
            var minStart = dateStart.getMinutes();
            var yearStart = dateStart.getFullYear();

            var endHour = dateEnd.getHours() - ISRAEL_TIME_DIFF;
            var dayEnd = dateEnd.getDate();
            var monthEnd = dateEnd.getMonth() + 1;
            var minEnd = dateEnd.getMinutes();
            var yearEnd = dateEnd.getFullYear();

            eventEndTime = new Date(yearEnd, monthEnd - 1, dayEnd, endHour, minEnd);
            eventStartTime = new Date(yearStart, monthStart - 1, dayStart, startHour, minStart);

            var strTimeStart = displayProperTimeLabel(eventStartTime.getHours(), eventStartTime.getMinutes());
            var strTimeEnd = displayProperTimeLabel(eventEndTime.getHours(), eventEndTime.getMinutes());
            var strStartTime = dayStart + "/" + monthStart + "/" + yearStart;

            $('#datePicker').val(strStartTime);
            $('#inputStartTime').val(strTimeStart);
            $('#inputEndTime').val(strTimeEnd);

        },
        slotDuration: '00:' + slotDurationInMinutes + ':00',
        lang: 'he',
        isRTL: true,
        minTime: calendarBeginTime + ":00",
        maxTime: calendarEndTime + ":00",
        hiddenDays: excludedDays,
        allDaySlot: false,
        contentHeight: 'auto',
        axisFormat: "HH:mm",
        defaultView: "agendaWeek",
        weekends: true,
        selectable: true,
        selectHelper: true,
        weekNumbers: true,  
        fixedWeekCount: false,
        allDayDefault: true,

        //this function is called when an event is being clicked.
        eventClick: function (calEvent, jsEvent, view) {
            $('#reservationDetailsDialog').modal('show');

            var date = new Date(calEvent.start);
            var startHourClick = date.getHours();
            var startMinClick = date.getMinutes();
            date = new Date(calEvent.end);
            var endHourClick = date.getHours();
            var endMinClick = date.getMinutes();
            displayOrderRoomInDialog(startHourClick, startMinClick, endHourClick, endMinClick, calEvent.title);

            // $('#myCalendar').fullCalendar('removeEvents',event._id);
            $(document).on("click", "#deleteOrderButton", function (event) {
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

    //fill user reservations
    addUserReservations();


    /*reserveRoom function
     create the event only if the time requested is not already passed.
     a room can't be reserved in the past !
     */
    function reserveRoom() {
        var roomName = $('#roomSelect').val();

        if (roomName == "בחר חדר:")
            return;
        var currentTime = new Date();
        if (eventStartTime.getYear() == currentTime.getYear()) {
            if (eventStartTime.getMonth() == currentTime.getMonth()) {
                if (eventStartTime.getDate() < currentTime.getDate())
                    return;
                else if (eventStartTime.getDate() == currentTime.getDate())
                    if (eventStartTime.getHours() <= currentTime.getHours())
                        return;
            }
            else if (eventStartTime.getMonth() < currentTime.getMonth())
                return;

        }
        else if( eventStartTime.getYear() < currentTime.getYear() )
            return;


        var roomName = $('#roomSelect').val();
        var dataString = 'groupId1' + groupID + 'roomId1' + selectedRoomId + 'userId1' + userID + 'startTime1' + eventStartTime + 'endTime' + eventEndTime ;

        sendDataToPhp();

        calendar.fullCalendar('renderEvent',
            {
                title: "רשום לחדר " + roomName.toString(),
                start: eventStartTime,
                end: eventEndTime,
                color: '#3300FF',
                textColor: 'white',
                allDay: false

            },
            true // make the event "stick"
        );
    }

    function addUserReservations() {

        //reservationsArray ->array of reservations for this looged user.
        // $resCell[0] = $selectSQL_reservation[$index]->roomId;
        // $resCell[1] = $selectSQL_reservation[$index]->startTime;
        // $resCell[2] = $selectSQL_reservation[$index]->endTime;

        var resIndex = 0;

        while(resIndex < reservationsArray.length)
        {
            calendar.fullCalendar('renderEvent',
                {
                    title: "רשום לחדר " + reservationsArray[resIndex][0].toString(),
                    start: reservationsArray[resIndex][1].toString(),
                    end: reservationsArray[resIndex][2].toString(),
                    color: '#3300FF',
                    textColor: 'white',
                    allDay: false

                },
                true // make the event "stick"
            );
            //alert(reservationsArray[resIndex]);
            resIndex++;
        }



    }


    ///duration of time start/end
    $(function () {
        $('#inputStartTime').timepicker({
            'minTime': calendarBeginTime,
            'maxTime': calendarEndTime,
            'timeFormat': 'H:i',
            'step': slotDurationInMinutes

        });
        $('#inputEndTime').timepicker({
            'minTime': calendarBeginTime,
            'maxTime': calendarEndTime,
            'timeFormat': 'H:i',
            'step': slotDurationInMinutes
        });
    });


    ///for a date picker
    $('#datePicker').datepicker({
        'format': 'd/m/yyyy',
        'autoclose': true
    });

    $('#datePicker').datepicker();

    /*
     displayProperTimeLabel this function get hour, min
     and return time.
     eg displayProperTimeLabel(6,7) = 06:07 .displayProperTimeLabel(12,10) = 12:10
     */
    function displayProperTimeLabel(startHour, startMin) {
        var strTimeStart;
        if (startHour < 10) {
            if (startMin < 10)
                strTimeStart = '0' + startHour + ':' + startMin + '0';
            else
                strTimeStart = '0' + startHour + ':' + startMin;
        }
        else {
            if (startMin < 10)
                strTimeStart = startHour + ':' + startMin + '0';
            else
                strTimeStart = startHour + ':' + startMin;
        }
        return strTimeStart;
    }

    //display the available rooms to the user
    function ShowAvailableRooms(startTime, endTime) {
        var j, i;
        var y = document.getElementById("roomSelect");

        for (i = 0; i < roomsArray.length + 1; i++) {
            y.remove(y.childNodes);
        }

        $('#roomSelect').append("<option>" + "בחר חדר:" + "</option>");
        if ($('#inputStartTime').val() != "" && $('#inputEndTime').val() != "" && $('#datePicker').val() != ""
            && $('#inputStartTime').val() < $('#inputEndTime').val()) {

            for (i = 0; i < roomsArray.length; i++) {
                $('#roomSelect').append("<option>" + roomsArray[i][1] + "</option>");
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


    function setRoomsPicture() {

        $('#roomPictureSelect').html("חדר נבחר: <br>" + $('#roomSelect').val() + "<br>  <div id='img'></div>");
        var name = $('#roomSelect').val();
        var i;
        for (i = 0; i < roomsArray.length; i++)
            if (name == roomsArray[i][1]) {
                selectedRoomId = roomsArray[i][0];
                break;
            }

        var noImage = "http://bookme.myweb.jce.ac.il/wp-content/uploads/2016/06/noPic.jpg";
       // var imgstring = "./img/" + availableRoomsTestArray[i][2] + ".jpg";
        var style = "width:240px;height:240px;";

        $('#img').replaceWith("<img id = 'img' src=" + noImage + " style=" + style + ">");

    }

    //change the services to checkboxes and display them in services div
    function displayCheckboxes(whichId) {


        var checkboxes = "<table class='table table-sm text-right table-cool'  align='right' >";


        if (servicesArray.length == 0)
            return;

        for (var i = 0; i < servicesArray.length; i++) {
            checkboxes += "<tr> <td data-halign='right' class ='tdCheckboxe'>" + servicesArray[i].toString() + "</td> <td data-halign='left'><input type='checkbox' data-group-cls='btn-group-sm'></td><td></tr>";
        }
        checkboxes+= "</table>";

        if (whichId == "checkboxes") {
            $('#checkboxes').append(checkboxes);
            $(':checkbox').checkboxpicker({onLabel:"כן",offLabel:"לא"});        }
        if (whichId == "checkboxes1") {
            $('#checkboxes1').append(checkboxes);
            $(':checkbox').checkboxpicker({onLabel:"כן",offLabel:"לא"});        }
    }


    //Returns the days should not present in the calendar
    // e.g [1,2,3,4,5] is the arry of the hide days in week calendar
    function getExcludedDays() {
        var i, j = 0;
        for (i = 0; i < activeDays.length; i++) {
            if (activeDays[i] == '') {
                excludedDays[j] = i;
                j++;
            }
        }
    }



    //display services in description
    function displayServicesDescription() {
        var services = "<ul>";
        for (var i = 0; i < servicesArray.length; i++)
            services += "<li>" + servicesArray[i] + "</li>"
        services += "</ul>"
        $('#services').append(services);
    }


    //change eventStartTime timEnd fo user changes in labels
    // e.g eventEndTime = ( "Mon May 30 2016 16:00:00 GMT+03:00(שעון קיץ ירושלים)" )
    function labelsChangeEvent() {
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
        var startTime = $("#inputStartTime").val();
        var endTime = $("#inputEndTime").val();
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

        eventStartTime = new Date(year, month - 1, day, hourStart, minStart);
        eventEndTime = new Date(year, month - 1, day, hourEnd, minEnd);
    }


    function timeStringToFloat(time) {
        var hoursMinutes = time.split(/[.:]/);
        var hours = parseInt(hoursMinutes[0], 10);
        var minutes = hoursMinutes[1] ? parseInt(hoursMinutes[1], 10) : 0;
        return hours + minutes / 60;
    }

    function displayOrderRoomInDialog(startHour, startMin, endHour, endMin, nameRoom){
        var startDisplay = displayProperTimeLabel(startHour,startMin);
        var endDisplay = displayProperTimeLabel(endHour,endMin);
        var description = "<div id = 'diplayOrderRoom'' class='modal-body'>";
        description += "החדר מוזמן לשעה: "
        description += startDisplay;
        description += " עד שעה: ";
        description += endDisplay;
        description += ", הינך ";
        description += nameRoom;
        $("#diplayOrderRoom").replaceWith(description);

        var noImage = "http://bookme.myweb.jce.ac.il/wp-content/uploads/2016/06/noPic.jpg";
        var style = "width:240px;height:240px;";
        $('#changeOrderTime').replaceWith("<img id = 'changeOrderTime' src=" + noImage + " style=" + style + ">");
    }

    function sendDataToPhp() {
        $.ajax({
                type: "POST",
                url:submitURL,
                data: {
                    group1: groupID,
                    room1: selectedRoomId,
                    userId: userID.toString(),
                    start1: eventStartTime.toString(),
                    end1: eventEndTime.toString(),
                    addRes: true,
                },//dataString
                cache: false,
                success:function(data) {
                    //alert(data);
                }
            });
    }
    //this function will check the room available for this query
    function checkRoomInSQL() {
        $.ajax({
            type: "POST",
            url:submitURL,
            data: {
                group1: groupID,
                room1: selectedRoomId,
                userId: userID.toString(),
                start1: eventStartTime.toString(),
                end1: eventEndTime.toString(),
                checkRes: true,
            },//dataString
            cache: false,
            success:function(data) {
                //if null -> no room

                //else -> show the rooms that we got from submit.

            }
        });
    }


});

