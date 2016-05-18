<?php

global $wpdb;


if($_GET['group_id']==true AND $_GET['save_options']==true)
{

    //get the table for modify it
    $group_options_table = $wpdb->prefix . "bookme_group_options";

    echo "<h1>save option script</h1>";
    
    //get the post array
    $postArray = $_POST['wp_book_me'];
    
    //get post array values
    $groupName =  $postArray['groupName'];
    $numOfRooms = $postArray['numOfRooms'];
    $roomsAvailableFrom = $postArray['roomsAvailableFrom'];
    $roomsAvailableUntil = $postArray['roomsAvailableUntil'];
    $groupDescription = $postArray['groupDescription'];
    $calendarColor = $postArray['calendarColor'];
    $timeSlot = $postArray['timeSlot'];

    //print post value
    echo "POST values <br>";
    echo $groupName ."<br>".$numOfRooms."<br>".$roomsAvailableFrom."<br>". $roomsAvailableUntil."<br>".$groupDescription."<br>".$calendarColor."<br>".$timeSlot;

}