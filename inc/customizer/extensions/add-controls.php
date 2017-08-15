<?php
/**
 * Customizer: Add Controls.
 *
 * @package Goedemorgen
 */

/**
 * Customizer Controls Implementation.
 *
 * @param WP_Customize_Manager $wp_customize Object that holds the customizer data.
 */
function goedemorgen_add_customizer_controls( $wp_customize ) {
    /* Failsafe is safe */
    if ( ! isset( $wp_customize ) ) {
        return;
    }

    /* Set path to Customizer controls */
    $controls_path = get_template_directory() . '/inc/customizer/controls/';

    /* List all custom controls */
    $custom_controls = array(
        array(
            'class' => 'Goedemorgen_Customizer_Font_Family_Control',
            'file' => 'font-family.php',
        ),
    );

    /* Register custom controls */
    foreach ( $custom_controls as $control ) {
        require_once( $controls_path . $control['file'] );
        $wp_customize->register_control_type( $control['class'] );
    }

    /* Get theme's default values */
	$defaults = goedemorgen_get_setting( 'defaults' );

    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

    /* Body typography */
    $wp_customize->add_setting( 'goedemorgen_settings[typography][body][font_family]', array(
        'default' => $defaults['typography']['body']['font_family'],
        'sanitize_callback' => 'goedemorgen_sanitize_font_family',
    ) );

    $wp_customize->add_control( new Goedemorgen_Customizer_Font_Family_Control( $wp_customize, 'goedemorgen_typography_body_fontfamily', array(
        'type' => 'font-family',
        'label' => esc_html__( 'Body Font Family', 'goedemorgen' ),
        'section' => 'goedemorgen_typography_body_options',
        'settings' => 'goedemorgen_settings[typography][body][font_family]',
        'description' => esc_html__( 'Select the body font family which will be used for text in the body of your website.', 'goedemorgen' ),
    ) ) );

    /* Headings typography */
    $wp_customize->add_setting( 'goedemorgen_settings[typography][headings][font_family]', array(
        'default' => $defaults['typography']['headings']['font_family'],
        'sanitize_callback' => 'goedemorgen_sanitize_font_family'
    ) );

    $wp_customize->add_control( new Goedemorgen_Customizer_Font_Family_Control( $wp_customize, 'goedemorgen_typography_headings_fontfamily', array(
        'type' => 'font-family',
        'label' => esc_html__( 'Headings Font Family', 'goedemorgen' ),
        'section' => 'goedemorgen_typography_headings_options',
        'settings' => 'goedemorgen_settings[typography][headings][font_family]',
        'description' => esc_html__( 'Select the font family which will be used for the headings on your website.', 'goedemorgen' ),
    ) ) );

    /* Footer Options: Widget Area Layout */
	$wp_customize->add_setting( 'goedemorgen_settings[footer][widgets_layout]', array(
		'default' => $defaults['footer']['widgets_layout'],
		'sanitize_callback' => 'absint'
	) );

	$wp_customize->add_control( 'goedemorgen_footer_widget_area_layout', array(
		'type' => 'select',
		'label' => esc_html__( 'Widget Area Layout', 'goedemorgen' ),
		'section' => 'goedemorgen_footer_options',
		'settings' => 'goedemorgen_settings[footer][widgets_layout]',
		'choices' => array(
			'2' => esc_html__( 'Two Columns', 'goedemorgen' ),
			'3' => esc_html__( 'Three Columns', 'goedemorgen' ),
			'4' => esc_html__( 'Four Columns', 'goedemorgen' ),
		),
		'priority' => 3,
		'description' => esc_html__( 'Select a layout for the footer widget area.', 'goedemorgen' ),
	) );

    /* Footer Options: Widget Area Columns Width */
	$wp_customize->add_setting( 'goedemorgen_settings[footer][is_widgets_equal]', array(
		'default' => $defaults['footer']['is_widgets_equal'],
		'sanitize_callback' => 'goedemorgen_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'goedemorgen_footer_widget_area_equal_columns', array(
		'label' => esc_html__( 'Make widget columns of equal width', 'goedemorgen' ),
		'section' => 'goedemorgen_footer_options',
		'settings' => 'goedemorgen_settings[footer][is_widgets_equal]',
		'priority' => 4,
		'type' => 'checkbox',
		'description' => esc_html__( 'By enabling this option, the footer widget items will have an equal width.', 'goedemorgen' ),
	) );

    /* General Options: Container Width */
	$wp_customize->add_setting( 'goedemorgen_settings[general][container_width]', array(
		'default' => $defaults['general']['container_width'],
		'sanitize_callback' => 'goedemorgen_sanitize_container_width_option',
	) );

	$wp_customize->add_control( 'goedemorgen_container_width', array(
		'type' => 'select',
		'label' => esc_html__( 'Container Width', 'goedemorgen' ),
		'section' => 'goedemorgen_general_options',
		'settings' => 'goedemorgen_settings[general][container_width]',
		'choices' => array(
			'large' => esc_html__( 'Large', 'goedemorgen' ),
            '' => esc_html__( 'Default', 'goedemorgen' ),
            'small' => esc_html__( 'Small', 'goedemorgen' ),
		),
		'priority' => 1,
		'description' => esc_html__( 'This option allows to change the width of the main container of your website.', 'goedemorgen' ),
	) );

    /* General Options: Archie view header image */
	$wp_customize->add_setting( 'goedemorgen_settings[archive][header_image]', array(
		'default' => $defaults['archive']['header_image'],
		'sanitize_callback' => 'absint',
	) );

    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'goedemorgen_archive_header_image', array(
        'label' => esc_html__( 'Archive View Header Image', 'goedemorgen' ),
        'section' => 'goedemorgen_archive_options',
        'settings' => 'goedemorgen_settings[archive][header_image]',
        'description' => esc_html__( 'This image will be show as a background image in all archive views.', 'goedemorgen' ),
        'mime_type' => 'image',
        'button_labels' => array(
            'select' => esc_html__( 'Select Image', 'goedemorgen' ),
            'change' => esc_html__( 'Change Image', 'goedemorgen' ),
            'frame_title' => esc_html__( 'Select Header Image', 'goedemorgen' ),
            'frame_button' => esc_html__( 'Choose Header Image', 'goedemorgen' ),
        ),
    ) ) );

    /* General Options: Blog view featured page */
    $wp_customize->add_setting( 'goedemorgen_settings[archive][featured_page_id]', array(
		'default'           => '0',
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'goedemorgen_blog_featured_page_one_id', array(
		'label' => esc_html__( 'Blog View Featured Page', 'goedemorgen' ),
        'description' => esc_html__( 'This page will be shown at the top of the first page of your blog.', 'goedemorgen' ),
		'section' => 'goedemorgen_archive_options',
        'settings' => 'goedemorgen_settings[archive][featured_page_id]',
		'type' => 'dropdown-pages',
        'active_callback' => 'goedemorgen_is_posts_page_front_page',
	) );

    /* Colors: Accent Color */
    $wp_customize->add_setting( 'goedemorgen_settings[color][accent]', array(
        'default' => $defaults['color']['accent'],
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'goedemorgen_colors_accent', array(
        'label' => esc_html__( 'Accent Color', 'goedemorgen' ),
        'section' => 'colors',
        'settings' => 'goedemorgen_settings[color][accent]',
        'priority' => 1,
    ) ) );

    /* Jumbotron Options: Text Alignment */
	$wp_customize->add_setting( 'goedemorgen_settings[jumbotron][alignment]', array(
		'default' => $defaults['jumbotron']['alignment'],
		'sanitize_callback' => 'goedemorgen_sanitize_text_alignment_option',
        'transport'   => 'postMessage',
	) );

	$wp_customize->add_control( 'goedemorgen_jumbotron_content_alignment', array(
		'type' => 'select',
		'label' => esc_html__( 'Content Alignment', 'goedemorgen' ),
		'section' => 'goedemorgen_jumbotron_options',
		'settings' => 'goedemorgen_settings[jumbotron][alignment]',
		'choices' => array(
			'' => esc_html__( 'Left Aligned', 'goedemorgen' ),
			'right' => esc_html__( 'Right Aligned', 'goedemorgen' ),
			'center' => esc_html__( 'Centered', 'goedemorgen' ),
		),
		'priority' => 1,
		'description' => esc_html__( 'This option determines how the text is displayed horizontally in the Jumbotron section.', 'goedemorgen' ),
	) );
}
add_action( 'customize_register', 'goedemorgen_add_customizer_controls' );
