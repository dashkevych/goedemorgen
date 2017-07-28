<?php
/**
 * Template part for displaying a content in 404 page.
 *
 * @package Goedemorgen
 */

?>

<section class="error-404 not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'goedemorgen' ); ?></h1>
		<div class="archive-description">
			<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'goedemorgen' ); ?>
		</div><!-- .archive-description -->
	</header><!-- .entry-header -->

	<div class="page-content">
		<?php get_search_form(); ?>
	</div><!-- .page-content -->
</section><!-- .error-404 -->
