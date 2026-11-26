<?php

/**
 * Design éditorial Studio (maquette Crescendo) — actif sur tout le site hors landing SEA.
 */
function crescendo_uses_studio_design() {
    if (is_admin()) {
        return false;
    }

    return !(function_exists('crescendo_is_landing_page') && crescendo_is_landing_page());
}

/**
 * Logo Crescendo Studio (SVG, currentColor).
 */
function crescendo_studio_logo_markup() {
    $path = get_template_directory() . '/assets/images/studio/logo.svg';
    if (!is_readable($path)) {
        return '';
    }

    $svg = file_get_contents($path);
    if ($svg === false || $svg === '') {
        return '';
    }

    $svg = preg_replace('/\sfill="none"/', '', $svg, 1);
    if (strpos($svg, 'class="studio-brand__logo"') === false) {
        $svg = preg_replace('/<svg\s/', '<svg class="studio-brand__logo" focusable="false" ', $svg, 1);
    }

    return $svg;
}

function crescendo_studio_body_class($classes) {
    if (crescendo_uses_studio_design()) {
        $classes[] = 'site-studio';
    }

    if (!is_admin() && is_front_page() && crescendo_uses_studio_design()) {
        $classes[] = 'has-immersive-hero';
    }

    return $classes;
}

add_filter('body_class', 'crescendo_studio_body_class', 20);

function crescendo_enqueue_studio_front_scripts() {
    if (is_admin() || !is_front_page() || !crescendo_uses_studio_design()) {
        return;
    }

    $themeDir = get_template_directory();
    $themeUri = get_template_directory_uri();
    $files = array(
        'crescendo-studio-mast-hero' => 'studio-mast-hero.js',
        'crescendo-studio-testimonials-slider' => 'studio-testimonials-slider.js',
        'crescendo-studio-cover-reveal' => 'studio-cover-reveal.js',
    );

    foreach ($files as $handle => $relativePath) {
        $path = $themeDir . '/assets/js/' . $relativePath;
        if (!is_readable($path)) {
            continue;
        }

        wp_enqueue_script(
            $handle,
            $themeUri . '/assets/js/' . $relativePath,
            array(),
            filemtime($path),
            true
        );
    }
}

add_action('wp_enqueue_scripts', 'crescendo_enqueue_studio_front_scripts', 30);