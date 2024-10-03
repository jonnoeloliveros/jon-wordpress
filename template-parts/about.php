<?php
    $about_image        = get_field('about_image');
    $about_title        = get_field('about_title');
    $about_description  = get_field('about_description');
    $about_button       = get_field('about_button');

    if ($about_image || $about_title || $about_description || $about_button ) {
        ?>
        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="about-img position-relative overflow-hidden p-5 pe-0">
                            <?php
                                if ($about_image) {
                                    echo '<img class="img-fluid w-100" src="' . $about_image . '" alt="">';
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <?php
                            if ($about_title) {
                                echo '<h1 class="mb-4">' . $about_title . '</h1>';
                            }
                            
                            echo $about_description;
                            
                            if (!empty($about_button)) {
                                echo '<a class="btn btn-primary py-3 px-5 mt-3" href="' . esc_url( $about_button['url'] ) . '" target="' . esc_html( $about_button['target'] ) . '">' . esc_html( $about_button['title'] ) . '</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->
        <?php
    }
?>
