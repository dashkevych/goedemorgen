<?php
/**
 * Template Name: Full-Width Page
 *
 * @package Goedemorgen
 */

get_header(); ?>

	<div id="primary" class="content-area full-width">
		<main id="main" class="site-main container-wrap" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'components/page/content', 'single' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
