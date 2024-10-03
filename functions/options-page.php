<?php
function my_theme_enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_jquery');

function my_theme_enqueue_admin_scripts( $hook ) {
    if ( 'toplevel_page_footer-settings' !== $hook ) {
        return;
    }

    wp_enqueue_media(); // Enqueue WordPress media uploader scripts

    wp_enqueue_script(
        'my-theme-gallery-picker',
        get_template_directory_uri() . '/js/gallery-picker.js',
        array( 'jquery' ), // Ensure jQuery is a dependency
        null,
        true
    );
}
add_action( 'admin_enqueue_scripts', 'my_theme_enqueue_admin_scripts' );

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

    add_menu_page(
        __('Footer Settings', 'textdomain'), // Page title
        __('Footer Settings', 'textdomain'), // Menu title
        'manage_options',                     // Capability
        'footer-settings',                    // Menu slug
        'my_footer_options_page_callback',    // Callback function
        'dashicons-admin-generic',            // Icon
        21                                  // Position
    );
}
add_action('admin_menu', 'my_custom_options_page');

// Step 2: Register settings
function my_custom_settings_init() {
    //Header Options
    register_setting('headerSettings', 'cta_button_label');
    register_setting('headerSettings', 'cta_button_url');

    //Footer Options
    //Column 1
    register_setting('footerSettings', 'column1_heading');
    register_setting('footerSettings', 'address');
    register_setting('footerSettings', 'phone_number');
    register_setting('footerSettings', 'email_address');
    register_setting('footerSettings', 'twitter_url');
    register_setting('footerSettings', 'facebook_url');
    register_setting('footerSettings', 'youtube_url');
    register_setting('footerSettings', 'linkedin_url');
    //Column 2
    register_setting('footerSettings', 'column2_heading');
    register_setting('footerSettings', 'footer_shortcode');
    //Column 3
    register_setting('footerSettings', 'column3_heading');
    register_setting( 'footerSettings', 'gallery_images' );
    add_settings_section( 'gallery_picker_section', 'Gallery Picker', null, 'gallery-picker' );
    add_settings_field( 'gallery_images_field', 'Select Gallery Images', 'my_footer_options_page_callback', 'gallery-picker', 'gallery_picker_section' );
    //Column 4
    register_setting('footerSettings', 'column4_heading');
    register_setting('footerSettings', 'column4_description');
    //Credits Section
    register_setting('footerSettings', 'credits_shortcode');
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
function my_footer_options_page_callback() {
    ?>
    <div class="wrap">
        <h1><?php _e('Footer Settings', 'textdomain'); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('footerSettings');
            do_settings_sections('footerSettings');

            $gallery_images = get_option( 'gallery_images' );
            ?>
            <hr/>
            <h3>Column 1</h3>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="column1_heading"><?php _e('Heading', 'textdomain'); ?></label></th>
                    <td><input type="text" id="column1_heading" name="column1_heading" value="<?php echo esc_attr(get_option('column1_heading', '')); ?>" placeholder="Get In Touch" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="address"><?php _e('Address', 'textdomain'); ?></label></th>
                    <td><input type="text" id="address" name="address" value="<?php echo esc_attr(get_option('address', '')); ?>" class="regular-text" placeholder="123 Street, New York, USA"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="phone_number"><?php _e('Phone', 'textdomain'); ?></label></th>
                    <td><input type="text" id="phone_number" name="phone_number" value="<?php echo esc_attr(get_option('phone_number', '')); ?>" class="regular-text" placeholder="+012 345 67890"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="email_address"><?php _e('Email Address', 'textdomain'); ?></label></th>
                    <td><input type="text" id="email_address" name="email_address" value="<?php echo esc_attr(get_option('email_address', '')); ?>" class="regular-text" placeholder="info@example.com"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="twitter_url"><?php _e('Twitter URL', 'textdomain'); ?></label></th>
                    <td><input type="url" id="twitter_url" name="twitter_url" value="<?php echo esc_attr(get_option('twitter_url', '')); ?>" class="regular-text" placeholder="https://x.com"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="facebook_url"><?php _e('Facebook URL', 'textdomain'); ?></label></th>
                    <td><input type="url" id="facebook_url" name="facebook_url" value="<?php echo esc_attr(get_option('facebook_url', '')); ?>" class="regular-text" placeholder="https://facebook.com"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="youtube_url"><?php _e('Youtube URL', 'textdomain'); ?></label></th>
                    <td><input type="url" id="youtube_url" name="youtube_url" value="<?php echo esc_attr(get_option('youtube_url', '')); ?>" class="regular-text" placeholder="https://youtube.com"/></td>
                </tr>
                <tr>
                    <th scope="row"><label for="linkedin_url"><?php _e('Linkedin URL', 'textdomain'); ?></label></th>
                    <td><input type="url" id="linkedin_url" name="linkedin_url" value="<?php echo esc_attr(get_option('linkedin_url', '')); ?>" class="regular-text" placeholder="https://linkedin.com"/></td>
                </tr>
            </table>
            <hr>
            <h3>Column 2</h3>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="column2_heading"><?php _e('Heading', 'textdomain'); ?></label></th>
                    <td><input type="text" id="column2_heading" name="column2_heading" value="<?php echo esc_attr(get_option('column2_heading', '')); ?>" placeholder="Quick Links" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="footer_shortcode"><?php _e('Menu Shortcode', 'textdomain'); ?></label></th>
                    <td><input type="text" id="footer_shortcode" name="footer_shortcode" value="<?php echo esc_attr(get_option('footer_shortcode', '')); ?>" placeholder='[simple_menu_items menu="footer"]' class="regular-text" /></td>
                </tr>
            </table>
            <hr/>
            <h3>Column 3</h3>
            <table class="form-table">
            <tr>
                <th scope="row"><label for="column3_heading"><?php _e('Heading', 'textdomain'); ?></label></th>
                    <td><input type="text" id="column3_heading" name="column3_heading" value="<?php echo esc_attr(get_option('column3_heading', '')); ?>" placeholder="Photo Gallery" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label><?php _e('Gallery Picker', 'textdomain'); ?></label></th>
                    <td>
                        <input type="hidden" id="gallery_images" name="gallery_images" value="<?php echo esc_attr( $gallery_images ); ?>">
                        <button type="button" class="button gallery-picker-button"><?php esc_html_e( 'Select Images', 'textdomain' ); ?></button>
                        <div class="gallery-preview" style="margin-top: 15px;">
                            <?php
                            if ( ! empty( $gallery_images ) ) {
                                $image_ids = explode( ',', $gallery_images );
                                foreach ( $image_ids as $image_id ) {
                                    $image_url = wp_get_attachment_image_src( $image_id, 'thumbnail' );
                                    if ( $image_url ) {
                                        echo '<img src="' . esc_url( $image_url[0] ) . '" style="max-width: 100px; margin-right: 10px;">';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </td>
                </tr>
            </table>
            <hr>
            <h3>Column 4</h3>
            <table class="form-table">
                <th scope="row"><label for="column4_heading"><?php _e('Heading', 'textdomain'); ?></label></th>
                    <td><input type="text" id="column4_heading" name="column4_heading" value="<?php echo esc_attr(get_option('column4_heading', '')); ?>" placeholder="Newsletter" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><label for="column4_description"><?php _e('Description', 'textdomain'); ?></label></th>
                    <td>
                        <textarea id="column4_description" name="column4_description" rows="5" class="large-text" placeholder="Dolor amet sit justo amet elitr clita ipsum elitr est."><?php echo esc_textarea(get_option('column4_description', '')); ?></textarea>
                    </td>
                </tr>
            </table>
            <hr>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="credits_shortcode"><?php _e('Credits Menu Shortcode', 'textdomain'); ?></label></th>
                    <td><input type="text" id="credits_shortcode" name="credits_shortcode" value="<?php echo esc_attr(get_option('credits_shortcode', '')); ?>" placeholder='[simple_menu_items menu="credits"]' class="regular-text" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
?>