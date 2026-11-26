<?php
$title = crescendo_realisations('realisations-cta-title');
$text = crescendo_realisations('realisations-cta-text');
$button = crescendo_realisations('realisations-cta-button');
$eyebrow = crescendo_realisations('realisations-cta-eyebrow');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');

if (!$title) {
    return;
}

$ctaUrl = !empty($button['url']) ? $button['url'] : $contactUrl;
$ctaLabel = !empty($button['title']) ? $button['title'] : __('Demander ma maquette gratuite', 'crescendo-2026');

if (!$text) {
    $text = __('Vous voyez un cas proche du vôtre ? Racontez-nous vos objectifs : nous revenons vers vous avec une direction créative et une maquette gratuite en 48 h.', 'crescendo-2026');
}

get_template_part('template-parts/general/studio', 'hub-cta', array(
    'eyebrow' => $eyebrow ?: __('Un projet avec Crescendo', 'crescendo-2026'),
    'title' => $title,
    'text' => $text,
    'title_id' => 'studio-realisations-cta-title',
    'section_class' => 'studio-contact studio-contact--hub studio-realisations-cta',
    'cta_url' => $ctaUrl,
    'cta_label' => $ctaLabel,
));