$(document).ready(function () {
    var availableRooms = [["A100","1","adamRoomSelector"], ["A101","2","adamRoomSelector"],
        ["A102", "3","adamRoomSelector"], ["B100", "1","adamRoomSelector"],
        ["B101" ,"2","adamRoomSelector"], ["B102","3","adamRoomSelector"],
        [ "C100","2","adamRoomSelector"],["C101","1","adamRoomSelector"],
        ["C102","3",""]];
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var timeStart;
    var timeEnd;
    var dateClick;
    $('#btnAddRoom').click(addEvent);
    $('#btnFindRoom').click(ShowAvailableRoom);
    $('#roomHide').hide();

    $('#datePicker').change(ShowAvailableRoom);
    $('#stepExample1').change(ShowAvailableRoom);
    $('#stepExample2').change(ShowAvailableRoom);

    $('#roomSelect').change(setPicture);

    var duartionInMin = windowTimeLength;
    var minimumTime = fromTime;
    var maximumTime = toTime;
    var services = ["11111", "222222", "3333333","444444", "555", "666666","77777", "88888",
        "99999","10000", "200000", "300"];
    displayCheckboxes();
    alert(activeDays);
    var calendar;
    calendar = $('#calendar').fullCalendar({
        header: {
            left: 'next,prev today',
            center: 'title',
            right: 'month, agendaWeek, basicDay'
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




        },
        slotDuration: '00:' + duartionInMin + ':00',
        lang: 'he',
        isRTL: true,
        minTime: minimumTime + ":00",
        maxTime: maximumTime + ":00",
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
            'minTime': minimumTime,
            'maxTime': maximumTime,
            'timeFormat': 'H:i',
            'step': function (i) {
                return (i % 2) ? duartionInMin : duartionInMin;
            }

        });
        $('#stepExample2').timepicker({
            'minTime': minimumTime,
            'maxTime': maximumTime,
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
        var  j,i;
        var y = document.getElementById("roomSelect");
        for (i = 0; i < availableRooms.length; i++) {
            y.remove(y.childNodes);
        }
        $('#roomSelect').append("<option>" + "בחר חדר:" + "</option>");
        if ($('#stepExample1').val() != "" && $('#stepExample2').val() != "" && $('#datePicker').val() != "") {
            for (i = 0; i < availableRooms.length; i++) {
                $('#roomSelect').append("<option>" + availableRooms[i] + "</option>");
                //.attr("value",key).text(value))
            }
            $('#roomHide').show();
            $('#btnFindRoom').hide();


        }
        else {
            alert("נא להכניס ערכים")
            var x = document.getElementById("roomSelect");
            for (i = 0; i < availableRooms.length; i++) {
                x.remove(x.childNodes);
            }
            $('#roomHide').hide();
            $('#btnFindRoom').show();
        }
        //$('#roomSelect').change($('#roomSelect').val());


    }

    function setPicture() {
        alert("in");
        var name =  $('#roomSelect').val();
        var i;
        for( i = 0 ; i < availableRooms.length ; i++)
            if(name == availableRooms[i])
                break;
        var imgstring = "./img/"+availableRooms[i][2]+".jpg";
        var style = "width:304px;height:228px;";

        $('#img').replaceWith("<img id = 'img' src="+imgstring+" style="+style+">");

    }

    function displayCheckboxes() {
        var checkboxes = "<tr class='col-sm-12 '>";

        for (var i = 0; i < services.length; i++) {
            if( i % 3 == 0 && i > 0)
                checkboxes +="</tr><tr class='col-sm-12'>"
            checkboxes += "<td class='checkbox-inline checkbox'> <label><input type='checkbox' value='' >"+
                " <span class='cr'><i class='cr-icon glyphicon glyphicon-ok'></i></span>" +
                services[i] +
                " </label></td>";

        }
        checkboxes += "</tr>"
        $('#checkboxes').append(checkboxes);
    }


});