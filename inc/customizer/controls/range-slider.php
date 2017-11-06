<?php
/**
 * Range slider control.
 *
 * @package Goedemorgen
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) ):

	class Goedemorgen_Customizer_Range_Slider_Control extends WP_Customize_Control {
		/**
		 * The type of customize control being rendered.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $type = 'goedemorgen-range-slider';

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
			$this->json['choices'] = $this->choices;
			$this->json['link'] = $this->get_link();
			$this->json['default'] = $this->setting->default;
			$this->json['resetLabel'] = esc_html__( 'Reset to default', 'goedemorgen' );

			if ( isset( $this->json['choices']['min'] ) && isset( $this->json['choices']['max'] ) ) {
				$this->json['notificationWarning'] = sprintf( esc_html__( 'Please select a value between %1$s and %2$s.', 'goedemorgen' ), $this->json['choices']['min'], $this->json['choices']['max'] );
			} else {
				$this->json['notificationWarning'] = esc_html__( 'This value is not allowed to have for the current option.', 'goedemorgen' );
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
			<div class="goedemorgen-range-slider-control">
				<div class="goedemorgen-control-header wp-clearfix">
					<div class="customize-control-notifications-container"></div>

					<# if ( data.label ) { #>
					<span class="customize-control-title">{{ data.label }}</span>
					<# } #>
					<button type="button" class="button goedemorgen-reset dashicons dashicons-image-rotate" title="{{ data.resetLabel }}">
						<span class="screen-reader-text">{{ data.resetLabel }}</span>
					</button><!-- .goedemorgen-reset -->
				</div><!-- .goedemorgen-control-header -->

				<label class="goedemorgen-control-body wp-clearfix">
					<div class="control-range-value wp-clearfix">
						<input type="number" class="value" value="{{ data.value }}" min="{{ data.choices['min'] }}" max="{{ data.choices['max'] }}" {{{ data.link }}} data-default="{{ data.default }}" />

						<# if ( data.choices['unit'] ) { #>
						<span class="unit">{{ data.choices['unit'] }}</span>
						<# } #>
					</div><!-- .control-range-value -->

					<div class="goedemorgen-slider" data-step="{{ data.choices['step'] }}" data-min="{{ data.choices['min'] }}" data-max="{{ data.choices['max'] }}"></div>
				</label><!-- .goedemorgen-control-body -->

				<# if ( data.description ) { #>
				<span class="description customize-control-description goedemorgen-control-description">{{ data.description }}</span>
				<# } #>
			</div><!-- .goedemorgen-range-slider-control -->
		<?php
		}
	}

endif;
