<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/flashxyz/BookMe/wiki
 * @since      1.0.0
 *
 * @package    Wp_book_me
 * @subpackage Wp_book_me/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_book_me
 * @subpackage Wp_book_me/includes
 * @author     nirbm, hudeda, rotemsd, flashxyz, liorsap1 <flashxyz@gmail.com>
 */
class Wp_book_me_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
	
		//get wordpress global variable of DB
		global $wpdb;

		//create variable to all SQL tables
		$group_options_table = $wpdb->prefix . "bookme_group_options";
		$rooms_options_table = $wpdb->prefix . "bookme_rooms_options";
		$room_reservation_table = $wpdb->prefix . "bookme_room_reservation";
		$general_options_table = $wpdb->prefix . "bookme_general_options";


		//check if the group_options_table already exist
		if($wpdb->get_var("SHOW TABLES LIKE '$group_options_table'") != $group_options_table)
		{
			//create SQL query for create this table
			$sql = "CREATE TABLE $group_options_table (
				id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				groupName VARCHAR(50),
				numOfRooms INT(3),
				activeDays VARCHAR(180),
				fromTime VARCHAR(50),
				toTime VARCHAR(50),
				description VARCHAR(200),
				viewMode VARCHAR(80),
				calendarColor VARCHAR(10),
				windowTimeLength INT(4),
				services VARCHAR(8000)
				) DEFAULT CHARACTER SET utf8";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			//execute the creation of the table
			dbDelta($sql);


		}


		//check if the rooms_options_table already exist
		if($wpdb->get_var("SHOW TABLES LIKE '$rooms_options_table'") != $rooms_options_table)
		{
			//create SQL query for create this table
			$sql = "CREATE TABLE $rooms_options_table (
				roomId BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				groupId BIGINT,
				roomName VARCHAR(50),
				capacity INT(4),
				services VARCHAR(100),
				isActive INT(1),
				activeDays VARCHAR(180),
				description VARCHAR(100)
				) DEFAULT CHARACTER SET utf8";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			//execute the creation of the table
			dbDelta($sql);
		}


		//check if the room_reservation_table already exist
		if($wpdb->get_var("SHOW TABLES LIKE '$room_reservation_table'") != $room_reservation_table)
		{
			//create SQL query for create this table
			$sql = "CREATE TABLE $room_reservation_table (
				reservationId BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				groupId BIGINT,
				roomId BIGINT,
				userId BIGINT,
				startTime VARCHAR(50),
				endTime VARCHAR(50),
				toTime VARCHAR(50)
				) DEFAULT CHARACTER SET utf8";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			//execute the creation of the table
			dbDelta($sql);

		}


		//check if the general_options_table already exist
		if($wpdb->get_var("SHOW TABLES LIKE '$general_options_table'") != $general_options_table)
		{
			//create SQL query for create this table
			$sql = "CREATE TABLE $general_options_table (
				id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				isRTL int(1),
				firstDayOfWeek VARCHAR(20),
				dateFormat VARCHAR(50)
				) DEFAULT CHARACTER SET utf8";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

			//execute the creation of the table
			dbDelta($sql);



			//insert default values to general options

			//create array of the data we want to insert to specific row
			$dataArray = array(
				'id' => '',
				'isRTL' => 1,
				'firstDayOfWeek' => 'sunday',
				'dateFormat' => 'dd/MM/YYYY'
			);

			//execute the insert new row query
			$wpdb->insert($general_options_table, $dataArray);

		}


	}

}