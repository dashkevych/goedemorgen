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

/**
 * Custom functions that act independently of the theme templates.
 */
require GOEDEMORGEN_DIR . '/inc/actions.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require GOEDEMORGEN_DIR . '/inc/filters.php';

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
