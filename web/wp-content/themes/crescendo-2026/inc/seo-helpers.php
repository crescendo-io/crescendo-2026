<?php

/**
 * Shared SEO helpers: single canonical, OG image, brand name, absolute URLs.
 */

function crescendo_brand_name() {
    return 'Crescendo Studio';
}

function crescendo_default_og_image() {
    $candidates = array(
        'assets/images/og-default.jpg',
        'assets/images/og-default.png',
        'assets/images/logo.png',
        'assets/favicon/android-chrome-512x512.png',
        'assets/favicon/android-chrome-192x192.png',
        'assets/favicon/apple-touch-icon.png',
        'assets/favicon/favicon-32x32.png',
    );

    foreach ($candidates as $relative) {
        $path = THEME_DIR . $relative;
        if (file_exists($path)) {
            return THEME_URL . $relative;
        }
    }

    return THEME_URL . 'assets/favicon/favicon-32x32.png';
}

function crescendo_get_og_image($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();

    if ($post_id && has_post_thumbnail($post_id)) {
        $url = get_the_post_thumbnail_url($post_id, 'large');
        if ($url) {
            return $url;
        }
    }

    if ($post_id) {
        $heroFields = array(
            'service-hero-image',
            'secteur-hero-image',
            'local-hero-image',
            'project-hero-image',
            'home-hero-image',
            'about-hero-image',
            'contact-hero-image',
            'realisations-hero-image',
        );

        foreach ($heroFields as $field) {
            $image = get_field($field, $post_id);
            if (is_array($image) && !empty($image['url'])) {
                return $image['url'];
            }
            if (is_string($image) && $image !== '') {
                return $image;
            }
        }
    }

    if (function_exists('crescendo_home')) {
        $homeImage = crescendo_home('home-hero-image');
        if (is_array($homeImage) && !empty($homeImage['url'])) {
            return $homeImage['url'];
        }
    }

    return crescendo_default_og_image();
}

function crescendo_absolute_url($url) {
    $url = trim((string) $url);
    if ($url === '') {
        return home_url('/');
    }

    if (preg_match('#^https?://#i', $url)) {
        return $url;
    }

    if (strpos($url, '//') === 0) {
        return (is_ssl() ? 'https:' : 'http:') . $url;
    }

    return home_url('/' . ltrim($url, '/'));
}

function crescendo_normalize_canonical($url) {
    $url = crescendo_absolute_url($url);
    $url = preg_replace('#/(services|secteurs)/(?:services|secteurs)/#', '/$1/', $url);
    return $url;
}

function crescendo_is_placeholder_phone($phone) {
    $normalized = preg_replace('/\s+/', '', (string) $phone);
    $placeholders = array(
        '0240000000',
        '0000000000',
        '0123456789',
        '+33000000000',
    );

    return $normalized === '' || in_array($normalized, $placeholders, true);
}

function crescendo_public_phone($phone = null) {
    if ($phone === null) {
        $phone = get_field('params-footer-phone', 'option');
    }

    if (crescendo_is_placeholder_phone($phone)) {
        return null;
    }

    return $phone;
}

function crescendo_print_json_ld($schema) {
    if (empty($schema) || !is_array($schema)) {
        return;
    }

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}

/**
 * Emit description, canonical, robots, Open Graph (+ image). No meta keywords.
 *
 * @param array  $seo     Keys: meta_title, meta_description, canonical, noindex
 * @param string $og_type website|article
 * @param int|null $post_id
 */
