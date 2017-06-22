<?php

/**
 * This file is used to markup the sidebar on the dashboard page.
 *
 * @since 1.0.0
 * @package Goedemorgen
 */

// Links that are used on this page.
$sidebar_links = array(
    'newsletter' => 'http://eepurl.com/cNGe5T',
);

?>

<div class="tab-section">
    <h4 class="section-title"><?php esc_html_e( 'Our newsletter', 'goedemorgen' ); ?></h4>

    <p><?php esc_html_e( 'Be among the first to know about exciting new updates, features and news by signing up for our newsletter.', 'goedemorgen' ); ?></p>

    <p>
    <?php
        // Display link to the newsletter.
        printf( '<a href="%1$s"  class="button button-primary" target="_blank">%2$s</a>', esc_url( $sidebar_links['newsletter'] ), esc_html__( 'Sign up to get news', 'goedemorgen' ) );
    ?>
    </p>
</div><!-- .tab-section -->
