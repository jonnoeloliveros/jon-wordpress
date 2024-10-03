<?php
    $property_listing_title       = get_field('property_listing_title');
    $property_listing_description = get_field('property_listing_description');

    $product_tags    = get_terms( array(
        'taxonomy'   => 'product_tag',
        'hide_empty' => false,
        'orderby'    => 'term_id',
        'order'      => 'ASC'
    ) );
?>
<!-- Property List Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <?php
                    if ($property_listing_title || $property_listing_description) {
                        echo '<div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">';
                            if ($property_listing_title) {
                                echo '<h1 class="mb-3">' . $property_listing_title . '</h1>';
                            }
                            echo $property_listing_description;
                        echo '</div>';
                    }
                ?>
            </div>
            <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                    <?php
                        if ( ! empty( $product_tags ) && ! is_wp_error( $product_tags ) ) {
                            $counter = 1;
                            foreach ( $product_tags as $tag ) {
                                $active_class = ($counter == 1) ? 'active' : '';
                                echo '<li class="nav-item me-2">
                                        <a class="btn btn-outline-primary ' . $active_class . '" data-bs-toggle="pill" href="#tab-' . $counter . '">' . $tag->name . '</a>
                                    </li>';
                                $counter++;
                            }
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <?php
                if ( ! empty( $product_tags ) && ! is_wp_error( $product_tags ) ) {
                    $counter = 1;
                    $excluded_tag_name = 'featured';

                    foreach ( $product_tags as $tag ) {
                        $active_class = ($counter == 1) ? 'active' : '';
                        echo '<div id="tab-' . $counter . '" class="tab-pane fade show p-0 ' . $active_class . '"><div class="row g-4">';

                        $args = array(
                            'post_type'      => 'product',
                            'posts_per_page' => -1,
                            'tax_query'      => array(
                                array(
                                    'taxonomy' => 'product_tag',
                                    'field'    => 'slug',
                                    'terms'    => $tag->slug,
                                ),
                            ),
                            'orderby'        => 'date',
                            'order'          => 'ASC',
                        );
                
                        $products = new WP_Query( $args );
                
                        if ( $products->have_posts() ) {
                            while ( $products->have_posts() ) {
                                $products->the_post();
                                
                                global $product;
                                $the_title = get_the_title();
                                $product_price = ($product->get_price()) ? '<h5 class="text-primary mb-3">' . wc_price( $product->get_price() ) . '</h5>' : '';
                                $categories = get_the_terms( get_the_ID(), 'product_cat' );
                                $product_image = get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'img-fluid' ) );
                                $product_address = (get_field('product_address')) ? '<p><i class="fa fa-map-marker-alt text-primary me-2"></i>' . get_field('product_address') . '</p>' : '';
                                $product_area = (get_field('product_area')) ? '<small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>' . get_field('product_area') . ' Sqft</small>' : '';
                                $product_bedrooms = (get_field('product_bedrooms')) ? '<small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>' . get_field('product_bedrooms') . ' Bed</small>': '';
                                $product_bathrooms = (get_field('product_bathrooms')) ? '<small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>' . get_field('product_bathrooms') . ' Bath</small>' : '';
                                $product_tags = wp_get_post_terms( get_the_ID(), 'product_tag' );

                                $filtered_tags = array_filter( $product_tags, function( $tag ) use ( $excluded_tag_name ) {
                                    return strtolower( $tag->name ) !== strtolower( $excluded_tag_name );
                                });

                                $tags_string = array_map(function($filtered_tags) {
                                    return $filtered_tags->name;
                                }, $filtered_tags);

                                $tags_string = implode(' ', $tags_string);

                                if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                                    $category_names = wp_list_pluck( $categories, 'name' );
                                    $categories_list = implode( ' ', $category_names );
                                } else {
                                    $categories_list = '';
                                }                                

                                echo '<div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="property-item rounded overflow-hidden">
                                        <div class="position-relative overflow-hidden">
                                            <a href="">' . $product_image . '</a>
                                            <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">' . $tags_string . '</div>
                                            <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">' . $categories_list . '</div>
                                        </div>
                                        <div class="p-4 pb-0">
                                            ' . $product_price . '
                                            <a class="d-block h5 mb-2" href="">' . $the_title . '</a>
                                            ' . $product_address . '
                                        </div>
                                        <div class="d-flex border-top">
                                            ' . $product_area . $product_bedrooms . $product_bathrooms . '
                                        </div>
                                    </div>
                                </div>';
                            }
                        } else {
                            echo '<div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">No products found.</div>';
                        }

                        echo '<div class="col-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                                    <a class="btn btn-primary py-3 px-5" href="">Browse More Property</a>
                            </div></div></div>';

                        wp_reset_postdata();
                        $counter++;
                    }
                }
            ?>
        </div>
    </div>
</div>
<!-- Property List End -->