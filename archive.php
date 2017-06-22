<?php
/**
 * The template for displaying archive pages
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
