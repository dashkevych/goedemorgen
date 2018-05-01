<?php
/**
 * Typography related functions.
 *
 * @package Goedemorgen
 */

 /**
  * Get default fonts
  */
function goedemorgen_get_default_fonts() {
	$fonts = array(
		'System Stack',
		'Arial, Helvetica, sans-serif',
		'Century Gothic, CenturyGothic, AppleGothic, sans-serif',
		'Comic Sans MS, cursive, sans-serif',
		'Helvetica Neue, Helvetica, sans-serif',
		'Impact, Charcoal, sans-serif',
		'Lucida Sans Unicode, Lucida Grande, sans-serif',
		'Segoe UI, Helvetica Neue, Helvetica, sans-serif',
		'Tahoma, Geneva, sans-serif',
		'Trebuchet MS, Helvetica, sans-serif',
		'Verdana, Geneva, sans-serif',
		'Georgia, Times New Roman, Times, serif',
		'Palatino Linotype, Book Antiqua, Palatino, serif',
		'Times New Roman, Times, serif',
		'Lucida Console, Monaco, monospace',
		'Courier New, Courier, monospace',
	);

	return apply_filters( 'goedemorgen_typography_default_fonts', $fonts );
}

/**
 * Register Google Fonts.
 */
function goedemorgen_google_fonts( $typography = false ) {
	$fonts_url = '';
	$fonts = array();
	$subsets = 'latin,latin-ext,cyrillic,cyrillic-ext';

	$default_fonts = goedemorgen_get_default_fonts();

	// Get theme's fonts.
	if ( ! $typography ) {
		$typography = goedemorgen_get_setting( 'typography' );
	}

	// Google font for headings.
	if ( isset( $typography['body']['font_family'] ) && ! in_array( $typography['body']['font_family'], $default_fonts ) ) {
		$fonts[] = $typography['body']['font_family'] . ':300,300i,400,400i,700,700i';
	}

	// Google font for body.
	if ( isset( $typography['headings']['font_family'] ) && ! in_array( $typography['headings']['font_family'], $default_fonts ) ) {
		$fonts[] = $typography['headings']['font_family'] . ':300,300i,400,400i,700,700i';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue Google Fonts if needed.
 */
function goedemorgen_enqueue_google_fonts() {
	$google_fonts = goedemorgen_google_fonts();

	if ( '' !== $google_fonts ) {
		wp_enqueue_style( 'goedemorgen-google-fonts', $google_fonts, array(), null );
	}
}
add_action( 'wp_enqueue_scripts', 'goedemorgen_enqueue_google_fonts' );

/**
 * Return System Font Stack.
 */
function goedemorgen_get_system_font_stack() {
	return '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"';
}
