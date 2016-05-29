<?php
//Room delete page
//this page will delete a room from edit-room page from SQL DB


global $wpdb;

if($_GET['group_id']==true AND $_GET['room_id']==true AND $_GET['delete_room']==true){

    $groupID = $_GET['group_id'];
    $roomID = $_GET['room_id'];
    $postArray = $_POST['wp_book_me'];

    echo "DeleteRoom";
    echo $groupID;
    echo $roomID;
}




?>