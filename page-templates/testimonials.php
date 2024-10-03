<?php
/**
 * Template Name: Testimonials
 */

get_header();
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        get_template_part('template-parts/banner');
        get_template_part('template-parts/property', 'search');
        get_template_part('template-parts/testimonials');
    }
} else {
    echo '<p>No content found</p>';
}
get_footer();
?>