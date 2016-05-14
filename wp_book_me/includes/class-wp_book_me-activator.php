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
	
	
		global $wpdb;
		
		$group_options_table = $wpdb->prefix . "bookme_group_optinos";
		$rooms_options_table = $wpdb->prefix . "bookme_rooms_optinos";
		$room_reservation_table = $wpdb->prefix . "bookme_room_reservation";
		$general_options_table = $wpdb->prefix . "bookme_general_optinos";

		
		if($wpdb->get_var("SHOW TABLES LIKE '$group_options_table'") != $group_options_table)
		{
			$sql = "CREATE TABLE $group_options_table (
				id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				groupName VARCHAR(50),
				numOfRooms INT(20),
				activeDays VARCHAR(50),
				fromTime VARCHAR(50),
				toTime VARCHAR(50),
				description VARCHAR(100),
				viewMode VARCHAR(50),
				calendarColor VARCHAR(50),
				windowTimeLength INT(5)
				) DEFAULT CHARACTER SET utf8";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);


		}

		if($wpdb->get_var("SHOW TABLES LIKE '$rooms_options_table'") != $rooms_options_table)
		{
			$sql = "CREATE TABLE $rooms_options_table (
				roomId BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				groupId BIGINT,
				roomName VARCHAR(50),
				capacity INT(20),
				services VARCHAR(100),
				isActive INT(1),
				description VARCHAR(100)
				) DEFAULT CHARACTER SET utf8";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}

		if($wpdb->get_var("SHOW TABLES LIKE '$room_reservation_table'") != $room_reservation_table)
		{
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
			dbDelta($sql);

		}

		if($wpdb->get_var("SHOW TABLES LIKE '$general_options_table'") != $general_options_table)
		{
			$sql = "CREATE TABLE $general_options_table (
				isRTL int(1),
				firstDayOfWeek int(1),
				dateFormat VARCHAR(50)
				) DEFAULT CHARACTER SET utf8";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);

		}
	}

}