<?php
/**
 * Customizer: Add Panels.
 *
 * @package Goedemorgen
 */

/**
 * Customizer Panels Implementation.
 *
 * @param WP_Customize_Manager $wp_customize Object that holds the customizer data.
 */
function goedemorgen_add_customizer_panels( $wp_customize ) {
    /**
     * Failsafe is safe.
     */
    if ( ! isset( $wp_customize ) ) {
        return;
    }

    /* Typography panel */
    $wp_customize->add_panel( 'goedemorgen_typography_panel', array(
		'priority' => 9997,
		'title' => esc_html__( 'Typography', 'goedemorgen' ),
	) );

    /* Theme Options panel */
	$wp_customize->add_panel( 'goedemorgen_theme_panel', array(
		'priority' => 9998,
		'title' => esc_html__( 'Theme Options', 'goedemorgen' ),
	) );

    /* Third Party Plugins panel */
	$wp_customize->add_panel( 'goedemorgen_plugins_panel', array(
		'priority' => 9999,
		'title' => esc_html__( 'Third Party Plugins', 'goedemorgen' ),
	) );
}
add_action( 'customize_register', 'goedemorgen_add_customizer_panels' );
