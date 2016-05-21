<?php

global $wpdb;


if($_GET['group_id']==true AND $_GET['save_options']==true)
{

    $groupID = $_GET['group_id'];
    //get the table for modify it
    $group_options_table = $wpdb->prefix . "bookme_group_options";

    //get the post array
    $postArray = $_POST['wp_book_me'];

    //get post array values
    $groupName =  $postArray['groupName'];
    $roomsAvailableFrom = $postArray['roomsAvailableFrom'];
    $roomsAvailableUntil = $postArray['roomsAvailableUntil'];
    $groupDescription = $postArray['groupDescription'];
    $calendarColor = $postArray['calendarColor'];
    $timeSlot = $postArray['timeSlot'];
    $calendarViewMode = $postArray['calendarViewMode'];
    $activeSundayCheckBox = $postArray['activeSunday'];
    $activeMondayCheckBox = $postArray['activeMonday'];
    $activeTuesdayCheckBox = $postArray['activeTuesday'];
    $activeWednesdayCheckBox = $postArray['activeWednesday'];
    $activeThursdayCheckBox = $postArray['activeThursday'];
    $activeFridayCheckBox = $postArray['activeFriday'];
    $activeSaturdayCheckBox = $postArray['activeSaturday'];
    
    //print post value
    //echo "POST values <br>";
    //echo $groupName ."<br>".$numOfRooms."<br>".$roomsAvailableFrom."<br>". $roomsAvailableUntil."<br>".$groupDescription."<br>".$calendarColor."<br>".$timeSlot."<br>".$calendarViewMode;

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
        'groupName' => $groupName,
        'fromTime' => $roomsAvailableFrom,
        'activeDays' => $activeDaysArray,
        'toTime' => $roomsAvailableUntil,
        'description' => $groupDescription,
        'viewMode' => $calendarViewMode,
        'calendarColor' => $calendarColor,
        'windowTimeLength' => $timeSlot
    );

    //create array of the condition to get the specific row
    $whereArray = array( 'id' => $groupID);

    //execute the update function for saving data
    $wpdb->update( $group_options_table, $dataArray, $whereArray);


}

//get the current path url
$siteURL = get_site_url()."/wp-admin/admin.php";
?>

<!-- this script redirect to the previous page-->
<script>

    var siteURL = <?php echo json_encode($siteURL);?>;
    window.location.replace(siteURL + "?page=wp_book_me&group_id=<?php echo $groupID ?>&edit_group=true");

</script>
