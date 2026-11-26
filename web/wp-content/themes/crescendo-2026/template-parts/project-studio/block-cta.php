<?php
$title = crescendo_project('project-cta-title');
$text = crescendo_project('project-cta-text');
$button = crescendo_project('project-cta-button');
$eyebrow = crescendo_project('project-cta-eyebrow');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');

if (!$title && empty($button['url'])) {
    return;
}

$ctaUrl = !empty($button['url']) ? $button['url'] : $contactUrl;
$ctaLabel = !empty($button['title']) ? $button['title'] : __('Demander ma maquette gratuite', 'crescendo-2026');

if (!$text) {
    $text = __('Parlons de votre site. Nous vous proposons une maquette gratuite en 48 h pour valider la direction avant de démarrer.', 'crescendo-2026');
}

get_template_part('template-parts/general/studio', 'hub-cta', array(
    'eyebrow' => $eyebrow ?: __('Un projet avec Crescendo', 'crescendo-2026'),
    'title' => $title,
    'text' => $text,
    'title_id' => 'studio-project-cta-title',
    'section_class' => 'studio-contact studio-contact--hub studio-project-hub-cta',
    'cta_url' => $ctaUrl,
    'cta_label' => $ctaLabel,
));