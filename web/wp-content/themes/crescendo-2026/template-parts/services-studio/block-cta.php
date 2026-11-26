<?php
$title = crescendo_services_hub('services-cta-title');
$text = crescendo_services_hub('services-cta-text');
$button = crescendo_services_hub('services-cta-button');
$eyebrow = crescendo_services_hub('services-cta-eyebrow');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');

if (!$title && !$text && empty($button['url'])) {
    return;
}

$ctaUrl = !empty($button['url']) ? $button['url'] : $contactUrl;
$ctaLabel = !empty($button['title']) ? $button['title'] : __('Demander ma maquette gratuite', 'crescendo-2026');

if (!$text) {
    $text = __('Parlons de votre projet à Nantes. Nous vous orientons vers la bonne formule et vous envoyons une maquette gratuite en 48 h pour valider la direction.', 'crescendo-2026');
}

get_template_part('template-parts/general/studio', 'hub-cta', array(
    'eyebrow' => $eyebrow ?: __('Un projet avec Crescendo', 'crescendo-2026'),
    'title' => $title,
    'text' => $text,
    'title_id' => 'studio-services-hub-cta-title',
    'section_class' => 'studio-contact studio-contact--hub studio-services-hub-cta',
    'cta_url' => $ctaUrl,
    'cta_label' => $ctaLabel,
));