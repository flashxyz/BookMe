<?php

$groupID = $_GET["group_id"];



if($_GET['group_id']==true AND $_GET['edit_rooms']==true)
{


    ?>
    <div class="wrap">

        <h1>Edit Rooms</h1>
        <hr>
        <h2>Group ID: <?php echo $groupID ?> </h2>
        <br>
        <form  action="?page=wp_book_me&group_id=<?php echo $groupID ?>&edit_group=true" method="post" id="<?php echo $this->plugin_name; ?>_adminGoBackForm">
            <input class="button-primary" type="submit" name="goBackBTN" value="Go Back"/>
        </form>
    </div>

<?php

}

?>