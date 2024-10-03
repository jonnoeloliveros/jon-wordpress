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
    );
    register_nav_menus($locations);
}
add_action('init', 'nav_menus');

// Simplified menu structure
function get_menu_items_with_children($menu_name) {
    $menu_locations = get_nav_menu_locations(); // Get the menu locations from the theme

    if (!isset($menu_locations[$menu_name])) {
        return []; // Return an empty array if the menu is not found
    }

    $menu_id = $menu_locations[$menu_name]; // Get the ID of the menu
    $menu_items = wp_get_nav_menu_items($menu_id); // Get the raw menu items

    $current_url = home_url(add_query_arg([], $GLOBALS['wp']->request)); // Get the current URL
    $menu_tree = [];
    $child_items = [];

    // First loop to separate child items
    foreach ($menu_items as $item) {
        // Check if the current menu item's URL matches the current page URL
        $is_current = (trailingslashit($item->url) == trailingslashit($current_url));

        if ($item->menu_item_parent) {
            // Save the child items with parent ID as key
            $child_items[$item->menu_item_parent][] = [
                'id'       => $item->ID,
                'title'    => $item->title,
                'url'      => $item->url,
                'current'  => $is_current,
                'children' => []
            ];
        } else {
            // Save parent items in the main tree
            $menu_tree[$item->ID] = [
                'id'       => $item->ID,
                'title'    => $item->title,
                'url'      => $item->url,
                'current'  => $is_current,
                'children' => []
            ];
        }
    }

    // Second loop to assign child items to their parent and set parent as current if any child is current
    foreach ($child_items as $parent_id => $children) {
        if (isset($menu_tree[$parent_id])) {
            // Assign child items to their parent
            $menu_tree[$parent_id]['children'] = $children;

            // Check if any child is current and set the parent as current too
            foreach ($children as $child) {
                if ($child['current']) {
                    $menu_tree[$parent_id]['current'] = true;
                    break; // No need to check further once a current child is found
                }
            }
        }
    }

    // Reset array keys and return the final array structure
    return array_values($menu_tree);
}

// Step 1: Create the options page
function my_custom_options_page() {
    add_menu_page(
        __('Header Settings', 'textdomain'), // Page title
        __('Header Settings', 'textdomain'), // Menu title
        'manage_options',                     // Capability
        'header-settings',                    // Menu slug
        'my_custom_options_page_callback',    // Callback function
        'dashicons-admin-generic',            // Icon
        20                                     // Position
    );
}
add_action('admin_menu', 'my_custom_options_page');

// Step 2: Register settings
function my_custom_settings_init() {
    register_setting('headerSettings', 'cta_button_label');
    register_setting('headerSettings', 'cta_button_url');
}
add_action('admin_init', 'my_custom_settings_init');

