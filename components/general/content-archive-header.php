<?php
/**
 * The template for displaying archive view header content in the page header section.
 *
 * @package Goedemorgen
 */

 ?>

<div class="inner-section">

	<?php
	if ( is_home() ) :

        goedemorgen_posts_page_header();

	elseif ( is_archive() && have_posts() ) :

		the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="archive-description">', '</div>' );

	elseif ( is_search() ) :

		if ( have_posts() ) : ?>
			<h1 class="page-title">
            <?php
                /* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
                printf( esc_html__( 'Search Results for: %s', 'goedemorgen' ), '<span>' . get_search_query() . '</span>' );
            ?>
            </h1><!-- .page-title -->
		<?php
        endif;

	endif; ?>

</div><!-- .inner-section -->
