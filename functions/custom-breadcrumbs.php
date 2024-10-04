<?php
function custom_breadcrumbs() {

    // Settings
    $separator = ''; // We will use the `breadcrumb-item` class instead
    $home_title = 'Home'; // Home text

    // Get the query & post information
    global $post;

    // Check if we're not on the homepage
    if (!is_front_page()) {
        $is_search = (is_search()) ? ' justify-content-center' : '';
        echo '<nav aria-label="breadcrumb animated fadeIn">';
        echo '<ol class="breadcrumb text-uppercase' . $is_search . '">';

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
?>