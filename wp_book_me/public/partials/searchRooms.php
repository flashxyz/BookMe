<?php
/**
 * Created by IntelliJ IDEA.
 * User: rsaado
 * Date: 6/13/2016
 * Time: 14:07
 */

//include WP content
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

global $wpdb;

//get rooms table
$rooms_options_table = $wpdb->prefix . "bookme_rooms_options";


if($_POST['searchByServices'] == true)
{
    echo "hello";

}