<?php
    $property_types_title       = get_field('property_types_title');
    $property_types_description = get_field('property_types_description');

    if ($property_types_title || $property_types_description) {
        ?>
        <!-- Category Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                    <?php
                        if ($property_types_title) {
                            echo '<h1 class="mb-3">' . $property_types_title . '</h1>';
                        }
                        
                        echo $property_types_description;
                    ?>
                </div>
                <?php
                    // Get product categories excluding 'Uncategorized'
                    $product_categories = get_terms(array(
                        'taxonomy'   => 'product_cat', // The taxonomy for WooCommerce product categories
                        'hide_empty' => false,          // Only get categories that have products
                        'exclude'    => array(get_option('default_product_cat')), // Exclude 'Uncategorized'
                        'orderby'    => 'term_order',  // Order by the term order set in the dashboard
                        'order'      => 'ASC',          // Ascending order (you can change to 'DESC' for descending)
                    ));

                    // Check if any categories were found
                    if (!empty($product_categories) && !is_wp_error($product_categories)) {
                        echo '<div class="row g-4">';
                        foreach ($product_categories as $category) {
                            $thumbnail_id   = get_term_meta($category->term_id, 'thumbnail_id', true);
                            $category_image = wp_get_attachment_image_url($thumbnail_id, 'full');
                            $category_link  = get_term_link($category);

                            if ($category_image) {
                                $image = '<div class="icon mb-3"><img class="img-fluid" src="' . esc_url($category_image) . '" alt="' . esc_attr($category->name) . '"></div>';
                            }
                            
                            echo '<div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                                    <a class="cat-item d-block bg-light text-center rounded p-3" href="' . esc_html( $category_link ) . '">
                                        <div class="rounded p-4">'. $image . '
                                            <h6>' . esc_html($category->name) . '</h6>
                                            <span>' . esc_html($category->count) . ' Properties</span>
                                        </div>
                                    </a>
                                </div>';
                        }
                        echo '</div>';
                    } else {
                        echo 'No product categories found.';
                    }
                ?>
            </div>
        </div>
        <!-- Category End -->
        <?php
    }
?>