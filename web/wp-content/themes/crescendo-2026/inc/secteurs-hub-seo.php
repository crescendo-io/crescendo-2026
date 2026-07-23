<?php

function crescendo_is_secteurs_hub_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-secteurs.php';
}

function crescendo_secteurs_hub($field, $post_id = null) {
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

function crescendo_get_secteurs_hub_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_secteurs_hub('secteurs-seo-meta-title', $post_id);
    $metaDescription = crescendo_secteurs_hub('secteurs-seo-meta-description', $post_id);
    $focusKeyword = crescendo_secteurs_hub('secteurs-seo-focus-keyword', $post_id);
    $noindex = (bool) crescendo_secteurs_hub('secteurs-seo-noindex', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | ' . crescendo_brand_name();
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_secteurs_hub('secteurs-hero-intro', $post_id) ?: ''), 28, '…');
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

function crescendo_secteurs_hub_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    return apply_filters('crescendo_secteurs_hub_breadcrumb', array(
        array('label' => 'Accueil', 'url' => home_url('/')),
        array('label' => get_the_title($post_id), 'url' => get_permalink($post_id)),
    ), $post_id);
}

function crescendo_get_secteurs_hub_children($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    return get_pages(array(
        'parent' => $post_id,
        'sort_column' => 'menu_order',
        'sort_order' => 'ASC',
        'post_status' => 'publish',
    ));
}

function crescendo_get_secteurs_hub_cards($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $cards = crescendo_secteurs_hub('secteurs-cards', $post_id);

    if (!empty($cards)) {
        return array_values(array_filter(array_map(function ($card) {
            if (empty($card['title']) || empty($card['url'])) {
                return null;
            }

            return array(
                'eyebrow' => $card['eyebrow'] ?? '',
                'title' => $card['title'],
                'text' => $card['text'] ?? '',
                'url' => $card['url'],
            );
        }, $cards)));
    }

    $children = crescendo_get_secteurs_hub_children($post_id);
    if (!empty($children)) {
        $cards = array();

        foreach ($children as $child) {
            $intro = get_field('secteur-hero-intro', $child->ID);
            $cards[] = array(
                'eyebrow' => get_field('secteur-hero-eyebrow', $child->ID) ?: '',
                'title' => get_the_title($child),
                'text' => $intro ? wp_trim_words($intro, 28, '…') : '',
                'url' => get_permalink($child),
            );
        }

        return $cards;
    }

    foreach (crescendo_get_site_nav_sections() as $section) {
        if ($section['id'] !== 'secteurs' || empty($section['items'])) {
            continue;
        }

        $cards = array();
        foreach ($section['items'] as $item) {
            $cards[] = array(
                'eyebrow' => '',
                'title' => $item['label'],
                'text' => '',
                'url' => $item['url'],
            );
        }

        return $cards;
    }

    return array();
}

function crescendo_output_secteurs_hub_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_secteurs_hub_seo($post_id);
    $children = crescendo_get_secteurs_hub_cards($post_id);

    $items = array();
    foreach ($children as $index => $child) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $child['title'],
            'url' => crescendo_absolute_url($child['url']),
        );
    }

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => crescendo_secteurs_hub('secteurs-hero-title', $post_id) ?: get_the_title($post_id),
        'description' => $seo['meta_description'],
        'url' => $seo['canonical'],
    );

    if (!empty($items)) {
        $schema['mainEntity'] = array(
            '@type' => 'ItemList',
            'itemListElement' => $items,
        );
    }

    crescendo_print_json_ld($schema);
}

function crescendo_secteurs_hub_head_meta() {
    if (!is_page() || !crescendo_is_secteurs_hub_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_secteurs_hub_seo(), 'website', get_the_ID());
}
add_action('wp_head', 'crescendo_secteurs_hub_head_meta', 1);

function crescendo_filter_secteurs_hub_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_secteurs_hub_page()) {
        return $title;
    }

    return crescendo_get_secteurs_hub_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_secteurs_hub_document_title', 20);
