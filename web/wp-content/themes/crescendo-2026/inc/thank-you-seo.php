<?php

function crescendo_is_thank_you_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();

    return get_page_template_slug($post_id) === 'template-thank-you.php';
}

function crescendo_thank_you($field, $post_id = null) {
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

function crescendo_get_thank_you_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_thank_you('thank-you-seo-meta-title', $post_id);
    $metaDescription = crescendo_thank_you('thank-you-seo-meta-description', $post_id);
    $focusKeyword = crescendo_thank_you('thank-you-seo-focus-keyword', $post_id);
    $noindex = crescendo_thank_you('thank-you-seo-noindex', $post_id);
    $noindex = ($noindex === null || $noindex === '') ? true : (bool) $noindex;

    if (!$metaTitle) {
        $metaTitle = 'Merci pour votre demande | ' . crescendo_brand_name();
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_thank_you('thank-you-hero-intro', $post_id) ?: ''), 28, '…');
    }

    return array(
        'meta_title' => $metaTitle,
        'meta_description' => $metaDescription,
        'focus_keyword' => $focusKeyword,
        'canonical' => get_permalink($post_id),
        'noindex' => $noindex,
    );
}

function crescendo_thank_you_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    return apply_filters('crescendo_thank_you_breadcrumb', array(
        array('label' => 'Accueil', 'url' => home_url('/')),
        array('label' => get_the_title($post_id), 'url' => get_permalink($post_id)),
    ), $post_id);
}

function crescendo_output_thank_you_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_thank_you_seo($post_id);

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => crescendo_thank_you('thank-you-hero-title', $post_id) ?: get_the_title($post_id),
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

function crescendo_thank_you_head_meta() {
    if (!is_page() || !crescendo_is_thank_you_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_thank_you_seo(), 'website', get_the_ID());
}
add_action('wp_head', 'crescendo_thank_you_head_meta', 1);

function crescendo_filter_thank_you_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_thank_you_page()) {
        return $title;
    }

    return crescendo_get_thank_you_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_thank_you_document_title', 20);
