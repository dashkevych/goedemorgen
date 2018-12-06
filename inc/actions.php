<?php
/**
 * Theme actions.
 *
 * @package Goedemorgen
 */

if ( ! function_exists( 'goedemorgen_setup' ) ) :
/**
* Sets up theme defaults and registers support for various WordPress features.
*
* Note that this function is hooked into the after_setup_theme hook, which
* runs before the init hook. The init hook is too late for some features, such
* as indicating support for post thumbnails.
*/
function goedemorgen_setup() {
	/**
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Goedemorgen, use a find and replace
	 * to change 'goedemorgen' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'goedemorgen', GOEDEMORGEN_DIR . '/languages' );

	/* Add default posts and comments RSS feed links to head. */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	/* Set up Custom Menu locations. */
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Header Menu', 'goedemorgen' ),
		'social' => esc_html__( 'Social Menu', 'goedemorgen' ),
	) );

	/**
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/* Set up the WordPress core custom background feature. */
	add_theme_support( 'custom-background', apply_filters( 'goedemorgen_custom_background_args', array(
		'default-color' => 'f5f6f7',
		'default-image' => '',
	) ) );

	/* Add support for core custom logo. */
	add_theme_support( 'custom-logo', array(
		'height'      => 200,
		'width'       => 860,
		'flex-width'  => true,
		'flex-height' => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );

	/* Add theme support for selective refresh for widgets. */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Enable support for Excerpt on Pages and Projects.
	 * See http://codex.wordpress.org/Excerpt
	 */
	add_post_type_support( 'page', 'excerpt' );

	/**
	 * This theme styles the visual editor to resemble the theme style.
	 */
	add_editor_style(
		array(
			'assets/css/editor-style.css',
			goedemorgen_google_fonts(),
			add_query_arg( 'action', 'goedemorgen_editor_dynamic_styles', admin_url( 'admin-ajax.php' ) ),
		)
	);

	/**
	 * Load footer social menu action only if the menu is set.
	 */
	if ( has_nav_menu( 'social' ) ) {
		add_action( 'goedemorgen_footer_middle', 'goedemorgen_add_footer_social_menu' );
	}

	/**
     * Setup Gutenberg.
     */
     // Add Gutenberg editor styles.
    add_theme_support( 'editor-styles' );

	// Disabling Gutengerg custom font sizes.
    add_theme_support( 'disable-custom-font-sizes' );

	// Add Gutengerg color palette.
	add_theme_support( 'editor-color-palette', array(
		array(
			'name' => esc_html__( 'Green', 'goedemorgen' ),
			'slug' => 'green',
			'color' => '#048448',
		),
		array(
			'name' => esc_html__( 'Red', 'goedemorgen' ),
			'slug' => 'red',
			'color' => '#dc2d47',
		),
		array(
			'name' => esc_html__( 'Blue', 'goedemorgen' ),
			'slug' => 'blue',
			'color' => '#3c40c6',
		),
		array(
			'name' => esc_html__( 'Black', 'goedemorgen' ),
			'slug' => 'black',
			'color' => '#1e272e',
		),
		array(
			'name' => esc_html__( 'White', 'goedemorgen' ),
			'slug' => 'white',
			'color' => '#ffffff',
		),
	) );
}
endif;
add_action( 'after_setup_theme', 'goedemorgen_setup' );

