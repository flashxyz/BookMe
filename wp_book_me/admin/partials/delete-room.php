<?php
//Room delete page
//this page will delete a room from edit-room page from SQL DB


    global $wpdb;

    if($_GET['group_id']==true AND $_GET['room_id']==true AND $_GET['delete_room']==true){



        $groupID = $_GET['group_id'];
        $roomID = $_GET['room_id'];

        echo "Delete Room " . $roomID . "in Group " . $groupID;

        //get the table name we want to work with
        $group_options_table = $wpdb->prefix . "bookme_group_options";
        $rooms_options_table = $wpdb->prefix . "bookme_rooms_options";

        //check if the row exist
        $selectSQL = $wpdb->get_results( "SELECT * FROM  $rooms_options_table WHERE roomId = '$roomID'" );

        //execute the delete query of the group id we want to delete
        $wpdb->query( $wpdb->prepare( " DELETE FROM $rooms_options_table WHERE roomId = %d", $roomID));


        //get all the rooms associate to this group id
        $selectSQL = $wpdb->get_results( "SELECT * FROM $rooms_options_table WHERE groupId = '$groupID'" );


        //update the number of rooms in group option table


        //take the num of the rooms + 1
        $numOfRooms  = sizeof($selectSQL);


        //create array of the data we want to insert to specific row
        $dataArray = array(
            'numOfRooms' => $numOfRooms
        );

        //create array of the condition to get the specific row
        $whereArray = array( 'id' => $groupID);

        //execute the update function for saving data
        $wpdb->update( $group_options_table, $dataArray, $whereArray);

    }




?>