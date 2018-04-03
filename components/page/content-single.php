<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Goedemorgen
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( goedemorgen_is_singular_hentry_header() ) : ?>
	<header class="entry-header singular-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-thumb">
			<?php the_post_thumbnail( 'full' ); ?>
		</div><!-- .entry-thumb -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<?php
	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'goedemorgen' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<footer class="entry-footer"><div class="edit-link">',
		'</div></footer>',
		null,
		'post-edit-link button secondary-button has-icon'
	); ?>
</article><!-- #post-## -->
