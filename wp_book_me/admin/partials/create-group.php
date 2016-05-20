<?php



global $wpdb;

$group_options_table = $wpdb->prefix . "bookme_group_options";

$wpdb->insert($group_options_table, array(
    'id' => '',
    'windowTimeLength' => '60',
));


?>