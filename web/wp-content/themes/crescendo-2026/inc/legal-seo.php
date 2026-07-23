<?php

function crescendo_is_legal_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-legal.php';
}

function crescendo_legal($field, $post_id = null) {
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

function crescendo_get_legal_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_legal('legal-seo-meta-title', $post_id);
    $metaDescription = crescendo_legal('legal-seo-meta-description', $post_id);
    $focusKeyword = crescendo_legal('legal-seo-focus-keyword', $post_id);
    $noindex = (bool) crescendo_legal('legal-seo-noindex', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | ' . crescendo_brand_name();
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_legal('legal-hero-intro', $post_id) ?: ''), 28, '…');
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

function crescendo_legal_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    return apply_filters('crescendo_legal_breadcrumb', array(
        array('label' => 'Accueil', 'url' => home_url('/')),
        array('label' => get_the_title($post_id), 'url' => get_permalink($post_id)),
    ), $post_id);
}

function crescendo_output_legal_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_legal_seo($post_id);

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => crescendo_legal('legal-hero-title', $post_id) ?: get_the_title($post_id),
        'description' => $seo['meta_description'],
        'url' => $seo['canonical'],
        'isPartOf' => array(
            '@type' => 'WebSite',
            'name' => crescendo_brand_name(),
            'url' => home_url('/'),
        ),
    );

    crescendo_print_json_ld($schema);
}

function crescendo_legal_head_meta() {
    if (!is_page() || !crescendo_is_legal_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_legal_seo(), 'website', get_the_ID());
}
add_action('wp_head', 'crescendo_legal_head_meta', 1);

function crescendo_filter_legal_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_legal_page()) {
        return $title;
    }

    return crescendo_get_legal_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_legal_document_title', 20);
