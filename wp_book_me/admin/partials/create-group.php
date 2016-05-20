<?php

//get the group id from the url parameters
$groupID = $_GET["group_id"];

global $wpdb;

//get the table name we want to work with
$group_options_table = $wpdb->prefix . "bookme_group_options";
$rooms_options_table = $wpdb->prefix . "bookme_rooms_options";


//get the next id of SQL Auto_increment generator
$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '$group_options_table'");
$nextID = $last->Auto_increment;

//check if the group already exist (FIX BUG: refreshing page creating another group)
if($nextID != $groupID)
    return;

//initialize default values when creating new group
$defaultGroupName = "Group " . $groupID;
$defaultNumOfRooms = 1;
$defaultViewMode = "month";
$defaultCalendarColor = "#000000";
$defaultWindowTimeLength = 60;


//execute the insert new row query
$wpdb->insert($group_options_table, array(
    'id' => '',
    'groupName' => $defaultGroupName,
    'numOfRooms' => $defaultNumOfRooms,
    'viewMode' => $defaultViewMode,
    'calendarColor' => $defaultCalendarColor,
    'windowTimeLength' => $defaultWindowTimeLength
));


//initialize default values when creating new room
$defaultRoomName = "Room 1";
$defaultIsActive = 1;


//execute the insert new row query
$wpdb->insert($rooms_options_table, array(
    'roomId' => '',
    'groupId' => $groupID,
    'roomName' => $defaultRoomName,
    'isActive' => $defaultIsActive

));



?>