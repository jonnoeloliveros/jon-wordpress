<?php

function enqueue_theme_styles() {
    // Enqueue stylesheet with file versioning based on last modification time
    wp_enqueue_style( 'main-style', get_template_directory_uri() . '/style.css', array(), filemtime( get_template_directory() . '/style.css' ), 'all' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_theme_styles' );


// Theme support
add_theme_support( 'menus' );


// Register multiple menu locations
function nav_menus() {
    $locations = array(
        'primary' => __('Primary menu', 'text-domain'),
        'footer' => __('Footer menu', 'text-domain'),
        'credits' => __('Credits menu', 'text-domain')
    );
    register_nav_menus($locations);
}
add_action('init', 'nav_menus');

require_once get_template_directory() . '/functions/simplified-menu.php';

require_once get_template_directory() . '/functions/options-page.php';

require_once get_template_directory() . '/functions/custom-breadcrumbs.php';

add_action('template_redirect', 'redirect_if_404');
function redirect_if_404() {
    if ( is_404() ) {
        // Remember to change the /path-to-go with the URL you like to redirect the users.
        // 301 is permanent redirect. 302 is Temporary redirect.
        wp_redirect(esc_url(home_url('/pages/404-error/')), 301);
        // And here will stop the file execution.
        exit();
    }
}

function modify_search_query($query) {
    if ($query->is_search && !is_admin() && $query->is_main_query()) {

        // Filter by property type (taxonomy query)
        if (isset($_GET['property_type']) && !empty($_GET['property_type'])) {
            $query->set('tax_query', array(
                array(
                    'taxonomy' => 'product_cat', // Replace with your actual taxonomy (for WooCommerce it's 'product_cat')
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field($_GET['property_type']),
                ),
            ));
        }

        // Filter by location (ACF meta query)
        if (isset($_GET['location']) && !empty($_GET['location'])) {
            $meta_query = array(
                array(
                    'key'     => 'product_address', // ACF field key
                    'value'   => sanitize_text_field($_GET['location']),
                    'compare' => 'LIKE', // Use 'LIKE' to allow partial matches
                ),
            );
            $query->set('meta_query', $meta_query);
        }

        // Optional: Restrict search to products only (if you're using WooCommerce or a custom post type)
        $query->set('post_type', 'product'); // Change 'product' to your post type
    }
}
add_action('pre_get_posts', 'modify_search_query');

//insert product title at product's detail page
add_action('woocommerce_single_product_summary', 'add_custom_product_title', 5);
function add_custom_product_title() {
    echo '<h1 class="product_title entry-title">' . get_the_title() . '</h1>';
}


function disable_wp_editor_globally() {
    remove_post_type_support( 'post', 'editor' );
    remove_post_type_support( 'page', 'editor' );
}
add_action( 'init', 'disable_wp_editor_globally' );
