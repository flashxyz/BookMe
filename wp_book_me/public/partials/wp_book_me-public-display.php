<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://github.com/flashxyz/BookMe/wiki
 * @since      1.0.0
 *
 * @package    Wp_book_me
 * @subpackage Wp_book_me/public/partials
 */




function display($atts)
{
    @ob_start();
    include_once 'frontend-bookme.php';
    $frontend_bookme = @ob_get_clean();
    return $frontend_bookme;
}

add_shortcode('bk_rooms_group', 'display');

?>