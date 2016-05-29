<?php
//Room Save page
//this page will save the input from edit-room page fields into the SQL DB


global $wpdb;

if($_GET['group_id']==true AND $_GET['room_id']==true AND  $_GET['save_room']==true){

    $groupID = $_GET['group_id'];
    $roomID = $_GET['room_id'];
    $postArray = $_POST['wp_book_me'];

    echo "EditRoom";
    echo $groupID;
    echo $roomID;
}




?>