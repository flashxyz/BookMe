<?php


	//check url parameters 
	if($_GET['group_id']==true AND $_GET['delete']==true)
	{

		//get the group id from the url parameters
		$groupID = $_GET["group_id"];
		
		global $wpdb;

		//get the table name we want to delete row from
		$group_options_table = $wpdb->prefix . "bookme_group_options";

		//check if the row exist
		$selectSQL = $wpdb->get_results( "SELECT * FROM $group_options_table WHERE id = '$groupID'" );

		//execute the delete query of the group id we want to delete
		$wpdb->query( $wpdb->prepare( " DELETE FROM $group_options_table WHERE id = %d", $groupID));

		//now delete the rooms associated to this group

		//room SQL table
		$room_options_table = $wpdb->prefix . "bookme_rooms_options";

		//execute the delete query of the group id we want to delete
		$wpdb->query( $wpdb->prepare( " DELETE FROM $room_options_table WHERE groupId = %d", $groupID));



	}



?>