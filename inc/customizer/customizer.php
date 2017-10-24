<?php
/**
 * Goedemorgen Theme Customizer.
 *
 * @package Goedemorgen
 */

// List all needed files for the Customizer.
$extensions_files = array(
    'sanitization-callbacks.php',
    'add-panels.php',
    'add-sections.php',
    'add-controls.php',
);

// Set path to Customizer extensions.
$extensions_path = GOEDEMORGEN_DIR . '/inc/customizer/extensions/';

// Load Customizer files.
foreach ( $extensions_files as $file ) {
    require_once( $extensions_path . $file );
}

/**
 * Enqueue script for custom customize control.
 */
function goedemorgen_enqueue_custom_controls_js() {
    wp_enqueue_script( 'goedemorgen-customize-controls', GOEDEMORGEN_DIR_URI . '/inc/customizer/js/customize-controls.js', array( 'jquery', 'customize-controls', 'jquery-ui-core' ) );
}
add_action( 'customize_controls_enqueue_scripts', 'goedemorgen_enqueue_custom_controls_js' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function goedemorgen_customize_preview_js() {
	wp_enqueue_script( 'goedemorgen-customize-preview', GOEDEMORGEN_DIR_URI . '/inc/customizer/js/customize-preview.js', array( 'jquery', 'customize-preview' ), '20171018', true );
}
add_action( 'customize_preview_init', 'goedemorgen_customize_preview_js' );
