<?php
/**
 * Template Name: Contact Us
 */

get_header();
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        get_template_part('template-parts/banner');
        get_template_part('template-parts/property', 'search');
        get_template_part('template-parts/contact');
    }
} else {
    echo '<p>No content found</p>';
}
get_footer();
?>