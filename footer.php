<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Goedemorgen
 */

 ?>

	<?php do_action( 'goedemorgen_after_site_content' ); ?>
	</div><!-- #content -->

	<footer id="colophon" <?php goedemorgen_footer_class(); ?> role="contentinfo">

		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
		<div class="widget-area clear">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div><!-- .widget-area -->
		<?php endif; ?>

		<?php if ( has_action( 'goedemorgen_footer_middle' ) ) : ?>
		<div class="footer-middle clear">
			<?php do_action( 'goedemorgen_footer_middle' ); ?>
		</div><!-- .footer-middle -->
		<?php endif; ?>

		<?php if ( has_action( 'goedemorgen_footer_bottom' ) ) : ?>
		<div class="footer-bottom clear">
			<?php do_action( 'goedemorgen_footer_bottom' ); ?>
		</div><!-- .footer-bottom -->
		<?php endif; ?>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
