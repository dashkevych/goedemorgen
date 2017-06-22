<?php
/**
 * Template for displaying search forms.
 *
 * @package Goedemorgen
 */

// Create an unique ID.
$unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo $unique_id; // WPCS: XSS OK. ?>">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'goedemorgen' ) ?></span>
		<input type="search" id="<?php echo $unique_id; // WPCS: XSS OK. ?>" class="search-field"
		placeholder="<?php echo esc_attr_x( 'Search this website&hellip;', 'placeholder', 'goedemorgen' ) ?>"
		value="<?php echo esc_attr( get_search_query() ); ?>" name="s"
		title="<?php echo esc_attr_x( 'Search for:', 'label', 'goedemorgen' ) ?>" />
	</label>
	<button type="submit" class="submit has-icon clean-button"><span class="screen-reader-text"><?php esc_html_e( 'Search', 'goedemorgen' ); ?></span></button>
</form><!-- .search-form -->
