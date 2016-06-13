<?php
/**
 * Created by IntelliJ IDEA.
 * User: Rotem
 * Date: 01/06/2016
 * Time: 21:31
 */

global $wpdb;

if($_GET['group_id']==true AND $_GET['add_service']==true)
{

    //get the table for farther modification
    $group_options_table = $wpdb->prefix . "bookme_group_options";
    //get room tables from sql
    $rooms_options_table = $wpdb->prefix . "bookme_rooms_options";

    //get gata from GET
    $groupID = $_GET['group_id'];
    $addService = $_GET['add_service'];

    //get the relevant group row
    $selectSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM $group_options_table WHERE id = %d", $groupID));

    //unserialize the service array
    $services = unserialize($selectSQL[0]->services);

    //add the new service
    array_push($services, $addService);

    //serialize the array again for pushing it back
    $serializeServices = serialize($services);

    //create array of the data we want to insert to specific row
    $dataArray = array(
        'services' => $serializeServices
    );


    //create array of the condition to get the specific row
    $whereArray = array( 'id' => $groupID);

    //execute the update function for saving data
    $wpdb->update( $group_options_table, $dataArray, $whereArray);


    $selectSQL_Rooms = $wpdb->get_results( "SELECT * FROM $rooms_options_table WHERE groupId = '$groupID'" );

    $numberOfRooms = sizeof($selectSQL_Rooms);

    $newRoomsArrayServices = array();


    foreach($selectSQL_Rooms as $value) {

        $servicesByID = unserialize($value -> services);
        $roomID = $value -> roomId;

        //add the new service
        $servicesByID[$addService] = null;

        //serialize the array again for pushing it back
        $newRoomsArrayServicesSerialized = serialize($servicesByID);

        //create array of the data we want to insert to specific row
        $dataArray = array(
            'services' => $newRoomsArrayServicesSerialized
        );


        //create array of the condition to get the specific row
        $whereArray = array( 'roomId' => $roomID);

        //execute the update function for saving data
        $wpdb->update( $rooms_options_table, $dataArray, $whereArray);
    }
}

//get the current path url
$siteURL = get_site_url()."/wp-admin/admin.php";

?>

<script>

    var siteURL = <?php echo json_encode($siteURL);?>;
    window.location.replace(siteURL + "?page=wp_book_me&group_id=<?php echo $groupID ?>&edit_group=true");

</script>

