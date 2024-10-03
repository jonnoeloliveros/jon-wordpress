<?php
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

// Define the shortcode function
function get_simple_menu_items_shortcode($atts) {
    // Set default attributes and allow dynamic values
    $atts = shortcode_atts(
        array(
            'menu' => 'primary',  // Default value
        ),
        $atts,
        'simple_menu_items' // Shortcode name
    );

    // Use the value of 'menu' passed from the shortcode
    return $menu_items = json_encode(get_menu_items_with_children($atts['menu']));
}

// Register the shortcode with WordPress
add_shortcode('simple_menu_items', 'get_simple_menu_items_shortcode');
?>