// Step 3: Options page callback
function my_custom_options_page_callback() {
    ?>
    <div class="wrap">
        <h1><?php _e('Header Settings', 'textdomain'); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('headerSettings');
            do_settings_sections('headerSettings');
            ?>
            <h2><?php _e('CTA Button', 'textdomain'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="cta_button_label"><?php _e('Button Label', 'textdomain'); ?></label></th>
                    <td><input type="text" id="cta_button_label" name="cta_button_label" value="<?php echo esc_attr(get_option('cta_button_label', '')); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="cta_button_url"><?php _e('Button URL', 'textdomain'); ?></label></th>
                    <td><input type="url" id="cta_button_url" name="cta_button_url" value="<?php echo esc_attr(get_option('cta_button_url', '')); ?>" class="regular-text" placeholder="<?php echo home_url(); ?>"/></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function custom_breadcrumbs() {

    // Settings
    $separator = ''; // We will use the `breadcrumb-item` class instead
    $home_title = 'Home'; // Home text

    // Get the query & post information
    global $post;

    // Check if we're not on the homepage
    if (!is_front_page()) {
        echo '<nav aria-label="breadcrumb animated fadeIn">';
        echo '<ol class="breadcrumb text-uppercase">';

        // Home (always present)
        echo '<li class="breadcrumb-item"><a href="' . home_url() . '">' . $home_title . '</a></li>';

        if (is_single()) { // If it's a single post
            // Get post type
            $post_type = get_post_type();
            
            if ($post_type != 'post') { // Custom post type
                $post_type_object = get_post_type_object($post_type);
                $post_type_link = get_post_type_archive_link($post_type);
                echo '<li class="breadcrumb-item"><a href="' . $post_type_link . '">' . $post_type_object->labels->singular_name . '</a></li>';
            }

            // Get categories
            $category = get_the_category();
            if (!empty($category)) {
                $last_category = end($category);
                $category_links = get_category_parents($last_category->term_id, true, '</li><li class="breadcrumb-item">');
                echo '<li class="breadcrumb-item">' . rtrim($category_links, $separator) . '</li>';
            }

            // Current post title
            echo '<li class="breadcrumb-item text-body active" aria-current="page">' . get_the_title() . '</li>';

        } elseif (is_page()) { // If it's a page
            if ($post->post_parent) { // If it has a parent
                // Get parent pages
                $parent_id = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<li class="breadcrumb-item"><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                    $parent_id = $page->post_parent;
                }

                // Reverse the array to display parent pages first
                $breadcrumbs = array_reverse($breadcrumbs);

                // Display breadcrumbs
                echo implode('', $breadcrumbs);
            }

            // Current page title
            echo '<li class="breadcrumb-item text-body active" aria-current="page">' . get_the_title() . '</li>';

        } elseif (is_category()) { // If it's a category archive
            echo '<li class="breadcrumb-item text-body active" aria-current="page">' . single_cat_title('', false) . '</li>';

        } elseif (is_tag()) { // If it's a tag archive
            echo '<li class="breadcrumb-item text-body active" aria-current="page">' . single_tag_title('', false) . '</li>';

        } elseif (is_author()) { // If it's an author archive
            global $author;
            $userdata = get_userdata($author);
            echo '<li class="breadcrumb-item text-body active" aria-current="page">' . $userdata->display_name . '</li>';

        } elseif (is_archive()) { // If it's a date, taxonomy, or custom post type archive
            if (is_post_type_archive()) {
                echo '<li class="breadcrumb-item text-body active" aria-current="page">' . post_type_archive_title('', false) . '</li>';
            } elseif (is_day()) {
                echo '<li class="breadcrumb-item text-body active" aria-current="page">' . get_the_date() . '</li>';
            } elseif (is_month()) {
                echo '<li class="breadcrumb-item text-body active" aria-current="page">' . get_the_date('F Y') . '</li>';
            } elseif (is_year()) {
                echo '<li class="breadcrumb-item text-body active" aria-current="page">' . get_the_date('Y') . '</li>';
            }
        } elseif (is_search()) { // If it's a search results page
            echo '<li class="breadcrumb-item text-body active" aria-current="page">Search results for: ' . get_search_query() . '</li>';
        }

        echo '</ol>';
        echo '</nav>';
    }
}

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

// Disable Gutenberg for all post types
// add_filter('use_block_editor_for_post', '__return_false', 10);
// add_filter('use_block_editor_for_post_type', '__return_false', 10);

// Optionally, disable it for custom post types
// add_filter('use_block_editor_for_post_type', function($use_block_editor, $post_type) {
    // List your custom post types that should not use Gutenberg
    // $post_types_to_disable = ['your_custom_post_type'];
    // if (in_array($post_type, $post_types_to_disable)) {
        // return false;
    // }
    // return $use_block_editor;
// }, 10, 2);

function disable_wp_editor_globally() {
    remove_post_type_support( 'post', 'editor' );
    remove_post_type_support( 'page', 'editor' );
}
add_action( 'init', 'disable_wp_editor_globally' );
