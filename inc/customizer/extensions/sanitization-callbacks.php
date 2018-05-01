<?php
/**
 * Customizer: Sanitization Callbacks.
 *
 * @package Goedemorgen
 */

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
function goedemorgen_sanitize_checkbox( $checked ) {
 	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Google font family sanitization callback.
 *
 * Sanitization callback for 'typography' type controls. This callback sanitizes `$font_family`
 * as a string.
 *
 * @param string $font_family Whether the font is availible in collection.
 * @return string Google font family.
 */
function goedemorgen_sanitize_font_family( $font_family ) {
    $font_data  = get_transient( 'goedemorgen-google-fonts-json' );

    if ( ! empty( $font_data ) ) {
        $fonts = array();
        $default_fonts = goedemorgen_get_default_fonts();

        foreach( $font_data as $family => $variants ) {
            $fonts[$family] = $family;
        }

        $fonts = array_merge( $fonts, $default_fonts );

        if ( in_array( $font_family, $fonts ) ) {
            return $font_family;
        } else {
            return 'Open Sans';
        }

    } else {
        return esc_attr( $font_family );
    }
}

/**
 * Text alignment sanitization callback.
 *
 * Sanitization callback for 'select' type controls. This callback sanitizes `$option`
 * as a string value, the position of the text. Either "left", "right" or "center".
 *
 * @param bool $option Selected option.
 * @return string Aligment of the text.
 */
function goedemorgen_sanitize_text_alignment_option( $option ) {
    if ( in_array( $option, array( 'left', 'right', 'center' ) ) ) {
		return $option;
	} else {
		return '';
	}
}

/**
 * Container width sanitization callback.
 *
 * Sanitization callback for 'select' type controls. This callback sanitizes `$option`
 * as a string value, the width of the main container. Either "small" or "large".
 *
 * @param bool $option Selected option.
 * @return string Aligment of the text.
 */
 function goedemorgen_sanitize_container_width_option( $option ) {
    if ( in_array( $option, array( 'small', 'large' ) ) ) {
 		return $option;
 	} else {
 		return '';
 	}
 }

/**
 * Posts page header visibility sanitization callback.
 *
 * Sanitization callback for 'radio' type controls. This callback sanitizes `$option`
 * as a string value, location of the page header in blog view.
 *
 * @param bool $option Selected option.
 * @return string Aligment of the text.
 */
function goedemorgen_sanitize_posts_page_header_visibility_option( $option ) {
    if ( 'on_first' === $option ) {
        return $option;
    } else {
        return '';
    }
}

/**
 * Toggle switch sanitization callback.
 *
 * Sanitization callback for 'toggle-switch' type controls. This callback sanitizes `$option`
 * as a string value, either ON or OFF.
 *
 * @param bool $option Selected option.
 * @return string ON/OFF as a number.
 */
function goedemorgen_sanitize_toggle_switch( $option ) {
   if ( in_array( $option, array( '0', '1' ) ) ) {
       return $option;
   } else {
       return '0';
   }
}

/**
 * Featured image size sanitization callback.
 *
 * Sanitization callback for "Featured Image Size" option. This callback sanitizes `$option`
 * as a string value, either empty string, 'thumbnail' or 'original'.
 *
 * @param bool $option Selected option.
 * @return string ON/OFF as a number.
 */
function goedemorgen_sanitize_featured_image_size_option( $option ) {
   if ( in_array( $option, array( 'thumbnail', 'original' ) ) ) {
       return $option;
   } else {
       return '';
   }
}

/**
 * Active callback for Jumbotron section.
 *
 * Display Jumbotron section only for the pages that has Jumbotron functionality.
 *
 * @return @return bool True/False . Either display or hide Jumbotron section.
 */
function goedemorgen_is_jumbotron_active() {

    if ( is_page_template( 'templates/panels-page.php' ) ) {
        return true;
    }

    return false;
}

/**
 * Active callback for the Posts page.
 *
 * Display "Blog View: Featured Page" option only if the Front Page displays recent blog posts.
 *
 * @return @return bool True/False . Either display or hide "Blog View: Featured Page" option.
 */
function goedemorgen_is_posts_page_front_page() {

    if ( is_home() && is_front_page() ) {
        return true;
    }

    return false;
}

/**
 * Active callback for the "Blog View: Header Visibility" option.
 *
 * Display "Blog View: Header Visibility" option only if the blog header section has content.
 *
 * @return @return bool True/False . Either display or hide "Blog View: Header Visibility" option.
 */
function goedemorgen_is_blog_header_visibility_option() {
    if ( goedemorgen_is_posts_page_front_page() || get_option( 'page_for_posts' ) ) {
        return true;
    }

    return false;
}
