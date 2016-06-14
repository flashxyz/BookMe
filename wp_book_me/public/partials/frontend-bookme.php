<?php
/**
 * Created by IntelliJ IDEA.
 * User: rsaado
 * Date: 5/24/2016
 * Time: 16:20
 */


global $wpdb;

extract(shortcode_atts(array(
    'id' => ''), $atts));

$groupID = $atts['id'];
$userID = get_current_user_id();

//general options
$general_options_table = $wpdb->prefix . "bookme_general_options";

//get general options from data
$selectSQL_generalOptions = $wpdb->get_row( "SELECT * FROM $general_options_table" );

$genOptIsRTL = $selectSQL_generalOptions->isRTL;
$genOptFirstDay = $selectSQL_generalOptions->firstDayOfWeek;
$genOptDateFormat = $selectSQL_generalOptions->dateFormat;

//set rtl as full calendars rtl
if($genOptIsRTL == '1')
{
    $genOptIsRTL = "true";
}
else
{
    $genOptIsRTL = "false";
}
//set first day as full calendars first day
if($genOptFirstDay == 'sunday')
{
    $genOptFirstDay = 0;
}
else
{
    $genOptFirstDay = 1;
}


//group SQL table
$group_options_table = $wpdb->prefix . "bookme_group_options";


$selectSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM $group_options_table WHERE id = %d", $groupID));


if (empty($selectSQL)) {

    echo "<h1>Sorry.. There is no shortcode id = " . $groupID . "</h1>";
    return;
}

//room SQL table
$room_options_table = $wpdb->prefix . "bookme_rooms_options";
//get rooms
$selectSQL_rooms = $wpdb->get_results($wpdb->prepare("SELECT * FROM $room_options_table WHERE groupId = %d", $groupID));

if (empty($selectSQL_rooms)) {

    //no rooms
}

//add rooms to array
$index = 0;
$roomsArray = [];
$selectSQL_rooms[$index];
$numberOfRooms = sizeof($selectSQL_rooms);

//map of room names by id
$roomArrayById = array();

while ($index < $numberOfRooms) {
    $roomCell[0] = $selectSQL_rooms[$index]->roomId;
    $roomCell[1] = $selectSQL_rooms[$index]->roomName;
    $roomCell[2] = $selectSQL_rooms[$index]->capacity;
    array_push($roomsArray, $roomCell);
    $roomArrayById[$roomCell[0]] = $roomCell[1];
    $index++;
}

//get table
$room_reservation_table = $wpdb->prefix . "bookme_room_reservation";


//get all reservations for this user id,group
$selectSQL_reservation = $wpdb->get_results($wpdb->prepare("SELECT * FROM $room_reservation_table WHERE groupId = %d AND userId = %d ", $groupID, $userID));
$numberOfReservation = sizeof($selectSQL_reservation);

//add all reservations for this user to an array
$reservation_array = [];
$index = 0;
while ($index < $numberOfReservation) {
    $resCell[0] = $selectSQL_reservation[$index]->roomId;
    $resCell[1] = $selectSQL_reservation[$index]->startTime;
    $resCell[2] = $selectSQL_reservation[$index]->endTime;
    $resCell[3] = $selectSQL_reservation[$index]->reservationId;
    $resCell[4] = $roomArrayById[$resCell[0]];
    array_push($reservation_array, $resCell);
    $index++;
}

$selectSQL_reservation_byUser = $wpdb->get_results($wpdb->prepare("SELECT * FROM $room_reservation_table WHERE userId = %d ",  $userID));
$numberOfReservationByUser = sizeof($selectSQL_reservation_byUser);

//add all reservations for this user to an array
$reservation_array_byUser = [];
$index = 0;
while ($index < $numberOfReservationByUser) {
    $resCell[0] = $selectSQL_reservation_byUser[$index]->roomId;
    $resCell[1] = $selectSQL_reservation_byUser[$index]->startTime;
    $resCell[2] = $selectSQL_reservation_byUser[$index]->endTime;
    $resCell[3] = $selectSQL_reservation_byUser[$index]->reservationId;
    array_push($reservation_array_byUser, $resCell);
    $index++;
}


