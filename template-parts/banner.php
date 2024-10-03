<?php
    $banner_title       = get_field('banner_title');
    $banner_description = get_field('banner_description');
    $banner_button      = get_field('banner_button');
    $banner_image_1     = get_field('banner_image_1');
    $banner_image_2     = get_field('banner_image_2');

    if ($banner_title || $banner_description || $banner_button || $banner_image_1 || $banner_image_2) {
        ?>
        <!-- Header Start -->
        <div class="container-fluid header bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <?php
                        if ($banner_title) {
                            echo  '<h1 class="display-5 animated fadeIn mb-4">' . $banner_title . '</h1>';

                        }
                        
                        if ( !is_front_page() && !is_home() ) {
                            custom_breadcrumbs();
                        }
                        
                        echo $banner_description;

                        if ( !empty( $banner_button ) ) {
                            echo '<a href="' . esc_url( $banner_button['url'] ) . '" target="' . esc_html( $banner_button['target'] ) . '" class="btn btn-primary py-3 px-5 me-3 animated fadeIn">' . esc_html( $banner_button['title'] ) . '</a>';
                        } 
                    ?>
                </div>
                <div class="col-md-6 animated fadeIn">
                    <div class="owl-carousel header-carousel">
                        <?php
                            if ($banner_image_1) {
                                ?>
                                <div class="owl-carousel-item">
                                    <img class="img-fluid" src="<?php echo $banner_image_1; ?>" alt="">
                                </div>
                                <?php
                            }
                            if ($banner_image_2) {
                                ?>
                                <div class="owl-carousel-item">
                                    <img class="img-fluid" src="<?php echo $banner_image_2; ?>" alt="">
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
        <?php
    }
?>