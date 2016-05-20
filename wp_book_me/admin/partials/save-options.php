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
    $numOfRooms = $postArray['numOfRooms'];
    $roomsAvailableFrom = $postArray['roomsAvailableFrom'];
    $roomsAvailableUntil = $postArray['roomsAvailableUntil'];
    $groupDescription = $postArray['groupDescription'];
    $calendarColor = $postArray['calendarColor'];
    $timeSlot = $postArray['timeSlot'];
    $calendarViewMode = $postArray['calendarViewMode'];

    //print post value
    //echo "POST values <br>";
    //echo $groupName ."<br>".$numOfRooms."<br>".$roomsAvailableFrom."<br>". $roomsAvailableUntil."<br>".$groupDescription."<br>".$calendarColor."<br>".$timeSlot."<br>".$calendarViewMode;

    $dataArray = array(
        'groupName' => $groupName,
        'numOfRooms' => $numOfRooms,
        'fromTime' => $roomsAvailableFrom,
        'toTime' => $roomsAvailableUntil,
        'description' => $groupDescription,
        'viewMode' => $calendarViewMode,
        'calendarColor' => $calendarColor,
        'windowTimeLength' => $timeSlot
    );

    $whereArray = array( 'id' => $groupID);


    $wpdb->update( $group_options_table, $dataArray, $whereArray);


}

$siteURL = get_site_url()."/wp-admin/admin.php";
?>

<script>

    var siteURL = <?php echo json_encode($siteURL);?>;
    window.location.replace(siteURL + "?page=wp_book_me&group_id=<?php echo $groupID ?>&edit_group=true");

</script>
