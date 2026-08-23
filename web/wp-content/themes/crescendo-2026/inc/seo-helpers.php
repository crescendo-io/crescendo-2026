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

    $path = wp_parse_url($url, PHP_URL_PATH);
    if (!is_string($path) || $path === '') {
        $path = '/';
    }

    return user_trailingslashit(home_url($path));
}

function crescendo_get_canonical_url($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    if (!$post_id) {
        return crescendo_normalize_canonical(home_url('/'));
    }

    if ((int) get_option('page_on_front') === (int) $post_id) {
        return crescendo_normalize_canonical(home_url('/'));
    }

    return crescendo_normalize_canonical(get_permalink($post_id));
}

function crescendo_trash_flat_hub_duplicate_pages() {
    if (!function_exists('crescendo_legacy_redirect_map')) {
        return;
    }

    foreach (crescendo_legacy_redirect_map() as $from => $to) {
        $flat_slug = trim($from, '/');
        if ($flat_slug === '' || strpos($flat_slug, '/') !== false) {
            continue;
        }

        $flat_page = get_page_by_path($flat_slug, OBJECT, 'page');
        $nested_page = get_page_by_path(ltrim($to, '/'), OBJECT, 'page');

        if (!$flat_page || !$nested_page || (int) $flat_page->ID === (int) $nested_page->ID) {
            continue;
        }

        wp_trash_post((int) $flat_page->ID);
    }
}

function crescendo_sync_stored_canonical_urls() {
    if (!function_exists('update_field')) {
        return;
    }

    $groups = array(
        array('template' => 'template-service.php', 'field' => 'service-seo-canonical'),
        array('template' => 'template-secteur.php', 'field' => 'secteur-seo-canonical'),
        array('template' => 'template-local.php', 'field' => 'local-seo-canonical'),
        array('template' => 'template-project.php', 'field' => 'project-seo-canonical'),
    );

    foreach ($groups as $group) {
        $page_ids = get_posts(array(
            'post_type' => 'page',
            'post_status' => array('publish', 'draft', 'pending', 'private'),
            'posts_per_page' => -1,
            'meta_key' => '_wp_page_template',
            'meta_value' => $group['template'],
            'fields' => 'ids',
        ));

        foreach ($page_ids as $page_id) {
            update_field($group['field'], crescendo_get_canonical_url($page_id), $page_id);
        }
    }
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
    return null;
}

function crescendo_print_json_ld($schema) {
    if (empty($schema) || !is_array($schema)) {
        return;
    }

    echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}

/**
 * Topics d'expertise pour Organization.knowsAbout (GEO / entité de marque).
 *
 * @return string[]
 */
function crescendo_get_organization_knows_about() {
    return apply_filters('crescendo_organization_knows_about', array(
        'Développement WordPress',
        'Création de sites web sur mesure',
        'Référencement naturel (SEO)',
        'CRM sur mesure',
        'E-commerce WooCommerce',
        'Maintenance WordPress',
        'Agence web Nantes',
    ));
}

/**
 * Profils sociaux vérifiés (sameAs). Ne pas inventer d'URL — filtre ou ACF futur.
 *
 * @return string[]
 */
function crescendo_instagram_url() {
    return 'https://www.instagram.com/crescendo.io/';
}

function crescendo_get_organization_same_as() {
    $urls = apply_filters('crescendo_organization_same_as', array(
        crescendo_instagram_url(),
    ));

    return array_values(array_filter(array_map('esc_url_raw', (array) $urls)));
}

/**
 * @param array<int, array{question?: string, answer?: string}> $items
 */
function crescendo_build_faq_page_schema(array $items, $page_url = null) {
    $entities = array();

    foreach ($items as $item) {
        if (empty($item['question']) || empty($item['answer'])) {
            continue;
        }

        $entities[] = array(
            '@type' => 'Question',
            'name' => $item['question'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text' => $item['answer'],
            ),
        );
    }

    if (empty($entities)) {
        return null;
    }

    $schema = array(
        '@type' => 'FAQPage',
        'mainEntity' => $entities,
    );

    if ($page_url) {
        $page_url = crescendo_normalize_canonical($page_url);
        $schema['@id'] = untrailingslashit($page_url) . '#faq';
        $schema['url'] = $page_url;
    }

    return $schema;
}

function crescendo_get_home_faq_items() {
    if (!function_exists('crescendo_home')) {
        return array();
    }

    $items = crescendo_home('home-faq-items');

    return is_array($items) ? $items : array();
}

/**
 * Emit description, canonical, robots, Open Graph (+ image). No meta keywords.
 *
 * @param array  $seo     Keys: meta_title, meta_description, canonical, noindex
 * @param string $og_type website|article
 * @param int|null $post_id
 */
