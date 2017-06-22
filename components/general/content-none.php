<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Goedemorgen
 */

?>

<section class="no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'goedemorgen' ); ?></h1>
		<div class="archive-description">
			<?php
			if ( is_home() && current_user_can( 'publish_posts' ) ) :

				/* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
				 printf( wp_kses( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'goedemorgen' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) );

			elseif ( is_search() ) :

				  esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'goedemorgen' );

			else :

				esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'goedemorgen' );

			endif; ?>
		</div><!-- .archive-description -->
	</header><!-- .entry-header -->

	<div class="page-content">
		<?php get_search_form(); ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
