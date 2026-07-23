<?php
define('THEME_DIR', get_template_directory() . '/');
define('THEME_URL', get_template_directory_uri() . '/');
define('HOME_URL', get_home_url());

define('AJAX_URL', admin_url('admin-ajax.php'));

if (ENV_PROD) {
    define('GTAG_KEY', get_field('params_ga_code', 'option'));
} else {
    define('GTAG_KEY', 'AIzaSyCvSv4RSBSEL6zCfuA6XIsMMcQA0cxgBno');
}

if(!ENV_LOCAL){
    define('ACF_LITE' , true);
}

require_once (__DIR__ . '/inc/datatypes.php');
require_once (__DIR__ . '/inc/configuration.php');
require_once (__DIR__ . '/inc/configuration_security.php');
require_once (__DIR__ . '/inc/methods.php');
require_once (__DIR__ . '/inc/ajax-methods.php');

require_once (__DIR__ . '/inc/vendors/vendor/autoload.php');


// --------------------------
// Scripts et style
// --------------------------
add_action('init', 'scripts_site');

function scripts_site(){

    if (!is_admin() && !is_login_page()) wp_deregister_script('jquery');

    if (!is_admin() || !is_user_logged_in()) {

         // Style
        wp_enqueue_style('style_principal', get_template_directory_uri() . '/assets/css/app.css', array(), filemtime(get_template_directory() . '/assets/css/app.css'));

        // Script
        wp_enqueue_script('script-js', get_template_directory_uri() . '/assets/js/app.js', array(), filemtime(get_template_directory() . '/assets/js/app.js'), true);

        // Script à injecter exemple :
        // if (is_front_page()) {
        //     wp_enqueue_script('home-js', get_template_directory_uri() . '/js/home.js', array('jquery'), '1.1.0', true);
        // }

       $dataToBePassed = array(
            'wp_ajax_url' => AJAX_URL,
            'wp_theme_url' => THEME_URL,
            'wp_home_url' => HOME_URL,
            'exampleNonce' => wp_create_nonce('exampleNonce'),
            'gtag_key' =>  GTAG_KEY,
            // 'bug_report_id' =>  get_field('params-bugreport-id', 'options')
        );
        wp_localize_script('script-js', 'ParamsData', $dataToBePassed);
    }
}
