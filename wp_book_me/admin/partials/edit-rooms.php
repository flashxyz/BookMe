    <?php

$groupID = $_GET["group_id"];



if($_GET['group_id']==true AND $_GET['edit_rooms']==true)
{
    global $wpdb;

    //get room tables from sql
    $rooms_options_table = $wpdb->prefix . "bookme_rooms_options";

    $selectSQL = $wpdb->get_results( "SELECT * FROM $rooms_options_table WHERE groupId = '$groupID'" );


    //get group table from SQL
    $group_options_table = $wpdb->prefix . "bookme_group_options";

    $selectSQLGroup = $wpdb->get_results($wpdb->prepare("SELECT * FROM $group_options_table WHERE id = %d", $groupID));

    //get active days from group
    $activeDays = unserialize($selectSQLGroup[0]->activeDays);

    $sundayChecked = $activeDays["sunday"];
    $mondayChecked = $activeDays["monday"];
    $tuesdayChecked = $activeDays["tuesday"];
    $wednesdayChecked = $activeDays["wednesday"];
    $thursdayChecked = $activeDays["thursday"];
    $fridayChecked = $activeDays["friday"];
    $saturdayChecked = $activeDays["saturday"];

    //decide if it's disabled or not
    $disableSunday = $sundayChecked?'':'disabled="disabled"';
    $disableMonday = $mondayChecked?'':'disabled="disabled"';
    $disableTuesday = $tuesdayChecked?'':'disabled="disabled"';
    $disableWednesday = $wednesdayChecked?'':'disabled="disabled"';
    $disableThursday = $thursdayChecked?'':'disabled="disabled"';
    $disableFriday = $fridayChecked?'':'disabled="disabled"';
    $disableSaturday = $saturdayChecked?'':'disabled="disabled"';


    //get group time constrains
    $fromTime = $selectSQLGroup[0]->fromTime;
    $toTime = $selectSQLGroup[0]->toTime;



    ?>

    <!--those hidden fields will contain the time restrictions for the JQUERY functions-->
    <input type="hidden" id="<?php echo $this->plugin_name; ?>_from_time_hidden" value="<?php echo $fromTime ?>">
    <input type="hidden" id="<?php echo $this->plugin_name; ?>_to_time_hidden" value="<?php echo $toTime ?>">
    <!--  --  -->
    
    <div class="wrap">

        <h1>Edit Rooms</h1>
        <hr>
        <h2>Group ID: <?php echo $groupID ?> </h2>
        <br>
        <form  action="" method="post" id="<?php echo $this->plugin_name; ?>_editRoomsSaveAllForm">

            <?php $roomIndex = 0; ?>
            <!--create row for each room we have-->
            <?php foreach($selectSQL as $value)
    		{
                $roomIndex++;
				$group_id = $value -> groupId;

                $room_id = $value -> roomId;

				if ($roomIndex % 2 != 0)
				{
					$backgroundColor = "#DFDFDF";
				}
				else
				{
					$backgroundColor = "#ECECEC";
				}    ?>
    
				<table width='635px' style='border: 1px solid <?php echo $backgroundColor ?>;background-color:<?php echo $backgroundColor ?>'>
				<tr style='background-color:<?php echo $backgroundColor ?>'>
                    <td style='padding-left:20px;width:100px;' ><p>Room <?php echo $roomIndex ?> </p></td>
                    <td align='center'>
                        <table width='400px'>
                            <tr>
                                <td width='200px'>
                                    <p>Room Name: </p>
                                </td>
                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionName">
                                        <input type="text" id="<?php echo $this->plugin_name; ?>_roomOptionName" class="<?php echo $this->plugin_name; ?>_roomOptionName" name="<?php echo $this->plugin_name; ?>[roomOptionName]" value="<?php echo $value->roomName; ?>"/>
                                    </label>
                                </td>


                            <tr>
                                <td width='200px'>
                                     <span>Room Capacity: </span>
                                </td>
                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionCapacity">
                                        <input type="number" id="<?php echo $this->plugin_name; ?>_roomOptionCapacity" class="<?php echo $this->plugin_name; ?>_roomOptionCapacity" name="<?php echo $this->plugin_name; ?>[roomOptionCapacity]" value="<?php echo $value->capacity; ?>"/>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td width='200px'>
                                    <span>Room available from: </span>
                                </td>
                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionFromTime">
                                        <input type="text" id="<?php echo $this->plugin_name; ?>_roomOptionFromTime" class="<?php echo $this->plugin_name; ?>_time_picker_r" name="<?php echo $this->plugin_name; ?>[roomOptionFromTime]" value=""/>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td width='200px'>
                                    <span>Room available until: </span>
                                </td>
                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionUntilTime">
                                        <input type="text" id="<?php echo $this->plugin_name; ?>_roomOptionUntilTime" class="<?php echo $this->plugin_name; ?>_time_picker_r" name="<?php echo $this->plugin_name; ?>[roomOptionUntilTime]" value=""/>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td width='200px'>
                                    <span>Services: </span>
                                </td>
                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionServices">
                                        <input type="text" id="<?php echo $this->plugin_name; ?>_roomOptionServices" class="<?php echo $this->plugin_name; ?>_roomOptionServices" name="<?php echo $this->plugin_name; ?>[roomOptionServices]" value="<?php echo $value->services; ?>"/>
                                    </label>
                                </td>
                            </tr>

                            <tr>
                                <td width='200px'>
                                    <span>Description: </span>
                                </td>
                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionDescription">
                                        <input type="text" id="<?php echo $this->plugin_name; ?>_roomOptionDescription" class="<?php echo $this->plugin_name; ?>_roomOptionDescription" name="<?php echo $this->plugin_name; ?>[roomOptionDescription]" value="<?php echo $value->description; ?>"/>
                                    </label>
                                </td>
                            </tr>

                            <tr>
                                <td width='200px'>
                                    <span>Active Room: </span>
                                </td>

                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionIsActive">
                                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_roomOptionIsActive" name="<?php echo $this->plugin_name; ?>[roomOptionIsActive]" value="1" <?php checked($value->isActive, 1); ?>/>
                                    </label>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <hr>
                        <span>Active days of the week: </span><hr>
                        <table width='400px'>
                            <tr>
                                <td width='100px' >
                                    <label for="<?php echo $this->plugin_name; ?>_activeSunday">
                                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeSunday" name="<?php echo $this->plugin_name; ?>[activeSunday]" value="1" <?php echo $disableSunday ?> <?php checked($sundayChecked, 1); ?>/>
                                        <sapn>Sunday</sapn>
                                    </label>
                                </td>
                                <td width='100px' >
                                    <label for="<?php echo $this->plugin_name; ?>_activeMonday">
                                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeMonday" name="<?php echo $this->plugin_name; ?>[activeMonday]" value="1" <?php echo $disableMonday ?> <?php checked($mondayChecked, 1); ?>/>
                                        <sapn>Monday</sapn>
                                    </label>
                                </td>
                                <td width='100px' >
                                    <label for="<?php echo $this->plugin_name; ?>_activeTuesday">
                                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeTuesday" name="<?php echo $this->plugin_name; ?>[activeTuesday]" value="1" <?php echo $disableThursday ?> <?php checked($tuesdayChecked, 1); ?>/>
                                        <sapn>Tuesday</sapn>
                                    </label>
                                </td>
                                <td width='100px' >
                                    <label for="<?php echo $this->plugin_name; ?>_activeWednesday">
                                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeWednesday" name="<?php echo $this->plugin_name; ?>[activeWednesday]" value="1" <?php echo $disableWednesday ?> <?php checked($wednesdayChecked, 1); ?>/>
                                        <sapn>Wednesday</sapn>
                                    </label>
                                </td>
                            </tr>

                            <tr>
                                <td width='100px' >
                                    <label for="<?php echo $this->plugin_name; ?>_activeThursday">
                                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeThursday" name="<?php echo $this->plugin_name; ?>[activeThursday]" value="1" <?php echo $disableThursday ?> <?php checked($thursdayChecked, 1); ?>/>
                                        <sapn>Thursday</sapn>
                                    </label>
                                </td >
                                <td width='100px' >
                                    <label for="<?php echo $this->plugin_name; ?>_activeFriday">
                                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeFriday" name="<?php echo $this->plugin_name; ?>[activeFriday]" value="1" <?php echo $disableFriday ?> <?php checked($fridayChecked, 1); ?>/>
                                        <sapn>Friday</sapn>
                                    </label>
                                </td>
                                <td width='100px'>
                                    <label for="<?php echo $this->plugin_name; ?>_activeSaturday">
                                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeSaturday" name="<?php echo $this->plugin_name; ?>[activeSaturday]" value="1" <?php echo $disableSaturday ?> <?php checked($saturdayChecked, 1); ?>/>
                                        <sapn>Saturday</sapn>
                                    </label>
                                </td>
                            </tr>
                        </table>

                    </td>

                    <td align="center"><p><form action="" method="POST" ><input type="hidden" name="room_id" value="<?php echo  $value->roomId ?>">
                            <input type="hidden" name="page" value="wp_book_me"><input name="" value="Save" type="Submit" class="button-secondary" style = "background-color:#BBEEAA;"></form></p></td>
                    <td align="center"><p><form action="" method="get" ><input type="hidden" name="room_id" value="<?php echo $value->roomId ?>">
                            <input type="hidden" name="delete" value="true"><input type="button" onClick="return checkMe(<?php echo  $value->roomId ?>)" value="Delete" class="button-secondary" style = "background-color:#FF8181;"></form></p></td>

                </tr>
				</table>
            <?php
            }
            ?>
        <br>
        <br>
        <table width="500px">
            <tr>
                <td width="150px">
                    <input class="button-primary" type="submit" name="saveOptionsBTN" value="Save All" />
         </form>
                </td>

                <td width="200px">
                    <form  action="?page=wp_book_me&group_id=<?php echo $groupID ?>&create_room=true&edit_rooms=true" method="post" id="<?php echo $this->plugin_name; ?>_editRoomsNewRoomForm">
                        <input class="button-primary" type="submit" name="editRoomsBTN" value="Create New Room"  />
                    </form>
                </td>
                <td width="150px">
                    <form  action="?page=wp_book_me&group_id=<?php echo $groupID ?>&edit_group=true" method="post" id="<?php echo $this->plugin_name; ?>_editRoomsGoBackForm">
                        <input class="button-primary" type="submit" name="goBackBTN" value="Go Back"/>
                    </form>
                </td>
            </tr>

        </table>
    </div>



<?php

}

?>