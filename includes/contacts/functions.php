<?php
function whale_get_record( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'subscribers WHERE subscriber_id = %d', $id ) );
}