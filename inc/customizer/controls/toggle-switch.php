<?php
/**
 * Toggle switch control.
 *
 * @package Goedemorgen
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) ):

	class Goedemorgen_Customizer_Toggle_Switch_Control extends WP_Customize_Control {
		/**
		 * The type of customize control being rendered.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $type = 'toggle-switch';

		/**
		 * Add custom parameters to pass to the JS via JSON.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function to_json() {
			parent::to_json();

			$this->json['value'] = $this->value();
			$this->json['link'] = $this->get_link();
			$this->json['id'] = $this->id;
		}

		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			if ( ! wp_style_is( 'goedemorgen-custom-controls-css', 'queue' ) ) {
				wp_enqueue_style( 'goedemorgen-custom-controls-css', GOEDEMORGEN_DIR_URI . '/inc/customizer/css/custom-controls.css', array(), '1.0', 'all' );
			}
		}

		/**
	     * Underscore JS template to handle the control's output.
	     *
	     * @since  1.0.0
	     * @access public
	     * @return void
	     */
		public function content_template() { ?>

			<input type="checkbox" value="{{ data.value }}" <# if ( "1" == data.value ) { #> checked="checked" <# } #> {{{ data.link }}} id="{{ data.id }}" class="toggle-switch-checkbox">
			<label for="{{ data.id }}">{{ data.label }}</label>

			<# if ( data.label ) { #>
			    <span class="customize-control-title">{{ data.label }}</span>
			<# } #>

			<# if ( data.description ) { #>
			    <span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		<?php
		}
	}

endif;
