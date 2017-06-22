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
 * Retrieve the classes for the page header area as an array.
 */
function goedemorgen_page_header_class() {
	// Default classes.
	$classes = array( 'page-header', 'container-wrap' );

	// Add class in single views.
	if ( is_singular() ) {
		$classes[] = 'entry-header';

		// Add class if featured image is set.
		if ( has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		}

	} else {
		$archive_options = goedemorgen_get_setting( 'archive' );
		// Add class if header image is set.
		if ( isset( $archive_options['header_image'] ) && '' != $archive_options['header_image'] ) {
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
function goedemorgen_jumbotron_class() {
	// Get jumbotron options.
	$jumbotron_options = goedemorgen_get_setting( 'jumbotron' );

	// Default classes.
	$classes = array( 'clear' );

	if ( isset( $jumbotron_options['alignment'] ) && '' != $jumbotron_options['alignment'] ) {
		switch ( $jumbotron_options['alignment'] ) {
			case 'right':
		        $classes[] = 'right-alignment';
		        break;
			case 'center':
		        $classes[] = 'centered-alignment';
		        break;
		}
	}

	// Allow to add custom classes.
	$classes = array_unique( apply_filters( 'goedemorgen_jumbotron_class', $classes ) );

	// Clean added classes.
	$classes = array_map( 'esc_attr', $classes );

	printf( 'class="%s"', join( ' ', $classes ) ); // WPCS: XSS OK.
}

/**
 * Get a default font family.
 *
 * @param string $section Specify a section for which we need a font.
 */
 function goedemorgen_get_default_font_family( $section = '' ) {

	$default = array(
 		'body' => 'Open Sans',
 		'headings' => 'Raleway',
 	);

	if ( 'body' === $section ) {
		return $default['body'];
	} else if ( 'headings' === $section ) {
		return $default['headings'];
	} else {
		return $default;
	}
 }

/**
 * Get a custom font family.
 *
 * @param string $section Specify a section for which we need a font.
 * @return string|bool
 */
function goedemorgen_get_font_family( $section = '' ) {
	if ( '' != $section && in_array( $section, array( 'body', 'headings' ) ) ) {

		$typography = goedemorgen_get_setting( 'typography' );
		$default = goedemorgen_get_default_font_family( $section );

		if ( isset( $typography[$section]['font_family'] ) &&  '' != $typography[$section]['font_family'] && $default != $typography[$section]['font_family'] ) {
			return $typography[$section]['font_family'];
		} else {
			return $default;
		}
	}

	return false;
}

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
 * Add body styles to the site.
 */
function goedemorgen_set_body_font_style() {
	$custom_font = goedemorgen_get_font_family( 'body' );

	if ( $custom_font && goedemorgen_get_default_font_family( 'body' ) != $custom_font ) {
		$body_font_family = "body, button, input, select, textarea { font-family: " . esc_attr( $custom_font ) . "; }";
		wp_add_inline_style( 'goedemorgen-style', $body_font_family );
	} else {
		return false;
	}
}
add_action( 'wp_enqueue_scripts', 'goedemorgen_set_body_font_style' );

/**
 * Add headings styles to the site.
 */
function goedemorgen_set_headings_font_style() {
	$custom_font = goedemorgen_get_font_family( 'headings' );

	if ( $custom_font && goedemorgen_get_default_font_family( 'headings' ) != $custom_font ) {
		$body_font_family = "h1, h2, h3, h4, h5, h6 { font-family: " . esc_attr( $custom_font ) . "; }";
		wp_add_inline_style( 'goedemorgen-style', $body_font_family );
	} else {
		return false;
	}
}
add_action( 'wp_enqueue_scripts', 'goedemorgen_set_headings_font_style' );

/**
 * Add custom styles (based on the Customizer options) to the Editor.
 */
function goedemorgen_editor_dynamic_styles_callback() {
	header( "Content-type: text/css; charset: UTF-8" );
	$styles = '';

	$body_font = goedemorgen_get_font_family( 'body' );
	$headings_font = goedemorgen_get_font_family( 'headings' );
	$theme_colors = goedemorgen_get_setting( 'color' );

	// Custom google font selected for the body.
	if ( $body_font && goedemorgen_get_default_font_family( 'body' ) != $body_font ) {
		$styles .= "body.mce-content-body { font-family: " . esc_attr( $body_font ) . "; }";
	}

	// Custom google font selected for the headings.
	if ( $headings_font && goedemorgen_get_default_font_family( 'headings' ) != $headings_font ) {
		$styles .= " .mce-content-body h1, .mce-content-body h2, .mce-content-body h3, .mce-content-body h4, .mce-content-body h5, .mce-content-body h6 { font-family: " . esc_attr( $headings_font ) . "; }";
	}

	// Custom accent color.
	if ( isset( $theme_colors['accent'] )  && '#0161bd' != $theme_colors['accent'] ) {
		$styles .= " .mce-content-body a, .mce-content-body blockquote:not(.pull-left):not(.pull-right):before { color: ". esc_attr( $theme_colors['accent'] ) ." } ";
		$styles .= " .mce-content-body a.button:not(.secondary-button):not(.minimal-button) { background: ". esc_attr( $theme_colors['accent'] ) ." }";
	}

	if ( '' != $styles ) {
		echo esc_attr( $styles );
	}

	die();
}
add_action( 'wp_ajax_goedemorgen_editor_dynamic_styles', 'goedemorgen_editor_dynamic_styles_callback' );
add_action( 'wp_ajax_nopriv_goedemorgen_editor_dynamic_styles', 'goedemorgen_editor_dynamic_styles_callback' );

/**
 * Change accent color.
 */
 function goedemorgen_set_custom_accent_color() {
	 $theme_colors = goedemorgen_get_setting( 'color' );

	 if ( isset( $theme_colors['accent'] )  && '#0161bd' != $theme_colors['accent'] ) {
		$accent_color = "
						a,
						a:visited,
						#masthead .main-navigation ul:not(.sub-menu):not(.children) > li > a:hover,
						.content-area blockquote:not(.pull-left):not(.pull-right):before { color: " . $theme_colors['accent'] . "; }
						";

		$accent_color .= "
						button,
						a.button:not(.secondary-button),
						input[type='button'],
						input[type='reset'],
						input[type='submit'] { background: " . $theme_colors['accent'] . "; }
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
						textarea:focus { border-color: " . $theme_colors['accent'] . "; }
		                ";

		wp_add_inline_style( 'goedemorgen-style', $accent_color );
	 }
 }
 add_action( 'wp_enqueue_scripts', 'goedemorgen_set_custom_accent_color' );

/**
 * Check if we need to display page header section.
 */
function goedemorgen_is_page_header() {
	// Display page header by default.
	$is_page_header = true;

	// Hide page header in single views.
	if ( is_singular() ) {
		$is_page_header = false;
	}

	/**
	 * Hide page header section on the custom Front Page template and in blog view
	 * when there is no static front page.
	 */
	if ( goedemorgen_is_front_page_template() || ( is_home() && is_front_page() ) || is_404() || ( is_search() && ! have_posts() ) ) {
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
