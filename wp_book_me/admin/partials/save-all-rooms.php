<?php


$groupID = $_GET["group_id"];



if($_GET['group_id']==true AND $_GET['save_all']==true)
{

    global $wpdb;

    //room SQL table
    $room_options_table = $wpdb->prefix . "bookme_rooms_options";
    //get rooms
    $selectSQL_rooms = $wpdb->get_results($wpdb->prepare("SELECT * FROM $room_options_table WHERE groupId = %d", $groupID));

    $numberOfRooms = sizeof($selectSQL_rooms);

    $index = 0;
    $roomsArray = array();

    while ($index < $numberOfRooms) {
        $roomsArray[$index] = $selectSQL_rooms[$index]->roomId;

        $index++;
    }
    print_r($roomsArray);

    //get the current path url
    $siteURL = get_site_url() . "/wp-admin/admin.php";

}
?>

<script>
    var siteURL = <?php echo json_encode($siteURL);?>;

    <?php $jsArray = json_encode( $roomsArray);
    echo "var numOfRooms = " . $jsArray . ";\n";
    ?>

    for( var i = 0 ; i < numOfRooms.length ; i++)
    {
        var formID = "#wp_book_me_RoomsSaveForm_" + numOfRooms[i];
        alert(formID);
        $("#wp_book_me_RoomsSaveForm_5").submit();
    }

    window.location.replace(siteURL + "?page=wp_book_me&group_id=<?php echo $groupID ?>&edit_rooms=true");

</script>