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

function disable_wp_editor_globally() {
    remove_post_type_support( 'post', 'editor' );
    remove_post_type_support( 'page', 'editor' );
}
add_action( 'init', 'disable_wp_editor_globally' );
