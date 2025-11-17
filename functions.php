<?php
function enqueue_theme_assets() {
    // CSS
    wp_enqueue_style(
        'style-css',
        get_stylesheet_directory_uri() . '/style.css',
        array(),
        wp_get_theme()->get('Version')
    );

    // JS
    wp_enqueue_script(
        'app-js',
        get_stylesheet_directory_uri() . '/assets/js/app.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );

    // OEKOBOX
    wp_enqueue_script(
        'client3-js',
        'https://oekobox-online.eu/v3/shop/biohofbraunST/api/client3.js?config=std',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'enqueue_theme_assets');





// Forceer type="module"
function add_module_type_to_app_js($tag, $handle, $src) {
    if ('app-js' === $handle) {
        return '<script type="module" src="' . esc_url($src) . '" id="app-js-js"></script>';
    }
    return $tag;
}
add_filter('script_loader_tag', 'add_module_type_to_app_js', 10, 3);

//include('assets/php/query-slider.php');