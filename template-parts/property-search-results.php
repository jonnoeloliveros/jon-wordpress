<!-- Header Start -->
<div class="container-fluid header bg-white p-0">
    <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-12 p-5 mt-lg-5 text-center" style="padding-top: 10% !important;">
            <?php
                echo  '<h1 class="display-5 animated fadeIn mb-4">Search Results</h1>';
                
                if ( !is_front_page() && !is_home() ) {
                    custom_breadcrumbs();
                }
            ?>
        </div>
    </div>
</div>
<!-- Header End -->

<div class="container-xxl py-5">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="row g-4">
                <?php 
                    while (have_posts()) : the_post();
                        global $product;
                        $the_title = get_the_title();
                        $product_link = get_the_permalink();
                        $product_price = ($product->get_price()) ? '<h5 class="text-primary mb-3">' . wc_price( $product->get_price() ) . '</h5>' : '';
                        $product_address = (get_field('product_address')) ? '<p><i class="fa fa-map-marker-alt text-primary me-2"></i>' . get_field('product_address') . '</p>' : '';
                        $product_area = (get_field('product_area')) ? '<small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>' . get_field('product_area') . ' Sqft</small>' : '';
                        $product_bedrooms = (get_field('product_bedrooms')) ? '<small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>' . get_field('product_bedrooms') . ' Bed</small>': '';
                        $product_bathrooms = (get_field('product_bathrooms')) ? '<small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>' . get_field('product_bathrooms') . ' Bath</small>' : '';
                        $product_image = get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'img-fluid' ) );
                        $categories = get_the_terms( get_the_ID(), 'product_cat' );
                        $product_tags = wp_get_post_terms( get_the_ID(), 'product_tag' );

                        $tags_string = array_map(function($product_tags) {
                            return $product_tags->name;
                        }, $product_tags);

                        $tags_string = implode(' | ', $tags_string);

                        if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                            $category_names = wp_list_pluck( $categories, 'name' );
                            $categories_list = implode( ' ', $category_names );
                        } else {
                            $categories_list = '';
                        }

                        echo '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="property-item rounded overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <a href="' . $product_link . '">' . $product_image . '</a>
                                    <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">' . $tags_string . '</div>
                                    <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">' . $categories_list . '</div>
                                </div>
                                <div class="p-4 pb-0">
                                    ' . $product_price . '
                                    <a class="d-block h5 mb-2" href="' . $product_link . '">' . $the_title . '</a>
                                    ' . $product_address . '
                                </div>
                                <div class="d-flex border-top">
                                    ' . $product_area . $product_bedrooms . $product_bathrooms . '
                                </div>
                            </div>
                        </div>';
                    endwhile;
                ?>
            </div>
        <?php else : ?>
            <p><?php _e('Sorry, no results found.', 'textdomain'); ?></p>
        <?php endif; ?>

        <div class="pagination">
            <?php
                // Pagination for search results
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'textdomain'),
                    'next_text' => __('Next', 'textdomain'),
                ));
            ?>
        </div>
    </div>
</div>