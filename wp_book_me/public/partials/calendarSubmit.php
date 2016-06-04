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

//get the table name we want to work with
$rooms_reservation_table = $wpdb->prefix . "bookme_room_reservation";

//get rooms table
$rooms_options_table = $wpdb->prefix . "bookme_rooms_options";



if($_POST[addRes] == true)
{
    $groupId = $_POST['group1'] ;
    $roomId = $_POST['room1'] ;
    $userId = $_POST['userId'] ;
    $startTime = $_POST['start1'] ;
    $endTime = $_POST['end1'] ;

    $selectSQL = $wpdb->get_results( "SELECT * FROM $rooms_options_table WHERE groupId = '$groupId'" );

    //execute the insert new row query
    $wpdb->insert($rooms_reservation_table, array(
        'reservationId' => '',
        'groupId' => $groupId,
        'roomId' => $roomId,
        'userId' => $userId,
        'startTime' => $startTime,
        'endTime' => $endTime

    ));


}

if($_POST[checkRes] == true)
{


    //check if room is available at this time


    //return list of rooms


}










?>




