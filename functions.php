<?php
/**
 * Goedemorgen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Goedemorgen
 */

// Theme Constants.
define( 'GOEDEMORGEN_DIR', get_template_directory() );
define( 'GOEDEMORGEN_DIR_URI', get_template_directory_uri() );

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
			'css/editor-style.css',
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

	wp_enqueue_script( 'goedemorgen-script', GOEDEMORGEN_DIR_URI . '/assets/js/goedemorgen.js', array( 'jquery' ), '1.0.2', true  );
}
add_action( 'wp_enqueue_scripts', 'goedemorgen_scripts' );

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
 * Register the required plugins for this theme.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function goedemorgen_register_required_plugins() {
	// Array of plugin arrays.
	$plugins = array(
		array(
			'name'      => 'Jetpack',
			'slug'      => 'jetpack',
			'required'  => false,
		),
		array(
			'name'      => 'Yoast SEO',
			'slug'      => 'wordpress-seo',
			'required'  => false,
		),
	);

	// TGMPA array of configuration settings.
	$config = array(
		'id'           => 'goedemorgen',
		'default_path' => '',
		'menu'         => 'goedemorgen-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'goedemorgen_register_required_plugins' );

/**
 * Load theme's settings file.
 */
require GOEDEMORGEN_DIR . '/inc/class-goedemorgen-settings.php';

/**
 * Load Dashboard welcome page.
 */
require GOEDEMORGEN_DIR . '/inc/admin/class-goedemorgen-welcome-screen.php';

/**
 * Custom template tags for this theme.
 */
require GOEDEMORGEN_DIR . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require GOEDEMORGEN_DIR . '/inc/extras.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require GOEDEMORGEN_DIR . '/inc/filters.php';

/**
 * Custom functions for site typography.
 */
require GOEDEMORGEN_DIR . '/inc/typography.php';

/**
 * Customizer additions.
 */
require GOEDEMORGEN_DIR . '/inc/customizer/customizer.php';

/**
 * Extra CSS file.
 */
require_once GOEDEMORGEN_DIR . '/inc/class-goedemorgen-extra-css.php';

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once GOEDEMORGEN_DIR . '/inc/class-tgm-plugin-activation.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require GOEDEMORGEN_DIR . '/inc/plugins/jetpack.php';
}

/**
 * Load Contact Form 7 compatibility file.
 */
if ( defined( 'WPCF7_VERSION' ) ) {
	require GOEDEMORGEN_DIR . '/inc/plugins/class-goedemorgen-wpcf7.php';
}

/**
 * Load SiteOrigin Page Builder compatibility file.
 */
if ( defined( 'SITEORIGIN_PANELS_VERSION' ) ) {
	require GOEDEMORGEN_DIR . '/inc/plugins/class-goedemorgen-siteorigin.php';
}
