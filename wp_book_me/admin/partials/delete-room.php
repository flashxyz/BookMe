<?php
//Room delete page
//this page will delete a room from edit-room page from SQL DB


    global $wpdb;

    if($_GET['group_id']==true AND $_GET['room_id']==true AND $_GET['delete_room']==true){



        $groupID = $_GET['group_id'];
        $roomID = $_GET['room_id'];

        echo "Delete Room " . $roomID . "in Group " . $groupID;

        //get the table name we want to work with
        $rooms_options_table = $wpdb->prefix . "bookme_rooms_options";

        //check if the row exist
        $selectSQL = $wpdb->get_results( "SELECT * FROM  $rooms_options_table WHERE roomId = '$roomID'" );

        //execute the delete query of the group id we want to delete
        $wpdb->query( $wpdb->prepare( " DELETE FROM $rooms_options_table WHERE roomId = %d", $roomID));



    }




?>