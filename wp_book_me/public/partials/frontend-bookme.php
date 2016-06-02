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
$index = 0;
$roomsArray = [];
$selectSQL_rooms[$index];
$numberOfRooms = sizeof($selectSQL_rooms);

while( $index < $numberOfRooms)
{

    array_push($roomsArray,$selectSQL_rooms[$index]->roomName);
    $index ++;
}


$calendarColor = $selectSQL[0]->calendarColor;
$fromTime = $selectSQL[0]->fromTime;
$toTime = $selectSQL[0]->toTime;
$windowTimeLength = $selectSQL[0]->windowTimeLength;
$services = unserialize($selectSQL[0]->services);
$activeDays = unserialize($selectSQL[0]->activeDays);
$groupName = $selectSQL[0]->groupName;
$description = $selectSQL[0]->description;

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


?>

<script type="text/javascript">

    var windowTimeLength = "<?php echo $windowTimeLength ?>";
    var fromTime = "<?php echo $fromTime ?>";
    var toTime = "<?php echo $toTime ?>";
    //active days
    var activeDays = [];
    activeDays[0] = "<?php echo $activeDays["sunday"] ?>";
    activeDays[1] = "<?php echo $activeDays["monday"] ?>";
    activeDays[2] = "<?php echo $activeDays["tuesday"] ?>";
    activeDays[3] = "<?php echo $activeDays["wednesday"] ?>";
    activeDays[4] = "<?php echo $activeDays["thursday"] ?>";
    activeDays[5] = "<?php echo $activeDays["friday"] ?>";
    activeDays[6] = "<?php echo $activeDays["saturday"] ?>";



    //get the services to array var in javascript
    var services = [];

    var i = 0;
    <?php for ( $i = 0 ; $i < sizeof($services) ; $i++){ ?>
    services[i] = "<?php echo $services[$i]?>";
    i++;
    <?php } ?>

    //roomsArray = [];

    <?php $jsArray = json_encode($roomsArray) ;
    echo "var roomsArray = " . $jsArray . ";\n";
    ?>

    
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

    .fc-bg {
        color: <?php echo $fiftyPercentBrighter; ?> !important;
    }

    .fc-center h2 {
        color: <?php echo $calendarColor; ?>;
    }

    .fc td, .fc th {
        color: <?php echo $fiftyPercentBrighter; ?> !important;
    }

</style>


<div class="container-fluid text-right">

    <!-- Calendar and description row -->
    <div class="row">
        <div class="col-md-9">
            <div id="calendar"></div>
            <hr>
        </div>

        <div class="col-md-3" >

            <h3><?php echo $groupName; ?></h3>
            <p style="border-top-left-radius: 15px; font-style: italic; background: linear-gradient(<?php echo $veryBrightColor; ?>, white" >
                    <?php echo $description; ?></p>
                <img src="http://bookme.myweb.jce.ac.il/wp-content/uploads/2016/05/meeting.png"/>
                <p></p><br>
                <h3>אמצעים מיוחדים</h3> <br>
                <div id=services></div>
            </p>
        </div>

    </div>
    <!-- /.row -->

    <!-- Related Projects Row -->

    <div class="rtl">

        <div class="col-sm-3 col-xs-6">
            <div id="roomPictureSelect">
                תיאור החדר
                <br>
            </div>
        </div>

        <div class="col-sm-3 col-xs-6">
            <div id="roomConfirmSelect">
                חדרים
                <br>
                <button type="button" id="btnFindRoom" class="btn btn-default">מצא</button>
                <br>
                <div id="roomHide"><br><br>
                    <div id="chooseroom"><select class="form-control" id="roomSelect" value="">
                            <option></option>
                        </select></div>
                    <button type="button" id="btnReserveRoom" class="btn btn-default">אישור</button>
                </div>
                </p>
            </div>
        </div>

        <div class="col-sm-3 col-xs-6 text-right">
            <p/>שירותים <br>

            <div class="pre-scrollable text-right">
                <div id="checkboxes">
                    <!--  here, the capabilities will be printed dynamically from js-->
                </div>
            </div>
        </div>

        <div class="col-sm-3 col-xs-6">
            <div>
                <table>
                    <p> מתי להזמין<br><br>
                        <tr class="trStart">
                            <td class='tdStart'><label>שעת התחלה: </label></td>
                            <td class='tdStart'><input id="inputStartTime" type="text" class="time labelForom"/></td>
                        </tr>
                        <tr class="trStart">
                            <td class='tdStart'><label>שעת סיום: </label></td>
                            <td class='tdStart'><input id="inputEndTime" type="text" class="time labelForom"/></td>
                        </tr>
                        <tr class="trStart">
                            <td class='tdStart'><label>תאריך:</label></td>
                            <td class='tdStart'><input type="text" class="date start labelForom" id="datePicker"/>
                            </td>
                        </tr>
                        <tr class="trStart">
                            <td class='tdStart'><label>כמות:</label></td>
                            <td class='tdStart'><input id="quantity" type="text" class="time labelForom"/></td>
                        </tr>
                    </p>
                </table>
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
                        <div class="modal-body">
                            <p>החדר מוזמן לכך וכך שעות</p>
                        </div>
                        <div class="modal-body" id="editRoomTime">
                            <div id="changeOrderTime">
                                כרגע לא ידוע מה יהיה כאן
                            </div>
                            <br>
                            <button id="deleteOrderButton" type="button" class="btn btn-success">מחיקת חדר</button>
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
    <!-- /.row -->
</div>



