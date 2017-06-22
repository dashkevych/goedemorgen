<?php
/**
 * The default template for displaying social menu content.
 *
 * @package Goedemorgen
 */

if ( has_nav_menu( 'social' ) ) : ?>
<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Navigation', 'goedemorgen' ); ?>">
<?php
	wp_nav_menu( array(
		'theme_location'  => 'social',
		'container'       => 'div',
		'depth'           => 1,
		'link_before'     => '<span class="screen-reader-text social-meta">',
		'link_after'      => '</span>',
		'fallback_cb'     => false,
		'menu_class'	  => 'menu social-menu',
	) );
?>
</nav><!-- .social-navigation -->
<?php
endif;
