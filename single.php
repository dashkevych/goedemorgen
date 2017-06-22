<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Goedemorgen
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container-wrap" role="main">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'components/post/content', 'single' );

			the_post_navigation( array(
				'next_text' => '<span class="nav-meta">' . esc_html__( 'Next Entry', 'goedemorgen' ) . '</span> <h3 class="nav-title">%title</h3>',
				'prev_text' => '<span class="nav-meta">' . esc_html__( 'Previous Entry', 'goedemorgen' ) . '</span> <h3 class="nav-title">%title</h3>',
			) );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
