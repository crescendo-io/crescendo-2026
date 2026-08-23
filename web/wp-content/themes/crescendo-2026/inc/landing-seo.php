<?php

function crescendo_is_landing_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-landing.php';
}

function crescendo_landing($field, $post_id = null) {
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

function crescendo_get_landing_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_landing('landing-seo-meta-title', $post_id);
    $metaDescription = crescendo_landing('landing-seo-meta-description', $post_id);
    $focusKeyword = crescendo_landing('landing-seo-focus-keyword', $post_id);
    $noindex = (bool) crescendo_landing('landing-seo-noindex', $post_id);
    $canonical = crescendo_landing('landing-seo-canonical', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | ' . crescendo_brand_name();
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_landing('landing-hero-intro', $post_id) ?: ''), 28, '…');
    }

    if (!$canonical) {
        $canonical = get_permalink($post_id);
    }

    return array(
        'meta_title' => $metaTitle,
        'meta_description' => $metaDescription,
        'focus_keyword' => $focusKeyword,
        'canonical' => crescendo_normalize_canonical($canonical),
        'noindex' => $noindex,
    );
}

function crescendo_get_landing_projects($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $items = crescendo_landing('landing-projects', $post_id);

    return crescendo_resolve_project_cards($items ?: array(), array());
}

function crescendo_get_landing_contact_form_args(array $overrides = array()) {
    return wp_parse_args($overrides, array(
        'variant' => 'landing',
        'source' => get_the_title(),
        'source_url' => get_permalink(),
        'projet_default' => 'site',
        'hide_prestations' => true,
        'submit_label' => 'Recevoir mon estimation',
    ));
}

function crescendo_get_landing_mockups($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $items = crescendo_landing('landing-mockups', $post_id) ?: array();
    $mockups = array();

    foreach ($items as $item) {
        if (!is_array($item)) {
            continue;
        }

        $image = $item['image'] ?? null;
        $alt = trim((string) ($item['alt'] ?? ''));

        if (empty($image) && !empty($item['project'])) {
            $project_id = is_object($item['project']) ? (int) $item['project']->ID : (int) $item['project'];

            if ($project_id > 0) {
                $card = crescendo_get_project_card($project_id);

                if (!empty($card['image'])) {
                    $image = $card['image'];
                    if ($alt === '' && !empty($card['title'])) {
                        $alt = $card['title'];
                    }
                }
            }
        }

        if ($image) {
            $mockups[] = array(
                'image' => $image,
                'alt' => $alt,
            );
        }
    }

    if (!empty($mockups)) {
        return $mockups;
    }

    foreach (crescendo_get_landing_projects($post_id) as $project) {
        if (empty($project['image'])) {
            continue;
        }

        $mockups[] = array(
            'image' => $project['image'],
            'alt' => $project['title'] ?? '',
        );
    }

    return $mockups;
}

function crescendo_output_landing_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_landing_seo($post_id);
    $faqItems = crescendo_landing('landing-faq-items', $post_id) ?: array();

    $serviceSchema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => crescendo_landing('landing-hero-title', $post_id) ?: get_the_title($post_id),
        'description' => $seo['meta_description'],
        'provider' => array(
            '@type' => 'LocalBusiness',
            'name' => crescendo_brand_name(),
            'url' => home_url('/'),
        ),
        'areaServed' => array(
            '@type' => 'Country',
            'name' => 'France',
        ),
        'url' => $seo['canonical'],
    );

    $price = crescendo_landing('landing-hero-price', $post_id);
    if ($price) {
        $serviceSchema['offers'] = array(
            '@type' => 'Offer',
            'priceCurrency' => 'EUR',
            'description' => $price,
        );
    }

    crescendo_print_json_ld($serviceSchema);

    $faqSchema = crescendo_build_faq_page_schema($faqItems, $seo['canonical']);
    if ($faqSchema) {
        crescendo_print_json_ld($faqSchema);
    }
}

function crescendo_landing_head_meta() {
    if (!is_page() || !crescendo_is_landing_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_landing_seo(), 'website', get_the_ID());
}
add_action('wp_head', 'crescendo_landing_head_meta', 1);

function crescendo_filter_landing_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_landing_page()) {
        return $title;
    }

    return crescendo_get_landing_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_landing_document_title', 20);

function crescendo_landing_body_class($classes) {
    if (is_page() && crescendo_is_landing_page()) {
        $classes[] = 'landing-page';
    }

    return $classes;
}
add_filter('body_class', 'crescendo_landing_body_class');

function crescendo_landing_enqueue_assets() {
    if (!is_page() || !crescendo_is_landing_page()) {
        return;
    }

    $js = get_template_directory() . '/assets/js/landing-sea.js';
    if (!file_exists($js)) {
        return;
    }

    wp_enqueue_script(
        'crescendo-landing-sea',
        get_template_directory_uri() . '/assets/js/landing-sea.js',
        array(),
        filemtime($js),
        true
    );
}
add_action('wp_enqueue_scripts', 'crescendo_landing_enqueue_assets', 20);
