<?php
/**
 * Dashboard welcome screen.
 *
 * The purpose of this screen is to introduce the theme to the user and to point the user to useful and relevant links.
 *
 * @since  1.0.0
 * @package Goedemorgen
 */
class Goedemorgen_Welcome_Screen {

	/**
	 * Class instance.
	 * @since 1.0.0
	 */
    private static $instance;

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Goedemorgen_Welcome_Screen ) ) {
			self::$instance = new Goedemorgen_Welcome_Screen;
			self::$instance->setup_actions();
		}
		return self::$instance;
	}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {
		// Display activation notice.
		add_action( 'load-themes.php', array( self::$instance, 'add_admin_notices' ) );
		// Add theme's info page to the Dashboard menu.
		add_action( 'admin_menu', array( self::$instance, 'register_menu_page' ) );
		// Add theme's info page scripts.
		add_action( 'admin_enqueue_scripts', array( self::$instance, 'admin_scripts' ) );
	}

	/**
	 * Load theme's info page styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_scripts() {
		global $pagenow;

		if ( 'themes.php' != $pagenow ) {
			return;
		}

		wp_enqueue_style( 'goedemorgen-dashboard', GOEDEMORGEN_DIR_URI . '/inc/admin/assets/dashboard-style.css', false, '1.0.0' );
	}

	/**
	 * Create theme's info page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_menu_page() {
		 add_theme_page( esc_html__( 'Goedemorgen Dashboard', 'goedemorgen' ), esc_html__( 'Goedemorgen', 'goedemorgen' ), 'edit_theme_options', 'goedemorgen-dashboard', array( self::$instance, 'theme_dashboard_page' ) );
	}

	/**
	 * Display a welcome notice upon successful activation.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_admin_notices() {
		global $pagenow;

		if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( self::$instance, 'welcome_admin_notice' ) );
		}
 	}

	/**
	 * Display a welcome notice when the theme is activated.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function welcome_admin_notice() {
		$theme_data = wp_get_theme(); ?>
		<div class="updated notice notice-success notice-alt is-dismissible">
			<p><?php
			/* translators: %1$s and %2$s are placeholders that will be replaced by variables passed as an argument. */
			printf( wp_kses( __( 'Welcome and thanks for choosing %1$s! To help you get starter with the theme, please visit our <a href="%2$s">welcome page</a>.', 'goedemorgen' ), array( 'a' => array( 'href' => array() ) ) ), esc_attr( $theme_data->Name ), esc_url( admin_url( 'themes.php?page=goedemorgen-dashboard' ) ) ); ?></p>
		</div><!-- .notice -->
		<?php
	}

	/**
	 * Display content of theme's dashabord page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function theme_dashboard_page() {
		require_once GOEDEMORGEN_DIR . '/inc/admin/partials/theme-dashboard-page.php';
	}

	/**
	 * Display tabs on the theme's dashabord page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param string
	 * @return void
	 */
	public function get_dashboard_page_tabs( $current_tab = '' ) {
		$tabs = array(
			array(
				'slug' => 'getting_started',
				'title' => esc_html__( 'Getting Started', 'goedemorgen' ),
			),
			array(
				'slug' => 'support',
				'title' => esc_html__( 'Support', 'goedemorgen' ),
			),
			array(
				'slug' => 'contribute',
				'title' => esc_html__( 'Contribute', 'goedemorgen' ),
			),
		);

		$tabs = apply_filters( 'goedemorgen_dashboard_page_tabs', $tabs );

		foreach ( $tabs as $tab ) {
			if ( $current_tab === $tab['slug'] ) {
				$class = 'nav-tab nav-tab-active';
			} else {
				$class = 'nav-tab';
			}

			// Create URL for the current tab.
			$url = esc_url( admin_url( 'themes.php?page=goedemorgen-dashboard&tab=' . $tab['slug'] ) );

			/* translators: %1$s, %2$s and %3$s are a placeholders that will be replaced by variables passed as an argument. */
			printf( '<a class="%1$s" href="%2$s">%3$s</a>', $class, $url, $tab['title'] ); // WPCS: XSS OK.
		}
	}

	/**
	 * Display tabs content on the theme's dashabord page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param string
	 * @return void
	 */
	public function get_dashboard_page_tab_content( $current_tab = '' ) {
		$content = array(
			'support' => GOEDEMORGEN_DIR . '/inc/admin/partials/theme-dashboard-support.php',
			'contribute' => GOEDEMORGEN_DIR . '/inc/admin/partials/theme-dashboard-contribute.php',
			'getting_started' => GOEDEMORGEN_DIR . '/inc/admin/partials/theme-dashboard-getting-started.php',
		);

		$content = apply_filters( 'goedemorgen_dashboard_page_tab_content', $content );

		if ( isset( $content[$current_tab] ) && file_exists( $content[$current_tab] ) ) {
			require_once $content[$current_tab];
		}
	}
}
Goedemorgen_Welcome_Screen::instance();
