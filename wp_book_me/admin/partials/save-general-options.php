<?php

global $wpdb;

//saved optionns for group
if($_GET['save_general_options']==true)
{
    $general_options_table = $wpdb->prefix . "bookme_general_options";

    //get the post array
    $postArray = $_POST['wp_book_me'];


    $dateFormat = $postArray['dateFormat'];
    $isRTL = $postArray['rtl'];
    $firstDayOfWeek = $postArray['firstDay'];

    //create array of the data we want to insert to specific row
    $dataArray = array(
        'dateFormat' => $dateFormat,
        'isRTL' => $isRTL,
        'firstDayOfWeek' => $firstDayOfWeek
    );

    //create array of the condition to get the specific row
    $whereArray = array( 'id' => 1);

    //execute the update function for saving data
    $wpdb->update( $general_options_table, $dataArray, $whereArray);


}

//get the current path url
$siteURL = get_site_url()."/wp-admin/admin.php";
?>

<!-- this script redirect to the previous page-->
<script>

    var siteURL = <?php echo json_encode($siteURL);?>;
    window.location.replace(siteURL + "?page=wp_book_me");

</script>
