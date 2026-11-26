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

    if (
        function_exists('crescendo_uses_studio_service_layout')
        && crescendo_uses_studio_service_layout()
    ) {
        $classes[] = 'has-studio-service-layout';
        $classes[] = 'has-studio-dark-hero';
    }

    if (
        function_exists('crescendo_uses_studio_secteur_layout')
        && crescendo_uses_studio_secteur_layout()
    ) {
        $classes[] = 'has-studio-secteur-layout';
        $classes[] = 'has-studio-dark-hero';
    }

    if (crescendo_studio_page_has_dark_hero_band($classes)) {
        $classes[] = 'has-studio-dark-hero';
    }

    return $classes;
}

/**
 * Pages Studio avec bandeau hero sombre (scroll mast).
 */
function crescendo_studio_page_has_dark_hero_band($classes) {
    if (in_array('has-studio-dark-hero', $classes, true) || in_array('has-immersive-hero', $classes, true)) {
        return false;
    }

    $layoutChecks = array(
        'crescendo_uses_studio_services_hub_layout',
        'crescendo_uses_studio_secteurs_hub_layout',
        'crescendo_uses_studio_realisations_layout',
        'crescendo_uses_studio_about_layout',
        'crescendo_uses_studio_project_layout',
    );

    foreach ($layoutChecks as $callback) {
        if (function_exists($callback) && $callback()) {
            return true;
        }
    }

    return false;
}

add_filter('body_class', 'crescendo_studio_body_class', 20);

function crescendo_page_uses_studio_interactions() {
    return function_exists('crescendo_uses_studio_design') && crescendo_uses_studio_design();
}

function crescendo_enqueue_studio_front_scripts() {
    if (is_admin() || !crescendo_uses_studio_design() || !crescendo_page_uses_studio_interactions()) {
        return;
    }

    $themeDir = get_template_directory();
    $themeUri = get_template_directory_uri();
    $files = array(
        'crescendo-studio-mast-hero' => 'studio-mast-hero.js',
        'crescendo-studio-mast-nav' => 'studio-mast-nav.js',
        'crescendo-studio-cover-reveal' => 'studio-cover-reveal.js',
    );

    if (
        is_front_page()
        || (function_exists('crescendo_uses_studio_about_layout') && crescendo_uses_studio_about_layout())
    ) {
        $files['crescendo-studio-testimonials-slider'] = 'studio-testimonials-slider.js';
    }

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