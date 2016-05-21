<?php

$groupID = $_GET["group_id"];



if($_GET['group_id']==true AND $_GET['edit_rooms']==true)
{
    global $wpdb;

    //get table from sql
    $rooms_options_table = $wpdb->prefix . "bookme_rooms_options";

    $selectSQL = $wpdb->get_results( "SELECT * FROM $rooms_options_table WHERE groupId = '$groupID'" );

    //$test = $selectSQL[0]->roomName;
    //echo $test;
    ?>
    <div class="wrap">

        <h1>Edit Rooms</h1>
        <hr>
        <h2>Group ID: <?php echo $groupID ?> </h2>
        <br>
        <form  action="" method="post" id="<?php echo $this->plugin_name; ?>_editRoomsSaveAllForm">

            <!--create row for each room we have-->
            <?php foreach($selectSQL as $value)
    		{

				$group_id = $value -> groupId;

				if ($group_id % 2 != 0)
				{
					$backgroundColor = "#DFDFDF";
				}
				else
				{
					$backgroundColor = "#ECECEC";
				}    ?>

				<table width='635px' style='border: 1px solid #DFDFDF;background-color:#ffffff;'>
				<tr style='background-color:#ffffff;'>
                    <td style='padding-left:20px;width:100px;' ><p>Room ID: <?php echo $value->roomId ?> </p></td>
                    <td align='center'>
                        <table width='400px'>
                            <tr>
                                <td width='200px'>
                                    <p>Room Name: </p>
                                </td>
                                <td width='200px'>
                                    <strong><?php echo $value->roomName ?></strong>
                                </td>


                            <tr>
                                <td width='200px'>
                                     <span>Room Capacity: </span>
                                </td>
                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionCapacity">
                                        <input type="number" id="<?php echo $this->plugin_name; ?>_roomOptionCapacity" name="<?php echo $this->plugin_name; ?>[roomOptionCapacity]" value="<?php echo $value->capacity; ?>"/>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td width='200px'>
                                    <span>Services: </span>
                                </td>
                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionServices">
                                        <input type="text" id="<?php echo $this->plugin_name; ?>_roomOptionServices" name="<?php echo $this->plugin_name; ?>[roomOptionServices]" value="<?php echo $value->services; ?>"/>
                                    </label>
                                </td>
                            </tr>

                            <tr>
                                <td width='200px'>
                                    <span>Description: </span>
                                </td>
                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionDescription">
                                        <input type="text" id="<?php echo $this->plugin_name; ?>_roomOptionDescription" name="<?php echo $this->plugin_name; ?>[roomOptionDescription]" value="<?php echo $value->description; ?>"/>
                                    </label>
                                </td>
                            </tr>

                            <tr>
                                <td width='200px'>
                                    <span>Active: </span>
                                </td>

                                <td width='200px'>
                                    <label for="<?php echo $this->plugin_name; ?>_roomOptionIsActive">
                                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>_roomOptionIsActive" name="<?php echo $this->plugin_name; ?>[roomOptionIsActive]" value="1" <?php checked($value->isActive, 1); ?>/>
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </td>

                    <td align="center"><p><form action="?page=wp_book_me&group_id=<?php echo $group_id ?>&save_room=true" method="POST" ><input type="hidden" name="room_id" value="<?php echo  $value->roomId ?>">
                            <input type="hidden" name="page" value="wp_book_me"><input name="" value="Save" type="Submit" class="button-secondary" style = "background-color:#BBEEAA;"></form></p></td>
                    <td align="center"><p><form action="?page=wp_book_me" method="get" ><input type="hidden" name="room_id" value="<?php echo $value->roomId ?>">
                            <input type="hidden" name="delete" value="true"><input type="button" onClick="return checkMe(<?php echo  $value->roomId ?>)" value="Delete" class="button-secondary" style = "background-color:#FF8181;"></form></p></td>

                </tr>
				</table>
            <?php
            }
            ?>
        <br>
        <br>
        <table width="500px">
            <tr>
                <td width="150px">
                    <input class="button-primary" type="submit" name="saveOptionsBTN" value="Save All" />
         </form>
                </td>

                <td width="200px">
                    <form  action="?page=wp_book_me&group_id=<?php echo $groupID ?>&create_room=true&edit_rooms=true" method="post" id="<?php echo $this->plugin_name; ?>_editRoomsNewRoomForm">
                        <input class="button-primary" type="submit" name="editRoomsBTN" value="Create New Room"  />
                    </form>
                </td>
                <td width="150px">
                    <form  action="?page=wp_book_me&group_id=<?php echo $groupID ?>&edit_group=true" method="post" id="<?php echo $this->plugin_name; ?>_editRoomsGoBackForm">
                        <input class="button-primary" type="submit" name="goBackBTN" value="Go Back"/>
                    </form>
                </td>
            </tr>

        </table>
    </div>

<?php

}

?>