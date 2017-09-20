<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Goedemorgen
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main container-wrap" role="main">

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();

				get_template_part( 'components/post/content', 'search' );

			endwhile;

			echo wp_kses_post( apply_filters( 'goedemorgen_posts_navigation', get_the_posts_navigation() ) );

		else :

			do_action( 'goedemorgen_nothing_found_content' );

		endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php

// Hide sidebar if there is no found posts.
if ( have_posts() ) :
	get_sidebar();
endif;

get_footer();
