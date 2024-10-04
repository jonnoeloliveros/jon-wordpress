<!-- Search Start -->
<div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
    <div class="container">
        <form role="search" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
            <div class="row g-2">
                <div class="col-md-10">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="s" class="form-control border-0 py-3" placeholder="Search Keyword" value="<?php echo get_search_query(); ?>">
                        </div>
                        <div class="col-md-4">
                            <select name="property_type" class="form-select border-0 py-3">
                                <option disabled selected>Select Property Type</option>
                                <?php
                                    $product_categories = get_terms(array(
                                        'taxonomy'   => 'product_cat', // The taxonomy for WooCommerce product categories
                                        'hide_empty' => false,          // Only get categories that have products
                                        'orderby'    => 'term_order',  // Order by the term order set in the dashboard
                                        'order'      => 'ASC',          // Ascending order (you can change to 'DESC' for descending)
                                    ));

                                    if (!empty($product_categories) && !is_wp_error($product_categories)) {
                                        foreach ($product_categories as $category) {
                                            echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="location" class="form-select border-0 py-3">
                                <option disabled selected>Select Location</option>
                                <?php
                                    // Query arguments to get all products
                                    $args = array(
                                        'post_type' => 'product', // Replace 'product' with your actual post type if different
                                        'posts_per_page' => -1,  // Get all products
                                        'post_status'    => 'publish' // Only get published (active) products
                                    );

                                    $products = get_posts($args);
                                    $product_addresses = array();

                                    if ($products) {
                                        // Loop through each product
                                        foreach ($products as $product) {
                                            // Get the ACF field value for each product
                                            $address = get_field('product_address', $product->ID);
                                            
                                            // Check if the address is not empty and add it to the array
                                            if (!empty($address)) {
                                                $product_addresses[] = $address; // Collect addresses
                                            }
                                        }
                                    }

                                    // Get distinct values
                                    $distinct_addresses = array_unique($product_addresses);

                                    if (!empty($distinct_addresses)) {
                                        // Populate the dropdown with distinct addresses
                                        foreach ($distinct_addresses as $address) {
                                            echo '<option value="' . esc_attr($address) . '">' . esc_html($address) . '</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark border-0 w-100 py-3">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Search End -->