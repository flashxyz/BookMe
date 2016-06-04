<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nir
 * Date: 04/06/2016
 * Time: 18:30
 */

global $wpdb;

echo var_dump( $wpdb );

$groupId = $_POST['group1'] ;
$roomId = $_POST['room1'] ;
$userId = $_POST['userId'] ;
$startTime = $_POST['start1'] ;
$endTime = $_POST['end1'] ;


//get the table name we want to work with
$rooms_reservation_table = $wpdb->prefix . "bookme_room_reservation";

$rooms_options_table = $wpdb->prefix . "bookme_rooms_options";


$selectSQL = $wpdb->get_results( "SELECT * FROM $rooms_options_table WHERE groupId = '$groupId'" );

echo $selectSQL[0];

//get the next id of SQL Auto_increment generator
//$last = $wpdb->get_row("SHOW TABLE STATUS LIKE '$rooms_reservation_table'");
//$nextID = $last->Auto_increment;


//execute the insert new row query
$wpdb->insert($rooms_reservation_table, array(
    'reservationId' => '1',
    'groupId' => $groupId,
    'roomId' => $roomId,
    'userId' => $userId,
    'startTime' => $startTime,
    'endTime' => $endTime

));




?>




