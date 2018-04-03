<?php
/**
 * SiteOrigin Page Builder Compatibility File.
 *
 * @link https://siteorigin.com/
 *
 * @package Goedemorgen
 */

 // Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *  Goedemorgen_SiteOrigin Class.
 *
 * @since 1.0.5
 */
class Goedemorgen_SiteOrigin {
	/**
	 * Class instance.
	 */
	protected static $instance = null;

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.5
	 * @access public
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Goedemorgen_SiteOrigin ) ) {
			self::$instance = new Goedemorgen_SiteOrigin;
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Sets up initial actions and filters.
	 *
	 * @since  1.0.5
	 * @access public
	 * @return void
	 */
	public static function init() {
		add_filter( 'siteorigin_panels_full_width_container', array( __CLASS__, 'set_full_width_container' ) );
		add_filter( 'siteorigin_panels_settings_fields', array( __CLASS__, 'remove_full_width_container_settings_field' ) );
	}

	/**
	 * Add plugin section to the theme settings.
	 *
	 * @since  1.0.5
	 * @access public
	 * @return string
	 */
	public static function set_full_width_container() {
		return '#main';
	}

	/**
	 * Remove "Full Width Container" option from the settings fields.
	 *
	 * @since  1.0.5
	 * @access public
	 * @param  array $fields
	 * @return array
	 */
	public static function remove_full_width_container_settings_field( $fields ) {
		if ( isset( $fields['layout']['fields']['full-width-container'] ) ) {
			unset( $fields['layout']['fields']['full-width-container'] );
		}

		return $fields;
	}
}

Goedemorgen_SiteOrigin::instance();
