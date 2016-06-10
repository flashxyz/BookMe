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
$defaultCalendarColor = "#000000";
$defaultWindowTimeLength = 60;
$defaultReservationLimitation =1;
$defaultservices = serialize(array());


//initialize default serialize array oy full active days
$defaultActiveDays = serialize( array(
        'sunday' => '1',
        'monday' => '1',
        'tuesday' => '1',
        'wednesday' => '1',
        'thursday' => '1',
        'friday' => '1',
        'saturday' => '1'
    ));


//initialize default values for the from / until times
$defaultFromTime = "08:00";
$defaultToTime = "17:00";


//execute the insert new row query
$wpdb->insert($group_options_table, array(
    'id' => '',
    'groupName' => $defaultGroupName,
    'numOfRooms' => $defaultNumOfRooms,
    'activeDays' => $defaultActiveDays,
    'fromTime' => $defaultFromTime,
    'toTime' => $defaultToTime,
    'description' => '',
    'calendarColor' => $defaultCalendarColor,
    'windowTimeLength' => $defaultWindowTimeLength,
    'reservationLimitation' => $defaultReservationLimitation,
    'services' => $defaultservices
));



//initialize default values when creating new room
$defaultRoomName = "Room 1";
$defaultCapacity = 1;
$defaultServices = '';
$defaultIsActive = 1;
$defaultActiveDays = '';
$defaultDescription = '';


//execute the insert new row query
$wpdb->insert($rooms_options_table, array(
    'roomId' => '',
    'groupId' => $groupID,
    'roomName' => $defaultRoomName,
    'capacity' => $defaultCapacity,
    'services' => $defaultServices,
    'isActive' => $defaultIsActive,
    'activeDays' => $defaultActiveDays,
    'description' => $defaultDescription

));

?>