        <!-- Footer Start -->
        <?php
            //column 1 variables
            $column1_heading = (get_option('column1_heading')) ? '<h5 class="text-white mb-4">' . get_option('column1_heading') . '</h5>' : '';
            $address = (get_option('address')) ? '<p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>' . get_option('address') . '</p>' : '';
            $phone_number = (get_option('phone_number')) ? '<p class="mb-2"><i class="fa fa-phone-alt me-3"></i>' . get_option('phone_number') . '</p>' : '';
            $email_address = (get_option('email_address')) ? '<p class="mb-2"><i class="fa fa-envelope me-3"></i>' . get_option('email_address') . '</p>' : '';
            $twitter_url = (get_option('twitter_url')) ? '<a class="btn btn-outline-light btn-social" href="' . get_option('twitter_url') . '"><i class="fab fa-twitter"></i></a>' : '';
            $facebook_url = (get_option('facebook_url')) ? '<a class="btn btn-outline-light btn-social" href="' . get_option('facebook_url') . '"><i class="fab fa-facebook-f"></i></a>' : '';
            $youtube_url = (get_option('youtube_url')) ? '<a class="btn btn-outline-light btn-social" href="' . get_option('youtube_url') . '"><i class="fab fa-youtube"></i></a>' : '';
            $linkedin_url = (get_option('linkedin_url')) ? '<a class="btn btn-outline-light btn-social" href="' . get_option('linkedin_url') . '"><i class="fab fa-linkedin-in"></i></a>' : '';
            //column 2 variables
            $column2_heading = (get_option('column2_heading')) ? '<h5 class="text-white mb-4">' . get_option('column2_heading') . '</h5>' : '';
            $footer_shortcode = get_option('footer_shortcode');
            //column 3 variables
            $column3_heading = (get_option('column3_heading')) ? '<h5 class="text-white mb-4">' . get_option('column3_heading') . '</h5>' : '';
            $gallery_images = get_option( 'gallery_images' );
            //Column 4 variables
            $column4_heading = (get_option('column4_heading')) ? '<h5 class="text-white mb-4">' . get_option('column4_heading') . '</h5>' : '';
            $column4_description = get_option('column4_description');
            //Credits
            $credits_shortcode = get_option('credits_shortcode');
        ?>
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <?php
                            echo $column1_heading
                                . $address
                                . $phone_number
                                . $email_address;

                            if ($twitter_url || $facebook_url || $youtube_url || $linkedin_url) {
                                echo '<div class="d-flex pt-2">' . 
                                    $twitter_url . 
                                    $facebook_url . 
                                    $youtube_url . 
                                    $linkedin_url . 
                                '</div>';
                            }
                        ?>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <?php
                            echo $column2_heading;
                            
                            $menu_shortcode = json_decode(do_shortcode( $footer_shortcode ));

                            if (! empty($menu_shortcode)) {
                                foreach ($menu_shortcode as $item) {
                                    echo '<a class="btn btn-link text-white-50" href="' . $item->url . '" target="_blank">' . $item->title . '</a>';
                                }
                            }
                        ?>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <?php
                            echo $column3_heading;

                            if ( ! empty( $gallery_images ) ) {
                                $image_ids = explode( ',', $gallery_images );

                                echo '<div class="row g-2 pt-2">';

                                    foreach ( $image_ids as $image_id ) {
                                        $gallery_image = wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'img-fluid rounded bg-light p-1' ) );
                                        
                                        echo '<div class="col-4">' . $gallery_image . '</div>';
                                    }

                                echo '</div>';
                            }                            
                        ?>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <?php
                            echo $column4_heading .
                                 $column4_description;
                        ?>
                        <div class="position-relative mx-auto" style="max-width: 400px;">
                            <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                            <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a>, All Right Reserved. 
							
							<!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
							Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <?php
                                $credits_menu_shortcode = json_decode(do_shortcode( $credits_shortcode ));

                                if (! empty($credits_shortcode)) {
                                    echo '<div class="footer-menu">';

                                        foreach ($credits_menu_shortcode as $item) {
                                            echo '<a href="' . $item->url . '">' . $item->title . '</a>';
                                        }

                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/lib/wow/wow.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/lib/easing/easing.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/lib/waypoints/waypoints.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>

    <!-- WordPress Footer Hook -->
    <?php wp_footer(); ?>
</body>

</html>