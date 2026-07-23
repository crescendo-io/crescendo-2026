<?php

function crescendo_is_project_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-project.php';
}

function crescendo_project($field, $post_id = null) {
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

function crescendo_get_project_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_project('project-seo-meta-title', $post_id);
    $metaDescription = crescendo_project('project-seo-meta-description', $post_id);
    $focusKeyword = crescendo_project('project-seo-focus-keyword', $post_id);
    $noindex = (bool) crescendo_project('project-seo-noindex', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | Crescendo Studio';
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_project('project-hero-intro', $post_id) ?: ''), 28, '…');
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

function crescendo_project_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $realisations = get_page_by_path('realisations', OBJECT, 'page');

    $items = array(
        array('label' => 'Accueil', 'url' => home_url('/')),
    );

    if ($realisations) {
        $items[] = array(
            'label' => $realisations->post_title,
            'url' => get_permalink($realisations),
        );
    }

    $items[] = array(
        'label' => get_the_title($post_id),
        'url' => get_permalink($post_id),
    );

    return apply_filters('crescendo_project_breadcrumb', $items, $post_id);
}

function crescendo_output_project_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_project_seo($post_id);
    $gallery = crescendo_project('project-gallery', $post_id) ?: array();
    $images = array();

    foreach ($gallery as $item) {
        if (!empty($item['image']['url'])) {
            $images[] = $item['image']['url'];
        }
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'CreativeWork',
        'name' => crescendo_project('project-hero-title', $post_id) ?: get_the_title($post_id),
        'description' => $seo['meta_description'],
        'url' => $seo['canonical'],
        'creator' => array(
            '@type' => 'Organization',
            'name' => 'Crescendo Studio',
            'url' => home_url('/'),
        ),
    );

    if (!empty($images)) {
        $schema['image'] = $images;
    }

    $clientUrl = crescendo_project('project-client-url', $post_id);
    if ($clientUrl) {
        $schema['isBasedOn'] = $clientUrl;
    }

    crescendo_print_json_ld($schema);
}

function crescendo_project_head_meta() {
    if (!is_page() || !crescendo_is_project_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_project_seo(), 'article', get_the_ID());
}
add_action('wp_head', 'crescendo_project_head_meta', 1);

function crescendo_filter_project_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_project_page()) {
        return $title;
    }

    return crescendo_get_project_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_project_document_title', 20);
