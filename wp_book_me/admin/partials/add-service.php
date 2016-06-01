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

    //get gata from GET\POST
    $groupID = $_GET['group_id'];
    $addService = $_GET['add_service'];

    $selectSQL = $wpdb->get_results($wpdb->prepare("SELECT * FROM $group_options_table WHERE id = %d", $groupID));

    $services = unserialize($selectSQL[0]->services);

    array_push($services, $addService);

    $serializeServices = serialize($services);

    //create array of the data we want to insert to specific row
    $dataArray = array(
        'services' => $serializeServices
    );


    //create array of the condition to get the specific row
    $whereArray = array( 'id' => $groupID);

    //execute the update function for saving data
    $wpdb->update( $group_options_table, $dataArray, $whereArray);

    echo "<h1>save service</h1>";
}

//get the current path url
$siteURL = get_site_url()."/wp-admin/admin.php";

?>

