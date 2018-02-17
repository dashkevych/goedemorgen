<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
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
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function goedemorgen_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'goedemorgen_pingback_header' );

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
 * Display page-links for paginated posts before Jetpack's share buttons and related posts.
 */
function goedemorgen_custom_link_pages( $content ) {
	if ( is_singular() ) {

		$content .= wp_link_pages( array(
			'before'      => '<div class="page-links secondary-size"><span class="page-links-title">' . esc_html__( 'Pages:', 'goedemorgen' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'goedemorgen' ) . ' </span>%',
			'separator'   => '<span class="screen-reader-text">, </span>',
			'echo'		  => 0,
		) );
	}

	return $content;
}
add_filter( 'the_content', 'goedemorgen_custom_link_pages', 1 );

/**
 * Change the content width for full-width layouts.
 */
function goedemorgen_full_width_layout_content_width() {
	global $content_width;

	if ( is_page_template( 'templates/panels-page.php' ) || is_page_template( 'templates/full-width-page.php' ) || ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 1240;
	}
}
add_action( 'template_redirect', 'goedemorgen_full_width_layout_content_width' );

/**
 * Add custom styles (based on the Customizer options) to the Editor.
 */
function goedemorgen_editor_dynamic_styles_callback() {
	header( "Content-type: text/css; charset: UTF-8" );
	$styles = '';

	$setting = goedemorgen_get_setting();
	$default = goedemorgen_get_setting( 'defaults' );

	if ( isset( $setting['typography']['body']['font_family'] ) && $default['typography']['body']['font_family'] != $setting['typography']['body']['font_family'] ) {
		$styles .= "body.mce-content-body { font-family: " . esc_attr( $setting['typography']['body']['font_family'] ) . "; }";
	}

	// Custom google font for the headings.
	if ( isset( $setting['typography']['headings']['font_family'] ) && $default['typography']['headings']['font_family'] != $setting['typography']['headings']['font_family'] ) {
		$styles .= " .mce-content-body h1, .mce-content-body h2, .mce-content-body h3, .mce-content-body h4, .mce-content-body h5, .mce-content-body h6 { font-family: " . esc_attr( $setting['typography']['headings']['font_family'] ) . "; }";
	}

	// Custom accent color.
	if ( isset( $setting['color']['accent'] ) && $default['color']['accent'] != $setting['color']['accent'] ) {
		$styles .= " .mce-content-body a, .mce-content-body blockquote:not(.pull-left):not(.pull-right):before { color: ". esc_attr( $setting['color']['accent'] ) ." } ";
		$styles .= " .mce-content-body a.button:not(.secondary-button):not(.minimal-button) { background: ". esc_attr( $setting['color']['accent'] ) ." }";
	}

	if ( '' != $styles ) {
		echo esc_attr( $styles );
	}

	die();
}
add_action( 'wp_ajax_goedemorgen_editor_dynamic_styles', 'goedemorgen_editor_dynamic_styles_callback' );
add_action( 'wp_ajax_nopriv_goedemorgen_editor_dynamic_styles', 'goedemorgen_editor_dynamic_styles_callback' );

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
 * Attach extra CSS styles to the theme's stylesheet.
 */
function goedemorgen_add_extra_css() {
	$extra_css = array();
	$extra_css = apply_filters( 'goedemorgen_set_extra_css', $extra_css );

	if ( ! empty( $extra_css ) ) {
		$extra_css = array_map( array( goedemorgen_extra_css(), 'clean_extra_css' ), $extra_css );
		$extra_css = join( ' ', $extra_css );

		wp_add_inline_style( 'goedemorgen-style', $extra_css );
	}
}
add_action( 'wp_enqueue_scripts', 'goedemorgen_add_extra_css' );

/**
 * Get ID of the featured page in blog view.
 */
function goedemorgen_get_posts_page_featured_page_id() {
	$archive_options = goedemorgen_get_setting( 'archive' );
	return $archive_options['featured_page_id'];
}
