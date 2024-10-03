<?php
/**
 * Template Name: Property List
 */

get_header();
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        get_template_part('template-parts/banner');
        get_template_part('template-parts/property', 'search');
        get_template_part('template-parts/property', 'list');
        get_template_part('template-parts/call-to-action');
    }
} else {
    echo '<p>No content found</p>';
}
get_footer();
?>