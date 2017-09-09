<?php
/**
 * Typography Control.
 *
 * @package Goedemorgen
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) ):

	class Goedemorgen_Customizer_Font_Family_Control extends WP_Customize_Control {
		/**
		 * The type of customize control being rendered.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $type = 'font-family';

		/**
		 * Add custom parameters to pass to the JS via JSON.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 */
		public function to_json() {
			parent::to_json();

			$this->json['value'] = $this->sanitize_font( $this->value() );
			$this->json['choices'] = $this->get_google_fonts();
			$this->json['link'] = $this->get_link();
			$this->json['defaultValue'] = $this->setting->default;
		}

		/**
		 * Sanitize a default font.
		 *
		 * @since  1.0.0
		 * @access private
		 * @param String $font A single name of the font.
		 * @return string
		 */
		private function sanitize_font( $font ) {
			$font = esc_attr( $font );
			if ( in_array( $font, $this->get_google_fonts() ) ) {
				return $font;
			} else {
				return '';
			}
		}

		/**
		 * Get json of all google fonts.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return array
		 */
		private function get_google_fonts_json() {
			$font_data  = get_transient( 'goedemorgen-google-fonts-json' );

			if ( ! empty( $font_data ) ) {
				return $font_data;
			} else {
				include GOEDEMORGEN_DIR . '/inc/customizer/extensions/google-fonts-json.php';

				if ( isset( $google_fonts_json ) ) {
					$font_data = json_decode( $google_fonts_json, true );
					set_transient( 'goedemorgen-google-fonts-json', $font_data, WEEK_IN_SECONDS );
					return $font_data;
				} else {
					return false;
				}
			}
		}

	    /**
		 * Get all availible google fonts.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return array
		 */
		public function get_google_fonts() {
			$font_data = $this->get_google_fonts_json();
			$fonts = array();

			if ( ! empty( $font_data ) ) {
				foreach( $font_data as $family => $variants) {
					$fonts[$family] = $family;
				}
			}

			return $fonts;
		}

		/**
	     * Underscore JS template to handle the control's output.
	     *
	     * @since  1.0.0
	     * @access public
	     * @return void
	     */
		public function content_template() { ?>

			<label>
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{ data.label }}</span>
				<# } #>

				<select {{{ data.link }}} name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}">
					<# for ( key in data.choices ) { #>
						<option value="{{ key }}" <# if ( key === data.value ) { #> selected="selected" <# } #>>{{ data.choices[ key ] }}</option>
					<# } #>
				</select>

				<p><button class="button-link reset-font-family" data-default-value="{{ data.defaultValue }}"><?php esc_html_e( 'Reset to default', 'goedemorgen' ); ?></button></p>

				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
			</label>

		<?php
		}
	}

endif;
