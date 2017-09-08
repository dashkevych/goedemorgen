<?php
/**
 * Template part for displaying single posts.
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

		<div class="entry-meta clear">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 140 ); ?>

			<div class="meta-inner secondary-size clear">
				<?php goedemorgen_posted_by(); ?>

				<div class="date-comments secondary-color">
					<?php goedemorgen_posted_on(); ?>

					<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
					<span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'goedemorgen' ), esc_html__( 'One Comment', 'goedemorgen' ), esc_html__( '% Comments', 'goedemorgen' ) ); ?></span>
					<?php endif; ?>
				</div><!-- .secondary-color -->
			</div><!-- .meta-inner -->
		</div><!-- .entry-meta -->

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

	<footer class="entry-footer secondary-size">
	<?php
		// Display post categories.
		goedemorgen_entry_categories();
		// Display post tags.
		goedemorgen_entry_tags();

		edit_post_link(
			sprintf(
				/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'goedemorgen' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<div class="edit-link">',
			'</div>',
			null,
			'post-edit-link button secondary-button has-icon'
		);

		// Display author's section.
		goedemorgen_author_bio();
	?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