/**
* Set the content width in pixels, based on the theme's design and stylesheet.
*
* Priority 0 to make it available to lower priority callbacks.
*
* @global int $content_width
*/
function goedemorgen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'goedemorgen_content_width', 730 );
}
add_action( 'after_setup_theme', 'goedemorgen_content_width', 0 );

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
* Register widget area.
*
* @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
*/
function goedemorgen_widgets_init() {
	/* Set up an array of default widget areas. */
	$widget_areas = array(
		'sidebar-1' => array(
			'name' => esc_html__( 'Sidebar', 'goedemorgen' ),
			'description' => esc_html__( 'Appears in the sidebar section of the site.', 'goedemorgen' ),
		),
		'sidebar-2' => array(
			'name' => esc_html__( 'Footer', 'goedemorgen' ),
			'description' => esc_html__( 'Appears in the footer section of the site.', 'goedemorgen' ),
		),
	);

	/* Register our widget areas. */
	foreach ( $widget_areas as $id => $area ) {
		register_sidebar( array(
			'name'          => $area['name'],
			'id'            => $id,
			'description'   => $area['description'],
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}

	/* Remove custom internal CSS that is generated by Recent Comments widget. */
	add_filter( 'show_recent_comments_widget_style', '__return_false', 99 );
}
add_action( 'widgets_init', 'goedemorgen_widgets_init' );

/**
* Enqueue scripts and styles.
*/
function goedemorgen_scripts() {
	wp_enqueue_style( 'font-awesome', GOEDEMORGEN_DIR_URI . '/assets/css/font-awesome.css' );
	wp_enqueue_style( 'goedemorgen-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'goedemorgen-script', GOEDEMORGEN_DIR_URI . '/assets/js/goedemorgen.js', array( 'jquery' ), '1.0.3', true  );

	wp_localize_script( 'goedemorgen-script', 'goedemorgenScreenReaderText', array(
		'expand'   => esc_html__( 'Expand child menu', 'goedemorgen' ),
		'collapse' => esc_html__( 'Collapse child menu', 'goedemorgen' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'goedemorgen_scripts' );

/**
* Register the required plugins for this theme.
*
* This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
*/
function goedemorgen_register_required_plugins() {
	// Array of plugin arrays.
	$plugins = array(
		array(
			'name' => 'Jetpack',
			'slug' => 'jetpack',
			'required' => false,
		),
		array(
			'name' => 'Yoast SEO',
			'slug' => 'wordpress-seo',
			'required' => false,
		),
	);

	// TGMPA array of configuration settings.
	$config = array(
		'id' => 'goedemorgen',
		'default_path' => '',
		'menu' => 'goedemorgen-install-plugins',
		'has_notices' => true,
		'dismissable' => true,
		'dismiss_msg' => '',
		'is_automatic' => false,
		'message' => '',
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'goedemorgen_register_required_plugins' );

/**
 * Allow to edit the page which is set to the Posts Page.
 * Content in this page will be used for the Jumbotron section in the Posts Page.
 *
 * @param Object $post
 * @return void
 */
function goedemorgen_add_editor_to_posts_page( $post ) {
     if ( isset( $post ) && $post->ID != get_option( 'page_for_posts' ) ) {
         return;
     }

     remove_action( 'edit_form_after_title', '_wp_posts_page_notice' );
     add_post_type_support( 'page', 'editor' );
}
add_action( 'edit_form_after_title', 'goedemorgen_add_editor_to_posts_page', 0 );

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
 * Add custom styles (based on the Customizer options) to the editor.
 */
function goedemorgen_editor_dynamic_styles_callback() {
	header( "Content-type: text/css; charset: UTF-8" );
	$styles = '';

	$setting = goedemorgen_get_setting();
	$default = goedemorgen_get_setting( 'defaults' );

	if ( isset( $setting['typography']['body']['font_family'] ) && $default['typography']['body']['font_family'] != $setting['typography']['body']['font_family'] ) {
		$styles .= "body, body.mce-content-body { font-family: " . esc_attr( $setting['typography']['body']['font_family'] ) . "; }";
	}

	// Custom google font for the headings.
	if ( isset( $setting['typography']['headings']['font_family'] ) && $default['typography']['headings']['font_family'] != $setting['typography']['headings']['font_family'] ) {
		$styles .= "h1, h2, h3, h4, h5, h6, .editor-post-title__block .editor-post-title__input, .mce-content-body h1, .mce-content-body h2, .mce-content-body h3, .mce-content-body h4, .mce-content-body h5, .mce-content-body h6 { font-family: " . esc_attr( $setting['typography']['headings']['font_family'] ) . "; }";
	}

	// Custom accent color.
	if ( isset( $setting['color']['accent'] ) && $default['color']['accent'] != $setting['color']['accent'] ) {
		$styles .= " .mce-content-body a, .mce-content-body blockquote:not(.pull-left):not(.pull-right):before { color: ". esc_attr( $setting['color']['accent'] ) ." } ";
		$styles .= " .mce-content-body a.button:not(.secondary-button):not(.minimal-button) { background: ". esc_attr( $setting['color']['accent'] ) ." }";
	}

	if ( '' !== $styles ) {
		echo esc_attr( $styles );
	}

	die();
}
add_action( 'wp_ajax_goedemorgen_editor_dynamic_styles', 'goedemorgen_editor_dynamic_styles_callback' );
add_action( 'wp_ajax_nopriv_goedemorgen_editor_dynamic_styles', 'goedemorgen_editor_dynamic_styles_callback' );

/**
 * Flush out the transients used in goedemorgen_categorized_blog.
 */
function goedemorgen_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'goedemorgen_categories' );
}
add_action( 'edit_category', 'goedemorgen_category_transient_flusher' );
add_action( 'save_post', 'goedemorgen_category_transient_flusher' );

/**
 * Displays the Back to Top button.
 */
function goedemorgen_add_back_to_top_button() {
	$footer_options = goedemorgen_get_setting( 'footer' );

	if ( $footer_options['is_backtotop_button'] ) {
		printf( '<button id="backtotop-button" class="clean-button has-icon"><span class="screen-reader-text">%s</span></button>', esc_html__( 'Scroll back to top', 'goedemorgen' ) );
	}
}
add_action( 'wp_footer', 'goedemorgen_add_back_to_top_button' );

/**
* Adds search form to the toggle menu.
*/
function goedemorgen_add_toggle_menu_search() {
	get_search_form();
}
add_action( 'goedemorgen_after_mobile_menu', 'goedemorgen_add_toggle_menu_search' );

/**
 * Adds header image to the page header section.
 */
function goedemorgen_add_page_header_image() {
	goedemorgen_page_header_image();
}
add_action( 'goedemorgen_page_header', 'goedemorgen_add_page_header_image' );

/**
 * Adds archive view header content to the page header section.
 */
function goedemorgen_add_archive_view_header_content() {
	if ( ! is_singular() ) {
		get_template_part( 'components/general/content', 'archive-header' );
	}
}
add_action( 'goedemorgen_page_header', 'goedemorgen_add_archive_view_header_content' );

/**
 * Adds a default content to the 404 page.
 */
function goedemorgen_add_404_content() {
	get_template_part( 'components/general/content', '404' );
}
add_action( 'goedemorgen_404_content', 'goedemorgen_add_404_content' );

/**
 * Adds a default content to the Nothing Found page.
 */
function goedemorgen_add_nothing_found_content() {
	get_template_part( 'components/general/content', 'none' );
}
add_action( 'goedemorgen_nothing_found_content', 'goedemorgen_add_nothing_found_content' );

/**
 * Adds credits sections to the bottom of the site.
 */
function goedemorgen_add_footer_credits() {
	get_template_part( 'components/footer/credits-section' );
}
add_action( 'goedemorgen_footer_bottom', 'goedemorgen_add_footer_credits' );

/**
 * Display entry content in archive view.
 */
function goedemorgen_hfeed_add_content() {
	the_content( sprintf(
		/* translators: %s: Name of current post. */
		wp_kses( __( 'Continue Reading %s', 'goedemorgen' ), array( 'span' => array( 'class' => array() ) ) ),
		the_title( '<span class="screen-reader-text">"', '"</span>', false )
	) );
}
add_action( 'goedemorgen_hfeed_content', 'goedemorgen_hfeed_add_content', 5 );
