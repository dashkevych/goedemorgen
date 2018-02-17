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
    $controls_path = GOEDEMORGEN_DIR . '/inc/customizer/controls/';

    /* List all custom controls */
    $custom_controls = array(
        array(
            'class' => 'Goedemorgen_Customizer_Font_Family_Control',
            'file' => 'font-family.php',
        ),

        array(
            'class' => 'Goedemorgen_Customizer_Range_Slider_Control',
            'file' => 'range-slider.php',
        ),

        array(
            'class' => 'Goedemorgen_Customizer_Toggle_Switch_Control',
            'file' => 'toggle-switch.php',
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

    /* Typography: Body typography */
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

    /* Typography: Body font size */
    $wp_customize->add_setting( 'goedemorgen_settings[typography][body][font_size]', array(
		'default' => $defaults['typography']['body']['font_size'],
		'sanitize_callback' => 'absint',
        'transport' => 'postMessage',
	) );

    $wp_customize->add_control( new Goedemorgen_Customizer_Range_Slider_Control( $wp_customize, 'goedemorgen_settings_typography_body_fontsize', array(
		'type' => 'goedemorgen-range-slider',
		'label' => esc_html__( 'Body Font Size', 'goedemorgen' ),
		'section' => 'goedemorgen_typography_body_options',
		'settings' => 'goedemorgen_settings[typography][body][font_size]',
		'choices' => array(
            'min' => 12,
            'max' => 26,
            'step' => 1,
            'unit' => 'px',
		),
        'description' => esc_html__( 'Select the base font size for your website.', 'goedemorgen' ),
	) ) );

    /* Typography: Headings typography */
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

    /* Footer Options: Back to Top Button */
    $wp_customize->add_setting( 'goedemorgen_settings[footer][is_backtotop_button]', array(
		'default' => $defaults['footer']['is_backtotop_button'],
		'sanitize_callback' => 'goedemorgen_sanitize_toggle_switch',
	) );

    $wp_customize->add_control( new Goedemorgen_Customizer_Toggle_Switch_Control( $wp_customize, 'goedemorgen_footer_is_backtotop_button', array(
		'label' => esc_html__( 'Back to Top Button', 'goedemorgen' ),
		'section' => 'goedemorgen_footer_options',
		'settings' => 'goedemorgen_settings[footer][is_backtotop_button]',
		'priority' => 5,
		'type' => 'toggle-switch',
		'description' => esc_html__( 'Enable this option if you want to display a button that will take the user to the top of the page when clicked on.', 'goedemorgen' ),
	) ) );

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
        'label' => esc_html__( 'Archive View: Page Header Image', 'goedemorgen' ),
        'section' => 'goedemorgen_archive_options',
        'settings' => 'goedemorgen_settings[archive][header_image]',
        'description' => esc_html__( 'This image will be show as a header background image in all archive views.', 'goedemorgen' ),
        'mime_type' => 'image',
        'button_labels' => array(
            'select' => esc_html__( 'Select Image', 'goedemorgen' ),
            'change' => esc_html__( 'Change Image', 'goedemorgen' ),
            'frame_title' => esc_html__( 'Select Header Image', 'goedemorgen' ),
            'frame_button' => esc_html__( 'Choose Header Image', 'goedemorgen' ),
        ),
    ) ) );

    /* Archive View Options: Blog view featured page */
    $wp_customize->add_setting( 'goedemorgen_settings[archive][featured_page_id]', array(
		'default'           => $defaults['archive']['featured_page_id'],
		'sanitize_callback' => 'absint',
	) );

	$wp_customize->add_control( 'goedemorgen_blog_featured_page_id', array(
		'label' => esc_html__( 'Blog View: Featured Page', 'goedemorgen' ),
        'description' => esc_html__( 'This page will be shown in the page header section of your blog.', 'goedemorgen' ),
		'section' => 'goedemorgen_archive_options',
        'settings' => 'goedemorgen_settings[archive][featured_page_id]',
		'type' => 'dropdown-pages',
        'active_callback' => 'goedemorgen_is_posts_page_front_page',
	) );

    /* Archive View Options: Blog View Header Visibility */
    $wp_customize->add_setting( 'goedemorgen_settings[archive][is_posts_page_header]' , array(
        'default' => $defaults['archive']['is_posts_page_header'],
        'sanitize_callback' => 'goedemorgen_sanitize_posts_page_header_visibility_option',
    ) );

    $wp_customize->add_control( 'goedemorgen_is_posts_page_header', array(
        'label' => esc_html( 'Blog View: Page Header Visibility', 'goedemorgen' ),
        'description' => esc_html__( 'Choose on which blog pages you want to display the page header section.', 'goedemorgen' ),
        'section' => 'goedemorgen_archive_options',
        'settings' => 'goedemorgen_settings[archive][is_posts_page_header]',
        'type' => 'radio',
        'choices' => array(
            '' => esc_html__( 'Display on all pages', 'goedemorgen' ),
            'on_first' => esc_html__( 'Display on the first page only', 'goedemorgen' ),
        ),
        'active_callback' => 'goedemorgen_is_blog_header_visibility_option',
    ) );

    /* Archive View Options: Featured Image Size */
    $wp_customize->add_setting( 'goedemorgen_settings[archive][featured_image_size]' , array(
        'default' => $defaults['archive']['featured_image_size'],
        'sanitize_callback' => 'goedemorgen_sanitize_featured_image_size_option',
    ) );

    $wp_customize->add_control( 'goedemorgen_achive_featured_image_size', array(
        'label' => esc_html( 'Archive View: Featured Image Size', 'goedemorgen' ),
        'description' => esc_html__( 'This option allows to choose a size of a featured image in archive views.', 'goedemorgen' ),
        'section' => 'goedemorgen_archive_options',
        'settings' => 'goedemorgen_settings[archive][featured_image_size]',
        'type' => 'select',
        'choices' => array(
            '' => esc_html__( 'Default', 'goedemorgen' ),
            'thumbnail' => esc_html__( 'Thumbnail', 'goedemorgen' ),
            'original' => esc_html__( 'Original', 'goedemorgen' ),
        ),
        'active_callback' => '',
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
}
add_action( 'customize_register', 'goedemorgen_add_customizer_controls' );
