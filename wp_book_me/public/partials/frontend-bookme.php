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

$group_options_table = $wpdb->prefix . "bookme_group_options";

$selectSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM $group_options_table WHERE id = %d", $groupID));

$calendarColor = $selectSQL[0]->calendarColor;
$fromTime = $selectSQL[0]->fromTime;
$toTime = $selectSQL[0]->toTime;
$windowTimeLength = $selectSQL[0]->windowTimeLength;
$services = unserialize($selectSQL[0]->services);
$activeDays = unserialize($selectSQL[0]->activeDays);
$groupName = $selectSQL[0]->groupName;

if (empty($selectSQL)) {

    echo "<h1>Sorry.. There is no shortcode id = " . $groupID . "</h1>";
    return;
}


?>

<script type="text/javascript">

    var windowTimeLength = "<?php echo $windowTimeLength ?>";
    var fromTime = "<?php echo $fromTime ?>";
    var toTime = "<?php echo $toTime ?>";
    var activeDays = [];
    activeDays[0] = "<?php echo $activeDays["sunday"] ?>";
    activeDays[1] = "<?php echo $activeDays["monday"] ?>";
    activeDays[2] = "<?php echo $activeDays["tuesday"] ?>";
    activeDays[3] = "<?php echo $activeDays["wednesday"] ?>";
    activeDays[4] = "<?php echo $activeDays["thursday"] ?>";
    activeDays[5] = "<?php echo $activeDays["friday"] ?>";
    activeDays[6] = "<?php echo $activeDays["saturday"] ?>";
</script>

<style>

    html, body {
        color: <?php echo $calendarColor; ?>;
        background-color: <?php echo $calendarColor; ?>;
    }

    .fc-widget-header {
        background-color: <?php echo $calendarColor; ?>;
    }

    .fc-header-title {
        background-color: <?php echo $calendarColor; ?>;
    }

    .fc-header-title h2 {
        color: <?php echo $calendarColor; ?>;
    }

    #roomSelector {
        color: <?php echo $calendarColor; ?>;
    }

    .fc-agenda-slots td div {
        color: <?php echo $calendarColor; ?>;
    }

    .fc-time-grid-event .fc-time {
        color: <?php echo $calendarColor; ?>;
    }

    .fc-axis {
        color: <?php echo $calendarColor; ?>;
    }

    .fc-center h2 {
        color: <?php echo $calendarColor; ?>;
    }


</style>


<div class="container text-right">

    <!-- Calendar and description row -->
    <div class="row">
        <div class="col-md-9">
            <div id="calendar"></div>
            <hr>
        </div>

        <div class="col-md-3">

            <img src="http://bookme.myweb.jce.ac.il/wp-content/uploads/2016/05/remindyou_logo.jpg"/>
            <h3><?php echo $groupName ?></h3> <br>
            <p>חדרי השקט ממוקמים בקומה מינוס 2 והם שקטים ביותר</p> <br>
            <h3>אמצעים מיוחדים</h3> <br>
            <div id = services></div>
<!--            <ul>-->
<!--                <li>זכוכית משוריינת ירי</li>-->
<!--                <li>מחשב מיוחד לעיוורים</li>-->
<!--                <li>ארוחות בין 14:00-16:00</li>-->
<!--                <li>סמים קלים</li>-->
<!--            </ul>-->
        </div>

    </div>
    <!-- /.row -->

    <!-- Related Projects Row -->
    <div class="row">

        <div class="col-sm-3 col-xs-6">
            <div id="roomPictureSelect">
                <br>
                <div id="img"></div>
            </div>
        </div>

        <div class="col-sm-3 col-xs-6">
            <div id="roomConfirmSelect">
                <br>
                <button type="button" id="btnFindRoom" class="btn btn-default">מצא</button>
                <br>
                <div id="roomHide">
                    <label for="roomSelect">בחר חדר: </label><br>
                    <select class="form-control labelForom" id="roomSelect" value="בחר חדר">
                        <option></option>
                    </select>
                    <button type="button" id="btnAddRoom" class="btn btn-default">אישור</button>
                </div>
                </p>
            </div>
        </div>

        <div class="col-sm-3 col-xs-6">
            <div class="pre-scrollable">
                <p/>שירותים <br>
                <div id="checkboxes"></div>
            </div>
        </div>

        <div class="col-sm-3 col-xs-6">
            <div id="roomTimeSelect">
                <p>מתי להזמין<br><br>
                    <label>שעת התחלה: </label>
                    <input id="stepExample1" type="text" class="time labelForom"/><br>
                    <label>שעת סיום: </label>
                    <input id="stepExample2" type="text" class="time labelForom"/><br>
                <p id="datepairExample">
                    <label>תאריך:</label>
                    <input type="text" class="date start labelForom" id="datePicker"/><br>
                    <label>כמות:</label>
                    <input id="quantity" type="text" class="time labelForom"/><br>
            </div>
        </div>
        <hr>
    </div>
    <!-- /.row -->
</div>



