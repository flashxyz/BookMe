<?php

$groupID = $_GET["group_id"];


if($_GET['group_id']==true AND $_GET['edit_group']==true)
{

    global $wpdb;

    $group_options_table = $wpdb->prefix . "bookme_group_options";
    
    $selectSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM $group_options_table WHERE id = %d", $groupID));

    if(empty($selectSQL)){
        echo 'Please Wait...';
        ?>
            <script>
                location.reload();
            </script>
        <?php
    }
    $groupName = $selectSQL[0]->groupName;
    $numOfRooms = $selectSQL[0]->numOfRooms;
    $activeDays = unserialize($selectSQL[0]->activeDays);
    $fromTime = $selectSQL[0]->fromTime;
    $toTime = $selectSQL[0]->toTime;
    $description = $selectSQL[0]->description;
    $calendarColor = $selectSQL[0]->calendarColor;
    $windowTimeLength = $selectSQL[0]->windowTimeLength;
    $reservationLimitation = $selectSQL[0]->reservationLimitation;
    $services = unserialize($selectSQL[0]->services);
    

    $sundayChecked = $activeDays["sunday"];
    $mondayChecked = $activeDays["monday"];
    $tuesdayChecked = $activeDays["tuesday"];
    $wednesdayChecked = $activeDays["wednesday"];
    $thursdayChecked = $activeDays["thursday"];
    $fridayChecked = $activeDays["friday"];
    $saturdayChecked = $activeDays["saturday"];

    $siteURL = get_site_url()."/wp-admin/admin.php";
    
    ?>
    
    <script type='text/javascript'>

        var siteURL = <?php echo json_encode($siteURL);?>;

        function addService()
        {
            var service=$('#wp_book_me_serviceBox').val();
            if(service == "")
                alert("Field is empty");
            else
            window.location.replace(siteURL+'?page=wp_book_me&group_id=' + <?php echo $groupID; ?> +'&add_service='+service);
        }

        function deleteService(index)
        {
            index += 1;
            window.location.replace(siteURL+'?page=wp_book_me&group_id=' + <?php echo $groupID; ?> +'&delete_service='+index);
        }
    </script>
    
    
    
    
    
    
    
    
    <div class="wrap">

        <h1>Rooms Group Options</h1>
        
        <hr>
        
        <h2>Group ID: <?php echo $groupID ?> </h2>

        <h2>Number of rooms:   <div class = "textDesign">  <?php echo $numOfRooms; ?> </div> </h2>

        <br>
        
        <form  action="?page=wp_book_me&group_id=<?php echo $groupID ?>&save_options=true" method="post" id="<?php echo $this->plugin_name; ?>_adminGroupOptionsForm">
            <table width='700px'>
                <tr>
                    <td width='250px' >
                        <span>Group name: </span>
                    </td>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_groupName">
                            <input type="text" id="<?php echo $this->plugin_name; ?>_groupName" name="<?php echo $this->plugin_name; ?>[groupName]" value="<?php echo $groupName; ?>"/>
                        </label>
                    </td>
                </tr>
    
                <tr>
                    <td width='250px' >
                        <span>Rooms available from: </span>
                    </td>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_roomsAvailableFrom">
                            <input type="text" class="<?php echo $this->plugin_name; ?>_time_picker" id="<?php echo $this->plugin_name; ?>_roomsAvailableFrom" name="<?php echo $this->plugin_name; ?>[roomsAvailableFrom]" value="<?php echo $fromTime; ?>"/>
                        </label>
                    </td>
    
                </tr>
    
                <tr>
                    <td width='250px'>
                        <span>Rooms available until: </span>
                    </td>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_roomsAvailableUntil">
                            <input type="text" class="<?php echo $this->plugin_name; ?>_time_picker" id="<?php echo $this->plugin_name; ?>_roomsAvailableUntil" name="<?php echo $this->plugin_name; ?>[roomsAvailableUntil]" value="<?php echo $toTime; ?>"/>
                        </label>
                    </td>
                </tr>
    
                <tr>
                    <td width='250px' >
                        <span>Group Description: </span>
                    </td>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_groupDescription">
                            <textarea id="<?php echo $this->plugin_name; ?>_groupDescription" name="<?php echo $this->plugin_name; ?>[groupDescription]" cols="20" rows="3" maxlength="99"><?php echo $description; ?></textarea>
                        </label>
                    </td>
                </tr>
    
                <tr>
                    <td width='250px' >
                        <span>Calendar Color: </span>
                    </td>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_calendarColor">
                            <input type="text" class="<?php echo $this->plugin_name; ?>_calendarColor_class"  id="<?php echo $this->plugin_name; ?>_calendarColor" name="<?php echo $this->plugin_name; ?>[calendarColor]" value="<?php echo $calendarColor; ?>"/>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td width='250px' >
                        <span>Time Slot Duration: </span>
                    </td>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_timeSlot">
                            <input type="number" id="<?php echo $this->plugin_name; ?>_timeSlot" name="<?php echo $this->plugin_name; ?>[timeSlot]" min="15" step="15" value="<?php echo $windowTimeLength; ?>"/>
                        </label>
                    </td>
                    <td width='250px' >
                        <span>minutes</span>
                    </td>
                </tr>
                <tr>
                    <td width='250px' >
                        <span>reservation limit: </span>
                    </td>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_reservationLimitation">
                            <input type="number" id="<?php echo $this->plugin_name; ?>_reservationLimitation" name="<?php echo $this->plugin_name; ?>[reservationLimitation]" min="1" step="1" value="<?php echo $reservationLimitation; ?>"/>
                        </label>
                    </td>
                    <td width='250px' >
                        <span>Time Slot</span>
                    </td>
                </tr>
    
    
            </table>


            <br><span>services: </span><hr>
            <input type="text" id="<?php echo $this->plugin_name; ?>_serviceBox" name="<?php echo $this->plugin_name; ?>[serviceBox]"/>

            <input class="button-primary" type="button" name="addServiceBTN" value="Add Service" onclick="return addService()"/>

            <br><br>

            <table width="300px">
                <?php

                for ($i = 0; $i < count($services); ++$i)
                {
                    ?>
                    <tr>
                        <td width="200px">
                            <span> <?php echo $services[$i]; ?></span>
                        </td>
                        <td width="100px">
                            <input class="button-secondary" type="button" name="deleteBTN" value="Delete" style = "background-color:#FF8181;" onclick="return deleteService(<?php echo $i; ?>)"/>
                        </td>
                    </tr>

                    <?php
                }

                ?>
            </table>
            
            
            <br><br><span>Active days of the week: </span><hr>
            <table width='400px'>
                <tr>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_activeSunday">
                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeSunday" name="<?php echo $this->plugin_name; ?>[activeSunday]" value="1" <?php checked($sundayChecked, 1); ?>/>
                            <sapn>Sunday</sapn>
                        </label>
                    </td>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_activeMonday">
                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeMonday" name="<?php echo $this->plugin_name; ?>[activeMonday]" value="1" <?php checked($mondayChecked, 1); ?>/>
                            <sapn>Monday</sapn>
                        </label>
                    </td>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_activeTuesday">
                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeTuesday" name="<?php echo $this->plugin_name; ?>[activeTuesday]" value="1" <?php checked($tuesdayChecked, 1); ?>/>
                            <sapn>Tuesday</sapn>
                        </label>
                    </td>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_activeWednesday">
                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeWednesday" name="<?php echo $this->plugin_name; ?>[activeWednesday]" value="1" <?php checked($wednesdayChecked, 1); ?>/>
                            <sapn>Wednesday</sapn>
                        </label>
                    </td>
                </tr>
    
                <tr>
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_activeThursday">
                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeThursday" name="<?php echo $this->plugin_name; ?>[activeThursday]" value="1" <?php checked($thursdayChecked, 1); ?>/>
                            <sapn>Thursday</sapn>
                        </label>
                    </td >
                    <td width='100px' >
                        <label for="<?php echo $this->plugin_name; ?>_activeFriday">
                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeFriday" name="<?php echo $this->plugin_name; ?>[activeFriday]" value="1" <?php checked($fridayChecked, 1); ?>/>
                            <sapn>Friday</sapn>
                        </label>
                    </td>
                    <td width='100px'>
                        <label for="<?php echo $this->plugin_name; ?>_activeSaturday">
                            <input type="checkbox" id="<?php echo $this->plugin_name; ?>_activeSaturday" name="<?php echo $this->plugin_name; ?>[activeSaturday]" value="1" <?php checked($saturdayChecked, 1); ?>/>
                            <sapn>Saturday</sapn>
                        </label>
                    </td>
                </tr>
            </table>

            <br>
            <br>
            <table width="450px">
                <tr>
                    <td width="150px">
                        <input class="button-primary" type="submit" name="saveOptionsBTN" value="Save Options" />
        </form>
                    </td>
    
                    <td width="150px">
                        <form  action="?page=wp_book_me&group_id=<?php echo $groupID ?>&edit_rooms=true" method="post" id="<?php echo $this->plugin_name; ?>_adminEditRoomsForm">
                            <input class="button-primary" type="submit" name="editRoomsBTN" value="Edit Rooms"  />
                        </form>
                    </td>
                    <td width="150px">
                        <form  action="?page=wp_book_me" method="post" id="<?php echo $this->plugin_name; ?>_editGroupGoBackForm">
                            <input class="button-primary" type="submit" name="goBackBTN" value="Go Back"/>
                        </form>
                    </td>
                </tr>
    
            </table>
            
            

        
        

    </div>
    
    
<?php

}


?>




