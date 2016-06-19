    <?php

$groupID = $_GET["group_id"];



if($_GET['group_id']==true AND $_GET['edit_rooms']==true)
{
    global $wpdb;

    //get room tables from sql
    $rooms_options_table = $wpdb->prefix . "bookme_rooms_options";

    $selectSQL = $wpdb->get_results( "SELECT * FROM $rooms_options_table WHERE groupId = '$groupID'" );

    if(empty($selectSQL)){
        echo 'Please Wait...';
        ?>
        <script>
            location.reload();
        </script>
        <?php
    }

    $numberOfRooms = sizeof($selectSQL);

    $index = 0;
    $roomsArray = array();

    while ($index < $numberOfRooms) {
        $roomsArray[$index] = $selectSQL[$index]->roomId;
        $index++;
    }

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

    $services = unserialize($selectSQLGroup[0] -> services);

    ?>

    <!--those hidden fields will contain the time restrictions for the JQUERY functions-->
    <!--
    <input type="hidden" id="<?php echo $this->plugin_name; ?>_from_time_hidden" value="<?php echo $fromTime ?>">
    <input type="hidden" id="<?php echo $this->plugin_name; ?>_to_time_hidden" value="<?php echo $toTime ?>">
    -->
    
    <div class="wrap">

        <h1>Edit Rooms</h1>
        <hr>
        <h2>Group ID: <?php echo $groupID ?> </h2>
        <br>
<!--        <form  action="" method="post" id="--><?php //echo $this->plugin_name; ?><!--_editRoomsSaveAllForm">-->

            <?php $roomIndex = 0; ?>
            <!--create row for each room we have-->
            <?php foreach($selectSQL as $value)
    		{
                $roomIndex++;
				$group_id = $value -> groupId;

                $ActiveRoomDaysByID = unserialize($value -> activeDays);
                $servicesByID = unserialize($value -> services);

                $sundayCheckedRoomByID = $ActiveRoomDaysByID["sunday"];
                $mondayCheckedRoomByID = $ActiveRoomDaysByID["monday"];
                $tuesdayCheckedRoomByID = $ActiveRoomDaysByID["tuesday"];
                $wednesdayCheckedRoomByID = $ActiveRoomDaysByID["wednesday"];
                $thursdayCheckedRoomByID = $ActiveRoomDaysByID["thursday"];
                $fridayCheckedRoomByID = $ActiveRoomDaysByID["friday"];
                $saturdayCheckedRoomByID = $ActiveRoomDaysByID["saturday"];

                $room_id = $value -> roomId;

				if ($roomIndex % 2 != 0)
				{
					$backgroundColor = "#DFDFDF";
				}
				else
				{
					$backgroundColor = "#ECECEC";
				}    ?>

                <form  action="?page=wp_book_me&group_id=<?php echo $groupID ?>&save_room=true&room_id=<?php echo$room_id ?>" method="post" id="<?php echo $this->plugin_name; ?>_RoomsSaveForm_<?php echo $room_id; ?>" class="<?php echo $this->plugin_name; ?>_RoomsSaveForm">
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
                                            <input type="text" class="<?php echo $this->plugin_name; ?>_roomOptionName" id="<?php echo $this->plugin_name; ?>_roomOptionName_<?php echo $room_id; ?>" class="<?php echo $this->plugin_name; ?>_roomOptionName" name="<?php echo $this->plugin_name; ?>[roomOptionName_<?php echo $room_id; ?>]" value="<?php echo $value->roomName; ?>" minlength="3"  maxlength="40"/>
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td width='200px'>
                                         <span>Room Capacity: </span>
                                    </td>
                                    <td width='200px'>
                                        <label for="<?php echo $this->plugin_name; ?>_roomOptionCapacity">
                                            <input class="<?php echo $this->plugin_name; ?>_roomOptionCapacity" type="number" id="<?php echo $this->plugin_name; ?>_roomOptionCapacity_<?php echo $room_id; ?>" class="<?php echo $this->plugin_name; ?>_roomOptionCapacity" name="<?php echo $this->plugin_name; ?>[roomOptionCapacity_<?php echo $room_id; ?>]" value="<?php echo $value->capacity; ?>" min="1" max="9999"/>
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td width='200px'>
                                        <span>Description: </span>
                                    </td>
                                    <td width='200px'>
                                        <label for="<?php echo $this->plugin_name; ?>_roomOptionDescription">
                                            <textarea id="<?php echo $this->plugin_name; ?>_roomOptionDescription_<?php echo $room_id; ?>" class="<?php echo $this->plugin_name; ?>_roomOptionDescription" name="<?php echo $this->plugin_name; ?>[roomOptionDescription_<?php echo $room_id; ?>]" cols="20" rows="3" maxlength="99" ><?php echo $value->description; ?></textarea>
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td width='200px'>
                                        <span>Active Room: </span>
                                    </td>

                                    <td width='200px'>
                                        <label for="<?php echo $this->plugin_name; ?>_roomOptionIsActive_<?php echo $room_id; ?>">
                                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_roomOptionIsActive_<?php echo $room_id; ?>" name="<?php echo $this->plugin_name; ?>[roomOptionIsActive_<?php echo $room_id; ?>]" value="1" <?php checked($value->isActive, 1); ?>/>
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
                                        <label for="<?php echo $this->plugin_name; ?>_activeSunday_<?php echo $room_id; ?>">
                                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeSunday_<?php echo $room_id; ?>" name="<?php echo $this->plugin_name; ?>[activeSunday_<?php echo $room_id; ?>]" value="1" <?php echo $disableSunday ?> <?php checked($sundayCheckedRoomByID, 1); ?>/>
                                            <sapn>Sunday</sapn>
                                        </label>
                                    </td>
                                    <td width='100px' >
                                        <label for="<?php echo $this->plugin_name; ?>_activeMonday_<?php echo $room_id; ?>">
                                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeMonday_<?php echo $room_id; ?>" name="<?php echo $this->plugin_name; ?>[activeMonday_<?php echo $room_id; ?>]" value="1" <?php echo $disableMonday ?> <?php checked($mondayCheckedRoomByID, 1); ?>/>
                                            <sapn>Monday</sapn>
                                        </label>
                                    </td>
                                    <td width='100px' >
                                        <label for="<?php echo $this->plugin_name; ?>_activeTuesday">
                                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeTuesday_<?php echo $room_id; ?>" name="<?php echo $this->plugin_name; ?>[activeTuesday_<?php echo $room_id; ?>]" value="1" <?php echo $disableTuesday ?> <?php checked($tuesdayCheckedRoomByID, 1); ?>/>
                                            <sapn>Tuesday</sapn>
                                        </label>
                                    </td>
                                    <td width='100px' >
                                        <label for="<?php echo $this->plugin_name; ?>_activeWednesday_<?php echo $room_id; ?>">
                                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeWednesday_<?php echo $room_id; ?>" name="<?php echo $this->plugin_name; ?>[activeWednesday_<?php echo $room_id; ?>]" value="1" <?php echo $disableWednesday ?> <?php checked($wednesdayCheckedRoomByID, 1); ?>/>
                                            <sapn>Wednesday</sapn>
                                        </label>
                                    </td>
                                </tr>

                                <tr>
                                    <td width='100px' >
                                        <label for="<?php echo $this->plugin_name; ?>_activeThursday_<?php echo $room_id; ?>">
                                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeThursday_<?php echo $room_id; ?>" name="<?php echo $this->plugin_name; ?>[activeThursday_<?php echo $room_id; ?>]" value="1" <?php echo $disableThursday ?> <?php checked($thursdayCheckedRoomByID, 1); ?>/>
                                            <sapn>Thursday</sapn>
                                        </label>
                                    </td >
                                    <td width='100px' >
                                        <label for="<?php echo $this->plugin_name; ?>_activeFriday_<?php echo $room_id; ?>">
                                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeFriday_<?php echo $room_id; ?>" name="<?php echo $this->plugin_name; ?>[activeFriday_<?php echo $room_id; ?>]" value="1" <?php echo $disableFriday ?> <?php checked($fridayCheckedRoomByID, 1); ?>/>
                                            <sapn>Friday</sapn>
                                        </label>
                                    </td>
                                    <td width='100px'>
                                        <label for="<?php echo $this->plugin_name; ?>_activeSaturday_<?php echo $room_id; ?>">
                                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeSaturday_<?php echo $room_id; ?>" name="<?php echo $this->plugin_name; ?>[activeSaturday_<?php echo $room_id; ?>]" value="1" <?php echo $disableSaturday ?> <?php checked($saturdayCheckedRoomByID, 1); ?>/>
                                            <sapn>Saturday</sapn>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                            <br>

                            <?php
                                //check if there are services to show
                                //if there are services so write "Services: " label
                                if(sizeof($services) > 0)
                                {
                                    ?>
                                    <hr>
                                    <span>Services: </span>
                                    <hr>
                                <?php
                                }



                            //show group services
                            $serviceIndex = 0;
                            foreach($services as $serv)
                            {
                             ?>
                            <table width='400px'>
                                <tr>
                                    <td width='100px' >
                                        <label for="<?php echo $this->plugin_name; ?>_room_<?php echo $room_id; ?>_service_<?php echo $serviceIndex; ?>">
                                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_room_<?php echo $room_id; ?>_service_<?php echo $serviceIndex; ?>" name="<?php echo $this->plugin_name; ?>[room_<?php echo $room_id; ?>_service_<?php echo $serviceIndex; ?>]" value="1" <?php checked($servicesByID[$serv], 1); ?>/>
                                            <sapn> <?php echo $serv?> </sapn>
                                        </label>
                                    </td>
                                </tr>
                            </table>
                            <?php
                                $serviceIndex++;
                            }?>
                        </td>

                        <td align="center">

    <!--                        ?page=wp_book_me&group_id=<?php echo $groupID ?>&save_room=true&room_id=<?php echo$room_id ?>

                            <form  action="EEEE" method="post" id="<?php echo $this->plugin_name; ?>_editRoomsSaveForm_<?php echo $room_id; ?>">
                                <input class="button-secondary" type="submit" name="saveRoomBTN" value="save" style = "background-color:#BBEEAA;" />
                            </form>
-->
                            <input class="button-secondary"  type="submit" name="saveRoomBTN_<?php echo$room_id ?>" value="Save" style = "background-color:#BBEEAA;" />
                        </td>
                </form>
                        <td align="center">

                            <form  action="?page=wp_book_me&group_id=<?php echo $groupID ?>&delete_room=true&room_id=<?php echo$room_id ?>" method="post" id="<?php echo $this->plugin_name; ?>_editRoomsGoBackForm">
                                <input class="button-secondary" type="submit" name="deleteBTN_<?php echo $value->roomId ?>" value="Delete" style = "background-color:#FF8181;"/>
                            </form>

                            <!--

                            <form action="DEL" method="get" ><input type="hidden" name="room_id" value="<?php echo $value->roomId ?>">
                                <input type="hidden" name="delete" value="true"><input type="button" onClick="return checkMe(<?php echo  $value->roomId ?>)" value="Delete" class="button-secondary" style = "background-color:#FF8181;"></form></p>
                            -->
                        </td>

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
                    <input class="button-primary" type="button" id="saveAllOptionsBTN" value="Save All" onclick="return saveAll()"/>
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

<script>

    function saveAll() {

        var numOfRooms = <?php echo json_encode($roomsArray );?>;
        for(var i=0; i < numOfRooms.length; i++)
        {
            var formID = "#wp_book_me_RoomsSaveForm_" + numOfRooms[i];
            $.post($(formID).attr("action"), $(formID).serialize());
        }

    }
</script>
