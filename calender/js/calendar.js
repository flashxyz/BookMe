var flag = false;
var activeEvents = [];


$(document).ready(function () {
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();
	var dateClick;
	$('#btnChooseColor').click(endDialig);

	var calendar;
	calendar = $('#calendar').fullCalendar({
		header: {
			left: 'next,prev today',
			center: 'title',
			right: 'month, agendaWeek, year'
		},

		dayClick: function( date, jsEvent, view, resourceObj ) {
			$("#dialog").dialog("open");
			dateClick = new Date(date);
			var houre = dateClick.getHours() - 3;
			var day = dateClick.getDate();
			var month = dateClick.getMonth();
			var min = dateClick.getMinutes();
			var year = dateClick.getFullYear();
			dateClick = new Date(year, month, day, houre, min);

			//alert("date is " + dateClick);

		},
		slotDuration: '00:10:00',
		lang: 'he',
		isRTL: true,
		minTime: "06:00:00",
		maxTime: "22:00:00",
		hiddenDays: [6],
		firstHour: 8,
		allDaySlot: false,
		height: 700,
		axisFormat: "HH:mm",
		defaultView: "agendaWeek",
		weekends: true,
		selectable: true,
		selectHelper: true,
		weekNumbers: true,
		allDayDefault: true,
		//eventClick :function(date, allDay, jsEvent, view) event cheange

		eventClick: function(calEvent, jsEvent, view)
		{
			var id = calEvent.id;
			var text = $("#event_input").val();
			if(text != undefined)
			{
				var text =  $("#endhour").val();
				var houre = parseInt(text);
				var day = dateClick.getDate();
				var month = dateClick.getMonth();
				var year = dateClick.getFullYear();
				var min = dateClick.getMinutes();

				text = "change the text";
				var endDate = new Date(year, month, day, houre, min);
				$("#dialog").dialog("close");

				if(dateClick.getHours() >= endDate.getHours())
				{	alert("uston we have a problem"); return;}

				calendar.fullCalendar('renderEvent',
					{
						title: text,
						start: dateClick,
						end: endDate,
						allDay: false
					},
					true // make the event "stick"
				);
			}
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


	$("#dialog").dialog ({
		autoOpen: false,
		height: 300,
		width: 300,
		modal: true
	});

	function endDialig(){
		var text = $("#endhour").val();
		var houre = parseInt(text);
		var day = dateClick.getDate();
		var month = dateClick.getMonth();
		var year = dateClick.getFullYear();
		var min = dateClick.getMinutes();



		text = $("#event_input").val();
		flag = true;
		for(var i = 0; i < activeEvents.length; i++) {
			if (text != activeEvents[i]) {
				$("#calendar").fullCalendar('removeEventSource', {
					title: text
				});
				active[i] = null;
				flag = false;
			}
		}
		var endDate = new Date(year, month, day, houre, min);
		$("#dialog").dialog("close");

		if(dateClick.getHours() >= endDate.getHours())
		{	alert("uston we have a problem"); return;}
		if(flag) {
			calendar.fullCalendar('renderEvent',
				{
					title: text + "\n",
					start: dateClick,
					end: endDate,
					allDay: false
				},
				true // make the event "stick"
			);
			var add = ["title"];
			activeEvents.concat(add);
		}



	}

});