<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Goedemorgen
 */

if ( ! function_exists( 'goedemorgen_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function goedemorgen_posted_on( $has_link = false ) {
	$time_string = '<span class="posted-on"><span>%1$s</span> <time class="published" datetime="%2$s">%3$s</time></span>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<span class="updated-on">%4$s <time class="updated" datetime="%5$s">%6$s</time></span>';
	}

	$time_string = sprintf( $time_string,
		esc_html__( 'Posted on', 'goedemorgen' ),
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_html__( 'Updated on', 'goedemorgen' ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	// Display or hide a link to the single post page.
	if ( ! $has_link ) {
		printf( '<div class="entry-date">%s</div>', $time_string ); // WPCS: XSS OK.
	} else {
		printf( '<div class="entry-date"><a href="%1$s" rel="bookmark">%2$s</a></div>', esc_url( get_permalink() ), $time_string ); // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'goedemorgen_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current author.
 */
function goedemorgen_posted_by() {
	$author_id = get_the_author_meta( 'ID' );

	/* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
	$byline = sprintf( esc_html_x( 'By %s', 'post author', 'goedemorgen' ), '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '">' . esc_html( get_the_author() ) . '</a></span>' );

	if ( is_single() ) {
		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
	} else {
		echo '<span class="byline"> ' . get_avatar( $author_id, 140 ) . $byline . '</span>'; // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'goedemorgen_entry_categories' ) ) :
/**
 * Prints HTML with meta information for the categories.
 */
function goedemorgen_entry_categories() {
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'goedemorgen' ) );
	if ( $categories_list && goedemorgen_categorized_blog() ) {

		if ( is_single() ) {
			printf( '<div class="entry-cats secondary-color"><span>%1$s </span>%2$s</div>', esc_html__( 'Posted in:', 'goedemorgen' ), $categories_list ); // WPCS: XSS OK.
		} else {
			printf( '<span class="entry-cats">%1$s</span>', $categories_list ); // WPCS: XSS OK.
		}
	}
}
endif;

if ( ! function_exists( 'goedemorgen_entry_tags' ) ) :
/**
 * Prints HTML with meta information for the tags.
 */
function goedemorgen_entry_tags() {
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', esc_html__( ', ', 'goedemorgen' ) );
	if ( $tags_list && ! is_wp_error( $tags_list ) ) {
		printf( '<div class="entry-tags secondary-color"><span>%1$s </span>%2$s</div>', esc_html__( 'Tagged:', 'goedemorgen' ), $tags_list ); // WPCS: XSS OK.
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function goedemorgen_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'goedemorgen_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'goedemorgen_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so goedemorgen_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so goedemorgen_categorized_blog should return false.
		return false;
	}
}

if ( ! function_exists( 'goedemorgen_breadcrumbs' ) ) :
/**
 * Site Breadcrumbs based on Yoast SEO plugin
 */
function goedemorgen_breadcrumbs() {
	if ( goedemorgen_is_yoast_breadcrumbs() && ! is_front_page() ) :
		printf( '<div class="site-breadcrumbs secondary-size container-wrap">%1$s</div>', yoast_breadcrumb( '', '', false ) ); // WPCS: XSS OK.
	endif;
}
endif;

if ( ! function_exists( 'goedemorgen_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 */
function goedemorgen_the_custom_logo() {
   if ( function_exists( 'the_custom_logo' ) ) {
	   the_custom_logo();
   }
}
endif;

if ( ! function_exists( 'goedemorgen_hfeed_thumbnail' ) ) :
/**
 * Print HTML with featured image for archive views.
 */
function goedemorgen_hfeed_thumbnail() {
	$archive_options = goedemorgen_get_setting( 'archive' );

	switch ( $archive_options['featured_image_size'] ) {
	    case 'original':
	        the_post_thumbnail( 'full' );
	        break;
	    case 'thumbnail':
			add_action( 'goedemorgen_hfeed_content', 'goedemorgen_hfeed_add_content_thumbnail', 4 );
	        break;
	    default:
	        printf( '<span class="featured-image large has-background-cover has-animation" %s></span>', goedemorgen_featured_image_style_attr( false ) ); // WPCS: XSS OK.
	}
}
endif;

/**
 * Display featured image thumbnail in the entry content area.
 */
function goedemorgen_hfeed_add_content_thumbnail() {
	if ( has_post_thumbnail() ) {
		printf( '<a href="%1$s" class="thumb-link">%2$s</a>', esc_url( get_permalink() ), get_the_post_thumbnail( get_the_ID(), 'thumbnail' ) ); // WPCS: XSS OK.
	}
}

/**
 * Print HTML with the title and content for blog page.
 */
function goedemorgen_posts_page_header() {
	// Default posts page.
	if ( is_front_page() ) {
		$featured_page_id = goedemorgen_get_posts_page_featured_page_id();

		// Print HTML with the title for the posts page.
		if ( '' !== ( $featured_page_title = get_the_title( $featured_page_id ) ) ) {
			printf( '<h1 class="page-title">%s</h1>', apply_filters( 'the_title', $featured_page_title ) ); // WPCS: XSS OK.
		}

		// Print HTML with the content for the posts page.
		if ( '' !== ( $featured_page_content = get_post_field( 'post_content', $featured_page_id ) ) ) {
			printf( '<div class="archive-description">%s</div>', apply_filters( 'the_content', $featured_page_content ) ); // WPCS: XSS OK.
		}
	} else {
		$current_post = get_post( get_option( 'page_for_posts' ) );

		// Print HTML with the title for the posts page.
		if ( '' !== $current_post->post_title ) {
			printf( '<h1 class="page-title">%s</h1>', apply_filters( 'the_title', $current_post->post_title ) ); // WPCS: XSS OK.
		}

		// Print HTML with the content for the posts page.
		if ( '' !== $current_post->post_content ) {
			printf( '<div class="archive-description">%s</div>', apply_filters( 'the_content', $current_post->post_content ) ); // WPCS: XSS OK.
		}
	}
}

/**
 * Print HTML with description for the attachment.
 *
 * @param string   $class   Add a custom to class to wrapper. Optional.
 */
function goedemorgen_attachment_description( $class = 'attachment-description' ) {
	$attachment_description = get_post( get_post_thumbnail_id() )->post_excerpt;

	if ( '' !== $attachment_description ) {
		printf( '<div class="%1$s">%2$s</div>', esc_attr( $class ), esc_html( $attachment_description ) );
	}
}

/**
 * Print HTML with featured image for single views, or header image for archive views.
 */
function goedemorgen_page_header_image() {
	// Default header image.
	$image = false;

	// Display header image in archive views.
	if ( ! is_singular() ) {

		// Get the featured page id (blog view).
		$featured_page_id = goedemorgen_get_posts_page_featured_page_id();

		// Get featured image of the featured page for the posts page.
		if ( is_home() && is_front_page() && has_post_thumbnail( $featured_page_id )  ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $featured_page_id ), 'goedemorgen-featured-image' );
		} else {
			$archive_options = goedemorgen_get_setting( 'archive' );

			if ( '' !== $archive_options['header_image'] ) {
				$image = wp_get_attachment_image_src( $archive_options['header_image'], 'goedemorgen-featured-image' );
			}
		}
	} else {
		$page_id = get_the_ID();

		if ( has_post_thumbnail( $page_id ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $page_id ), 'goedemorgen-featured-image' );
		}
	}

	if ( is_array( $image ) && isset( $image[0] ) ) {
		printf( '<div class="header-image has-background-cover overlay" style="background-image: url(\'%s\');"></div>', esc_url( $image[0] ) );
	}
}

/**
 * Print HTML with credits infromation in the footer area.
 */
function goedemorgen_display_footer_credits() {
	$credits = '';

	if ( has_filter( 'goedemorgen_footer_credits' ) ) {
		$credits = apply_filters( 'goedemorgen_footer_credits', $credits );
	}

	if ( '' !== $credits ) {
		printf( '%s', wp_kses_post( $credits ) );
	} else {
		get_template_part( 'components/footer/credits-content' );
	}
}

/**
 * Adds social menu to the footer area.
 */
function goedemorgen_add_footer_social_menu() {
	get_template_part( 'menu', 'social' );
}

/**
 * Displays author bio in single post views.
 */
function goedemorgen_author_bio() {
	get_template_part( 'components/post/author', 'section' );
}

/**
 * Checks if current post has a content.
 *
 * @return bool
 */
function goedemorgen_has_content() {
	return '' !== get_post_field( 'post_content', get_the_ID() ) ? true : false;
}
