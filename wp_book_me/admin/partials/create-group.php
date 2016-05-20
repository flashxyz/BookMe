<?php

$groupID = $_GET["group_id"];

global $wpdb;

$group_options_table = $wpdb->prefix . "bookme_group_options";
$rooms_options_table = $wpdb->prefix . "bookme_rooms_options";

$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '$group_options_table'");
$nextID = $last->Auto_increment;

//check if the group already exist (FIX BUG: refreshing page creating another group)
if($nextID != $groupID)
    return;

$defaultGroupName = "Group " . $groupID;
$defaultNumOfRooms = 1;
$defaultViewMode = "month";
$defaultCalendarColor = "#000000";
$defaultWindowTimeLength = 60;


$wpdb->insert($group_options_table, array(
    'id' => '',
    'groupName' => $defaultGroupName,
    'numOfRooms' => $defaultNumOfRooms,
    'viewMode' => $defaultViewMode,
    'calendarColor' => $defaultCalendarColor,
    'windowTimeLength' => $defaultWindowTimeLength
));


$defaultRoomName = "Room 1";
$defaultIsActive = 1;

$wpdb->insert($rooms_options_table, array(
    'roomId' => '',
    'groupId' => $groupID,
    'roomName' => $defaultRoomName,
    'isActive' => $defaultIsActive

));


?>