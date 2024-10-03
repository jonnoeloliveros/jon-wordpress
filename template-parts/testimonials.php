<?php
    $testimonials_title       = get_field('testimonials_title');
    $testimonials_description = get_field('testimonials_description');

    if ($testimonials_title || $testimonials_description) {
        ?>
        <!-- Testimonial Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">';
                    <?php
                        if ($testimonials_title) {
                            echo '<h1 class="mb-3">' . $testimonials_title . '</h1>';
                        }
                        echo $testimonials_description;
                    ?>
                </div>
                <?php
                    $args = array(
                        'post_type'      => 'testimonial',
                        'posts_per_page' => -1,
                        'orderby'        => 'date',
                        'order'          => 'ASC',
                    );
            
                    $testimonials = new WP_Query( $args );
            
                    if ( $testimonials->have_posts() ) {

                        echo '<div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.1s">';

                        while ( $testimonials->have_posts() ) {
                            $testimonials->the_post();

                            $name = get_the_title();
                            $profession = (get_field('testimonial_profession')) ? '<small>' . get_field('testimonial_profession') . '</small>' : '';
                            $testimony = get_field('testimonial_testimony');
                            $image = get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'img-fluid flex-shrink-0 rounded', 'style' => 'width: 45px; height: 45px;' ) );

                            echo '<div class="testimonial-item bg-light rounded p-3">
                                    <div class="bg-white border rounded p-4">
                                        ' . $testimony . '
                                        <div class="d-flex align-items-center">
                                            ' . $image . '
                                            <div class="ps-3">
                                                <h6 class="fw-bold mb-1">' . $name . '</h6>
                                                ' . $profession . '
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }

                        echo '</div>';
                    }
                    wp_reset_postdata();
                ?>
            </div>
        </div>
        <!-- Testimonial End -->
        <?php
    }
?>