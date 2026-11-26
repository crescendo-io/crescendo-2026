<?php

/**
 * Performance front : CSS/JS non essentiels, styles WordPress inutiles.
 */
function crescendo_performance_resource_hints() {
    if (is_admin()) {
        return;
    }

    if (function_exists('crescendo_uses_studio_design') && crescendo_uses_studio_design()) {
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;550;575;600;650;655;700&display=swap">' . "\n";
    }

    $theme_uri = get_template_directory_uri();
    $fonts = array(
        'poppins-latin-400.woff2',
        'poppins-latin-ext-400.woff2',
        'poppins-latin-500.woff2',
        'poppins-latin-600.woff2',
        'poppins-latin-700.woff2',
    );

    if (!(function_exists('crescendo_uses_studio_design') && crescendo_uses_studio_design())) {
        foreach ($fonts as $font) {
            echo '<link rel="preload" href="' . esc_url($theme_uri . '/assets/fonts/poppins/' . $font) . '" as="font" type="font/woff2" crossorigin>' . "\n";
        }
    }

    $app_css = $theme_uri . '/assets/css/app.css';
    $app_ver = filemtime(get_template_directory() . '/assets/css/app.css');
    echo '<link rel="preload" href="' . esc_url($app_css . '?ver=' . $app_ver) . '" as="style">' . "\n";
}
add_action('wp_head', 'crescendo_performance_resource_hints', 1);

function crescendo_performance_dequeue_core_styles() {
    if (is_admin()) {
        return;
    }

    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('global-styles-inline');
}
add_action('wp_enqueue_scripts', 'crescendo_performance_dequeue_core_styles', 100);

function crescendo_performance_disable_global_styles() {
    if (is_admin()) {
        return;
    }

    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
}
add_action('init', 'crescendo_performance_disable_global_styles', 20);
