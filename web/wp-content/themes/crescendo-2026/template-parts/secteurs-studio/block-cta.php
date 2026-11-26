<?php
$title = crescendo_secteurs_hub('secteurs-cta-title');
$text = crescendo_secteurs_hub('secteurs-cta-text');
$button = crescendo_secteurs_hub('secteurs-cta-button');
$eyebrow = crescendo_secteurs_hub('secteurs-cta-eyebrow');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');

if (!$title && !$text && empty($button['url'])) {
    return;
}

$ctaUrl = !empty($button['url']) ? crescendo_resolve_link_url($button['url']) : $contactUrl;
$ctaLabel = !empty($button['title']) ? $button['title'] : __('Parler de mon projet', 'crescendo-2026');

if (!$text) {
    $text = __('Nous adaptons nos sites à toute activité B2B ou B2C. Décrivez-nous votre métier : nous vous répondons sous 24 h avec une proposition et une maquette gratuite en 48 h.', 'crescendo-2026');
}

get_template_part('template-parts/general/studio', 'hub-cta', array(
    'eyebrow' => $eyebrow ?: __('Votre activité · sur mesure', 'crescendo-2026'),
    'title' => $title,
    'text' => $text,
    'title_id' => 'studio-secteurs-hub-cta-title',
    'section_class' => 'studio-contact studio-contact--hub studio-secteurs-hub-cta',
    'cta_url' => $ctaUrl,
    'cta_label' => $ctaLabel,
));