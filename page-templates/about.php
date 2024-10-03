<?php
/**
 * Template Name: About
 */

get_header();
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        get_template_part('template-parts/banner');
        get_template_part('template-parts/property', 'search');
        get_template_part('template-parts/about');
        get_template_part('template-parts/call-to-action');
        get_template_part('template-parts/team');
    }
} else {
    echo '<p>No content found</p>';
}
get_footer();
?>