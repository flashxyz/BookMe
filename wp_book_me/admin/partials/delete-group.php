<?php

	$optionID = $_GET["option_id"];

	if($_GET['option_id']==true AND $_GET['delete']==true)
	{
		
		global $wpdb;

		$tablename = $wpdb->prefix . "bookme_test_options";

		$selectSQL = $wpdb->get_results( "SELECT * FROM $tablename WHERE id = '$optionID'" );

		$wpdb->query( $wpdb->prepare( " DELETE FROM $tablename WHERE id = %d", $optionID));


	}



?>