<?php
/**
 * Template Name: Builder Page
 *
 * @package Goedemorgen
 */

get_header(); ?>

	<div id="primary" class="content-area full-width">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				the_content();

				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'goedemorgen' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<div class="container-wrap entry-footer edit-link">',
					'</div>',
					null,
					'post-edit-link button secondary-button has-icon'
				);

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
