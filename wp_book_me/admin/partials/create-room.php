<?php

//get the group id from the url parameters
$groupID = $_GET["group_id"];

global $wpdb;

//get the table name we want to work with
$rooms_options_table = $wpdb->prefix . "bookme_rooms_options";
$group_options_table = $wpdb->prefix . "bookme_group_options";

//get all the rooms associate to this group id
$selectSQL = $wpdb->get_results( "SELECT * FROM $rooms_options_table WHERE groupId = '$groupID'" );

//take the num of the rooms + 1
$numOfRooms  = sizeof($selectSQL) + 1;

//initialize default values when creating new room
$defaultRoomName = "Room " . $numOfRooms;
$defaultIsActive = 1;


//execute the insert new row query
$wpdb->insert($rooms_options_table, array(
    'roomId' => '',
    'groupId' => $groupID,
    'roomName' => $defaultRoomName,
    'isActive' => $defaultIsActive

));

//create array of the data we want to insert to specific row
$dataArray = array(
        'numOfRooms' => $numOfRooms
);

//create array of the condition to get the specific row
$whereArray = array( 'id' => $groupID);

//execute the update function for saving data
$wpdb->update( $group_options_table, $dataArray, $whereArray);


$siteURL = get_site_url()."/wp-admin/admin.php";


?>

    <script>

        var siteURL = <?php echo json_encode($siteURL);?>;

        window.location.replace(siteURL +"?page=wp_book_me&group_id=" + <?php echo $groupID; ?> + "&edit_rooms=true");

    </script>
