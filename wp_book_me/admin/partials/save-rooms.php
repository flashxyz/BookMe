<?php
//Room Save page
//this page will save the input from edit-room page fields into the SQL DB


global $wpdb;

if($_GET['group_id']==true AND $_GET['room_id']==true AND  $_GET['save_room']==true){

    //get the table for farther modification
    $room_options_table = $wpdb->prefix . "bookme_rooms_options";

    //get gata from GET\POST
    $groupID = $_GET['group_id'];
    $roomID = $_GET['room_id'];
    $postArray = $_POST['wp_book_me'];
    
    //get fields from submitted forms
    $roomName = $postArray['roomOptionName_' . $roomID];
    $roomCapacity = $postArray['roomOptionCapacity_' . $roomID];
    //get group table
    $group_options_table = $wpdb->prefix . "bookme_group_options";
    
    //get specific group table
    $selectSQL_Group = $wpdb->get_results($wpdb->prepare("SELECT * FROM $group_options_table WHERE id = %d", $groupID));

    //get amount of services
    $services = unserialize($selectSQL_Group[0]->services);

    //so that we can use if to get services from room page
    $num_of_services = sizeof($services);


    //services for each room
    $roomServicesSerialized;

    //for SQL
    $roomServicesArray;

    //loop for every service.
    $serviceIndex = 0;

    while($serviceIndex < $num_of_services) {

        $roomServices = $postArray['room_' . $roomID . '_service_' . $serviceIndex];
        //run over group services and apply room values
        //$roomServices[$serviceIndex] = $roomServices;
        //echo $serviceIndex;
        $roomServicesArray[$services[$serviceIndex]] = $roomServices;

        $serviceIndex++;

    }

    //serialize the data for SQL.
    $roomServicesSerialized = serialize($roomServicesArray);


    $roomDescription = $postArray['roomOptionDescription_' . $roomID];
    $roomIsActive = $postArray['roomOptionIsActive_' . $roomID];
    $activeSundayCheckBox = $postArray['activeSunday_' . $roomID];
    $activeMondayCheckBox = $postArray['activeMonday_' . $roomID];
    $activeTuesdayCheckBox = $postArray['activeTuesday_' . $roomID];
    $activeWednesdayCheckBox = $postArray['activeWednesday_' . $roomID];
    $activeThursdayCheckBox = $postArray['activeThursday_' . $roomID];
    $activeFridayCheckBox = $postArray['activeFriday_' . $roomID];
    $activeSaturdayCheckBox = $postArray['activeSaturday_' . $roomID];


    //parse the active days to TLV format
    $activeDaysArray = serialize(array(
        'sunday' => $activeSundayCheckBox,
        'monday' => $activeMondayCheckBox,
        'tuesday' => $activeTuesdayCheckBox,
        'wednesday' => $activeWednesdayCheckBox,
        'thursday' => $activeThursdayCheckBox,
        'friday' => $activeFridayCheckBox,
        'saturday' => $activeSaturdayCheckBox
    ));


    //create array of the data we want to insert to specific row
    $dataArray = array(
        'roomName' => $roomName,
        'capacity' => $roomCapacity,
        'activeDays' => $activeDaysArray,
        'services' => $roomServicesSerialized,
        'description' => $roomDescription,
        'isActive' => $roomIsActive
    );


    //create array of the condition to get the specific row
    $whereArray = array( 'roomId' => $roomID);

    //execute the update function for saving data
    $wpdb->update( $room_options_table, $dataArray, $whereArray);




}

//get the current path url
$siteURL = get_site_url()."/wp-admin/admin.php";

?>

<script>
    var siteURL = <?php echo json_encode($siteURL);?>;
    window.location.replace(siteURL + "?page=wp_book_me&group_id=<?php echo $groupID ?>&edit_rooms=true");

</script>