$calendarColor = $selectSQL[0]->calendarColor;
$fromTime = $selectSQL[0]->fromTime;
$toTime = $selectSQL[0]->toTime;
$windowTimeLength = $selectSQL[0]->windowTimeLength;
$services = unserialize($selectSQL[0]->services);
$activeDays = unserialize($selectSQL[0]->activeDays);
$groupName = $selectSQL[0]->groupName;
$description = $selectSQL[0]->description;
$reservationLimitation =  $selectSQL[0]->reservationLimitation;

//define a brighter color by 50%
$brightness = 0.5; // 50% brighter
$fiftyPercentBrighter = colourBrightness($calendarColor, $brightness);
$brightness = 0.2; // 80% brighter
$veryBrightColor = colourBrightness($calendarColor, $brightness);
$brightness = 0.9; // 10% lighter
$darkerColor = colourBrightness($calendarColor, $brightness);


//this function will generate a brighter color than the one given as a parameter.
//the whole calendar colors will be based upon that.
function colourBrightness($hex, $percent)
{
    // Work out if hash given
    $hash = '';
    if (stristr($hex, '#')) {
        $hex = str_replace('#', '', $hex);
        $hash = '#';
    }
    /// HEX TO RGB
    $rgb = array(hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2)));
    //// CALCULATE
    for ($i = 0; $i < 3; $i++) {
        // See if brighter or darker
        if ($percent > 0) {
            // Lighter
            $rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1 - $percent));
        } else {
            // Darker
            $positivePercent = $percent - ($percent * 2);
            $rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1 - $positivePercent));
        }
        // In case rounding up causes us to go to 256
        if ($rgb[$i] > 255) {
            $rgb[$i] = 255;
        }
    }
    //// RBG to Hex
    $hex = '';
    for ($i = 0; $i < 3; $i++) {
        // Convert the decimal digit to hex
        $hexDigit = dechex($rgb[$i]);
        // Add a leading zero if necessary
        if (strlen($hexDigit) == 1) {
            $hexDigit = "0" . $hexDigit;
        }
        // Append to the hex string
        $hex .= $hexDigit;
    }
    return $hash . $hex;
}


//get the current path url
$submitURL = get_site_url()."/wp-content/plugins/wp_book_me/public/partials/calendarSubmit.php";

$searchRoomsURL = get_site_url()."/wp-content/plugins/wp_book_me/public/partials/searchRooms.php";

$searchServiceURL = get_site_url()."/wp-content/plugins/wp_book_me/public/partials/searchServices.php";




?>

<link rel="stylesheet" type="text/css"
      href="https://fonts.googleapis.com/css?family=Tangerine">


