<?php

function crescendo_is_service_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-service.php';
}

function crescendo_service($field, $post_id = null) {
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

function crescendo_service_has($field, $post_id = null) {
    $value = crescendo_service($field, $post_id);
    return $value !== null && $value !== '';
}

function crescendo_get_service_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_service('service-seo-meta-title', $post_id);
    $metaDescription = crescendo_service('service-seo-meta-description', $post_id);
    $focusKeyword = crescendo_service('service-seo-focus-keyword', $post_id);
    $noindex = (bool) crescendo_service('service-seo-noindex', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | ' . crescendo_brand_name();
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_service('service-hero-intro', $post_id) ?: ''), 28, '…');
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

function crescendo_service_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $items = array(
        array(
            'label' => 'Accueil',
            'url' => home_url('/'),
        ),
        array(
            'label' => 'Services',
            'url' => home_url('/services/'),
        ),
        array(
            'label' => get_the_title($post_id),
            'url' => get_permalink($post_id),
        ),
    );

    return apply_filters('crescendo_service_breadcrumb', $items, $post_id);
}

function crescendo_output_service_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_service_seo($post_id);
    $faqItems = crescendo_service('service-faq-items', $post_id) ?: array();

    $serviceSchema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => crescendo_service('service-hero-title', $post_id) ?: get_the_title($post_id),
        'description' => $seo['meta_description'],
        'provider' => array(
            '@type' => 'LocalBusiness',
            'name' => crescendo_brand_name(),
            'url' => home_url('/'),
            'address' => array(
                '@type' => 'PostalAddress',
                'addressLocality' => 'Nantes',
                'addressRegion' => 'Pays de la Loire',
                'addressCountry' => 'FR',
            ),
        ),
        'areaServed' => array(
            '@type' => 'City',
            'name' => 'Nantes',
        ),
        'url' => $seo['canonical'],
    );

    $schemas = array($serviceSchema);

    if (!empty($faqItems)) {
        $faqEntities = array();
        foreach ($faqItems as $item) {
            if (empty($item['question']) || empty($item['answer'])) {
                continue;
            }
            $faqEntities[] = array(
                '@type' => 'Question',
                'name' => $item['question'],
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text' => $item['answer'],
                ),
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

function crescendo_filter_document_title($title) {
    if (is_admin() || !is_page()) {
        return $title;
    }

    if (!crescendo_is_service_page()) {
        return $title;
    }

    $seo = crescendo_get_service_seo();
    return $seo['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_document_title');

function crescendo_service_head_meta() {
    if (!is_page() || !crescendo_is_service_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_service_seo(), 'website', get_the_ID());
}
add_action('wp_head', 'crescendo_service_head_meta', 1);
