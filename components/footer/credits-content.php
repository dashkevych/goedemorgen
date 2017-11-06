<?php
/**
 * The template for displaying default credits at the bottom of the site.
 *
 * @package Goedemorgen
 */

?>

<span class="site-copyright">
<?php echo esc_html( date( 'Y' ) ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
</span><!-- .site-copyright -->
<span class="sep"> &bull; </span>

<?php
/* translators: %1$s and %2$s are placeholders that will be replaced by a variables passed as an argument. */
printf( esc_html__( 'Proudly powered by %1$s and %2$s.', 'goedemorgen' ), '<a href="https://wordpress.org/" >WordPress</a>', '<a href="https://goedemorgenwp.com/">Goedemorgen</a>' );