<script type="text/javascript">

    var submitURL = "<?php echo $submitURL ?>";
    
    var searchRoomsURL = "<?php echo $searchRoomsURL ?>";

    var searchServiceURL ="<?php echo $searchServiceURL ?>";

    var windowTimeLength = "<?php echo $windowTimeLength ?>";
    var fromTime = "<?php echo $fromTime ?>";
    var toTime = "<?php echo $toTime ?>";
    var reservationLimitation = "<?php echo $reservationLimitation ?>";
    
    var activeDays = [];
    activeDays[0] = "<?php echo $activeDays["sunday"] ?>";
    activeDays[1] = "<?php echo $activeDays["monday"] ?>";
    activeDays[2] = "<?php echo $activeDays["tuesday"] ?>";
    activeDays[3] = "<?php echo $activeDays["wednesday"] ?>";
    activeDays[4] = "<?php echo $activeDays["thursday"] ?>";
    activeDays[5] = "<?php echo $activeDays["friday"] ?>";
    activeDays[6] = "<?php echo $activeDays["saturday"] ?>";
    var userID = <?php echo $userID; ?>;
    var groupID =  <?php echo $groupID ?>;
    //get the services to array var in javascript
    var services = [];


    var i = 0;
    <?php for ( $i = 0 ; $i < sizeof($services) ; $i++){ ?>
    services[i] = "<?php echo $services[$i]?>";
    i++;
    <?php } ?>

    var numOfReservations= "<?php echo $numberOfReservationByUser ?>";

    //roomsArray = [];

    <?php $jsArray = json_encode($roomsArray);
    echo "var roomsArray = " . $jsArray . ";\n";
    ?>

    <?php $jsArray = json_encode( $reservation_array);
    echo "var reservationsArray = " . $jsArray . ";\n";
    ?>

    <?php $jsArray = json_encode( $reservation_array_byUser);
    echo "var reservationsArrayByUser = " . $jsArray . ";\n";
    ?>

    //general options import -------------------
    var genOptIsRTL = "<?php echo $genOptIsRTL ?>";
    var genOptDateFormat = "<?php echo $genOptDateFormat ?>";
    var genOptFirstDay = "<?php echo $genOptFirstDay ?>";
    //end of general options import -----------------



</script>

<style>

    html, body {
        color: <?php echo $calendarColor; ?>;
        background-color: <?php echo $calendarColor; ?>;
        font-family: 'Open Sans Hebrew', sans-serif;

    }

    .fc-widget-header {
        background: linear-gradient(<?php echo $darkerColor; ?>, <?php echo $calendarColor; ?>);
        font-family: 'Open Sans Hebrew', sans-serif;

    }

    .fc-week-number span {
        color: <?php echo $veryBrightColor; ?>;
    }

    .fc-day-header {
        color: <?php echo $veryBrightColor; ?>;
        height: 20px;
    }

    .fc-header-title {
        background-color: <?php echo $veryBrightColor; ?>;
        font-family: 'Open Sans Hebrew', sans-serif;

    }

    .fc-divider {
        background-color: <?php echo $calendarColor; ?> !important;
        color: <?php echo $fiftyPercentBrighter; ?> !important;

    }

    #roomSelector {
        color: <?php echo $veryBrightColor; ?>;
    }

    .fc-agenda-slots td div {
        color: <?php echo $calendarColor; ?>;
    }

    .fc-time-grid-event, .fc-v-event, .fc-event, .fc-start, .fc-end {
        color: <?php echo $calendarColor; ?>;
        background-color: <?php echo $calendarColor; ?> !important;
    }

    .fc-axis {
        color: <?php echo $calendarColor; ?>;
    }

    #roomSelect {
        background-color: <?php echo $veryBrightColor; ?>;
    }

    .cool-button {
        background:  <?php echo $calendarColor; ?>;
    }
    .cool-button:hover {
        background:  <?php echo $fiftyPercentBrighter; ?> !important;
    }
    .fc-bg {
        color: <?php echo $fiftyPercentBrighter; ?> !important;
    }
    .fc-state-hover{
        background-color: <?php echo $veryBrightColor; ?> !important;
    }
    .fc-center h2 {
        color: <?php echo $calendarColor; ?>;
    }

    .fc td, .fc th {
        color: <?php echo $fiftyPercentBrighter; ?> !important;
    }

    .greyGradient p {
        color: <?php echo $fiftyPercentBrighter; ?>;
    }
    #services {
        color: <?php echo $fiftyPercentBrighter; ?>;
    }

</style>


