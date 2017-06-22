<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Goedemorgen
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main container-wrap" role="main">

		<?php
		if ( have_posts() ) :

			while ( have_posts() ) : the_post();

				get_template_part( 'components/post/content' );

			endwhile;

			echo wp_kses_post( apply_filters( 'goedemorgen_posts_navigation', get_the_posts_navigation() ) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
