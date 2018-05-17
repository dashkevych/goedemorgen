<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Goedemorgen
 */

/**
 * Retrieve the classes for the site footer area as an array.
 */
 function goedemorgen_footer_class() {
	// Default classes.
	$classes = array( 'site-footer', 'container-wrap', 'secondary-size' );

	// Widget area options: layout and column width.
	$widget_options = goedemorgen_get_setting( 'footer' );

	$classes[] =  'widgets-col-' . $widget_options['widgets_layout'];

	if ( isset( $widget_options['is_widgets_equal'] ) && '' != $widget_options['is_widgets_equal'] ) {
		$classes[] = 'widgets-equal-width';
	}

	// Allow to add custom classes.
	$classes = array_unique( apply_filters( 'goedemorgen_footer_class', $classes ) );

	// Clean added classes.
	$classes = array_map( 'esc_attr', $classes );

	printf( 'class="%s"', join( ' ', $classes ) ); // WPCS: XSS OK.
 }

/**
 * Check if Yoast breadcrumbs option is enabled.
 */
function goedemorgen_is_yoast_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		$options = get_option( 'wpseo_internallinks' );

		if ( isset( $options['breadcrumbs-enable'] ) ) {
			return (bool) $options['breadcrumbs-enable'];
		}
	}

	return false;
}

/**
 * Add featured image as background image.
 *
 * @param bool   $echo   Optional, default to true. Whether to display or return.
 */
function goedemorgen_featured_image_style_attr( $echo = true ) {

	$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'goedemorgen-featured-image' );

	if ( ! is_array( $image ) ) {
		return;
	}

	if ( $echo ) {
		printf( ' style="background-image: url(\'%s\');"', esc_url( $image[0] ) );
	} else {
		return sprintf( ' style="background-image: url(\'%s\');"', esc_url( $image[0] ) );
	}
}

/**
 * Check if current page is set to the Front Page template.
 */
function goedemorgen_is_front_page_template() {
	$template = get_post_meta( get_the_ID(), '_wp_page_template', true );
	$is_template = preg_match( '%front-page.php%', $template );

	if (  0 == $is_template ) {
		return false;
	} else {
		return true;
	}
}

/**
 * Check if current page is set to the Panels template.
 */
function goedemorgen_is_panels_template() {
	$template = get_post_meta( get_the_ID(), '_wp_page_template', true );
	$is_template = preg_match( '%panels-page.php%', $template );

	if (  0 == $is_template ) {
		return false;
	} else {
		return true;
	}
}

/**
 * Check if the current page has a Jumbotron section.
 */
function goedemorgen_is_jumbotron_header() {
	// Check if the current page is Panels Page template.
	if ( is_page() && goedemorgen_is_panels_template() ) {
		return true;
	}

	// Check if the current page is the Blog page.
	if ( is_home() ) {
		if ( is_front_page() ) {
			// Get the ID of the feautred page in blog view.
			$featured_page_id = goedemorgen_get_posts_page_featured_page_id();

			if ( $featured_page_id && '' != get_post_field( 'post_content', $featured_page_id ) ) {
				return true;
			}
		} else {
			// Get the ID of the page which is set to the Posts Page.
			$current_post = get_post( get_option( 'page_for_posts' ) );

			if ( '' != $current_post->post_content ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Retrieve the classes for the page header area as an array.
 */
function goedemorgen_page_header_class() {
	// Default classes.
	$classes = array( 'page-header', 'container-wrap' );

	if ( ! is_singular() ) {

		if ( is_home() && is_front_page() && has_post_thumbnail( goedemorgen_get_posts_page_featured_page_id() ) ) {
			$classes[] = 'has-post-thumbnail';
		} else {
			$archive_options = goedemorgen_get_setting( 'archive' );
			// Add class if header image is set.
			if ( isset( $archive_options['header_image'] ) && '' != $archive_options['header_image'] ) {
				$classes[] = 'has-post-thumbnail';
			}
		}

	} else {
		$classes[] = 'entry-header';

		// Add class if featured image is set.
		if ( has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		}
	}

	// Allow to add custom classes.
	$classes = array_unique( apply_filters( 'goedemorgen_page_header_class', $classes ) );

	// Clean added classes.
	$classes = array_map( 'esc_attr', $classes );

	printf( 'class="%s"', join( ' ', $classes ) ); // WPCS: XSS OK.
}

/**
 * Check if we need to display a page header section.
 */
function goedemorgen_is_page_header() {
	// Display page header by default.
	$is_page_header = true;

	/**
	 * Hide page header section on the custom Front Page template and in blog view
	 * when there is no static front page.
	 */
	if (
		is_singular() ||
		goedemorgen_is_front_page_template() ||
		is_404() ||
		( is_search() && ! have_posts() )
	) {
		$is_page_header = false;
	}

	if ( has_filter( 'goedemorgen_is_page_header' ) ) {
		$is_page_header = apply_filters( 'goedemorgen_is_page_header', $is_page_header );
	}

	return (bool) $is_page_header;
}

/**
 * Check if we need to display hentry header in single views.
 */
function goedemorgen_is_singular_hentry_header() {
	// Display hentry header by default.
	$is_hentry_header = true;

	if ( has_filter( 'goedemorgen_is_page_header' ) ) {
		$is_hentry_header = apply_filters( 'goedemorgen_is_singular_hentry_header', $is_hentry_header );
	}

	return (bool) $is_hentry_header;
}

/**
 * Retrieve child posts of the current parent page.
 */
function goedemorgen_get_children_query() {
	return new WP_Query( array(
		'post_type'      => 'page',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_parent'    => get_the_ID(),
		'posts_per_page' => 99,
		'no_found_rows'  => true,
	) );
}

/**
 * Retrieve the class based on container width.
 */
function goedemorgen_get_container_width_class() {
	$general_options = goedemorgen_get_setting( 'general' );
	if ( isset( $general_options['container_width'] ) && '' != $general_options['container_width'] ) {
		return 'container-' . $general_options['container_width'];
	} else {
		return 'container-default';
	}
}

/**
 * Get ID of the featured page in blog view.
 */
function goedemorgen_get_posts_page_featured_page_id() {
	$archive_options = goedemorgen_get_setting( 'archive' );
	return $archive_options['featured_page_id'];
}
