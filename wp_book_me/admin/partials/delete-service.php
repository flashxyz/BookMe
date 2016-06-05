<?php
/**
 * Created by IntelliJ IDEA.
 * User: Rotem
 * Date: 01/06/2016
 * Time: 21:31
 */


global $wpdb;

if($_GET['group_id']==true AND $_GET['delete_service']==true)
{

    //get the table for farther modification
    $group_options_table = $wpdb->prefix . "bookme_group_options";

    //get gata from GET
    $groupID = $_GET['group_id'];
    $deleteServiceIndex = $_GET['delete_service'];
    $deleteServiceIndex--;

    //get the relevant group row
    $selectSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM $group_options_table WHERE id = %d", $groupID));

    //unserialize the service array
    $services = unserialize($selectSQL[0]->services);

    //delete the service
    array_splice($services, $deleteServiceIndex, 1);

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


}

//get the current path url
$siteURL = get_site_url()."/wp-admin/admin.php";

?>

<script>

    var siteURL = <?php echo json_encode($siteURL);?>;
    window.location.replace(siteURL + "?page=wp_book_me&group_id=<?php echo $groupID ?>&edit_group=true");

</script>

