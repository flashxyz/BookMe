<?php

$groupID = $_GET["group_id"];


if($_GET['group_id']==true AND $_GET['edit_group']==true)
{

    global $wpdb;

    $group_options_table = $wpdb->prefix . "bookme_group_optinos";

    $selectSQL = $wpdb->get_results( "SELECT * FROM $group_options_table WHERE id = '$groupID'" );


    
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
                        <input type="text" id="<?php echo $this->plugin_name; ?>_groupName" name="<?php echo $this->plugin_name; ?> [groupName]" value="text"/>
                    </label>
                </td>
            </tr>

            <tr>
                <td width='250px' >
                    <span>Number of rooms: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_numOfRooms">
                        <input type="number" id="<?php echo $this->plugin_name; ?>_numOfRooms" name="<?php echo $this->plugin_name; ?> [numOfRooms]" min="0" value="0"/>
                    </label>
                </td>
            </tr>

            <tr>
                <td width='250px' >
                    <span>Rooms available from: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_roomsAvailableFrom">
                        <input type="text" id="<?php echo $this->plugin_name; ?>_roomsAvailableFrom" name="<?php echo $this->plugin_name; ?> [roomsAvailableFrom]" min="0" value="0"/>
                    </label>
                </td>

                <td width='250px' align="right">
                    <span>Until: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_roomsAvailableUntil">
                        <input type="text" id="<?php echo $this->plugin_name; ?>_roomsAvailableUntil" name="<?php echo $this->plugin_name; ?> [roomsAvailableUntil]" min="0" value="0"/>
                    </label>
                </td>

            </tr>

            <tr>
                <td width='250px' >
                    <span>Group Description: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_groupDescription">
                        <input type="text" id="<?php echo $this->plugin_name; ?>_groupDescription" name="<?php echo $this->plugin_name; ?> [groupDescription]" rows="3"/>
                    </label>
                </td>
            </tr>

            <tr>
                <td width='250px' >
                    <span>Calendar Color: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_calendarColor">
                        <input type="text" id="<?php echo $this->plugin_name; ?>_calendarColor" name="<?php echo $this->plugin_name; ?> [calendarColor]"/>
                    </label>
                </td>
            </tr>
            <tr>
                <td width='250px' >
                    <span>Time Slot Duration: </span>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_timeSlot">
                        <input type="number" id="<?php echo $this->plugin_name; ?>_timeSlot" name="<?php echo $this->plugin_name; ?> [timeSlot]" value="60" min="0" step="15"/>
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
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeSunday" name="<?php echo $this->plugin_name; ?> [activeSunday]" value="1" <?php checked($cleanup, 1); ?>/>
                        <sapn>Sunday</sapn>
                    </label>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeMonday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeMonday" name="<?php echo $this->plugin_name; ?> [activeMonday]" value="1" <?php checked($cleanup, 1); ?>/>
                        <sapn>Monday</sapn>
                    </label>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeTuesday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeTuesday" name="<?php echo $this->plugin_name; ?> [activeTuesday]" value="1" <?php checked($cleanup, 1); ?>/>
                        <sapn>Tuesday</sapn>
                    </label>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeWednesday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeWednesday" name="<?php echo $this->plugin_name; ?> [activeWednesday]" value="1" <?php checked($cleanup, 1); ?>/>
                        <sapn>Wednesday</sapn>
                    </label>
                </td>
            </tr>

            <tr>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeThursday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeThursday" name="<?php echo $this->plugin_name; ?> [activeThursday]" value="1" <?php checked($cleanup, 1); ?>/>
                        <sapn>Thursday</sapn>
                    </label>
                </td >
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_activeFriday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeFriday" name="<?php echo $this->plugin_name; ?> [activeFriday]" value="1" <?php checked($cleanup, 1); ?>/>
                        <sapn>Friday</sapn>
                    </label>
                </td>
                <td width='100px'>
                    <label for="<?php echo $this->plugin_name; ?>_activeSaturday">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeSaturday" name="<?php echo $this->plugin_name; ?> [activeSaturday]" value="1" <?php checked($cleanup, 1); ?>/>
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
                        <input type="radio" id="<?php echo $this->plugin_name; ?>_calendarViewMode" name="<?php echo $this->plugin_name; ?> [calendarViewMode]" value="month" <?php checked($cleanup, 1); ?>/>
                        <sapn>Month</sapn>
                    </label>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_calendarViewMode">
                        <input type="radio" id="<?php echo $this->plugin_name; ?>_calendarViewMode" name="<?php echo $this->plugin_name; ?> [calendarViewMode]" value="week" <?php checked($cleanup, 1); ?>/>
                        <sapn>Week</sapn>
                    </label>
                </td>
                <td width='100px' >
                    <label for="<?php echo $this->plugin_name; ?>_calendarViewMode">
                        <input type="radio" id="<?php echo $this->plugin_name; ?>_calendarViewMode" name="<?php echo $this->plugin_name; ?> [calendarViewMode]" value="agenda" <?php checked($cleanup, 1); ?>/>
                        <sapn>Agenda</sapn>
                    </label>
                </td>
            </tr>


        </table>

    </div>
    
    
<?php

}


?>




