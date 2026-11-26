<?php

function crescendo_is_services_hub_page($post_id = null) {
    $post_id = $post_id ?: get_queried_object_id();
    return get_page_template_slug($post_id) === 'template-services.php';
}

function crescendo_uses_studio_services_hub_layout($post_id = null) {
    if (!function_exists('crescendo_uses_studio_design') || !crescendo_uses_studio_design()) {
        return false;
    }

    $post_id = $post_id ?: get_queried_object_id();

    return $post_id && crescendo_is_services_hub_page($post_id);
}

function crescendo_services_hub($field, $post_id = null) {
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

function crescendo_get_services_hub_seo($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    $metaTitle = crescendo_services_hub('services-seo-meta-title', $post_id);
    $metaDescription = crescendo_services_hub('services-seo-meta-description', $post_id);
    $focusKeyword = crescendo_services_hub('services-seo-focus-keyword', $post_id);
    $noindex = (bool) crescendo_services_hub('services-seo-noindex', $post_id);

    if (!$metaTitle) {
        $metaTitle = get_the_title($post_id) . ' | ' . crescendo_brand_name();
    }

    if (!$metaDescription) {
        $metaDescription = wp_trim_words(strip_tags(crescendo_services_hub('services-hero-intro', $post_id) ?: ''), 28, '…');
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

function crescendo_services_hub_breadcrumb($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    return apply_filters('crescendo_services_hub_breadcrumb', array(
        array('label' => 'Accueil', 'url' => home_url('/')),
        array('label' => get_the_title($post_id), 'url' => get_permalink($post_id)),
    ), $post_id);
}

function crescendo_get_services_hub_children($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    return get_pages(array(
        'parent' => $post_id,
        'sort_column' => 'menu_order',
        'sort_order' => 'ASC',
        'post_status' => 'publish',
    ));
}

function crescendo_get_services_hub_offers($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $offers = crescendo_services_hub('services-offers', $post_id);

    if (!empty($offers)) {
        return array_values(array_filter(array_map(function ($offer) {
            if (empty($offer['title'])) {
                return null;
            }

            $features = array();
            if (!empty($offer['features']) && is_array($offer['features'])) {
                foreach ($offer['features'] as $feature) {
                    $text = is_array($feature) ? ($feature['text'] ?? '') : $feature;
                    if ($text !== '') {
                        $features[] = array('text' => $text);
                    }
                }
            }

            return array(
                'eyebrow' => $offer['eyebrow'] ?? '',
                'title' => $offer['title'],
                'text' => $offer['text'] ?? '',
                'price' => $offer['price'] ?? '',
                'price_suffix' => $offer['price_suffix'] ?? '',
                'features' => $features,
                'url' => $offer['url'] ?? '',
                'cta_title' => $offer['cta_title'] ?? 'Découvrir l\'offre →',
                'featured' => !empty($offer['featured']),
            );
        }, $offers)));
    }

    return array(
        array(
            'eyebrow' => 'Achat · Propriété du site',
            'title' => 'Achat de votre site internet',
            'text' => 'Site WordPress sur mesure, design premium et SEO intégré. Vous êtes propriétaire du site et de son contenu.',
            'price' => 'Dès 3 000 €',
            'price_suffix' => 'HT',
            'features' => array(
                array('text' => 'Design UX/UI personnalisé'),
                array('text' => 'WordPress 100 % sur mesure'),
                array('text' => 'SEO technique et éditorial'),
                array('text' => 'Formation à l\'administration'),
            ),
            'url' => home_url('/services/creation-site-web-nantes/'),
            'cta_title' => 'Voir la création de site →',
            'featured' => false,
        ),
        array(
            'eyebrow' => 'Location · Tout inclus',
            'title' => 'Location de votre site internet',
            'text' => 'Formule clé en main sans frais de création : hébergement, maintenance, mises à jour et SEO de base inclus.',
            'price' => '350 €',
            'price_suffix' => '/mois HT',
            'features' => array(
                array('text' => 'Zéro investissement initial'),
                array('text' => 'Création et refonte incluses'),
                array('text' => 'Hébergement premium et sauvegardes'),
                array('text' => 'Support réactif à Nantes'),
            ),
            'url' => home_url('/services/location-site-internet/'),
            'cta_title' => 'Voir la location →',
            'featured' => true,
        ),
        array(
            'eyebrow' => 'CRM · Connecté au site',
            'title' => 'Création de CRM sur mesure',
            'text' => 'CRM connecté à votre site WordPress pour capturer, qualifier et suivre vos leads — sans Excel ni double saisie.',
            'price' => 'Sur devis',
            'price_suffix' => 'audit gratuit',
            'features' => array(
                array('text' => 'Connexion native site ↔ CRM'),
                array('text' => 'HubSpot, Pipedrive ou custom'),
                array('text' => 'Workflows et relances automatisés'),
                array('text' => 'Formation de vos équipes'),
            ),
            'url' => home_url('/services/crm-sur-mesure-nantes/'),
            'cta_title' => 'Voir le CRM sur mesure →',
            'featured' => false,
        ),
    );
}

function crescendo_get_services_hub_cards($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $cards = crescendo_services_hub('services-cards', $post_id);

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

    $children = crescendo_get_services_hub_children($post_id);
    if (!empty($children)) {
        $cards = array();

        foreach ($children as $child) {
            $intro = get_field('service-hero-intro', $child->ID);
            $cards[] = array(
                'eyebrow' => get_field('service-hero-eyebrow', $child->ID) ?: '',
                'title' => get_the_title($child),
                'text' => $intro ? wp_trim_words($intro, 28, '…') : '',
                'url' => get_permalink($child),
            );
        }

        return $cards;
    }

    foreach (crescendo_get_site_nav_sections() as $section) {
        if ($section['id'] !== 'services' || empty($section['items'])) {
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

function crescendo_output_services_hub_schema($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $seo = crescendo_get_services_hub_seo($post_id);
    $children = crescendo_get_services_hub_cards($post_id);

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
        'name' => crescendo_services_hub('services-hero-title', $post_id) ?: get_the_title($post_id),
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

function crescendo_services_hub_head_meta() {
    if (!is_page() || !crescendo_is_services_hub_page()) {
        return;
    }

    crescendo_print_seo_head_meta(crescendo_get_services_hub_seo(), 'website', get_the_ID());
}
add_action('wp_head', 'crescendo_services_hub_head_meta', 1);

function crescendo_filter_services_hub_document_title($title) {
    if (is_admin() || !is_page() || !crescendo_is_services_hub_page()) {
        return $title;
    }

    return crescendo_get_services_hub_seo()['meta_title'];
}
add_filter('pre_get_document_title', 'crescendo_filter_services_hub_document_title', 20);