<div class="container-fluid text-right">

    <!-- Calendar and description row -->
    <div class="row">
        <div class="col-md-9">
            <div id="calendar"></div>
            <hr>
        </div>

        <div class="col-md-3">
            <div class ="greyGradient">
            <h3><?php echo $groupName; ?></h3>
                <p style="text-align: center;" >
                    <?php echo $description; ?>
                </p>
                <img src="http://bookme.myweb.jce.ac.il/wp-content/uploads/2016/05/meeting.png"/>
                <div id="ShowNumOfEvents" class="ShowNumOfEventsAnimation"></div>
                <p></p><br>
                <h4>אמצעים מיוחדים</h4> <br>
                <div id=services></div>
        
            </div>
        </div>

    </div>
    <!-- /.row -->

    <!-- Related Projects Row -->
    <div class="row">
        <div class="spacer">
            <hr style="border: 1px dotted <?php echo $veryBrightColor; ?>; border-style: none none dotted;">
        </div>
    </div>
    <div class="row">

        <div class="optionsContainer">

            <div class="col-sm-3 col-xs-6">
                <div id="roomPictureSelect">

                    תיאור החדר
                    <br> <br>
                </div>
            </div>

            <div class="col-sm-3 col-xs-6">

                    חדרים
                    <br><br>
                <div id="roomConfirmSelect">
                    <button type="button" id="btnFindRoom" class="cool-button">מצא</button>

                    <div id="roomHide">
                        <div id="chooseroom"><select class="form-control" id="roomSelect" value="">
                                <option></option>
                            </select></div>
                        <button type="button" id="btnReserveRoom" class="cool-button">אישור</button>
                    </div>
             
                </div>
            </div>

            <div class="col-sm-3 col-xs-6 text-right">
               שירותים <br><br>
                <table class="table-sm text-right table-cool" style="margin-bottom: 0px;" > <tbody> <tr> <td data-halign="right"  class ="text-right"> שירות </td> <td data-halign="left">&emsp; סמן &emsp;</td> </tr> </tbody></table>

                    <div id="checkboxes">
                        <!--  here, the capabilities will be printed dynamically from js-->
                    </div>
            </div>

            <div class="col-sm-3 col-xs-6 text-right">
                <div>
                    <table class="table-cool">
                        מתי להזמין<br><br>
                        <tr class="trStart">
                            <td class='tdStart'><label>שעת התחלה: </label></td>
                            <td class='tdStart'><input id="inputStartTime" type="text" class="time labelForom"  pattern="[0-9]" maxlength="5" placeholder="##:##" data-error="input time as ##:##" onkeydown="return false"  required/>
                            </td>
                        </tr>
                        <tr class="trStart">
                            <td class='tdStart'><label>שעת סיום: </label></td>
                            <td class='tdStart'><input id="inputEndTime" type="text" class="time labelForom" data-toggle="validator" pattern="[0-9]" maxlength="5" placeholder="##:##" data-error="input time as ##:##"  onkeydown="return false" required/></td>
                        </tr>
                        <tr class="trStart">
                            <td class='tdStart'><label>תאריך:</label></td>
                            <td class='tdStart'><input type="text" class="date start labelForom" id="datePicker" data-toggle="validator" pattern="[0-9](/)" maxlength="10" placeholder="####/##/##" data-error="input date as ##/##/####" onkeydown="return false" required/>
                            </td>
                        </tr>
                        <tr class="trStart">
                            <td class='tdStart'><label>כמות:</label></td>
                            <td class='tdStart'><input id="quantity" type="text" class="time labelForom" data-toggle="validator" pattern="[0-9]" maxlength="3" required/></td>
                        </tr>
                    </table>
                    <div id="errorInput"></div>
                </div>
            </div>
            <div id="dialogWithUser">
                <div class="modal fade" id="reservationDetailsDialog" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">פרטי החדר</h4>
                            </div>
                            <div id = "diplayOrderRoom" class="modal-body">
                                
                            </div>
                            <div class="modal-body" id="editRoomTime">
                                <div id="changeOrderTime">
                                    כרגע לא ידוע מה יהיה כאן
                                </div>
                                <br>
                                <button id="deleteOrderButton" type="button" data-dismiss="modal" class="btn btn-success">מחיקת חדר</button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <hr>
        </div>
    </div>
    <!-- /.row -->
</div>



