<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goedemorgen
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site container">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'goedemorgen' ); ?></a>

	<header id="masthead" class="site-header container-wrap" role="banner">
		<div class="header-inner clear">
			<div class="site-branding">
				<?php
				goedemorgen_the_custom_logo();

				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				endif;

				$description = get_bloginfo( 'description', 'display' );
				if ( $description || is_customize_preview() ) : ?>
					<p class="site-description secondary-size"><?php echo $description; /* WPCS: xss ok. */ ?></p>
				<?php
				endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="site-navigation main-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>

				<?php get_search_form(); ?>

				<button id="header-search-button" class="header-search clean-button has-icon"><span class="screen-reader-text"><?php esc_html_e( 'Search', 'goedemorgen' ); ?></span></button>
			</nav><!-- #site-navigation -->

			<button id="mobile-menu-toggle" class="has-icon clean-button" aria-controls="mobile-navigation" aria-expanded="false">
				<span><?php esc_html_e( 'Menu', 'goedemorgen' ); ?></span>
			</button><!-- #mobile-menu-toggle -->
		</div><!-- .header-inner -->
	</header><!-- #masthead -->

	<div id="toggle-menu" class="container-wrap" aria-hidden="true">
		<nav id="mobile-navigation" class="mobile-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'goedemorgen' ); ?>"></nav><!-- #secondary-navigation -->

		<?php do_action( 'goedemorgen_after_mobile_menu' ); ?>

		<button id="close-toggle-menu" class="has-icon"><?php esc_html_e( 'Close menu', 'goedemorgen' ); ?></button>
	</div><!-- #toggle-menu -->

	<div id="content" class="site-content">

		<?php get_template_part( 'components/general/page', 'header' ); ?>

		<?php goedemorgen_breadcrumbs(); ?>
