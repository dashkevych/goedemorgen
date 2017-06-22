<?php
/**
 * Template part for displaying page content in panels-page.php
 *
 * @package Goedemorgen
 */

?>

<div class="container-wrap panel-section panel-<?php the_ID(); ?>">
	<div <?php post_class(); ?>>
		<header class="entry-header">
			<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>

			<?php if ( has_excerpt() ) : ?>
			<div class="entry-summary secondary-color">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			<?php endif; ?>

			<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-thumb">
				<?php the_post_thumbnail( 'full' ); ?>
			</div><!-- .entry-thumb -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
		<?php
			the_content( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue Reading %s', 'goedemorgen' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>
		</div><!-- .entry-content -->

		<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<?php
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
				?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div><!-- .hentry -->
</div><!-- .panel-section -->
