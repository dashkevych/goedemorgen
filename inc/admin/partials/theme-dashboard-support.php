<?php

/**
 * This file is used to markup the "Support" section on the dashboard page.
 *
 * @since 1.0.0
 * @package Goedemorgen
 */

// Define support links.
$general_questions_link = '<a href="https://wordpress.org/support/forum/how-to-and-troubleshooting/" target="_blank">' . esc_html__( 'How-To and Troubleshooting', 'goedemorgen' ) . '</a>';
$customization_link = '<a href="https://wordpress.org/support/theme/goedemorgen/" target="_blank">' . esc_html__( 'Goedemorgen', 'goedemorgen' ) . '</a>';
$documentation_link = '<a href="http://docs.goedemorgenwp.com/" target="_blank">' . esc_html__( 'documentation', 'goedemorgen' ) . '</a>';
$contact_form_link = '<a href="https://goedemorgenwp.com/contacts/" target="_blank">' . esc_html__( 'contact form', 'goedemorgen' ) . '</a>';
?>

<div class="tab-section">
    <h3 class="section-title"><?php esc_html_e( 'Looking for help?', 'goedemorgen' ); ?></h3>

    <p><?php esc_html_e( 'We have collected some resources that you may find helpful:', 'goedemorgen' ); ?></p>

    <ul>
        <li>
        <?php
            /* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
            printf( esc_html__( 'If you have a general question related to WordPress, please post it on WordPress.org %s forum.', 'goedemorgen' ), $general_questions_link ); // WPCS: XSS OK.
        ?>
        </li>

        <li>
        <?php
            /* translators: %s is a placeholder that will be replaced by a variable passed as an argument. */
            printf( esc_html__( 'If you have a theme specific question, please post it on %s forum.', 'goedemorgen' ), $customization_link ); // WPCS: XSS OK.
        ?>
        </li>

        <li>
        <?php
            /* translators: %1$s and %2$s are a placeholders that will be replaced by variables passed as an argument. */
            printf( esc_html__( 'Before contacting us, please visit our %1$s website. If your answer can not be found in the links that are posted above, please use our %2$s.', 'goedemorgen' ), $documentation_link, $contact_form_link ); // WPCS: XSS OK.
        ?>
        </li>
    </ul>

    <p><?php esc_html_e( "Note, there is a fine line between support and modifications. So as we try to help you with any type of query, we cannot provide any help with customizations beyond the scope of the theme's original style or functionality.", 'goedemorgen' ); ?></p>
</div><!-- .tab-section -->
