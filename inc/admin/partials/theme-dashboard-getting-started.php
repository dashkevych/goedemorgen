<?php

/**
 * This file is used to markup the "Getting Started" section on the dashboard page.
 *
 * @since 1.0.0
 * @package Goedemorgen
 */

// Links that are used on this page.
$getting_started_links = array(
    'demo_docs' => 'http://docs.goedemorgenwp.com/category/39-demo-websites',
    'demo' => 'https://demo.goedemorgenwp.com/',
    'docs' => 'http://docs.goedemorgenwp.com/',
    'child_theme' => 'https://github.com/dashkevych/goedemorgen-child/',
    'child_theme_docs' => 'http://docs.goedemorgenwp.com/article/19-creating-a-child-theme',
); ?>

<div class="tab-section">
    <h3 class="section-title"><?php esc_html_e( 'Documentation', 'goedemorgen' ); ?></h3>

    <p><?php esc_html_e( 'We are so glad that you have chosen the Goedemorgen theme for your website. Now it is time to find out what you can achieve with our theme, and how to use Goedemorgen to its fullest. To do so, we have created a dedicated documentation portal to help you get started.', 'goedemorgen' ); ?></p>

    <p>
    <?php
        // Display link to theme's documentation.
        printf( '<a href="%1$s" class="button" target="_blank">%2$s</a>', esc_url( $getting_started_links['docs'] ), esc_html__( 'Open Documentation', 'goedemorgen' ) );
    ?>
    </p>
</div><!-- .tab-section -->

<div class="tab-section">
    <h3 class="section-title"><?php esc_html_e( 'Recommended Plugins', 'goedemorgen' ); ?></h3>

    <p><?php esc_html_e( 'Please keep in mind, we do not officially support these plugins, but they may help you to extend the functionality of your WordPress website.', 'goedemorgen' ); ?></p>

    <p>
    <?php
        // Display link Recommended Plugins page.
        printf( '<a href="%1$s" class="button">%2$s</a>', esc_url( admin_url( 'themes.php?page=goedemorgen-install-plugins' ) ), esc_html__( 'Install Plugins', 'goedemorgen' ) );
    ?>
    </p>
</div><!-- .tab-section -->

<div class="tab-section">
    <h3 class="section-title"><?php esc_html_e( 'Theme Options', 'goedemorgen' ); ?></h3>

    <p><?php esc_html_e( 'Goedemorgen makes use of the Customizer to provide you with the theme options. Click on the button below to open the Customizer and start making changes to your website.', 'goedemorgen' ); ?></p>

    <p><a href="<?php echo wp_customize_url(); // WPCS: XSS OK. ?>" class="button" target="_blank"><?php esc_html_e( 'Customize Theme', 'goedemorgen' ); ?></a></p>
</div><!-- .tab-section -->

<div class="tab-section">
    <h3 class="section-title"><?php esc_html_e( 'Heavy Customizations', 'goedemorgen' ); ?></h3>

    <p><?php esc_html_e( 'We have created a blank starter child theme for Goedemorgen. It is highly recommended to use a child theme if you are planning to modify the parent theme.', 'goedemorgen' ); ?></p>

    <p>
    <?php
        // Display a link to download child theme.
        printf( '<a href="%1$s" class="button" target="_blank">%2$s</a>', esc_url( $getting_started_links['child_theme'] ), esc_html__( 'Download Child Theme', 'goedemorgen' ) );

        // Display a link to the child theme documentation.
        printf( '<a href="%1$s" class="demo-button" target="_blank">%2$s</a>', esc_url( $getting_started_links['child_theme_docs'] ), esc_html__( 'Learn About Child Themes', 'goedemorgen' ) );
    ?>
    </p>
</div><!-- .tab-section -->

<div class="tab-section">
    <h3 class="section-title"><?php esc_html_e( 'Demo Website', 'goedemorgen' ); ?></h3>

    <p><?php esc_html_e( 'It is fairly easy to recreate the layout of the demo website. All you need is the right plugins and settings, and you should be able to mimic most of the elements found in the demo. Please note that a lot of the details that make our demo looks good are the result of many hours of hard work.', 'goedemorgen' ); ?></p>

    <p>
    <?php
        // Display a link to documentation that describes how to mimic demo website.
        printf( '<a href="%1$s" class="button" target="_blank">%2$s</a>', esc_url( $getting_started_links['demo_docs'] ), esc_html__( 'Reproduce Demo', 'goedemorgen' ) );

        // Display a link to the demo website.
        printf( '<a href="%1$s" class="demo-button" target="_blank">%2$s</a>', esc_url( $getting_started_links['demo'] ), esc_html__( 'View Demo', 'goedemorgen' ) );
    ?>
    </p>
</div><!-- .tab-section -->
