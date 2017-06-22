<?php
/**
 * The template for displaying Author's section.
 *
 * @package Goedemorgen
 */

?>

<div class="entry-author">
	<div class="author-avatar">
		<?php
		/**
		 * Filter the author bio avatar size.
		 *
		 * @param int $size The avatar height and width size in pixels.
		 */
		$author_bio_avatar_size = apply_filters( 'jetpack_author_bio_avatar_size', 280 );

		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
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
		<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
		<?php
			/* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
			printf( esc_html__( 'View all posts by %s', 'goedemorgen' ), get_the_author() );
		?>
		</a><!-- .author-link -->
	</p><!-- .author-bio -->
</div><!-- .entry-auhtor -->
