<?php

function crescendo_is_sitemap_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-sitemap.php';
}

function crescendo_sitemap($field, $post_id = null) {
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

function crescendo_get_sitemap_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_sitemap('sitemap-seo-meta-title', $post_id);
    $metaDescription = crescendo_sitemap('sitemap-seo-meta-description', $post_id);
    $focusKeyword = crescendo_sitemap('sitemap-seo-focus-keyword', $post_id);
    $noindex = (bool) crescendo_sitemap('sitemap-seo-noindex', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | ' . crescendo_brand_name();
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_sitemap('sitemap-hero-intro', $post_id) ?: ''), 28, '…');
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

function crescendo_sitemap_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    return apply_filters('crescendo_sitemap_breadcrumb', array(
        array('label' => 'Accueil', 'url' => home_url('/')),
        array('label' => get_the_title($post_id), 'url' => get_permalink($post_id)),
    ), $post_id);
}

function crescendo_output_sitemap_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_sitemap_seo($post_id);
    $sections = crescendo_get_sitemap_page_sections();
    $items = array();
    $position = 1;

    foreach ($sections as $section) {
        if (!empty($section['url'])) {
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $section['label'],
                'url' => crescendo_absolute_url($section['url']),
            );
        }

        if (!empty($section['items'])) {
            foreach ($section['items'] as $item) {
                $items[] = array(
                    '@type' => 'ListItem',
                    'position' => $position++,
                    'name' => $item['label'],
                    'url' => crescendo_absolute_url($item['url']),
                );
            }
        }
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => crescendo_sitemap('sitemap-hero-title', $post_id) ?: get_the_title($post_id),
        'description' => $seo['meta_description'],
        'url' => $seo['canonical'],
        'mainEntity' => array(
            '@type' => 'ItemList',
            'itemListElement' => $items,
        ),
    );

    crescendo_print_json_ld($schema);
}

function crescendo_sitemap_head_meta() {
    if (!is_page() || !crescendo_is_sitemap_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_sitemap_seo(), 'website', get_the_ID());
}
add_action('wp_head', 'crescendo_sitemap_head_meta', 1);

function crescendo_filter_sitemap_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_sitemap_page()) {
        return $title;
    }

    return crescendo_get_sitemap_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_sitemap_document_title', 20);
