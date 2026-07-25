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
    $homeUrl = crescendo_normalize_canonical(home_url('/'));
    $orgId = untrailingslashit($homeUrl) . '#organization';
    $businessId = untrailingslashit($homeUrl) . '#localbusiness';
    $websiteId = untrailingslashit($homeUrl) . '#website';
    $email = get_field('params-footer-email', 'option') ?: 'b.vidal@crescendo-studio.io';
    $address = array(
        '@type' => 'PostalAddress',
        'addressLocality' => 'Nantes',
        'addressRegion' => 'Pays de la Loire',
        'addressCountry' => 'FR',
    );

    $organization = array(
        '@type' => 'Organization',
        '@id' => $orgId,
        'name' => crescendo_brand_name(),
        'url' => $homeUrl,
        'logo' => crescendo_default_og_image(),
        'description' => $seo['meta_description'],
        'email' => $email,
        'address' => $address,
        'knowsAbout' => crescendo_get_organization_knows_about(),
        'areaServed' => array(
            array('@type' => 'City', 'name' => 'Nantes'),
            array('@type' => 'AdministrativeArea', 'name' => 'Loire-Atlantique'),
        ),
    );

    $sameAs = crescendo_get_organization_same_as();
    if (!empty($sameAs)) {
        $organization['sameAs'] = $sameAs;
    }

    $localBusiness = array(
        '@type' => 'LocalBusiness',
        '@id' => $businessId,
        'name' => crescendo_brand_name(),
        'description' => $seo['meta_description'],
        'url' => $homeUrl,
        'image' => crescendo_get_og_image(),
        'priceRange' => '€€',
        'email' => $email,
        'address' => $address,
        'parentOrganization' => array('@id' => $orgId),
        'areaServed' => array(
            '@type' => 'City',
            'name' => 'Nantes',
        ),
    );

    $website = array(
        '@type' => 'WebSite',
        '@id' => $websiteId,
        'name' => crescendo_brand_name(),
        'url' => $homeUrl,
        'description' => $seo['meta_description'],
        'publisher' => array('@id' => $orgId),
        'inLanguage' => 'fr-FR',
    );

    $graph = array(
        '@context' => 'https://schema.org',
        '@graph' => array(
            $organization,
            $localBusiness,
            $website,
        ),
    );

    $faqSchema = crescendo_build_faq_page_schema(crescendo_get_home_faq_items(), $homeUrl);
    if ($faqSchema) {
        $graph['@graph'][] = $faqSchema;
    }

    crescendo_print_json_ld($graph);
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
