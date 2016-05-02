<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/flashxyz/BookMe/wiki
 * @since             1.0.0
 * @package           Wp_book_me
 *
 * @wordpress-plugin
 * Plugin Name:       WP BookMe plugin
 * Plugin URI:        https://github.com/flashxyz/BookMe
 * Description:       BookMe is a smart and generic WordPress plugin for managing & booking rooms at any facility. 
BookMe aim is to provide a platform for anyone who wants to reserve a room for any use.
 * Version:           1.0.0
 * Author:            nirbm, hudeda, rotemsd, flashxyz, liorsap1
 * Author URI:        https://github.com/flashxyz/BookMe/wiki
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_book_me
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp_book_me-activator.php
 */
function activate_wp_book_me() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp_book_me-activator.php';
	Wp_book_me_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp_book_me-deactivator.php
 */
function deactivate_wp_book_me() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp_book_me-deactivator.php';
	Wp_book_me_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_book_me' );
register_deactivation_hook( __FILE__, 'deactivate_wp_book_me' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp_book_me.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_book_me() {

	$plugin = new Wp_book_me();
	$plugin->run();

}
run_wp_book_me();
