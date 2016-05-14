<?php

$groupID = $_GET["group_id"];


if($_GET['group_id']==true AND $_GET['edit_group']==true)
{

    global $wpdb;

    $group_options_table = $wpdb->prefix . "bookme_group_optinos";

    ?>
    <h1>Rooms Group Options</h1>
    <h2>Group ID: <?php echo $groupID ?> </h2>
    
    
    
    
<?php

}


?>




