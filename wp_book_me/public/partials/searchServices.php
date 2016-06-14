<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

global $wpdb;

//get rooms table
$rooms_options_table = $wpdb->prefix . "bookme_rooms_options";



if($_POST[searchByRoomId] == true) {
    $servicesArray = $_POST['servicesArray'];
    $roomID = $_POST['roomId'];
    $groupID = $_POST['groupId'];

    $selectSQL_roomService =  $wpdb->get_results( "SELECT * FROM $rooms_options_table WHERE groupId = '$groupID'" );

    foreach($selectSQL_roomService as $value)
    {
        $roomIDa = $value -> roomId;
        if($roomID == $roomIDa)
        {
            $servicesOfRoomServices= unserialize($value -> services);
            $services = array();
            $s = 0;
            for($i =0; $i < sizeof($servicesArray); $i++)
            {
                if($servicesOfRoomServices[$servicesArray[$i]] == 1)
                    array_push($services, $servicesArray[$i]);
            }
        }
    }
       echo json_encode($services);
}
