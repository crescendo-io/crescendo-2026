<?php

function crescendo_nav_url($path) {
    return home_url('/' . ltrim($path, '/') . '/');
}

function crescendo_nav_normalize_path($url) {
    $path = wp_parse_url((string) $url, PHP_URL_PATH);
    if (!is_string($path) || $path === '' || $path === '/') {
        return '/';
    }

    return untrailingslashit($path);
}

function crescendo_nav_is_current($url) {
    $linkPath = crescendo_nav_normalize_path($url);
    if ($linkPath === '/') {
        return is_front_page();
    }

    $currentPath = crescendo_nav_normalize_path(home_url(add_query_arg(array())));
    if ($currentPath === $linkPath) {
        return true;
    }

    return str_starts_with($currentPath . '/', $linkPath . '/');
}

function crescendo_nav_link_is_active(array $link) {
    if (!empty($link['url']) && crescendo_nav_is_current($link['url'])) {
        return true;
    }

    if (empty($link['children']) || !is_array($link['children'])) {
        return false;
    }

    foreach ($link['children'] as $child) {
        if (!empty($child['url']) && crescendo_nav_is_current($child['url'])) {
            return true;
        }
    }

    return false;
}

function crescendo_nav_service_url($slug) {
    return crescendo_nav_url('services/' . ltrim($slug, '/'));
}

function crescendo_nav_secteur_url($slug) {
    return crescendo_nav_url('secteurs/' . ltrim($slug, '/'));
}

function crescendo_get_site_nav_sections() {
    $services = array(
        array('label' => 'Création de site internet', 'url' => crescendo_nav_service_url('creation-site-web-nantes')),
        array('label' => 'Site vitrine Nantes', 'url' => crescendo_nav_service_url('creation-site-vitrine-nantes')),
        array('label' => 'Site e-commerce Nantes', 'url' => crescendo_nav_service_url('creation-site-ecommerce-nantes')),
        array('label' => 'Création site WordPress', 'url' => crescendo_nav_service_url('creation-site-wordpress')),
        array('label' => 'Refonte site WordPress', 'url' => crescendo_nav_service_url('refonte-site-wordpress')),
        array('label' => 'Location de site internet', 'url' => crescendo_nav_service_url('location-site-internet')),
        array('label' => 'CRM sur mesure Nantes', 'url' => crescendo_nav_service_url('crm-sur-mesure-nantes')),
        array('label' => 'Agence SEO Nantes', 'url' => crescendo_nav_service_url('agence-seo-nantes')),
        array('label' => 'Maintenance WordPress', 'url' => crescendo_nav_service_url('maintenance-wordpress')),
    );

    $secteurs = array(
        array('label' => 'Site web artisan Nantes', 'url' => crescendo_nav_secteur_url('creation-site-artisan-nantes')),
        array('label' => 'Site web coiffeur Nantes', 'url' => crescendo_nav_secteur_url('creation-site-coiffeur-nantes')),
        array('label' => 'Site web avocat Nantes', 'url' => crescendo_nav_secteur_url('creation-site-avocat-nantes')),
        array('label' => 'Site web immobilier Nantes', 'url' => crescendo_nav_secteur_url('creation-site-immobilier-nantes')),
        array('label' => 'Site web restaurant Nantes', 'url' => crescendo_nav_secteur_url('creation-site-restaurant-nantes')),
        array('label' => 'Site web startup Nantes', 'url' => crescendo_nav_secteur_url('creation-site-startup-nantes')),
        array('label' => 'Site web B2B Nantes', 'url' => crescendo_nav_secteur_url('creation-site-b2b-nantes')),
        array('label' => 'Site web coach Nantes', 'url' => crescendo_nav_secteur_url('creation-site-coach-nantes')),
        array('label' => 'Site web architecte Nantes', 'url' => crescendo_nav_secteur_url('creation-site-architecte-nantes')),
        array('label' => 'Site web thérapeute Nantes', 'url' => crescendo_nav_secteur_url('creation-site-therapeute-nantes')),
        array('label' => 'Site web association Nantes', 'url' => crescendo_nav_secteur_url('creation-site-association-nantes')),
        array('label' => 'Site web BTP Nantes', 'url' => crescendo_nav_secteur_url('creation-site-btp-nantes')),
        array('label' => 'Site web paysagiste Nantes', 'url' => crescendo_nav_secteur_url('creation-site-paysagiste-nantes')),
        array('label' => 'Site web électricien Nantes', 'url' => crescendo_nav_secteur_url('creation-site-electricien-nantes')),
        array('label' => 'Site web plombier Nantes', 'url' => crescendo_nav_secteur_url('creation-site-plombier-nantes')),
        array('label' => 'Site web industrie Nantes', 'url' => crescendo_nav_secteur_url('creation-site-industrie-nantes')),
        array('label' => 'Site web cabinet RH Nantes', 'url' => crescendo_nav_secteur_url('creation-site-cabinet-rh-nantes')),
    );

    $locales = array(
        array('label' => 'Agence web Nantes', 'url' => home_url('/')),
        array('label' => 'Agence web Saint-Herblain', 'url' => crescendo_nav_url('agence-web-saint-herblain')),
        array('label' => 'Agence web Rezé', 'url' => crescendo_nav_url('agence-web-reze')),
        array('label' => 'Agence web Orvault', 'url' => crescendo_nav_url('agence-web-orvault')),
        array('label' => 'Agence web Carquefou', 'url' => crescendo_nav_url('agence-web-carquefou')),
        array('label' => 'Agence web Bouguenais', 'url' => crescendo_nav_url('agence-web-bouguenais')),
        array('label' => 'Agence web Saint-Sébastien-sur-Loire', 'url' => crescendo_nav_url('agence-web-saint-sebastien-sur-loire')),
        array('label' => 'Agence web Saint-Nazaire', 'url' => crescendo_nav_url('agence-web-saint-nazaire')),
    );

    $projets = array(
        array('label' => 'Toutes nos réalisations', 'url' => crescendo_nav_url('realisations')),
        array('label' => 'Atelier Gambetta', 'url' => crescendo_nav_url('realisations/atelier-gambetta')),
        array('label' => 'Be Focus', 'url' => crescendo_nav_url('realisations/be-focus')),
        array('label' => 'Bag X Pro', 'url' => crescendo_nav_url('realisations/bag-x-pro')),
        array('label' => 'Maison Jaden', 'url' => crescendo_nav_url('realisations/maison-jaden')),
        array('label' => 'Ludovic Géhéniaux', 'url' => crescendo_nav_url('realisations/ludovic-geheniaux')),
        array('label' => 'Vanetty Music', 'url' => crescendo_nav_url('realisations/vanetty-music')),
        array('label' => 'CM&A Associés', 'url' => crescendo_nav_url('realisations/cma-associes')),
        array('label' => 'Car Design France', 'url' => crescendo_nav_url('realisations/car-design')),
        array('label' => 'Padam Immo', 'url' => crescendo_nav_url('realisations/padam-immo')),
        array('label' => 'Ta Kifé', 'url' => crescendo_nav_url('realisations/ta-kife')),
    );

    $agency = array(
        array('label' => 'À propos', 'url' => crescendo_nav_url('a-propos')),
        array('label' => 'Contact', 'url' => crescendo_nav_url('contact')),
    );

    $legal = array(
        array('label' => 'Mentions légales', 'url' => crescendo_nav_url('mentions-legales')),
        array('label' => 'Politique de confidentialité', 'url' => crescendo_nav_url('politique-de-confidentialite')),
        array('label' => 'Plan du site', 'url' => crescendo_nav_url('plan-du-site')),
    );

    return apply_filters('crescendo_site_nav_sections', array(
        array(
            'id' => 'services',
            'label' => 'Services',
            'url' => crescendo_nav_url('services'),
            'items' => $services,
        ),
        array(
            'id' => 'secteurs',
            'label' => 'Secteurs',
            'url' => crescendo_nav_url('secteurs'),
            'items' => $secteurs,
        ),
        array(
            'id' => 'locales',
            'label' => 'Nantes & région',
            'url' => home_url('/'),
            'items' => $locales,
        ),
        array(
            'id' => 'realisations',
            'label' => 'Réalisations',
            'url' => crescendo_nav_url('realisations'),
            'items' => $projets,
        ),
        array(
            'id' => 'agency',
            'label' => 'L\'agence',
            'url' => crescendo_nav_url('a-propos'),
            'items' => $agency,
        ),
        array(
            'id' => 'legal',
            'label' => 'Informations légales',
            'url' => crescendo_nav_url('mentions-legales'),
            'items' => $legal,
        ),
    ));
}

