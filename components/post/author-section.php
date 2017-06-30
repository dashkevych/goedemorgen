<?php
/**
 * The template for displaying Author's section.
 *
 * @package Goedemorgen
 */

$current_author_id = get_the_author_meta( 'ID' );

if ( get_the_author_meta( 'description', $current_author_id ) ) : ?>

<div class="entry-author">
	<div class="author-avatar">
		<?php echo get_avatar( $current_author_id, '352' ); ?>
	</div><!-- .author-avatar -->

	<div class="author-heading">
		<h2 class="author-title">
		<?php
			/* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
			printf( esc_html__( 'Published by %s', 'goedemorgen' ), '<span class="author-name">' . get_the_author() . '</span>' );
		?>
		</h2><!-- .author-title -->
	</div><!-- .author-heading -->

	<p class="author-bio">
		<?php the_author_meta( 'description' ); ?>
		<a class="author-link" href="<?php echo esc_url( get_author_posts_url( $current_author_id ) ); ?>" rel="author">
		<?php
			/* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
			printf( esc_html__( 'View all posts by %s', 'goedemorgen' ), get_the_author() );
		?>
		</a><!-- .author-link -->
	</p><!-- .author-bio -->
</div><!-- .entry-auhtor -->
<?php
endif;
