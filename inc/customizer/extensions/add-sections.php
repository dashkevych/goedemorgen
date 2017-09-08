<?php
/**
 * Customizer: Add Sections.
 *
 * @package Goedemorgen
 */

/**
 * Customizer Sections Implementation.
 *
 * @param WP_Customize_Manager $wp_customize Object that holds the customizer data.
 */
function goedemorgen_add_customizer_sections( $wp_customize ) {
    /*
     * Failsafe is safe
     */
    if ( ! isset( $wp_customize ) ) {
        return;
    }

    /* Typography: Body */
    $wp_customize->add_section( 'goedemorgen_typography_body_options', array(
    	'title'    => esc_html__( 'Body', 'goedemorgen' ),
    	'priority' => 1,
    	'panel'    => 'goedemorgen_typography_panel',
    ) );

    /* Typography: Headings */
	$wp_customize->add_section( 'goedemorgen_typography_headings_options', array(
		'title'    => esc_html__( 'Headings', 'goedemorgen' ),
		'priority' => 2,
		'panel'    => 'goedemorgen_typography_panel',
	) );

    /* Theme Options: General Options */
	$wp_customize->add_section( 'goedemorgen_general_options', array(
		'title'    => esc_html__( 'General Options', 'goedemorgen' ),
		'priority' => 2,
		'panel'    => 'goedemorgen_theme_panel',
	) );

    /* Theme Options: Jumbotron */
	$wp_customize->add_section( 'goedemorgen_jumbotron_options', array(
		'title'    => esc_html__( 'Jumbotron Options', 'goedemorgen' ),
		'priority' => 3,
		'panel'    => 'goedemorgen_theme_panel',
        'description' => esc_html__( 'This section is designed to showcase key content on your site.', 'goedemorgen' ),
        'active_callback' => 'goedemorgen_is_jumbotron_header',
	) );

    /* Theme Options: Archive View Options */
	$wp_customize->add_section( 'goedemorgen_archive_options', array(
		'title'    => esc_html__( 'Archive View Options', 'goedemorgen' ),
		'priority' => 4,
		'panel'    => 'goedemorgen_theme_panel',
	) );

    /* Theme Options: Footer Options */
	$wp_customize->add_section( 'goedemorgen_footer_options', array(
		'title'    => esc_html__( 'Footer Options', 'goedemorgen' ),
		'priority' => 99,
		'panel'    => 'goedemorgen_theme_panel',
	) );
}
add_action( 'customize_register', 'goedemorgen_add_customizer_sections' );
