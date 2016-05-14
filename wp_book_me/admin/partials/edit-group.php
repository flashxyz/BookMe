<?php

$groupID = $_GET["group_id"];


if($_GET['group_id']==true AND $_GET['edit_group']==true)
{

    global $wpdb;

    $group_options_table = $wpdb->prefix . "bookme_group_options";

    $selectSQL = $wpdb->get_results( "SELECT * FROM $group_options_table WHERE id = '$groupID'" );


    $groupName = $selectSQL[0]->groupName;
    $numOfRooms = $selectSQL[0]->numOfRooms;
    $activeDays = unserialize($selectSQL[0]->activeDays);
    $fromTime = $selectSQL[0]->fromTime;
    $toTime = $selectSQL[0]->totime;
    $description = $selectSQL[0]->description;
    $viewMode = unserialize($selectSQL[0]->viewMode);
    $calendarColor = $selectSQL[0]->calendarColor;
    $windowTimeLength = $selectSQL[0]->windowTimeLength;

    $sundayChecked = $activeDays["sunday"];
    $mondayChecked = $activeDays["monday"];
    $tuesdayChecked = $activeDays["tuesday"];
    $wednesdayChecked = $activeDays["wednesday"];
    $thursdayChecked = $activeDays["thursday"];
    $fridayChecked = $activeDays["friday"];
    $saturdayChecked = $activeDays["saturday"];

    $monthRadioChecked = $viewMode["month"];
    $weekRadioChecked = $viewMode["week"];
    $agendaRadioChecked = $viewMode["agenda"];






    ?>
    <div class="wrap">

        <h1>Rooms Group Options</h1>
        <hr>
        <h2>Group ID: <?php echo $groupID ?> </h2>
        <br>
        <table width='700px'>
            <tr>
                <td width='250px' >
                    <span>Group name: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_groupName">
                        <input type="text" id="<?php echo $this->plugin_name; ?>_groupName" name="<?php echo $this->plugin_name; ?> [groupName]" value="<?php echo $groupName; ?>"/>
                    </label>
                </td>
            </tr>

            <tr>
                <td width='250px' >
                    <span>Number of rooms: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_numOfRooms">
                        <input type="number" id="<?php echo $this->plugin_name; ?>_numOfRooms" name="<?php echo $this->plugin_name; ?> [numOfRooms]" min="0" value="<?php echo $numOfRooms; ?>"/>
                    </label>
                </td>
            </tr>

            <tr>
                <td width='250px' >
                    <span>Rooms available from: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_roomsAvailableFrom">
                        <input type="text" class="<?php echo $this->plugin_name; ?>_time_picker" id="<?php echo $this->plugin_name; ?>_roomsAvailableFrom" name="<?php echo $this->plugin_name; ?> [roomsAvailableFrom]" value="<?php echo $fromTime; ?>"/>
                    </label>
                </td>

            </tr>

            <tr>
                <td width='250px'>
                    <span>Rooms available until: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_roomsAvailableUntil">
                        <input type="text" class="<?php echo $this->plugin_name; ?>_time_picker" id="<?php echo $this->plugin_name; ?>_roomsAvailableUntil" name="<?php echo $this->plugin_name; ?> [roomsAvailableUntil]" value="<?php echo $toTime; ?>"/>
                    </label>
                </td>
            </tr>

            <tr>
                <td width='250px' >
                    <span>Group Description: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_groupDescription">
                        <input type="text" id="<?php echo $this->plugin_name; ?>_groupDescription" name="<?php echo $this->plugin_name; ?> [groupDescription]" rows="3" value="<?php echo $description; ?>"/>
                    </label>
                </td>
            </tr>

            <tr>
                <td width='250px' >
                    <span>Calendar Color: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_calendarColor">
                        <input type="text" class="<?php echo $this->plugin_name; ?>_calendarColor_class"  id="<?php echo $this->plugin_name; ?>_calendarColor" name="<?php echo $this->plugin_name; ?> [calendarColor]" value="<?php echo $calendarColor; ?>"/>
                    </label>
                </td>
            </tr>
            <tr>
                <td width='250px' >
                    <span>Time Slot Duration: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_timeSlot">
                        <input type="number" id="<?php echo $this->plugin_name; ?>_timeSlot" name="<?php echo $this->plugin_name; ?> [timeSlot]" min="15" step="15" value="<?php echo $windowTimeLength; ?>"/>
                    </label>
                </td>
                <td width='250px' >
                    <span>minutes</span>
                </td>
            </tr>
            
            
        </table>




        <br><span>Active days of the week: </span><hr>
        <table width='400px'>
            <tr>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeSunday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeSunday" name="<?php echo $this->plugin_name; ?> [activeSunday]" value="1" <?php checked($sundayChecked, 1); ?>/>
                        <sapn>Sunday</sapn>
                    </label>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeMonday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeMonday" name="<?php echo $this->plugin_name; ?> [activeMonday]" value="1" <?php checked($mondayChecked, 1); ?>/>
                        <sapn>Monday</sapn>
                    </label>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeTuesday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeTuesday" name="<?php echo $this->plugin_name; ?> [activeTuesday]" value="1" <?php checked($tuesdayChecked, 1); ?>/>
                        <sapn>Tuesday</sapn>
                    </label>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeWednesday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeWednesday" name="<?php echo $this->plugin_name; ?> [activeWednesday]" value="1" <?php checked($wednesdayChecked, 1); ?>/>
                        <sapn>Wednesday</sapn>
                    </label>
                </td>
            </tr>

            <tr>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeThursday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeThursday" name="<?php echo $this->plugin_name; ?> [activeThursday]" value="1" <?php checked($thursdayChecked, 1); ?>/>
                        <sapn>Thursday</sapn>
                    </label>
                </td >
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeFriday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeFriday" name="<?php echo $this->plugin_name; ?> [activeFriday]" value="1" <?php checked($fridayChecked, 1); ?>/>
                        <sapn>Friday</sapn>
                    </label>
                </td>
                <td width='100px'>
                    <label for="<?php echo $this->plugin_name; ?>_activeSaturday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeSaturday" name="<?php echo $this->plugin_name; ?> [activeSaturday]" value="1" <?php checked($saturdayChecked, 1); ?>/>
                        <sapn>Saturday</sapn>
                    </label>
                </td>
            </tr>
        </table>



        <br><span>Calendar view mode: </span><hr>
        <table width='300px'>
            <tr>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_calendarViewMode">
                        <input type="radio" id="<?php echo $this->plugin_name; ?>_calendarViewMode" name="<?php echo $this->plugin_name; ?> [calendarViewMode]" value="month" <?php checked($monthRadioChecked, 1); ?>/>
                        <sapn>Month</sapn>
                    </label>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_calendarViewMode">
                        <input type="radio" id="<?php echo $this->plugin_name; ?>_calendarViewMode" name="<?php echo $this->plugin_name; ?> [calendarViewMode]" value="week" <?php checked($weekRadioChecked, 1); ?>/>
                        <sapn>Week</sapn>
                    </label>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_calendarViewMode">
                        <input type="radio" id="<?php echo $this->plugin_name; ?>_calendarViewMode" name="<?php echo $this->plugin_name; ?> [calendarViewMode]" value="agenda" <?php checked($agendaRadioChecked, 1); ?>/>
                        <sapn>Agenda</sapn>
                    </label>
                </td>
            </tr>


        </table>
        <br>
        <br>
        <table width="500px">
            <tr>
                <td width="250px">
                    <input class="button-primary" type="submit" name="saveOptionsBTN" value="Save Options" />
                </td>
                
                <td width="250px">
                    <input class="button-primary" type="submit" name="editRoomsBTN" value="Edit Rooms"  />
                </td>
            </tr>
            
        </table>
        
        

    </div>
    
    
<?php

}


?>




