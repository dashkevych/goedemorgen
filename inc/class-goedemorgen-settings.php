<?php
/**
 * Theme options functionality.
 *
 * @package Goedemorgen
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Goedemorgen_Settings Class
 *
 * @since 1.0.0
 */
final class Goedemorgen_Settings {

	/**
	 * Retrieve settings for the specific section.
	 *
	 * @since  1.0.0
	 * @access private
	 * @param array $options, string $section
	 * @return array
	 */
	private static function validate_section( $options, $section ) {
		$sections = array(
			'general', 'header', 'footer', 'archive', 'typography', 'jumbotron', 'color',
		);

		if ( in_array( $section, $sections ) ) {

			if ( ! empty( $options[$section] ) ) {
				return $options[$section];
			}
		}

		return array();
	}

	/**
	 * Retrieve current theme options that were set in the Customizer.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param string $section
	 * @return array
	 */
	private static function get_theme_options( $section = false ) {
		$theme_options = (array) get_theme_mod( 'goedemorgen_settings', '' );
		if ( $section ) {
			$theme_options = self::validate_section( $theme_options, $section );
		}

		return $theme_options;
	}

	/**
	 * Set default theme options.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private static function get_defaults( $section = false ) {
		$defaults = array(
			'general' => array(
				'container_width' => '',
			),

			'footer' => array(
				'widgets_layout' => '4',
				'is_widgets_equal' => '',
			),

			'archive' => array(
				'header_image' => '',
			),

			'typography' => array(
				'body' => array(
					'font_family' => 'Open Sans',
				),

				'headings' => array(
					'font_family' => 'Raleway',
				),
			),

			'jumbotron' => array(
				'alignment' => '',
			),

			'color' => array(
				'accent' => '#0161bd',
			),
		);

		if ( $section ) {
			$defaults = self::validate_section( $defaults, $section );
		}

		return $defaults;
	}

	/**
	 * Retrieve theme options mixed with a default options.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param string $section
	 * @return array
	 */
	public static function get_options( $section = false ) {
		if ( $section ) {
			if ( 'defaults' === $section ) {
				return self::get_defaults();
			} else {
				return wp_parse_args(
			        self::get_theme_options( $section ),
			        self::get_defaults( $section )
			    );
			}
		} else {
			return wp_parse_args(
				self::get_theme_options(),
				self::get_defaults()
			);
		}
	}
}

/**
 * A wrapper for theme's settings.
 */
function goedemorgen_get_setting( $section = false ) {
	return Goedemorgen_Settings::get_options( $section );
}
