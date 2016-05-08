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
		
		$primary_tablename = $wpdb->prefix . "bookme_rooms_group_primary";
		
		if($wpdb->get_var("SHOW TABLES LIKE '$primary_tablename'") != $primary_tablename)
		{
			$sql = "CREATE TABLE $primary_tablename (
				id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
				roomsGroupName VARCHAR(200),
				maxRooms INT(20)
				) DEFAULT CHARACTER SET utf8";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
				
			
		}
			
	}

}