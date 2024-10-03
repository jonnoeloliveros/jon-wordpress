<?php
    $property_agent_title       = get_field('property_agent_title');
    $property_agent_description = get_field('property_agent_description');
?>
<!-- Team Start -->
<div class="container-xxl py-5">
    <div class="container">
        <?php
            if ($property_agent_title || $property_agent_description) {
                echo '<div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">';

                if ($property_agent_title) {
                    echo '<h1 class="mb-3">' . $property_agent_title . '</h1>';
                }

                echo $property_agent_description;
                
                echo '</div>';
            }

            $args = array(
                'post_type'      => 'agent',
                'posts_per_page' => -1,
                'orderby'        => 'date',
                'order'          => 'ASC'
            );
            
            $query = new WP_Query( $args );
            
            if ( $query->have_posts() ) {
                echo '<div class="row g-4">';
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $title = get_the_title();
                    $agent_designation = get_field('agent_designation');
                    $agent_facebook_link = get_field('agent_facebook_link');
                    $agent_twitter_link = get_field('agent_twitter_link');
                    $agent_instagram_link = get_field('agent_instagram_link');
                    $agent_image = get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'img-fluid' ) );
                    ?>
                    <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item rounded overflow-hidden">
                            <div class="position-relative">
                                <?php
                                    if ( has_post_thumbnail() ) {
                                        echo $agent_image;
                                    }

                                    if ($agent_facebook_link || $agent_twitter_link || $agent_instagram_link) {
                                        echo '<div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">';
                                            if ($agent_facebook_link) {
                                                echo '<a class="btn btn-square mx-1" href="' . $agent_facebook_link . '"><i class="fab fa-facebook-f"></i></a>';
                                            }
                                            if ($agent_twitter_link) {
                                                echo '<a class="btn btn-square mx-1" href="' . $agent_twitter_link . '"><i class="fab fa-twitter"></i></a>';
                                            }
                                            if ($agent_instagram_link) {
                                                echo '<a class="btn btn-square mx-1" href="' . $agent_instagram_link . '"><i class="fab fa-instagram"></i></a>';
                                            }
                                        echo '</div>';
                                    }
                                ?>
                            </div>
                            <div class="text-center p-4 mt-3">
                                <h5 class="fw-bold mb-0"><?php echo $title; ?></h5>
                                <?php
                                    if ($agent_designation) {
                                        echo '<small>' . $agent_designation . '</small>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                echo '</div>';
                wp_reset_postdata();
            } else {
                echo 'No posts found.';
            }            
        ?>
    </div>
</div>
<!-- Team End -->