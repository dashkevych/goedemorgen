<?php
/**
 * Contact Form 7 compatibility file.
 *
 * @link https://contactform7.com/
 *
 * @package Goedemorgen
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  Goedemorgen_WPCF7 Class.
 *
 * @since 1.0.4
 */
class Goedemorgen_WPCF7 {
	/**
	 * Class instance.
	 */
	protected static $instance = null;

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.4
	 * @access public
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Goedemorgen_WPCF7 ) ) {
			self::$instance = new Goedemorgen_WPCF7;
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Sets up initial actions and filters.
	 *
	 * @since  1.0.4
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'goedemorgen_setting_sections', array( __CLASS__, 'add_plugin_settings_section' ) );
		add_filter( 'goedemorgen_setting_defaults', array( __CLASS__, 'add_default_settings' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
		add_action( 'customize_register', array( __CLASS__, 'customizer_options' ) );
	}

	/**
	 * Load plugin styles.
	 *
	 * @since  1.0.4
	 * @access public
	 * @return void
	 */
	public static function enqueue_scripts() {
		// Get current settings of the plugin.
		$plugin_options = goedemorgen_get_setting( 'plugins' );

		// Load custom styles only if it's set in the Customizer.
		if ( ! isset( $plugin_options['wpcf7']['is_default_styles'] ) || ! $plugin_options['wpcf7']['is_default_styles'] ) {
			return;
		}

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

	/**
	 * Sets up Customizer options.
	 *
	 * @since  1.0.4
	 * @access public
	 * @param  WP_Customize_Manager $wp_customize Object that holds the customizer data.
	 * @return void
	 */
	public static function customizer_options( $wp_customize ) {
		// Get default values of the plugin settings.
		$defaults = goedemorgen_get_setting( 'plugins', true );

		/* Contact Form 7 section */
		$wp_customize->add_section( 'goedemorgen_wpcf7_options', array(
			'title' => esc_html__( 'Contact Form 7', 'goedemorgen' ),
			'panel' => 'goedemorgen_plugins_panel',
		) );

		$wp_customize->add_setting( 'goedemorgen_settings[plugins][wpcf7][is_default_styles]', array(
			'default' => $defaults['wpcf7']['is_default_styles'],
			'sanitize_callback' => 'goedemorgen_sanitize_checkbox',
		) );

		$wp_customize->add_control( 'goedemorgen_plugins_default_styles', array(
			'label' => esc_html__( 'Use styles created by the theme', 'goedemorgen' ),
			'section' => 'goedemorgen_wpcf7_options',
			'settings' => 'goedemorgen_settings[plugins][wpcf7][is_default_styles]',
			'priority' => 1,
			'type' => 'checkbox',
			'description' => esc_html__( 'By enabling this option, default styles of the plugin will be disabled.', 'goedemorgen' ),
		) );
	}

	/**
	 * Add plugin section to the theme settings.
	 *
	 * @since  1.0.4
	 * @access public
	 * @param  array $sections
	 * @return array
	 */
	public static function add_plugin_settings_section( $sections ) {
		$sections[] = 'plugins';

		return $sections;
	}

	/**
	 * Add default WPCF7 settings.
	 *
	 * @since  1.0.4
	 * @access public
	 * @param  array $defaults
	 * @return array
	 */
	public static function add_default_settings( $defaults ) {
		// Check if plugin section is availible for default values.
		if ( ! isset( $defaults['plugins'] ) ) {
			$defaults['plugins'] = array();
		}

		// Add WPCF7 default values.
		if ( ! isset( $defaults['plugins']['wpcf7'] ) ) {
			$defaults['plugins']['wpcf7'] = array(
				'is_default_styles' => true
			);
		}

		return $defaults;
	}
}

Goedemorgen_WPCF7::instance();
