<?php

function crescendo_is_local_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-local.php';
}

function crescendo_local($field, $post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $value = get_field($field, $post_id);

    if (is_array($value) && empty($value)) {
        return null;
    }

    if ($value !== null && $value !== false && $value !== '') {
        return $value;
    }

    return null;
}

function crescendo_get_local_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_local('local-seo-meta-title', $post_id);
    $metaDescription = crescendo_local('local-seo-meta-description', $post_id);
    $focusKeyword = crescendo_local('local-seo-focus-keyword', $post_id);
    $noindex = (bool) crescendo_local('local-seo-noindex', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | ' . crescendo_brand_name();
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_local('local-hero-intro', $post_id) ?: ''), 28, '…');
    }

    $canonical = get_permalink($post_id);

    return array(
        'meta_title' => $metaTitle,
        'meta_description' => $metaDescription,
        'focus_keyword' => $focusKeyword,
        'canonical' => $canonical,
        'noindex' => $noindex,
    );
}

function crescendo_local_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $items = array(
        array('label' => 'Accueil', 'url' => home_url('/')),
        array('label' => 'Nantes & métropole', 'url' => home_url('/creation-site-web-nantes/')),
        array('label' => get_the_title($post_id), 'url' => get_permalink($post_id)),
    );

    return apply_filters('crescendo_local_breadcrumb', $items, $post_id);
}

function crescendo_output_local_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_local_seo($post_id);
    $faqItems = crescendo_local('local-faq-items', $post_id) ?: array();
    $cityName = crescendo_local('local-city-name', $post_id) ?: get_the_title($post_id);
    $breadcrumb = crescendo_local_breadcrumb($post_id);

    $schemas = array(
        array(
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => crescendo_brand_name(),
            'url' => home_url('/'),
            'logo' => crescendo_default_og_image(),
            'areaServed' => array(
                array('@type' => 'City', 'name' => $cityName),
                array('@type' => 'AdministrativeArea', 'name' => 'Loire-Atlantique'),
            ),
        ),
        array(
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => crescendo_brand_name(),
            'description' => $seo['meta_description'],
            'url' => home_url('/'),
            'priceRange' => '€€',
            'address' => array(
                '@type' => 'PostalAddress',
                'addressLocality' => 'Nantes',
                'addressRegion' => 'Pays de la Loire',
                'addressCountry' => 'FR',
            ),
            'areaServed' => array('@type' => 'City', 'name' => $cityName),
        ),
        array(
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => crescendo_local('local-hero-title', $post_id) ?: get_the_title($post_id),
            'description' => $seo['meta_description'],
            'provider' => array(
                '@type' => 'LocalBusiness',
                'name' => crescendo_brand_name(),
                'url' => home_url('/'),
            ),
            'areaServed' => array('@type' => 'City', 'name' => $cityName),
            'url' => $seo['canonical'],
        ),
    );

    $breadcrumbEntities = array();
    foreach ($breadcrumb as $index => $item) {
        $breadcrumbEntities[] = array(
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $item['label'],
            'item' => $item['url'],
        );
    }
    if (!empty($breadcrumbEntities)) {
        $schemas[] = array(
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbEntities,
        );
    }

    if (!empty($faqItems)) {
        $faqEntities = array();
        foreach ($faqItems as $item) {
            if (empty($item['question']) || empty($item['answer'])) {
                continue;
            }
            $faqEntities[] = array(
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => array('@type' => 'Answer', 'text' => $item['answer']),
            );
        }
        if (!empty($faqEntities)) {
            $schemas[] = array(
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $faqEntities,
            );
        }
    }

    foreach ($schemas as $schema) {
        crescendo_print_json_ld($schema);
    }
}

function crescendo_local_head_meta() {
    if (!is_page() || !crescendo_is_local_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_local_seo(), 'website', get_the_ID());
}
add_action('wp_head', 'crescendo_local_head_meta', 1);

function crescendo_filter_local_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_local_page()) {
        return $title;
    }

    return crescendo_get_local_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_local_document_title', 20);
