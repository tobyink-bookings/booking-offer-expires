<?php
/**
 * Plugin Name:       TIL Bookings Offer Expiry
 * Description:       Allow payment links to auto-expire.
 * Version:           1.0
 * Requires at least: 5.6
 * Requires PHP:      7.2
 * Author:            Toby Ink Ltd
 * Author URI:        https://toby.ink/hire/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html 
 */

add_action( 'init', function () {
	if ( array_key_exists( 'til_bookings_offer_expiry', $_GET ) ) {
		do_action( 'til_bookings_offer_expiry' );
	}

	if ( ! is_admin() ) {
		return false;
	}

	if ( wp_next_scheduled( 'til_bookings_offer_expiry' ) ) {
		return false;
	}

	wp_schedule_event( time(), 'hourly', 'til_bookings_offer_expiry' );
} );

add_action( 'til_bookings_offer_expiry', function () {

	$yesterday = date( 'Ymd', time() - 24*60*60 );

	$q = new WP_Query( [
		'post_type'  => 'booking',
		'meta_query' => [
			'relation' => 'AND',
			[ 'key' => 'status',        'compare' => '=',  'value' => 'Accepted' ],
			[ 'key' => 'offer_expires', 'compare' => '<=', 'value' => $yesterday ],
		],
	] );

	if ( $q->have_posts() ) {
		$q->the_post();
		update_post_meta( $q->post->ID, 'status', 'Declined' );
	}

	wp_reset_postdata();
} );
