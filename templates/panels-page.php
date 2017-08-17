<?php
/**
 * Template Name: Panels Page
 *
 * @package Goedemorgen
 */

get_header(); ?>

<div id="jumbotron-section" <?php goedemorgen_page_header_class(); ?>>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php goedemorgen_page_header_image(); ?>

		<div class="inner-section">
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php the_content(); ?>
			</div><!-- .entry-content -->
		</div><!-- .inner-section -->
	<?php endwhile; ?>
</div><!-- #jumbotron-section -->

<?php

$panels = goedemorgen_get_children_query();

if ( $panels->have_posts() ) :
	while ( $panels->have_posts() ) : $panels->the_post();
		get_template_part( 'components/page/content', 'panel' );
	endwhile;
endif;

wp_reset_postdata();

get_footer();
