<?php
/**
 * Theme filters.
 *
 * @package Goedemorgen
 */

/**
* Adds custom classes to the array of body classes.
*
* @param array $classes Classes for the body element.
* @return array
*/
function goedemorgen_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class if a sidebar is not active.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'inactive-sidebar';
	} else {
		$classes[] = 'active-sidebar';
	}

	// Adds a class if the user is visiting using a mobile device.
	if ( wp_is_mobile() ) {
		$classes[] = 'mobile-view';
	}

	// Adds a class if user wants to change a default width of container.
	$classes[] = goedemorgen_get_container_width_class();

	return $classes;
}
add_filter( 'body_class', 'goedemorgen_body_classes' );

/**
 * Display page-links for paginated posts before Jetpack's share buttons and related posts.
 */
function goedemorgen_custom_link_pages( $content ) {
	if ( is_singular() ) {
		$content .= wp_link_pages( array(
			'before' => '<div class="page-links secondary-size"><span class="page-links-title">' . esc_html__( 'Pages:', 'goedemorgen' ) . '</span>',
			'after' => '</div>',
			'link_before' => '<span>',
			'link_after' => '</span>',
			'pagelink' => '<span class="screen-reader-text">' . esc_html__( 'Page', 'goedemorgen' ) . ' </span>%',
			'separator' => '<span class="screen-reader-text">, </span>',
			'echo' => 0,
		) );
	}

	return $content;
}
add_filter( 'the_content', 'goedemorgen_custom_link_pages', 1 );

if ( ! function_exists( 'goedemorgen_set_tag_cloud_font_size' ) ) :
/**
 * Modify tag cloud widget font size.
 */
function goedemorgen_set_tag_cloud_font_size( $args ) {
    $args['smallest'] = 0.875;
    $args['largest'] = 0.875;
	$args['unit'] = 'rem';

    return $args;
}
add_filter( 'widget_tag_cloud_args', 'goedemorgen_set_tag_cloud_font_size' );
endif;

if ( ! function_exists( 'goedemorgen_filter_archive_title' ) ) :
/**
 * Add a span around the title prefix so that the prefix can be hidden with CSS.
 *
 * @param string $title Archive title.
 * @return string Archive title with inserted span around prefix.
 */
function goedemorgen_filter_archive_title( $title ) {
	// Split the title into parts so we can wrap them with span tag.
	$title_parts = explode( ': ', $title, 2 );

	// Glue title's parts back together.
	if ( ! empty( $title_parts[1] ) ) {
		// Add a span around the title.
		$title = '<span>' . $title_parts[0] . ': </span>' . $title_parts[1];

		// Sanitize our title.
		$title = wp_kses( $title, array( 'span' => array(), ) );
	}

	return $title;

}
add_filter( 'get_the_archive_title', 'goedemorgen_filter_archive_title' );
endif;

if ( ! function_exists( 'goedemorgen_excerpt_more' ) ) :
/**
 *	Customize excerpts More tag.
 */
function goedemorgen_excerpt_more( $more ) {
	if ( ! is_search() ) {
		/* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
		return sprintf( '&#x2026; <span class="link-container"><a href="%1$s" class="more-link">%2$s</a></span>',
			esc_url( get_permalink( get_the_ID() ) ),
			sprintf( esc_html__( 'Continue Reading %s', 'goedemorgen' ), '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>' )
		);
	}
}
add_filter( 'excerpt_more', 'goedemorgen_excerpt_more' );
endif;

if ( ! function_exists( 'goedemorgen_modify_more_link' ) ) :
/**
 * Modify the post's "more" link.
 *
 * @param string $link More link.
 * @return string More link with a "button" class and wrapped withig a span.
 */
function goedemorgen_modify_more_link( $link ) {
	$link = str_replace( 'more-link', 'more-link button', $link );
	return sprintf( '<span class="link-container">%s</span>', $link );
}
add_filter( 'the_content_more_link', 'goedemorgen_modify_more_link' );
endif;

/**
* Retrieve the classes for the jumbotron area as an array.
*/
function goedemorgen_jumbotron_class( $classes ) {
	if ( goedemorgen_is_jumbotron_header() ) {
		// Get jumbotron options.
		$jumbotron_options = goedemorgen_get_setting( 'jumbotron' );

		// Default classes.
		$classes[] = 'clear';
		$classes[] = 'jumbotron-header';
	}

	return $classes;
}
add_filter( 'goedemorgen_page_header_class', 'goedemorgen_jumbotron_class' );

/**
 * Check if we need to display a page header section in blog view.
 */
function goedemorgen_is_posts_page_header( $is_page_header ) {
	if ( is_home() ) {
		$archive_options = goedemorgen_get_setting( 'archive' );

		// Display the page header only if the posts page has a featured page.
		if ( is_front_page() && ! goedemorgen_get_posts_page_featured_page_id() ) {
			$is_page_header = false;
		}

		// Display the page header only on the first page.
		if ( 'on_first' === $archive_options['is_posts_page_header'] && is_paged() ) {
			$is_page_header = false;
		}
	}

	return $is_page_header;
}
add_filter( 'goedemorgen_is_page_header', 'goedemorgen_is_posts_page_header' );
