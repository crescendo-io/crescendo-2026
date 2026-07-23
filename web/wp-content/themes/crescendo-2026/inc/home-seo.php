<?php

function crescendo_get_home_seo() {
    $metaTitle = 'Agence web Nantes — WordPress & CRM | Crescendo';
    $metaDescription = 'Crescendo Studio, agence web à Nantes : sites WordPress sur mesure, CRM connecté et location dès 350€/mois. Maquette gratuite en 48h, sans engagement.';

    $acfTitle = function_exists('crescendo_home') ? crescendo_home('home-seo-meta-title') : null;
    $acfDescription = function_exists('crescendo_home') ? crescendo_home('home-seo-meta-description') : null;

    if ($acfTitle) {
        $metaTitle = $acfTitle;
    }
    if ($acfDescription) {
        $metaDescription = $acfDescription;
    }

    return array(
        'meta_title' => $metaTitle,
        'meta_description' => $metaDescription,
        'canonical' => home_url('/'),
        'noindex' => false,
    );
}

function crescendo_output_home_schema() {
    $seo = crescendo_get_home_seo();
    $phone = crescendo_public_phone();
    $email = get_field('params-footer-email', 'option') ?: 'contact@crescendo-studio.io';

    $organization = array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => crescendo_brand_name(),
        'url' => home_url('/'),
        'logo' => crescendo_default_og_image(),
        'email' => $email,
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Nantes',
            'addressRegion' => 'Pays de la Loire',
            'addressCountry' => 'FR',
        ),
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Nantes'),
            array('@type' => 'AdministrativeArea', 'name' => 'Loire-Atlantique'),
        ),
    );

    if ($phone) {
        $organization['telephone'] = $phone;
    }

    $localBusiness = array(
        '@context' => 'https://schema.org',
        '@type' => 'LocalBusiness',
        'name' => crescendo_brand_name(),
        'description' => $seo['meta_description'],
        'url' => home_url('/'),
        'image' => crescendo_get_og_image(),
        'priceRange' => '€€',
        'email' => $email,
        'address' => array(
            '@type' => 'PostalAddress',
            'addressLocality' => 'Nantes',
            'addressRegion' => 'Pays de la Loire',
            'addressCountry' => 'FR',
        ),
        'areaServed' => array(
            '@type' => 'City',
            'name' => 'Nantes',
        ),
    );

    if ($phone) {
        $localBusiness['telephone'] = $phone;
    }

    $website = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => crescendo_brand_name(),
        'url' => home_url('/'),
        'description' => $seo['meta_description'],
        'publisher' => array(
            '@type' => 'Organization',
            'name' => crescendo_brand_name(),
            'url' => home_url('/'),
        ),
        'inLanguage' => 'fr-FR',
    );

    crescendo_print_json_ld($organization);
    crescendo_print_json_ld($localBusiness);
    crescendo_print_json_ld($website);
}

function crescendo_home_head_meta() {
    if (!is_front_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_home_seo(), 'website', get_queried_object_id());
}
add_action('wp_head', 'crescendo_home_head_meta', 1);

function crescendo_filter_home_document_title($title) {
    if (is_admin() || !is_front_page()) {
        return $title;
    }

    return crescendo_get_home_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_home_document_title', 20);

function crescendo_home_footer_schema() {
    if (!is_front_page()) {
        return;
    }

    crescendo_output_home_schema();
}
add_action('wp_footer', 'crescendo_home_footer_schema', 5);
