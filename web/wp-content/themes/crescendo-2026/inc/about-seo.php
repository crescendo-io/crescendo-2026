<?php

function crescendo_is_about_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-about.php';
}

function crescendo_about($field, $post_id = null) {
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

function crescendo_get_about_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_about('about-seo-meta-title', $post_id);
    $metaDescription = crescendo_about('about-seo-meta-description', $post_id);
    $focusKeyword = crescendo_about('about-seo-focus-keyword', $post_id);
    $canonical = crescendo_about('about-seo-canonical', $post_id);
    $noindex = (bool) crescendo_about('about-seo-noindex', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | ' . get_bloginfo('name');
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_about('about-hero-intro', $post_id) ?: ''), 28, '…');
    }

    if (!$canonical) {
        $canonical = get_permalink($post_id);
    }

    return array(
        'meta_title' => $metaTitle,
        'meta_description' => $metaDescription,
        'focus_keyword' => $focusKeyword,
        'canonical' => $canonical,
        'noindex' => $noindex,
    );
}

function crescendo_about_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    return apply_filters('crescendo_about_breadcrumb', array(
        array('label' => 'Accueil', 'url' => home_url('/')),
        array('label' => get_the_title($post_id), 'url' => get_permalink($post_id)),
    ), $post_id);
}

function crescendo_output_about_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_about_seo($post_id);

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'AboutPage',
        'name' => crescendo_about('about-hero-title', $post_id) ?: get_the_title($post_id),
        'description' => $seo['meta_description'],
        'url' => $seo['canonical'],
        'mainEntity' => array(
            '@type' => 'Organization',
            'name' => 'Crescendo Studio',
            'url' => home_url('/'),
            'description' => crescendo_about('about-story-text', $post_id),
            'address' => array(
                '@type' => 'PostalAddress',
                'addressLocality' => 'Nantes',
                'addressRegion' => 'Pays de la Loire',
                'addressCountry' => 'FR',
            ),
        ),
    );

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}

function crescendo_about_head_meta() {
    if (!is_page() || !crescendo_is_about_page()) {
        return;
    }

    $seo = crescendo_get_about_seo();

    echo '<meta name="description" content="' . esc_attr($seo['meta_description']) . '">' . "\n";

    if (!empty($seo['focus_keyword'])) {
        echo '<meta name="keywords" content="' . esc_attr($seo['focus_keyword']) . '">' . "\n";
    }

    echo '<link rel="canonical" href="' . esc_url($seo['canonical']) . '">' . "\n";

    if ($seo['noindex']) {
        echo '<meta name="robots" content="noindex, nofollow">' . "\n";
    }

    echo '<meta property="og:title" content="' . esc_attr($seo['meta_title']) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($seo['meta_description']) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($seo['canonical']) . '">' . "\n";
    echo '<meta property="og:type" content="website">' . "\n";
}
add_action('wp_head', 'crescendo_about_head_meta', 1);

function crescendo_filter_about_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_about_page()) {
        return $title;
    }

    return crescendo_get_about_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_about_document_title', 20);
