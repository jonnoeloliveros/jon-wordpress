<?php
get_header();
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        ?>
        <div class="container-xxl py-5">
            <div class="container"> 
                <?php the_content(); ?>
            </div>
        </div>
        <?php
    }
}
get_footer();
?>