<?php
/**
 * This class adds extra CSS to the theme.
 *
 * @package Goedemorgen
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Goedemorgen_Settings Class.
 *
 * @since 1.0.0
 */
class Goedemorgen_Extra_CSS {
	/**
	 * Class instance.
	 */
	protected static $instance = null;

	/**
	 * This holds default typography options.
	 *
	 * @access protected
	 */
	protected static $typography_defaults = array();

	/**
	 * This holds selected typography options.
	 *
	 * @access protected
	 */
	protected static $typography = array();

	/**
	 * This holds default color options.
	 *
	 * @access protected
	 */
	protected static $color_defaults = array();

	/**
	 * This holds selected color options.
	 *
	 * @access protected
	 */
	protected static $color = array();

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Magic method to keep the object from being cloned.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function __clone() {}

	/**
	 * Magic method to keep the object from being unserialized.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
   	private function __wakeup() {}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Goedemorgen_Extra_CSS ) ) {
			self::$instance = new Goedemorgen_Extra_CSS;
			self::$instance->get_options();
			self::$instance->init();
		}
		return self::$instance;
	}

	/**
  	 * Set theme options.
  	 *
  	 * @since  1.0.0
  	 * @access protected
  	 * @return void
  	 */
	protected static function get_options() {
		self::$typography_defaults = goedemorgen_get_setting( 'typography', true );
		self::$typography = goedemorgen_get_setting( 'typography' );
		self::$color_defaults = goedemorgen_get_setting( 'color', true );
		self::$color = goedemorgen_get_setting( 'color' );
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @return void
	 */
	protected static function init() {
		add_filter( 'goedemorgen_set_extra_css', array( self::instance(), 'set_custom_accent_color' ) );
		add_filter( 'goedemorgen_set_extra_css', array( self::instance(), 'set_body_font_style' ) );
		add_filter( 'goedemorgen_set_extra_css', array( self::instance(), 'set_headings_font_style' ) );
		add_filter( 'goedemorgen_set_extra_css', array( self::instance(), 'set_body_font_size' ) );
		add_action( 'customize_preview_init', array( self::instance(), 'update_selected_options' ) );
	}

	/**
  	 * Update selected theme options when viewed in the Customizer.
  	 *
  	 * @since  1.0.0
  	 * @access public
  	 * @return void
  	 */
	public function update_selected_options() {
		self::$typography = goedemorgen_get_setting( 'typography' );
		self::$color = goedemorgen_get_setting( 'color' );
	}

	/**
  	 * Clean extra CSS styles by removing extra spaces and tabs.
  	 *
  	 * @since  1.0.0
  	 * @access protected
  	 * @return string
  	 */
	public function clean_extra_css( $css ) {
		return trim( preg_replace( '/\s+/', ' ', $css ) );
	}

	/**
	 * Change accent color.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param array
	 * @return array
	 */
	public function set_custom_accent_color( $extra_css ) {
		if ( isset( self::$color['accent'] ) && self::$color_defaults['accent'] !== self::$color['accent'] ) {
			$accent_color = "
							a,
							a:visited,
							#masthead .main-navigation ul:not(.sub-menu):not(.children) > li > a:hover,
							.content-area blockquote:not(.pull-left):not(.pull-right):before { color: " . self::$color['accent'] . "; }
							";

			$accent_color .= "
							button,
							a.button:not(.secondary-button),
							input[type='button'],
							input[type='reset'],
							input[type='submit'] { background: " . self::$color['accent'] . "; }
							";

			$accent_color .= "
							input[type='text']:focus,
							input[type='email']:focus,
							input[type='url']:focus,
							input[type='password']:focus,
							input[type='search']:focus,
							input[type='number']:focus,
							input[type='tel']:focus,
							input[type='range']:focus,
							input[type='date']:focus,
							input[type='month']:focus,
							input[type='week']:focus,
							input[type='time']:focus,
							input[type='datetime']:focus,
							input[type='datetime-local']:focus,
							input[type='color']:focus,
							textarea:focus { border-color: " . self::$color['accent'] . "; }
			                ";

			$extra_css[] = $accent_color;
		}

		return $extra_css;
	}

	/**
	 * Add a custom body font style.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param array
	 * @return array
	 */
	public function set_body_font_style( $extra_css ) {
		if ( isset( self::$typography['body']['font_family'] ) && self::$typography_defaults['body']['font_family'] !== self::$typography['body']['font_family'] ) {

			if ( 'System Stack' === self::$typography['body']['font_family'] ) {
				$font_family = goedemorgen_get_system_font_stack();
			} else {
				$font_family = self::$typography['body']['font_family'];
			}

			$extra_css[] = "body, button, input, select, textarea { font-family: " . $font_family . "; }";
		}

 		return $extra_css;
 	}

	/**
 	 * Add a custom headings font style.
 	 *
 	 * @since  1.0.0
 	 * @access public
	 * @param array
 	 * @return array
 	 */
	public function set_headings_font_style( $extra_css ) {
		if ( isset( self::$typography['headings']['font_family'] ) && self::$typography_defaults['headings']['font_family'] !== self::$typography['headings']['font_family'] ) {

			if ( 'System Stack' === self::$typography['headings']['font_family'] ) {
				$font_family = goedemorgen_get_system_font_stack();
			} else {
				$font_family = self::$typography['headings']['font_family'];
			}

			$extra_css[] = "h1, h2, h3, h4, h5, h6 { font-family: " . $font_family . "; }";
		}

		return $extra_css;
	}

	/**
 	 * Add a custom font size for a website body.
 	 *
 	 * @since  1.0.0
 	 * @access public
	 * @param array
 	 * @return array
 	 */
	public function set_body_font_size( $extra_css ) {
		if ( isset( self::$typography['body']['font_size'] ) && self::$typography_defaults['body']['font_size'] !== self::$typography['body']['font_size'] ) {
			$extra_css[] = 'html { font-size: ' . esc_attr( self::$typography['body']['font_size'] ) . 'px; }';
		}

		return $extra_css;
	}
}

/**
 * The main function that returns Goedemorgen_Extra_CSS instance.
 *
 * @return object|Goedemorgen_Extra_CSS.
 */
function goedemorgen_extra_css() {
	return Goedemorgen_Extra_CSS::instance();
}

// Get goedemorgen_extra_css running.
goedemorgen_extra_css();
