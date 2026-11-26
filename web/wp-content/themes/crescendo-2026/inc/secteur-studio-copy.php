<?php

/**
 * Affichage Studio des pages secteur : pas de ancrage géographique dans les textes.
 */
function crescendo_secteur_field_is_urlish($key) {
    if (!is_string($key) || $key === '') {
        return false;
    }

    $key = strtolower($key);

    return str_contains($key, 'url')
        || str_contains($key, 'canonical')
        || $key === 'slug'
        || $key === 'target';
}

function crescendo_secteur_strip_localization_text($text) {
    if (!is_string($text) || $text === '') {
        return $text;
    }

  $search = array(
        ' à Nantes',
        ' de Nantes',
        ' en Nantes',
        ' · Nantes',
        ' · Loire-Atlantique',
        ' en Loire-Atlantique',
        ' et métropole',
        ' et la métropole',
        ' et de la métropole',
        ' et des communes voisines',
        ' et sa métropole',
        'Loire-Atlantique',
        'SEO local',
        'référencement local',
        "zone d'intervention",
        'zone de prospection',
        'zone de chalandise',
        'zone géographique',
        'Accompagnement local à Nantes',
        'Agence nantaise',
        'agence nantaise',
        'Accompagnement local',
    );

  $replace = array(
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        'SEO',
        'référencement',
        'marché',
        'marché',
        'clientèle',
        'marché',
        'Accompagnement dédié',
        'Équipe Crescendo',
        'Équipe Crescendo',
        'Accompagnement dédié',
    );

    $text = str_replace($search, $replace, $text);
    $text = preg_replace('/\s*à\s+Nantes\b/ui', '', $text);
    $text = preg_replace('/\s*·\s*Nantes\b/ui', '', $text);
    $text = preg_replace('/\s{2,}/', ' ', $text);
    $text = preg_replace('/\s+([,.;:!?])/', '$1', $text);

    return trim($text);
}

/**
 * @param mixed $value
 * @return mixed
 */
function crescendo_secteur_sanitize_copy($value, $fieldKey = '') {
    if (crescendo_secteur_field_is_urlish($fieldKey)) {
        return $value;
    }

    if (is_string($value)) {
        return crescendo_secteur_strip_localization_text($value);
    }

    if (!is_array($value)) {
        return $value;
    }

    $out = array();
    foreach ($value as $key => $item) {
        if (is_string($key) && str_starts_with($key, 'secteur-area-')) {
            continue;
        }
        $childKey = is_string($key) ? $key : $fieldKey;
        $out[$key] = crescendo_secteur_sanitize_copy($item, $childKey);
    }

    return $out;
}

function crescendo_secteur_should_sanitize_display($post_id = null) {
    return function_exists('crescendo_uses_studio_design')
        && crescendo_uses_studio_design()
        && (
            (function_exists('crescendo_uses_studio_secteur_layout') && crescendo_uses_studio_secteur_layout($post_id))
            || (function_exists('crescendo_uses_studio_secteurs_hub_layout') && crescendo_uses_studio_secteurs_hub_layout($post_id))
        );
}

/**
 * @param string $field
 * @param mixed $value
 * @return mixed
 */
function crescendo_filter_studio_secteur_post_title($title, $post_id = 0) {
    if (is_admin() || $title === '' || !function_exists('crescendo_secteur_strip_localization_text')) {
        return $title;
    }

    if (function_exists('crescendo_uses_studio_secteur_layout') && crescendo_uses_studio_secteur_layout($post_id)) {
        return crescendo_secteur_strip_localization_text($title);
    }

    if (
        function_exists('crescendo_is_secteurs_hub_page')
        && function_exists('crescendo_uses_studio_secteurs_hub_layout')
        && crescendo_is_secteurs_hub_page($post_id)
        && crescendo_uses_studio_secteurs_hub_layout($post_id)
    ) {
        return crescendo_secteur_strip_localization_text($title);
    }

    return $title;
}

add_filter('the_title', 'crescendo_filter_studio_secteur_post_title', 20, 2);

function crescendo_secteur_sanitize_field_value($field, $value, $post_id = null) {
    if ($value === null || $value === false || $value === '') {
        return $value;
    }

    if (!crescendo_secteur_should_sanitize_display($post_id)) {
        return $value;
    }

    if (str_starts_with($field, 'secteur-area-')) {
        return null;
    }

    return crescendo_secteur_sanitize_copy($value, $field);
}