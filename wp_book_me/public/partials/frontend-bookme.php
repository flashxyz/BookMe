<?php
/**
 * Created by IntelliJ IDEA.
 * User: rsaado
 * Date: 5/24/2016
 * Time: 16:20
 */
global $wpdb;

extract( shortcode_atts( array(
    'id' => ''), $atts ) );

$groupID = $atts['id'];

$group_options_table = $wpdb->prefix . "bookme_group_options";

$selectSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM $group_options_table WHERE id = %d", $groupID));

$calendarColor = $selectSQL[0]->calendarColor;
$fromTime = $selectSQL[0]->fromTime;
$toTime = $selectSQL[0]->toTime;
$windowTimeLength = $selectSQL[0]->windowTimeLength;
$services = unserialize($selectSQL[0]->services);
$activeDays = unserialize($selectSQL[0]->activeDays);

if(empty($selectSQL)) {

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
        color:  <?php echo $calendarColor; ?>;
        background-color:  <?php echo $calendarColor; ?>;
    }
    .fc-widget-header {
        background-color: <?php echo $calendarColor; ?>;
    }

    .fc-header-title {
        background-color:  <?php echo $calendarColor; ?>;
    }
    .fc-header-title h2 {
        color:  <?php echo $calendarColor; ?>;
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

<h1>The group id is: <?php echo $groupID; ?> and the view will appear here</h1>


<div class="container-fluid">
    <div class="row-fluid">
        <div class="jumbotron vertical-center">
            <div class="centering text-center">
                <!--<div class="BookHeader" >-->
                <!--<img src="BookMeLogo.png" style="width: auto; height: auto;max-width: 500px;max-height: 350px" />-->
                <!--<hr>-->
                <!--</div>-->
                <div id="calendar"></div>
                <hr>
                <div id="roomSelector">
                    <section id="examples">
                        <article>
                            <div class="demo">
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
                                <div  id="roomServicesSelect">
                                    <p/>שירותים <br>
                                    <div id="checkboxes"></div>
                                </div>
                                <div  id="roomConfirmSelect">
                                    <br>

                                    <button type="button" id="btnFindRoom" class="btn btn-default">מצא</button><br>
                                    <div id = "roomHide">
                                        <label for="roomSelect">בחר חדר: </label><br>
                                        <select class="form-control labelForom" id="roomSelect" value="בחר חדר">
                                            <option></option>
                                        </select>
                                        <button type="button" id="btnAddRoom" class="btn btn-default">אישור</button>

                                    </div>

                                    </p>
                                </div>

                                <div  id="roomPictureSelect">
                                    <br>
                                    <div id = "img"></div>
                                </div>
                            </div>

                        </article>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div id="myModal1" class="modal-content">
                <div class="modal-header">


                    <label> Please Choose Room Accessories </label><br>

                    <form>
                        <input type="radio" id="projector"> Projector<br>
                        <input type="radio" id="Microphone"> Microphone<br>
                        <input type="radio" id="Speakers"> Speakers<br>
                        <input type="radio" id="Computer"> Computer<br>
                    </form>
                    <br>
                    <label> Room floor: </label>
                    <input type="text" id="room_floor_input"/><br><br>
                    <label> Event title: </label>
                    <input type="text" id="event_input"/><br>
                    <label> end hour: </label>
                    <input type="time" min="06:00:00" max="21:00:00" step="3600" id="endhour"/><br><br>
                    <label> Please Choose Available Room </label>
                    <label> (will appear after choose upper options) </label>

                    <form>
                        <input type="radio" id="A100"> A100<br>
                        <input type="radio" id="A101"> A101<br>
                        <input type="radio" id="A102"> A102<br>
                    </form>
                    <button class="jscolor {valueElement: 'color_value'}" id="btnChooseColor"> choose color</button>
                    <button id="btnRemove"> Remove</button>
                </div>
            </div>
        </div>


    </div>
</div>