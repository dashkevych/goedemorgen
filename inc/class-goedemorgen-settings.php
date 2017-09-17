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
		// Default sections.
		$sections = array(
			'general', 'header', 'footer', 'archive', 'typography', 'jumbotron', 'color',
		);

		// Additional sections.
		$additional_sections = apply_filters( 'goedemorgen_setting_sections', array() );

		// Merge default sections and additional sections.
		if ( ! empty( $additional_sections ) ) {
			$sections = array_merge( $sections, $additional_sections );
		}

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
		// Default theme options for the General section.
		$general_defaults = array(
			'container_width' => '',
		);

		// Default theme options for the Footer section.
		$footer_defaults = array(
			'widgets_layout' => '4',
			'is_widgets_equal' => '',
			'is_backtotop_button' => '0',
		);

		// Default theme options for the Archive section.
		$archive_defaults = array(
			'header_image' => '',
			'featured_page_id' => '0',
			'is_posts_page_header' => '',
			'featured_image_size' => '',
		);

		// Default theme options for the Typography section.
		$typography_defaults = array(
			'body' => array(
				'font_family' => 'Open Sans',
			),

			'headings' => array(
				'font_family' => 'Raleway',
			),
		);

		// Default theme options for the Jumbotron section.
		$jumbotron_defaults = array(
			'alignment' => '',
		);

		// Default theme options for the Color section.
		$color_defaults = array(
			'accent' => '#0161bd',
		);

		$defaults = array(
			'general' => apply_filters( 'goedemorgen_default_general_options', $general_defaults ),
			'footer' => apply_filters( 'goedemorgen_default_footer_options', $footer_defaults ),
			'archive' => apply_filters( 'goedemorgen_default_archive_options', $archive_defaults ),
			'typography' => apply_filters( 'goedemorgen_default_typography_options', $typography_defaults ),
			'jumbotron' => apply_filters( 'goedemorgen_default_jumbotron_options', $jumbotron_defaults ),
			'color' => apply_filters( 'goedemorgen_default_color_options', $color_defaults ),
		);

		if ( $section ) {
			$defaults = self::validate_section( $defaults, $section );
		}

		return $defaults;
	}

	/**
	 * Retrieve theme options mixed with default options.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param string $section
	 * @param bool $get_defaults
	 * @return array
	 */
	public static function get_options( $section = false, $get_defaults = false ) {
		if ( $section ) {
			if ( 'defaults' === $section ) {
				return self::get_defaults();
			} else {
				if ( $get_defaults ) {
					return self::get_defaults( $section );
				} else {
					return wp_parse_args(
				        self::get_theme_options( $section ),
				        self::get_defaults( $section )
				    );
				}
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
function goedemorgen_get_setting( $section = false, $get_defaults = false ) {
	return Goedemorgen_Settings::get_options( $section, $get_defaults );
}
