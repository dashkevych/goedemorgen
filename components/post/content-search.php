<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Goedemorgen
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'post' === ( $current_post_type = get_post_type() ) ) : ?>
		<div class="entry-meta top-meta secondary-color secondary-size">
			<?php goedemorgen_posted_on( true ); ?>
			<?php goedemorgen_entry_categories(); ?>
		</div><!-- .top-meta -->
		<?php endif; ?>

		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<?php if ( 'post' === $current_post_type ) : ?>
		<div class="entry-meta bottom-meta secondary-color secondary-size">
			<?php goedemorgen_posted_by(); ?>

			<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( esc_html__( 'Leave a comment', 'goedemorgen' ), esc_html__( 'One Comment', 'goedemorgen' ), esc_html__( '% Comments', 'goedemorgen' ) ); ?></span>
			<?php endif; ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
