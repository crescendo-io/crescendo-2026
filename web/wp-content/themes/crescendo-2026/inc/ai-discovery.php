<?php

/**
 * GEO / AI discovery : llms.txt, signaux head, robots pour crawlers IA (prod uniquement).
 */

function crescendo_is_llms_txt_request() {
    $uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
    $path = wp_parse_url($uri, PHP_URL_PATH);

    return untrailingslashit((string) $path) === '/llms.txt';
}

function crescendo_llms_txt_url() {
    return home_url('/llms.txt');
}

/**
 * @return array<int, array{label: string, url: string, note?: string}>
 */
function crescendo_llms_txt_nav_links($section_id) {
    foreach (crescendo_get_site_nav_sections() as $section) {
        if (($section['id'] ?? '') !== $section_id) {
            continue;
        }

        $links = array();
        foreach ($section['items'] as $item) {
            if (empty($item['label']) || empty($item['url'])) {
                continue;
            }
            $links[] = array(
                'label' => $item['label'],
                'url' => crescendo_normalize_canonical($item['url']),
            );
        }

        return $links;
    }

    return array();
}

function crescendo_render_llms_txt() {
    $brand = crescendo_brand_name();
    $seo = function_exists('crescendo_get_home_seo') ? crescendo_get_home_seo() : array();
    $summary = $seo['meta_description'] ?? 'Agence web à Nantes : WordPress sur mesure, CRM et location dès 350€/mois.';
    $heroText = function_exists('crescendo_home') ? (string) crescendo_home('home-hero-text') : '';
    $email = get_field('params-footer-email', 'option') ?: 'b.vidal@crescendo-studio.io';
    $address = get_field('params-footer-address', 'option') ?: 'Nantes, Loire-Atlantique (44), France';

    $lines = array();
    $lines[] = '# ' . $brand;
    $lines[] = '';
    $lines[] = '> ' . $summary;
    $lines[] = '';

    if ($heroText !== '') {
        $lines[] = $heroText;
        $lines[] = '';
    }

    $lines[] = '**Entité** : ' . $brand . ' — agence web à Nantes (Loire-Atlantique, France).';
    $lines[] = '**Site** : ' . home_url('/');
    $lines[] = '**Email** : ' . $email;
    $lines[] = '**Adresse** : ' . $address;
    $lines[] = '**Langue** : fr-FR';
    $lines[] = '';

    $lines[] = '## Pages essentielles';
    $lines[] = '- [Accueil — agence web Nantes](' . esc_url(home_url('/')) . '): WordPress sur mesure, CRM, location dès 350€/mois, maquette gratuite 48h.';
    $lines[] = '- [À propos](' . esc_url(crescendo_nav_url('a-propos')) . '): histoire et équipe de l\'agence.';
    $lines[] = '- [Contact](' . esc_url(crescendo_nav_url('contact')) . '): demande de devis et maquette gratuite.';
    $lines[] = '- [Réalisations](' . esc_url(crescendo_nav_url('realisations')) . '): portfolio de sites WordPress livrés.';
    $lines[] = '';

    $sections = array(
        'Services' => 'services',
        'Secteurs d\'activité' => 'secteurs',
        'Agence web par ville' => 'locales',
    );

    foreach ($sections as $heading => $section_id) {
        $links = crescendo_llms_txt_nav_links($section_id);
        if (empty($links)) {
            continue;
        }

        $lines[] = '## ' . $heading;
        foreach ($links as $link) {
            $lines[] = '- [' . $link['label'] . '](' . esc_url($link['url']) . ')';
        }
        $lines[] = '';
    }

    $faqItems = crescendo_get_home_faq_items();
    if (!empty($faqItems)) {
        $lines[] = '## Questions fréquentes';
        foreach ($faqItems as $item) {
            if (empty($item['question']) || empty($item['answer'])) {
                continue;
            }
            $lines[] = '### ' . $item['question'];
            $lines[] = $item['answer'];
            $lines[] = '';
        }
    }

    $lines[] = '## Optional';
    $lines[] = '- [Hub services](' . esc_url(crescendo_nav_url('services')) . ')';
    $lines[] = '- [Hub secteurs](' . esc_url(crescendo_nav_url('secteurs')) . ')';
    $lines[] = '- [Plan du site](' . esc_url(crescendo_nav_url('plan-du-site')) . ')';
    $lines[] = '- [Mentions légales](' . esc_url(crescendo_nav_url('mentions-legales')) . ')';
    $lines[] = '- [Sitemap XML](' . esc_url(home_url('/wp-sitemap.xml')) . ')';

    return apply_filters('crescendo_llms_txt_content', implode("\n", $lines) . "\n");
}

function crescendo_serve_llms_txt() {
    if (!crescendo_is_llms_txt_request()) {
        return;
    }

    status_header(200);
    header('Content-Type: text/plain; charset=utf-8');
    header('X-Robots-Tag: noindex');
    echo crescendo_render_llms_txt();
    exit;
}
add_action('template_redirect', 'crescendo_serve_llms_txt', 0);

function crescendo_ai_discovery_head_links() {
    echo '<link rel="alternate" type="text/plain" title="Guide pour assistants IA" href="' . esc_url(crescendo_llms_txt_url()) . '">' . "\n";
}
add_action('wp_head', 'crescendo_ai_discovery_head_links', 3);

function crescendo_add_llms_to_robots($output, $is_public) {
    $llms_url = crescendo_llms_txt_url();

    if (strpos($output, $llms_url) === false) {
        $output .= "\n# Guide pour assistants IA (llms.txt)\n";
        $output .= '# ' . $llms_url . "\n";
    }

    if (!$is_public) {
        return $output;
    }

    $ai_agents = array(
        'GPTBot',
        'ChatGPT-User',
        'Google-Extended',
        'anthropic-ai',
        'ClaudeBot',
        'PerplexityBot',
    );

    foreach ($ai_agents as $agent) {
        if (stripos($output, 'User-agent: ' . $agent) !== false) {
            continue;
        }

        $output .= "\nUser-agent: {$agent}\nAllow: /\n";
    }

    return $output;
}
add_filter('robots_txt', 'crescendo_add_llms_to_robots', 15, 2);
