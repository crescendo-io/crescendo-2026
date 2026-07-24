<?php
/**
 * Explicit 301 redirects for legacy flat URLs and retired project slugs.
 * Do not rely solely on redirect_canonical after reparenting.
 */

function crescendo_legacy_redirect_map() {
    static $map = null;

    if ($map !== null) {
        return $map;
    }

    $map = array(
        '/realisations/gide/' => '/realisations/cma-associes/',
    );

    $service_slugs = array(
        'agence-web-nantes',
        'creation-site-web-nantes',
        'creation-site-vitrine-nantes',
        'creation-site-ecommerce-nantes',
        'creation-site-wordpress',
        'refonte-site-wordpress',
        'location-site-internet',
        'crm-sur-mesure-nantes',
        'agence-seo-nantes',
        'maintenance-wordpress',
    );

    foreach ($service_slugs as $slug) {
        $map['/' . $slug . '/'] = '/services/' . $slug . '/';
    }

    $secteur_slugs = array(
        'creation-site-artisan-nantes',
        'creation-site-coiffeur-nantes',
        'creation-site-avocat-nantes',
        'creation-site-immobilier-nantes',
        'creation-site-restaurant-nantes',
        'creation-site-startup-nantes',
        'creation-site-b2b-nantes',
        'creation-site-coach-nantes',
        'creation-site-architecte-nantes',
        'creation-site-therapeute-nantes',
        'creation-site-association-nantes',
        'creation-site-btp-nantes',
        'creation-site-paysagiste-nantes',
        'creation-site-electricien-nantes',
        'creation-site-plombier-nantes',
        'creation-site-industrie-nantes',
        'creation-site-cabinet-rh-nantes',
    );

    foreach ($secteur_slugs as $slug) {
        $map['/' . $slug . '/'] = '/secteurs/' . $slug . '/';
    }

    // Historic filename / slug aliases.
    $map['/creation-site-immo-nantes/'] = '/secteurs/creation-site-immobilier-nantes/';
    $map['/creation-site-avocats-nantes/'] = '/secteurs/creation-site-avocat-nantes/';
    $map['/creation-site-restaurants-nantes/'] = '/secteurs/creation-site-restaurant-nantes/';
    $map['/secteurs/creation-site-immo-nantes/'] = '/secteurs/creation-site-immobilier-nantes/';
    $map['/secteurs/creation-site-avocats-nantes/'] = '/secteurs/creation-site-avocat-nantes/';
    $map['/secteurs/creation-site-restaurants-nantes/'] = '/secteurs/creation-site-restaurant-nantes/';

    return $map;
}

function crescendo_normalize_request_path($path) {
    $path = (string) $path;
    $path = parse_url($path, PHP_URL_PATH);
    if (!is_string($path) || $path === '') {
        return '/';
    }

    $path = '/' . ltrim($path, '/');
    if (substr($path, -1) !== '/') {
        $path .= '/';
    }

    return $path;
}

function crescendo_handle_legacy_redirects() {
    if (is_admin() || wp_doing_ajax() || wp_doing_cron() || (defined('REST_REQUEST') && REST_REQUEST)) {
        return;
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
    $path = crescendo_normalize_request_path($request_uri);
    $map = crescendo_legacy_redirect_map();

    if (!isset($map[$path])) {
        return;
    }

    $target = home_url($map[$path]);
    $query = parse_url($request_uri, PHP_URL_QUERY);
    if (is_string($query) && $query !== '') {
        $target .= (strpos($target, '?') === false ? '?' : '&') . $query;
    }

    wp_safe_redirect($target, 301);
    exit;
}
add_action('template_redirect', 'crescendo_handle_legacy_redirects', 0);
