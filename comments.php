<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Goedemorgen
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>

		<h2 class="comments-title">
		<?php
			if ( '1' === ( $comments_number = get_comments_number() ) ) {
				esc_html_e( 'One comment', 'goedemorgen' );
			} else {
				/* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
				printf( esc_html( _n( '%s comment', '%s comments', $comments_number, 'goedemorgen' ) ), number_format_i18n( $comments_number ) ); // WPCS: XSS OK.
			}
		?>
		</h2><!-- .comments-title -->

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 76,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'goedemorgen' ); ?></p>
	<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->
