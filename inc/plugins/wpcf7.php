<?php
/**
 * Contact Form 7 compatibility file.
 *
 * @link https://contactform7.com/
 *
 * @package Goedemorgen
 */

function goedemorgen_wpcf7_scripts() {
	// Dequeue default Contact Form 7 styles.
	if ( wp_style_is( 'contact-form-7', 'enqueued' ) ) {
		wp_dequeue_style( 'contact-form-7' );
	}

	if ( wp_style_is( 'contact-form-7-rtl', 'enqueued' ) ) {
		wp_dequeue_style( 'contact-form-7-rtl' );
	}

	// Load a theme-specific Contact Form 7 style.
	wp_enqueue_style( 'goedemorgen-contact-form-7', GOEDEMORGEN_DIR_URI . '/assets/css/wpcf7-styles.css' );
}
add_action( 'wp_enqueue_scripts', 'goedemorgen_wpcf7_scripts' );