function crescendo_print_seo_head_meta(array $seo, $og_type = 'website', $post_id = null) {
    $canonical = crescendo_normalize_canonical($seo['canonical'] ?? get_permalink());
    $title = $seo['meta_title'] ?? wp_get_document_title();
    $description = $seo['meta_description'] ?? '';
    $ogImage = crescendo_get_og_image($post_id);

    if ($description !== '') {
        echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    }

    echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";

    if (!empty($seo['noindex'])) {
        echo '<meta name="robots" content="noindex, nofollow">' . "\n";
    }

    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    if ($description !== '') {
        echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    }
    echo '<meta property="og:url" content="' . esc_url($canonical) . '">' . "\n";
    echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr(crescendo_brand_name()) . '">' . "\n";
    echo '<meta property="og:locale" content="fr_FR">' . "\n";
    echo '<meta property="og:image" content="' . esc_url($ogImage) . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    if ($description !== '') {
        echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
    }
    echo '<meta name="twitter:image" content="' . esc_url($ogImage) . '">' . "\n";
}

function crescendo_disable_wp_canonical() {
    remove_action('wp_head', 'rel_canonical');
}
add_action('wp_head', 'crescendo_disable_wp_canonical', 0);

/**
 * One-shot: reparent money pages under hubs + import plan du site if missing.
 */
function crescendo_maybe_fix_seo_structure() {
    if (get_option('crescendo_seo_structure_fixed_v2')) {
        return;
    }

    if (!did_action('init') || !function_exists('get_page_by_path')) {
        return;
    }

    $services = get_page_by_path('services', OBJECT, 'page');
    $secteurs = get_page_by_path('secteurs', OBJECT, 'page');

    if ($services) {
        $service_pages = get_posts(array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template-service.php',
            'fields' => 'ids',
        ));

        foreach ($service_pages as $page_id) {
            if ((int) get_post_field('post_parent', $page_id) !== (int) $services->ID) {
                wp_update_post(array(
                    'ID' => $page_id,
                    'post_parent' => (int) $services->ID,
                ));
            }

            $canonical = get_field('service-seo-canonical', $page_id);
            if (is_string($canonical) && (strpos($canonical, '/services/services/') !== false || !preg_match('#/services/[^/]+/?$#', $canonical))) {
                $slug = get_post_field('post_name', $page_id);
                update_field('service-seo-canonical', 'https://crescendo-studio.io/services/' . $slug . '/', $page_id);
            }
        }
    }

    if ($secteurs) {
        $secteur_pages = get_posts(array(
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template-secteur.php',
            'fields' => 'ids',
        ));

        foreach ($secteur_pages as $page_id) {
            if ((int) get_post_field('post_parent', $page_id) !== (int) $secteurs->ID) {
                wp_update_post(array(
                    'ID' => $page_id,
                    'post_parent' => (int) $secteurs->ID,
                ));
            }

            $canonical = get_field('secteur-seo-canonical', $page_id);
            if (is_string($canonical) && (strpos($canonical, '/secteurs/secteurs/') !== false || !preg_match('#/secteurs/[^/]+/?$#', $canonical))) {
                $slug = get_post_field('post_name', $page_id);
                update_field('secteur-seo-canonical', 'https://crescendo-studio.io/secteurs/' . $slug . '/', $page_id);
            }
        }
    }

    if (!get_page_by_path('plan-du-site', OBJECT, 'page')) {
        $imported = false;
        if (function_exists('crescendo_import_socle_from_json_file') && function_exists('crescendo_find_content_import_file')) {
            $file = crescendo_find_content_import_file('socle', 'plan-du-site.json');
            if ($file) {
                $result = crescendo_import_socle_from_json_file($file);
                $imported = !is_wp_error($result);
            }
        }

        if (!$imported) {
            $post_id = wp_insert_post(array(
                'post_title' => 'Plan du site',
                'post_name' => 'plan-du-site',
                'post_type' => 'page',
                'post_status' => 'publish',
                'menu_order' => 97,
            ), true);

            if (!is_wp_error($post_id)) {
                update_post_meta($post_id, '_wp_page_template', 'template-sitemap.php');
                if (function_exists('update_field')) {
                    update_field('sitemap-seo-meta-title', 'Plan du site · Crescendo Studio — Agence web Nantes', $post_id);
                    update_field('sitemap-seo-meta-description', 'Plan du site Crescendo Studio : accès à toutes nos pages services, secteurs, villes, réalisations et informations légales. Agence web WordPress à Nantes.', $post_id);
                    update_field('sitemap-hero-title', 'Plan du site', $post_id);
                    update_field('sitemap-hero-intro', 'Retrouvez l\'ensemble des pages du site Crescendo Studio : services, secteurs d\'activité, agence web par ville, réalisations et pages légales.', $post_id);
                }
            }
        }
    }

    $front_id = (int) get_option('page_on_front');
    if ($front_id && function_exists('update_field')) {
        $currentHero = get_field('home-hero-title', $front_id);
        if (!$currentHero || $currentHero === 'Sites WordPress sur mesure & CRM sur mesure') {
            update_field('home-hero-title', 'Agence web à Nantes — sites WordPress & CRM sur mesure', $front_id);
        }
    }

    $contact = get_page_by_path('contact', OBJECT, 'page');
    if ($contact && function_exists('update_field')) {
        $phone = get_field('contact-info-phone', $contact->ID);
        if (function_exists('crescendo_is_placeholder_phone') && crescendo_is_placeholder_phone($phone)) {
            update_field('contact-info-phone', '', $contact->ID);
        }
    }

    $optionPhone = get_field('params-footer-phone', 'option');
    if (function_exists('crescendo_is_placeholder_phone') && crescendo_is_placeholder_phone($optionPhone)) {
        update_field('params-footer-phone', '', 'option');
    }

    flush_rewrite_rules(false);
    update_option('crescendo_seo_structure_fixed_v2', 1, false);
    delete_option('crescendo_seo_structure_fixed_v1');
}
add_action('init', 'crescendo_maybe_fix_seo_structure', 30);

