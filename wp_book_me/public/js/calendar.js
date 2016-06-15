$(document).ready(function () {
    //this is a test array, for rooms offering functionality.
    var selectedRoomId = 0;
    var roomsAfterFilter = [];
    var serviceAfterFilter = [];

    //represent the start & end time of a specific room order request
    var eventStartTime;
    var eventEndTime;

    const ISRAEL_TIME_DIFF = 3;

    var errorMenyQuantity = 0;
    var errorCurrentTime = 1;
    var errorMenyHourPerUser = 2;
    var errorAlreadyBooked = 3;
    var errorEmptyInputs = 4;
    var errorEarlyInputs = 5;
    var errorNoRoomsAvailable = 6;
    var errorMoreThenOneDay = 7;


    $("#inputStartTime").keypress(function (event) {
        event.preventDefault();
    });

    //this array represent the days that will be excluded from calendar given days
    var excludedDays = [];
    //parsing of the inactive days, to get the excluded days
    getExcludedDays();

    $('#btnReserveRoom').click(reserveRoom);
    $('#btnFindRoom').click(validationFindRoom);

    //hide the room selection div 
    $('#roomHide').hide();
    $('#errorInput').hide();

    $('#reservationDetailsDialog').modal('hide');

    $('#datePicker').change(labelsChangeEvent);
    $('#inputStartTime').change(labelsChangeEvent);
    $('#inputEndTime').change(labelsChangeEvent);
    $('#quantity').change(labelsChangeEvent);

    //when a different room is chosen, the picture need to be updated using setRoomsPicture.
    $('#roomSelect').change(setRoomsPicture);


    var slotDurationInMinutes = windowTimeLength;
    var calendarBeginTime = fromTime;
    var calendarEndTime = toTime;
    var servicesArray = services;
    var numOfReservationsPerUser = numOfReservations;
    var preventSlotTime = reservationLimitation * windowTimeLength;
    displayCheckboxes("checkboxes");
    displayServicesDescription();
    displayNumberOfEventsPerUser();

    var calendar;
    calendar = $('#calendar').fullCalendar({
        header: {
            left: 'next,prev today',
            center: 'title',
            right: ''
        },

        select: function (start, end, jsEvent, view) {
            $('#errorInput').hide();
            $('#roomHide').hide();
            $('#btnFindRoom').show();

            var strStartTime;

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

            var currentTime = new Date();

            if (endHour < 0)
                dayEnd--;

            if (startHour < 0 && endHour < 0)
                dayEnd++;

            if (dayStart != dayEnd && currentTime.getDate() > dayStart) {
                cleanInErrorInput(errorEarlyInputs);
                return;
            }
            if (currentTime.getDate() == dayStart && currentTime.getHours() >= startHour) {
                cleanInErrorInput(errorEarlyInputs);
                return;
            }
            if (currentTime.getDate() == null || currentTime.getHours() == null) {
                cleanInErrorInput(errorEmptyInputs);
                return;
            }
            //that fix the calendar problem 21:00 in calendar is -3 and 22:00 is -2 ...
            if (endHour < 0)
                endHour += 24;
            if (startHour < 0)
                startHour += 24;

            //addMin for add minute for calculate the user time piker
            var addMIn = minStart;

            //if minStart equals minEnd so no calc will be only in hour
            if (minStart == minEnd)
                addMIn = 0;

            //if minStart bigger minEnd like 08:30 09:15 so minus 1 in hour time  and calculate the rest minute
            else if (minStart > minEnd) {
                endHour--;
                addMIn = 60 - (minStart - minEnd);
            }

            //if minStart lower minEnd like 08:10 09:15 so calculate the rest minute
            else if (minStart < minEnd)
                addMIn = (minEnd - minStart);


            //check the selection is for the same day!
            if (dateStart.getDate() != dateEnd.getDate() ) {
                cleanInErrorInput(errorMoreThenOneDay);
                return;
            }

            //check the user minute and the preventSlotTime(limit of admin)
            if ( (((endHour - startHour) * 60 + addMIn) > preventSlotTime ) || (dateStart.getDate() != dateEnd.getDate()) ) {
                cleanInErrorInput(errorMenyHourPerUser);
                return;
            }
            if (minStart > minEnd) {
                endHour++;
            }
            //that fix the calendar problem in calendar 20:00 and above return the next day
            if (startHour > 20) {
                eventEndTime = new Date(yearEnd, monthEnd - 1, dayEnd - 1, endHour, minEnd);
                eventStartTime = new Date(yearStart, monthStart - 1, dayStart - 1, startHour, minStart);
                strStartTime = dayStart - 1 + "/" + monthStart + "/" + yearStart;
            }
            else {
                eventEndTime = new Date(yearEnd, monthEnd - 1, dayEnd, endHour, minEnd);
                eventStartTime = new Date(yearStart, monthStart - 1, dayStart, startHour, minStart);
                strStartTime = dayStart + "/" + monthStart + "/" + yearStart;
            }


            var strTimeStart = displayProperTimeLabel(eventStartTime.getHours(), eventStartTime.getMinutes());
            var strTimeEnd = displayProperTimeLabel(eventEndTime.getHours(), eventEndTime.getMinutes());


            $('#datePicker').val(strStartTime);
            $('#inputStartTime').val(strTimeStart);
            $('#inputEndTime').val(strTimeEnd);

        },
        slotDuration: '00:' + slotDurationInMinutes + ':00',
        lang: 'he',
        isRTL: genOptIsRTL,
        firstDay: genOptFirstDay,
        minTime: calendarBeginTime + ":00",
        maxTime: calendarEndTime + ":00",
        hiddenDays: excludedDays,
        allDaySlot: false,
        contentHeight: 'auto',
        height: 650,
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

            //$('#myCalendar').fullCalendar('removeEvents',event._id);
            $(document).on("click", "#deleteOrderButton", function (event) {

                swal({
                        title: "?האם אתה בטוח",
                        text: "לא יתאפשר לשחזר את הזמנת החדר!",
                        type: "warning",
                        cancelButtonText: "ביטול",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "!כן, מחק את החדר",
                        closeOnConfirm: false
                    },
                    function () {
                        //this function will actually delete a SQL entry via php calendar submit page
                        deleteEvent(calEvent._id);
                        $('#calendar').fullCalendar('removeEvents', function (event) {
                            return event == calEvent;
                        });
                        swal("!נמחק", "הזמנת החדר נמחקה", "success");
                        //if we remove event here we should also decrease the number of reservations global var.
                        numOfReservationsPerUser--;
                        displayNumberOfEventsPerUser();
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
        var booked = alreadyBooked();
        if (!booked) {
            cleanInErrorInput(errorAlreadyBooked);
            return;
        }
        var roomName = $('#roomSelect').val();

        if (roomName == "בחר חדר:")
            return;

        var roomName = $('#roomSelect').val();
        var dataString = 'groupId1' + groupID + 'roomId1' + selectedRoomId + 'userId1' + userID + 'startTime1' + eventStartTime + 'endTime' + eventEndTime;

        sendDataToPhp();
        swal({
            title: '!תודה',
            text: 'החדר הוזמן בהצלחה',
            type: 'success'
        });

        //if we render event here we should also increase the number of reservations global.
        numOfReservationsPerUser++;
        displayNumberOfEventsPerUser();
        calendar.fullCalendar('renderEvent',
            {
                id: 'tempId',
                title: "רשום לחדר " + roomName.toString(),
                start: eventStartTime,
                end: eventEndTime,
                color: '#3300FF',
                textColor: 'white',
                allDay: false

            },
            true // make the event "stick"
        );

        $('#datePicker').val("");
        $('#inputStartTime').val("");
        $('#inputEndTime').val("");
        $('#roomHide').hide();
        $('#btnFindRoom').show();


    }

    function addUserReservations() {

        //reservationsArray ->array of reservations for this looged user.
        // $resCell[0] = $selectSQL_reservation[$index]->roomId;
        // $resCell[1] = $selectSQL_reservation[$index]->startTime;
        // $resCell[2] = $selectSQL_reservation[$index]->endTime;
        //$resCell[3] = $selectSQL_reservation[$index]->reservationId;


        var resIndex = 0;
        var startOrderDate;
        var endOrderDate;
        while (resIndex < reservationsArray.length) {
            startOrderDate = new Date(reservationsArray[resIndex][1]);
            endOrderDate = new Date(reservationsArray[resIndex][2])
            calendar.fullCalendar('renderEvent',
                {
                    id: reservationsArray[resIndex][3].toString(),
                    title: "רשום לחדר " + reservationsArray[resIndex][4],
                    start: startOrderDate,
                    end: endOrderDate,
                    color: '#3300FF',
                    textColor: 'white',
                    allDay: false

                },
                true // make the event "stick"
            );

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

        //room capacity is now at :
        //roomsArray[i][2]


        var j, i;
        var y = document.getElementById("roomSelect");

        for (i = 0; i < roomsArray.length + 1; i++) {
            y.remove(y.childNodes);
        }
        $('#roomSelect').append("<option>" + "בחר חדר:" + "</option>");
        if ($('#inputStartTime').val() != "" && $('#inputEndTime').val() != "" && $('#datePicker').val() != ""
            && $('#inputStartTime').val() < $('#inputEndTime').val()) {

            // $('#roomHide').show();
            // $('#btnFindRoom').hide();
        }
        else {
            var x = document.getElementById("roomSelect");
            for (i = 0; i < roomsAfterFilter.length + 1; i++) {
                x.remove(x.childNodes);
            }
            $('#roomHide').hide();
            $('#btnFindRoom').show();

        }

    }


    function setRoomsPicture() {

        var name = $('#roomSelect').val();
        if (name == "בחר חדר:")
            return;
        var dropdownstr = " <div class='dropdown'><button class='dropbtn'>שירותי " + name;

        var services;
        var i;
        for (i = 0; i < roomsArray.length; i++) {

            if (name == roomsArray[i][1]) {
                selectedRoomId = roomsArray[i][0];
                services = roomsArray[i][3];
                break;
            }
        }
        var specificRoomServices = services.split(',');
        var servicesRoomSelected = "<div class='dropdown-content'>";
        for (var i = 0; i < specificRoomServices.length; i++) {
            servicesRoomSelected += "<a href='#'>" + specificRoomServices[i].toString() + "</a>";
        }
        servicesRoomSelected += "</div> </div>";
        dropdownstr += servicesRoomSelected;

        //noinspection JSAnnotator
        var randomImages = ["http://bookme.myweb.jce.ac.il/wp-content/uploads/2016/06/noPic.jpg" ,
        "http://bookme.myweb.jce.ac.il/wp-content/uploads/2016/06/purpleRoom.jpg",
        "http://bookme.myweb.jce.ac.il/wp-content/uploads/2016/06/greenRoom.jpg"
        ] ;
        var randomImgIndex = Math.floor(Math.random() * 3);
        alert("random images index is " +randomImgIndex);

        $('#roomPictureSelect').css('background-image', 'url(' + randomImages[randomImgIndex] + ')');
        $('#roomPictureSelect').css('background-size', '100%');
        $('#roomPictureSelect').html(dropdownstr);


    }


    //change the services to checkboxes and display them in services div
    function displayCheckboxes(whichId) {
        var checkboxes = "<table class='table table-sm text-right table-cool'  align='right' >";


        if (servicesArray.length == 0)
            return;
        for (var i = 0; i < servicesArray.length; i++) {
            checkboxes += "<tr> <td data-halign='right' class ='tdCheckboxe'>" + servicesArray[i].toString() + "</td> <td data-halign='left'><input type='checkbox' data-group-cls='btn-group-sm' name='presentServicce' id = " + "service" + i + "></td><td></tr>";
        }
        checkboxes += "</table>";

        if (whichId == "checkboxes") {
            $('#checkboxes').append(checkboxes);
            $(':checkbox').checkboxpicker({onLabel: "כן", offLabel: "לא", checked: true, disabled: false});
            $(':checkbox').change(labelsChangeEvent);
        }
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
        $('#errorInput').hide();
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


        if (hourStart == hourEnd && minStart > minEnd) {
            cleanInErrorInput(errorCurrentTime);
            return;
        }
        else if (hourStart > hourEnd) {
            cleanInErrorInput(errorCurrentTime);
            return;
        }

        eventStartTime = new Date(year, month - 1, day, hourStart, minStart);
        eventEndTime = new Date(year, month - 1, day, hourEnd, minEnd);

        for(var i = 0; i < excludedDays.length ; i++)
            if(excludedDays[i] == eventStartTime.getDay())
                cleanInErrorInput(errorCurrentTime);
    }


    function displayOrderRoomInDialog(startHour, startMin, endHour, endMin, nameRoom) {
        var startDisplay = displayProperTimeLabel(startHour, startMin);
        var endDisplay = displayProperTimeLabel(endHour, endMin);
        var description = "<div id = 'diplayOrderRoom'' class='modal-body'>";
        description += "החדר מוזמן לשעה: ";
        description += startDisplay;
        description += " עד שעה: ";
        description += endDisplay + " ";
        description += nameRoom + ".";
        var name = nameRoom.slice(10, nameRoom.length);
        var services;
        for (i = 0; i < roomsArray.length; i++) {

            if (name == roomsArray[i][1]) {
                services = roomsArray[i][3];
                break;
            }
        }
        var specificRoomServices = services.split(',');
        if (specificRoomServices.length != 1) {
            description += "<br> השירותים בחדר זה הם:";
            description += "<br>";

            for (var i = 0; i < specificRoomServices.length; i++) {
                if (i < specificRoomServices.length - 1)
                    description += specificRoomServices[i].toString() + ",";
                else
                    description += specificRoomServices[i].toString() + ".";
            }
        }
        else
            description += "<br>"+ "אין שירותים בחדר זה.";
        $("#diplayOrderRoom").replaceWith(description);

        var noImage = "http://bookme.myweb.jce.ac.il/wp-content/uploads/2016/06/noPic.jpg";
        var style = "width:240px;height:240px;";
        $('#changeOrderTime').replaceWith("<img id = 'changeOrderTime' src=" + noImage + " style=" + style + ">");
    }

    function sendDataToPhp() {

        var requestedSlots = [];
        requestedSlots = breakDurationIntoSlotsArray();
        alert(requestedSlots.toString());
        $.ajax({
            type: "POST",
            url: submitURL,
            data: {
                group: groupID,
                room: selectedRoomId,
                userId: userID.toString(),
                startString: eventStartTime.toString(),
                endString: eventEndTime.toString(),
                dateString: getDateTimeFromDate(eventStartTime),
                startTimeDouble:getHourTimeIntegerFromDate(eventStartTime),
                endTimeDouble:getHourTimeIntegerFromDate(eventEndTime),
                addRes: true,
            },//dataString
            cache: false,
            success: function (data) {
                //apply the id on the new event!
                var newEvent = calendar.fullCalendar('clientEvents', 'tempId')[0];
                newEvent._id = data;
            }
        });
    }

    function getHourTimeIntegerFromDate(time)
    {
        var hour = time.getHours();
        var minutes = time.getMinutes()/60;
        return (hour+minutes);
    }

    function getDateTimeFromDate(time)
    {
        return time.getDate() + "/" + (time.getMonth()+1);
    }

    /*  this function is using the start of selection time, and the end of selection time,
     to generate an array of slots, for easier comparison against the database tables.
     for example: if the user marked the hours 8-10, and the duration of each slot is 60 minutes,
     the array returned by the function is 8, 9 , 9 , 10 */

    function breakDurationIntoSlotsArray() {
        //calculate how many slots of time the user has picked, respective to the slotDuration set by the admin
        var how_many_slots_picked = (eventEndTime - eventStartTime) / (60000 * slotDurationInMinutes); // get number of slots selected
        //this array will hold the single slots after the breaking, without the hebrew/english time stamp
        var splittedArrayToReturn = [];
        var curr = eventStartTime;
        var prev;
        for (var i = 1; i <= how_many_slots_picked; i++) {
            prev = curr;
            //adding slotDurationInMinutes to the current date, to build a single time slot at a time.
            curr = new Date(prev.getTime() + slotDurationInMinutes * 60000);
            //pushing to the array we return, the pushed values are already  cleaned.
            splittedArrayToReturn.push(prev.toString().split('(')[0], curr.toString().split('(')[0]);
        }

        return splittedArrayToReturn;
    }

    //this functions will delete event from SQL
    function deleteEvent(eventId) {
        $.ajax({
            type: "POST",
            url: submitURL,
            data: {
                event_id: eventId,
                delRes: true,
            },//dataString
            cache: false,
            success: function (data) {
                //if null -> no room

                //else -> show the rooms that we got from submit.
            }
        });
    }


    function clickedServices(roomClickedServices) {
        var demandedCapacity = $('#quantity').val();

        if (demandedCapacity == "")
            demandedCapacity = 1;

        $.ajax({
            type: "POST",
            url: searchRoomsURL,
            data: {
                servicesArray: roomClickedServices,
                groupId: groupID,
                dateString: getDateTimeFromDate(eventStartTime),
                startTimeDouble:getHourTimeIntegerFromDate(eventStartTime),
                endTimeDouble:getHourTimeIntegerFromDate(eventEndTime),
                capacityRoom: demandedCapacity,
                searchByServices: true,
            },//dataString
            cache: false,
            success: function (data) {

                //if null -> no room
                roomsAfterFilter = JSON.parse(data);
                //else -> show the rooms that we got from submit.
                if (roomsAfterFilter.length == 0) {
                    $('#roomHide').hide();
                    $('#btnFindRoom').show();
                    cleanInErrorInput(errorNoRoomsAvailable);

                }
                else {

                    $('#roomHide').show();
                    $('#btnFindRoom').hide();
                    $('#roomSelect').empty();
                    $('#roomSelect').append("<option>" + "בחר חדר:" + "</option>");

                    for (var i = 0; i < roomsAfterFilter.length; i++) {

                        $('#roomSelect').append("<option>" + roomsAfterFilter[i] + "</option>");

                    }
                }
            }
        });
    }

    //this function will make validations of the fields
    //and if they empty or they un legal - the site will alert the fields required.
    function validationFindRoom() {


        if (userID == 0) {
            sweetAlert("...אופס", ".!עליך להתחבר על מנת לבצע הזמנה", "error");
            return;
        }

        if (!eventStartTime) {
            cleanInErrorInput(errorEmptyInputs);
            return;
        }
        if ($('#inputEndTime').val() == null || $('#inputStartTime').val() == null || $('#datePicker').val() == null) {
            cleanInErrorInput(errorEmptyInputs);
            return;
        }
        if ($('#inputEndTime').val() == "" || $('#inputStartTime').val() == "" || $('#datePicker').val() == "") {
            cleanInErrorInput(errorEmptyInputs);
            return;
        }
        $('#errorInput').hide();
        errorMenyQuantity = document.getElementById("quantity").value;
        var currentTime = new Date();
        if (eventStartTime.getYear() == currentTime.getYear()) {
            if (eventStartTime.getMonth() == currentTime.getMonth()) {
                if (eventStartTime.getDate() < currentTime.getDate()) {
                    cleanInErrorInput(errorEarlyInputs);
                    return;
                }
                else if (eventStartTime.getDate() == currentTime.getDate())
                    if (eventStartTime.getHours() <= currentTime.getHours()
                        || (eventEndTime.getHours() - eventStartTime.getHours()) > preventSlotTime) {
                        cleanInErrorInput(errorEarlyInputs);
                        return;
                    }
            }
            else if (eventStartTime.getMonth() < currentTime.getMonth()) {
                cleanInErrorInput(errorCurrentTime);
                return;
            }
        }
        else if (eventStartTime.getYear() < currentTime.getYear()) {
            cleanInErrorInput(errorCurrentTime);
            return;
        }
        else if (!atoiInJS(errorMenyQuantity)) {
            cleanInErrorInput(50);
            return;
        }
        var userServices = getArrayUserServicesSelected();
        clickedServices(userServices);
        //ShowAvailableRooms();

    }

    function cleanInErrorInput(eroorInput) {
        var errorInput = "";
        if (eroorInput == errorCurrentTime) {
            sweetAlert("...אופס", "!תאריך ושעה לא נכונים", "error");
        }
        if (eroorInput == errorEarlyInputs) {
            sweetAlert("...אופס", "!תאריך ושעה כבר עברו, בחר תאריך ושעה עדכניים", "error");
        }
        else if (eroorInput == errorMenyHourPerUser) {
            sweetAlert("...אופס", "אינך יכול להזמין יותר מ - " + reservationLimitation + " משבצות זמן!", "error");
        }
        else if (eroorInput == errorAlreadyBooked) {
            sweetAlert("...אופס", "!אתה כבר רשום לשעה זו", "error");
        }
        else if (eroorInput == 50) {
            sweetAlert("...אופס", "!שים לב לכמות - היא לא תקנית", "error");
        }
        else if (eroorInput == errorEmptyInputs) {
            sweetAlert("...אופס", "!יש שדות שיש למלא", "error");
        }
        else if (eroorInput == errorNoRoomsAvailable) {
            sweetAlert("...אופס", "!לא נמצאו חדרים העונים לדרישתך", "error");
        }
        else if (eroorInput == errorMoreThenOneDay) {
            sweetAlert("...אופס", "!הזמנה לא יכול להיות על שני ימים", "error");
        }

        $("#errorInput").replaceWith(errorInput);
        $('#datePicker').val("");
        $('#inputStartTime').val("");
        $('#inputEndTime').val("");
        $('#errorInput').show();

    }

    function atoiInJS(str) {
        if (str == null || str.length == 0)
            return false;
        for (var i = o; i < str.length; i++) {
            if (str[i] > "9" || str[i] < "0")
                return false;
        }
        return true;
    }

    function getArrayUserServicesSelected() {
        var userServices = [];
        var j = 0;
        for (var i = 0; i < servicesArray.length; i++)
            if ($('#service' + i).prop('checked')) {
                userServices[j] = servicesArray[i].toString();
                j++;
            }
        return userServices;
    }

    function alreadyBooked() {
        var dateStart;
        var dateEnd;
        for (var i = 0; i < reservationsArrayByUser.length; i++) {
            dateStart = new Date(reservationsArrayByUser[i][1]);
            dateEnd = new Date(reservationsArrayByUser[i][2])
            if (eventStartTime < dateStart && eventEndTime > dateStart)
                return false;
            if (eventStartTime >= dateStart && eventEndTime <= dateEnd)
                return false;
            if (eventStartTime < dateEnd && eventEndTime > dateEnd)
                return false;
            if (eventStartTime < dateStart && eventEndTime > dateEnd)
                return false;
        }
        return true;
    }


    function displayNumberOfEventsPerUser() {

        var numOfEvents = numOfReservationsPerUser; //Dummy value
        var text = "מספר האירועים שהזמנת: " + numOfEvents;
        $('#ShowNumOfEvents').html(text);

    }

});