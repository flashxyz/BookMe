<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nir
 * Date: 04/06/2016
 * Time: 18:30
 */

//include WP content
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

global $wpdb;

//get reservation table
$room_reservation_table = $wpdb->prefix . "bookme_room_reservation";

//room SQL table
$room_options_table = $wpdb->prefix . "bookme_rooms_options";


if($_POST[addRes] == true)
{

    $groupId = $_POST['group'];
    $roomId = $_POST['room'];
    $userId = $_POST['userId'];
    $startTimeString = $_POST['startString'];
    $endTimeString = $_POST['endString'];
    $dateString = $_POST['dateString'];
    $startTimeDouble = $_POST['startTimeDouble'];
    $endTimeDouble = $_POST['endTimeDouble'];



    //execute the insert new row query
    $wpdb->insert($room_reservation_table, array(
        'reservationId' => '',
        'groupId' => $groupId,
        'roomId' => $roomId,
        'userId' => $userId,
        'startTime' => $startTimeString,
        'endTime' => $endTimeString,
        'resDate' => $dateString,
        'startDoubleTime' => $startTimeDouble,
        'endDoubleTime' => $endTimeDouble

    ));

    //get last added row
    $selectSQL_lastAddedRow =  $wpdb->get_results( "SELECT * FROM $room_reservation_table WHERE groupId = '$groupId' AND userId = '$userId' AND roomId = '$roomId' AND startTime = '$startTimeString' AND endTime = '$endTimeString'" );
    //return row to calendar
    echo $selectSQL_lastAddedRow[0]->reservationId;


    


}

if($_POST[checkRes] == true)
{
    $groupId = $_POST['group'] ;
    $userId = $_POST['userId'] ;
    $startTime = $_POST['start'] ;
    $endTime = $_POST['end'] ;

    //get rooms with free space. -> we need to create occupied SQL field and update it every time
    //$selectSQL_reservation = $wpdb->get_results( "SELECT * FROM $rooms_reservation_table WHERE groupId = '$groupId' AND capacity < occupied" );
    
    
    //check from available rooms the services we need!
    //...
    
    
    
    //here we need to add every optional room id to an array and and return it.
    $rooms_array = [];
    $index = 0;
//    while ($index < sizeof($rooms_array)) {
//
//        $rCell[0] = $selectSQL_reservation[$index]->roomId;
//        $rCell[1] = $selectSQL_reservation[$index]->startTime;
//        $rCell[2] = $selectSQL_reservation[$index]->endTime;
//        array_push($reservation_array, $resCell);
//        $index++;
//    }
    //check if room is available at this time


    //return list of rooms


}

if($_POST[delRes] == true)
{
    $eventId = $_POST['event_id'] ;

    //execute the delete query of the group id we want to delete
    $wpdb->query( $wpdb->prepare( " DELETE FROM $room_reservation_table WHERE reservationId = %d", $eventId));

}

if($_POST[getReservationArray] == true)
{
    $groupID = $_POST['groupId'] ;
    $userID = $_POST['userId'] ;



    //get all reservations for this user id,group
    $selectSQL_reservation = $wpdb->get_results($wpdb->prepare("SELECT * FROM $room_reservation_table WHERE groupId = %d AND userId = %d ", $groupID, $userID));
    $numberOfReservation = sizeof($selectSQL_reservation);

    //get rooms
    $selectSQL_rooms = $wpdb->get_results($wpdb->prepare("SELECT * FROM $room_options_table WHERE groupId = %d", $groupID));


    //add rooms to array
    $index = 0;
    $roomsArray = [];
    $selectSQL_rooms[$index];
    $numberOfRooms = sizeof($selectSQL_rooms);

    //map of room names by id
    $roomArrayById = array();

    while ($index < $numberOfRooms) {
        $roomCell[0] = $selectSQL_rooms[$index]->roomId;
        $roomCell[1] = $selectSQL_rooms[$index]->roomName;
        $roomArrayById[$roomCell[0]] = $roomCell[1];
        $index++;
    }

    //add all reservations for this user to an array
    $reservation_array = [];
    $index = 0;
    while ($index < $numberOfReservation) {
        $resCell[0] = $selectSQL_reservation[$index]->roomId;
        $resCell[1] = $selectSQL_reservation[$index]->startTime;
        $resCell[2] = $selectSQL_reservation[$index]->endTime;
        $resCell[3] = $selectSQL_reservation[$index]->reservationId;
        $resCell[4] = $roomArrayById[$resCell[0]];
        array_push($reservation_array, $resCell);
        $index++;
    }

    echo json_encode($reservation_array);
    //echo "hello";
}

if($_POST[getReservationArrayByUser] == true)
{
    $userID = $_POST['userId'] ;

    $selectSQL_reservation_byUser = $wpdb->get_results($wpdb->prepare("SELECT * FROM $room_reservation_table WHERE userId = %d ", $userID));
    $numberOfReservationByUser = sizeof($selectSQL_reservation_byUser);

    //add all reservations for this user to an array
    $reservation_array_byUser = [];
    $index = 0;

    while ($index < $numberOfReservationByUser) {
        $resCell[0] = $selectSQL_reservation_byUser[$index]->roomId;
        $resCell[1] = $selectSQL_reservation_byUser[$index]->startTime;
        $resCell[2] = $selectSQL_reservation_byUser[$index]->endTime;
        $resCell[3] = $selectSQL_reservation_byUser[$index]->reservationId;
        array_push($reservation_array_byUser, $resCell);
        $index++;
    }

    echo json_encode($reservation_array_byUser);



}


?>




