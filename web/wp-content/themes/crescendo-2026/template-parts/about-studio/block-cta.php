<?php
$title = crescendo_about('about-cta-title');
$text = crescendo_about('about-cta-text');
$button = crescendo_about('about-cta-button');
$eyebrow = crescendo_about('about-cta-eyebrow');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');

if (!$title) {
    return;
}

$ctaUrl = !empty($button['url']) ? $button['url'] : $contactUrl;
$ctaLabel = !empty($button['title']) ? $button['title'] : __('Demander ma maquette gratuite', 'crescendo-2026');

if (!$text) {
    $text = __('Envie de travailler avec une équipe locale et exigeante ? Présentez votre besoin en quelques lignes : nous échangeons sous 24 h et préparons une maquette gratuite en 48 h.', 'crescendo-2026');
}

get_template_part('template-parts/general/studio', 'hub-cta', array(
    'eyebrow' => $eyebrow ?: __('Un projet avec Crescendo', 'crescendo-2026'),
    'title' => $title,
    'text' => $text,
    'title_id' => 'studio-about-cta-title',
    'section_class' => 'studio-contact studio-contact--hub studio-about-cta',
    'cta_url' => $ctaUrl,
    'cta_label' => $ctaLabel,
));