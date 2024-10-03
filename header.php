<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Title of the Website -->
    <title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo( 'name' ); ?></title>

    <!-- SEO Meta Tags -->
    <meta content="<?php bloginfo('description'); ?>" name="description">
    <meta content="" name="keywords">

    <!-- Favicon (Optional) -->
    <link rel="icon" href="<?php echo (get_site_icon_url()) ? get_site_icon_url() : get_template_directory_uri() . '/images/favicon.ico'; ?>" type="image/x-icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?php echo get_template_directory_uri(); ?>/lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?php echo get_template_directory_uri(); ?>/css/style.css" rel="stylesheet">

    <!-- WordPress Head -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="<?php echo home_url(); ?>" class="navbar-brand d-flex align-items-center text-center">
                    <?php
                        if (get_theme_mod('custom_logo')) {
                            echo '<div class="icon p-2 me-2"><img class="img-fluid" src="' . esc_url(get_theme_mod('custom_logo')) . '" alt="' . esc_attr(get_bloginfo('name')) . '" style="width: 30px; height: 30px;"></div>';
                        }
                    ?>
                    <h1 class="m-0 text-primary"><?php bloginfo( 'name' ); ?></h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <?php
                            $menu = get_menu_items_with_children('primary');
                            
                            foreach ($menu as $value) {
                                $is_active = ($value['current']) ? ' active' : '';
                                if (empty($value['children'])) {
                                    echo '<a href="' . $value['url'] . '" class="nav-item nav-link' . $is_active . '">' . $value['title'] . '</a>';
                                } else {
                                    echo '<div class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle' . $is_active . '" data-bs-toggle="dropdown">' . $value['title'] . '</a>
                                        <div class="dropdown-menu rounded-0 m-0">';
                                            foreach ($value['children'] as $child) {
                                                $is_active_child = ($child['current']) ? ' active' : '';
                                                echo '<a href="' . $child['url'] . '" class="dropdown-item' . $is_active_child. '">' . $child['title'] . '</a>';
                                            }
                                        echo '</div>
                                    </div>';
                                }
                            }
                        ?>
                    </div>
                    <?php
                        $button_label = get_option('cta_button_label');
                        $button_url = get_option('cta_button_url');                     
                        
                        if ( ! empty( $button_label ) && ! empty( $button_url ) ) {
                            echo '<a href="' . esc_url( $button_url ) . '" class="btn btn-primary px-3 d-none d-lg-flex">' . esc_html( $button_label ) . '</a>';
                        }                    
                    ?>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->
