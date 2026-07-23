<?php

function crescendo_is_contact_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-contact.php';
}

function crescendo_contact($field, $post_id = null) {
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

function crescendo_get_contact_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_contact('contact-seo-meta-title', $post_id);
    $metaDescription = crescendo_contact('contact-seo-meta-description', $post_id);
    $focusKeyword = crescendo_contact('contact-seo-focus-keyword', $post_id);
    $canonical = crescendo_contact('contact-seo-canonical', $post_id);
    $noindex = (bool) crescendo_contact('contact-seo-noindex', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | ' . get_bloginfo('name');
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_contact('contact-hero-intro', $post_id) ?: ''), 28, '…');
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

function crescendo_contact_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    return apply_filters('crescendo_contact_breadcrumb', array(
        array('label' => 'Accueil', 'url' => home_url('/')),
        array('label' => get_the_title($post_id), 'url' => get_permalink($post_id)),
    ), $post_id);
}

function crescendo_output_contact_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_contact_seo($post_id);
    $phone = crescendo_contact('contact-info-phone', $post_id) ?: get_field('params-footer-phone', 'option');
    $email = crescendo_contact('contact-info-email', $post_id) ?: get_field('params-footer-email', 'option');
    $faqItems = crescendo_contact('contact-faq-items', $post_id) ?: array();

    $schemas = array(
        array(
            '@context' => 'https://schema.org',
            '@type' => 'ContactPage',
            'name' => crescendo_contact('contact-hero-title', $post_id) ?: get_the_title($post_id),
            'description' => $seo['meta_description'],
            'url' => $seo['canonical'],
            'mainEntity' => array(
                '@type' => 'LocalBusiness',
                'name' => get_bloginfo('name'),
                'url' => home_url('/'),
                'telephone' => $phone,
                'email' => $email,
                'address' => array(
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Nantes',
                    'addressRegion' => 'Pays de la Loire',
                    'addressCountry' => 'FR',
                ),
            ),
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
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}

function crescendo_contact_head_meta() {
    if (!is_page() || !crescendo_is_contact_page()) {
        return;
    }

    $seo = crescendo_get_contact_seo();

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
add_action('wp_head', 'crescendo_contact_head_meta', 1);

function crescendo_filter_contact_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_contact_page()) {
        return $title;
    }

    return crescendo_get_contact_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_contact_document_title', 20);