function crescendo_get_header_nav_links() {
    $sections = crescendo_get_site_nav_sections();
    $links = array();

    foreach ($sections as $section) {
        if (in_array($section['id'], array('legal', 'agency', 'locales'), true)) {
            continue;
        }

        $links[] = array(
            'label' => $section['label'],
            'url' => $section['url'],
            'children' => $section['items'],
        );
    }

    $links[] = array(
        'label' => 'À propos',
        'url' => crescendo_nav_url('a-propos'),
    );
    $links[] = array(
        'label' => 'Contact',
        'url' => crescendo_nav_url('contact'),
    );

    return apply_filters('crescendo_header_nav_links', $links);
}

function crescendo_get_sitemap_page_sections() {
    $sections = crescendo_get_site_nav_sections();

    return array_merge(
        array(
            array(
                'id' => 'home',
                'label' => 'Accueil',
                'url' => home_url('/'),
                'items' => array(),
            ),
        ),
        $sections
    );
}

function crescendo_get_footer_nav_columns() {
    $sections = crescendo_get_site_nav_sections();
    $byId = array();

    foreach ($sections as $section) {
        $byId[$section['id']] = $section;
    }

    return apply_filters('crescendo_footer_nav_columns', array(
        array(
            'title' => 'Services',
            'items' => $byId['services']['items'],
        ),
        array(
            'title' => 'Secteurs',
            'items' => array_slice($byId['secteurs']['items'], 0, 6),
        ),
        array(
            'title' => 'Villes',
            'items' => $byId['locales']['items'],
        ),
    ));
}