/**
 * Fallback meta description for templates without a dedicated SEO handler.
 */
function crescendo_fallback_head_meta() {
    if (is_admin() || is_front_page()) {
        return;
    }

    $hasDedicated = (
        (function_exists('crescendo_is_service_page') && is_page() && crescendo_is_service_page())
        || (function_exists('crescendo_is_secteur_page') && is_page() && crescendo_is_secteur_page())
        || (function_exists('crescendo_is_services_hub_page') && is_page() && crescendo_is_services_hub_page())
        || (function_exists('crescendo_is_secteurs_hub_page') && is_page() && crescendo_is_secteurs_hub_page())
        || (function_exists('crescendo_is_local_page') && is_page() && crescendo_is_local_page())
        || (function_exists('crescendo_is_contact_page') && is_page() && crescendo_is_contact_page())
        || (function_exists('crescendo_is_about_page') && is_page() && crescendo_is_about_page())
        || (function_exists('crescendo_is_legal_page') && is_page() && crescendo_is_legal_page())
        || (function_exists('crescendo_is_sitemap_page') && is_page() && crescendo_is_sitemap_page())
        || (function_exists('crescendo_is_realisations_page') && is_page() && crescendo_is_realisations_page())
        || (function_exists('crescendo_is_project_page') && is_page() && crescendo_is_project_page())
    );

    if ($hasDedicated) {
        return;
    }

    $description = '';
    if (is_singular()) {
        $description = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags(get_post_field('post_content', get_the_ID())), 28, '…');
    }
    if ($description === '') {
        $description = 'Crescendo Studio, agence web à Nantes : création de sites WordPress sur mesure, SEO local, CRM et location dès 350€/mois.';
    }

    crescendo_print_seo_head_meta(array(
        'meta_title' => wp_get_document_title(),
        'meta_description' => $description,
        'canonical' => is_singular() ? get_permalink() : home_url('/'),
        'noindex' => is_404(),
    ), 'website', get_queried_object_id());
}
add_action('wp_head', 'crescendo_fallback_head_meta', 2);