function crescendo_print_seo_head_meta(array $seo, $og_type = 'website', $post_id = null) {
    if ($post_id) {
        $canonical = crescendo_get_canonical_url($post_id);
    } else {
        $canonical = crescendo_normalize_canonical($seo['canonical'] ?? home_url('/'));
    }
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

    if ($ogImage === crescendo_default_og_image()) {
        echo '<meta property="og:image:width" content="1200">' . "\n";
        echo '<meta property="og:image:height" content="630">' . "\n";
        echo '<meta property="og:image:type" content="image/jpeg">' . "\n";
    }
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
    if (get_option('crescendo_seo_structure_fixed_v3')) {
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
                update_field('service-seo-canonical', crescendo_get_canonical_url($page_id), $page_id);
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
                update_field('secteur-seo-canonical', crescendo_get_canonical_url($page_id), $page_id);
            }
        }
    }

    // Ensure critical secteur pages exist (audit: architecte status 0 / missing).
    if (function_exists('crescendo_import_secteur_from_json_file') && function_exists('crescendo_find_content_import_file')) {
        $architecte = function_exists('crescendo_find_import_page_by_slug')
            ? crescendo_find_import_page_by_slug('creation-site-architecte-nantes', 'secteurs')
            : get_page_by_path('secteurs/creation-site-architecte-nantes', OBJECT, 'page');
        if (!$architecte) {
            $file = crescendo_find_content_import_file('secteurs', 'creation-site-architecte-nantes.json');
            if ($file) {
                crescendo_import_secteur_from_json_file($file);
            }
        }
    }

    // Fix dead /realisations/gide/ links still stored in the hub ACF.
    $realisations = get_page_by_path('realisations', OBJECT, 'page');
    if ($realisations && function_exists('get_field') && function_exists('update_field')) {
        $projects = get_field('realisations-projects', $realisations->ID);
        if (is_array($projects)) {
            $changed = false;
            foreach ($projects as &$project) {
                if (!is_array($project)) {
                    continue;
                }
                $url = (string) ($project['url'] ?? '');
                if (strpos($url, '/realisations/gide') !== false) {
                    $project['url'] = '/realisations/cma-associes/';
                    $changed = true;
                }
                if (($project['title'] ?? '') === 'Gide') {
                    $project['title'] = 'CM&A Associés';
                    $changed = true;
                }
            }
            unset($project);
            if ($changed) {
                update_field('realisations-projects', $projects, $realisations->ID);
            }
        }
    }

    // Refresh project meta descriptions from JSON (remove truncated … leftovers).
    if (function_exists('crescendo_import_project_from_json_file') && function_exists('crescendo_list_project_import_files')) {
        foreach (crescendo_list_project_import_files() as $project_file) {
            crescendo_import_project_from_json_file($project_file);
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
        if (!$currentHero || $currentHero === 'Sites WordPress sur mesure & CRM sur mesure' || $currentHero === 'Agence web à Nantes — sites WordPress & CRM sur mesure' || $currentHero === 'Votre agence web WordPress & CRM à Nantes') {
            update_field('home-hero-title', 'Agence web à Nantes — WordPress & CRM sur mesure', $front_id);
        }
    }

    $contact = get_page_by_path('contact', OBJECT, 'page');
    if ($contact && function_exists('update_field')) {
        update_field('contact-info-phone', '', $contact->ID);
    }

    if (function_exists('update_field')) {
        update_field('params-footer-phone', '', 'option');
    }

    flush_rewrite_rules(false);
    update_option('crescendo_seo_structure_fixed_v3', 1, false);
    delete_option('crescendo_seo_structure_fixed_v2');
    delete_option('crescendo_seo_structure_fixed_v1');
}
add_action('init', 'crescendo_maybe_fix_seo_structure', 30);

function crescendo_maybe_fix_seo_duplicates() {
    if (get_option('crescendo_seo_structure_fixed_v4')) {
        return;
    }

    if (!did_action('init') || !function_exists('get_page_by_path')) {
        return;
    }

    crescendo_trash_flat_hub_duplicate_pages();
    crescendo_sync_stored_canonical_urls();
    flush_rewrite_rules(false);

    update_option('crescendo_seo_structure_fixed_v4', 1, false);
}
add_action('init', 'crescendo_maybe_fix_seo_duplicates', 31);

function crescendo_maybe_migrate_canonical_www() {
    if (get_option('crescendo_canonical_www_v1')) {
        return;
    }

    if (!did_action('init') || !function_exists('crescendo_is_crescendo_production_site') || !crescendo_is_crescendo_production_site()) {
        return;
    }

    crescendo_sync_stored_canonical_urls();
    update_option('crescendo_canonical_www_v1', 1, false);
}
add_action('init', 'crescendo_maybe_migrate_canonical_www', 32);

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
        || (function_exists('crescendo_is_thank_you_page') && is_page() && crescendo_is_thank_you_page())
        || (function_exists('crescendo_is_landing_page') && is_page() && crescendo_is_landing_page())
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

    $fallbackSeo = array(
        'meta_title' => wp_get_document_title(),
        'meta_description' => $description,
        'canonical' => is_singular() ? get_permalink() : home_url('/'),
        'noindex' => is_404() || (function_exists('crescendo_is_seo_noise_query') && crescendo_is_seo_noise_query()),
    );

    crescendo_print_seo_head_meta(apply_filters('crescendo_fallback_seo', $fallbackSeo), 'website', get_queried_object_id());
}
add_action('wp_head', 'crescendo_fallback_head_meta', 2);

/**
 * Clean 404 document title (avoid bare theme/site name leftovers).
 */
function crescendo_filter_404_document_title($title) {
    if (!is_404()) {
        return $title;
    }

    return 'Page non trouvée | ' . crescendo_brand_name();
}
add_filter('pre_get_document_title', 'crescendo_filter_404_document_title', 30);
