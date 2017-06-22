<?php
/**
 * The template for displaying page header.
 *
 * @package Goedemorgen
 */

if ( ! goedemorgen_is_page_header() ) {
	return;
} ?>

<header <?php goedemorgen_page_header_class(); ?>>

	<?php do_action( 'goedemorgen_page_header' ); ?>

</header><!-- .page-header -->
