<?php

	$groupID = $_GET["group_id"];

	if($_GET['group_id']==true AND $_GET['delete']==true)
	{
		
		global $wpdb;

		$group_options_table = $wpdb->prefix . "bookme_group_optinos";

		$selectSQL = $wpdb->get_results( "SELECT * FROM $group_options_table WHERE id = '$groupID'" );

		$wpdb->query( $wpdb->prepare( " DELETE FROM $group_options_table WHERE id = %d", $groupID));


	}



?>