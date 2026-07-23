<?php

function crescendo_is_secteur_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-secteur.php';
}

function crescendo_secteur($field, $post_id = null) {
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

function crescendo_get_secteur_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_secteur('secteur-seo-meta-title', $post_id);
    $metaDescription = crescendo_secteur('secteur-seo-meta-description', $post_id);
    $focusKeyword = crescendo_secteur('secteur-seo-focus-keyword', $post_id);
    $noindex = (bool) crescendo_secteur('secteur-seo-noindex', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | ' . crescendo_brand_name();
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_secteur('secteur-hero-intro', $post_id) ?: ''), 28, '…');
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

function crescendo_secteur_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $items = array(
        array('label' => 'Accueil', 'url' => home_url('/')),
        array('label' => 'Secteurs', 'url' => home_url('/secteurs/')),
        array('label' => get_the_title($post_id), 'url' => get_permalink($post_id)),
    );

    return apply_filters('crescendo_secteur_breadcrumb', $items, $post_id);
}

function crescendo_output_secteur_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_secteur_seo($post_id);
    $faqItems = crescendo_secteur('secteur-faq-items', $post_id) ?: array();

    $schemas = array(
        array(
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => crescendo_secteur('secteur-hero-title', $post_id) ?: get_the_title($post_id),
            'description' => $seo['meta_description'],
            'provider' => array(
                '@type' => 'LocalBusiness',
                'name' => crescendo_brand_name(),
                'url' => home_url('/'),
            ),
            'areaServed' => array('@type' => 'City', 'name' => 'Nantes'),
            'url' => $seo['canonical'],
        ),
    );

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

function crescendo_secteur_head_meta() {
    if (!is_page() || !crescendo_is_secteur_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_secteur_seo(), 'website', get_the_ID());
}
add_action('wp_head', 'crescendo_secteur_head_meta', 1);

function crescendo_filter_secteur_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_secteur_page()) {
        return $title;
    }

    return crescendo_get_secteur_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_secteur_document_title', 20);
