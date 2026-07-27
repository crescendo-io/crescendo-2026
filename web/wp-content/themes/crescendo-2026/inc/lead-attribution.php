<?php

function crescendo_lead_attribution_post_keys() {
    return array(
        'attribution_utm_source' => 'lead_utm_source',
        'attribution_utm_medium' => 'lead_utm_medium',
        'attribution_utm_campaign' => 'lead_utm_campaign',
        'attribution_utm_term' => 'lead_utm_term',
        'attribution_utm_content' => 'lead_utm_content',
        'attribution_gclid' => 'lead_gclid',
        'attribution_msclkid' => 'lead_msclkid',
        'attribution_fbclid' => 'lead_fbclid',
        'attribution_landing_page' => 'lead_landing_page',
        'attribution_referrer' => 'lead_referrer',
    );
}

function crescendo_lead_attribution_meta_keys() {
    $keys = array_values(crescendo_lead_attribution_post_keys());
    $keys[] = 'lead_channel';

    return $keys;
}

function crescendo_sanitize_lead_attribution_value($value, $is_url = false) {
    $value = is_string($value) ? trim(wp_unslash($value)) : '';

    if ($value === '') {
        return '';
    }

    if ($is_url) {
        return crescendo_sanitize_lead_url($value);
    }

    return sanitize_text_field($value);
}

function crescendo_get_lead_attribution_from_post() {
    $meta = array();

    foreach (crescendo_lead_attribution_post_keys() as $post_key => $meta_key) {
        $is_url = in_array($post_key, array('attribution_landing_page', 'attribution_referrer'), true);
        $meta[$meta_key] = crescendo_sanitize_lead_attribution_value($_POST[$post_key] ?? '', $is_url);
    }

    $meta['lead_channel'] = crescendo_resolve_lead_channel($meta);

    return $meta;
}

function crescendo_resolve_lead_channel(array $data) {
    $medium = strtolower((string) ($data['lead_utm_medium'] ?? ''));
    $source = strtolower((string) ($data['lead_utm_source'] ?? ''));
    $gclid = (string) ($data['lead_gclid'] ?? '');
    $msclkid = (string) ($data['lead_msclkid'] ?? '');
    $referrer = (string) ($data['lead_referrer'] ?? '');

    if ($gclid !== '' || $msclkid !== '') {
        return 'SEA';
    }

    $paid_mediums = array('cpc', 'ppc', 'paid', 'paidsearch', 'cpm', 'display', 'paidsocial');
    if (in_array($medium, $paid_mediums, true)) {
        return 'SEA';
    }

    if ($medium === 'organic') {
        return 'SEO';
    }

    if (crescendo_lead_referrer_is_organic_search($referrer)) {
        return 'SEO';
    }

    if ($medium === 'email') {
        return 'Email';
    }

    if ($medium === 'social' || crescendo_lead_referrer_is_social($referrer)) {
        return 'Social';
    }

    if ($referrer !== '' && !crescendo_lead_referrer_is_own_site($referrer)) {
        return 'Referral';
    }

    if ($referrer === '' && $medium === '' && $source === '' && $gclid === '' && $msclkid === '') {
        return 'Direct';
    }

    return 'Autre';
}

function crescendo_lead_referrer_host($referrer) {
    if ($referrer === '') {
        return '';
    }

    $host = wp_parse_url($referrer, PHP_URL_HOST);

    if (!is_string($host) || $host === '') {
        return '';
    }

    return strtolower(preg_replace('/^www\./', '', $host));
}

function crescendo_lead_referrer_is_own_site($referrer) {
    $host = crescendo_lead_referrer_host($referrer);

    if ($host === '') {
        return false;
    }

    $site_host = crescendo_lead_referrer_host(home_url('/'));

    return $site_host !== '' && ($host === $site_host || str_ends_with($host, '.' . $site_host));
}

function crescendo_lead_referrer_is_organic_search($referrer) {
    $host = crescendo_lead_referrer_host($referrer);

    if ($host === '') {
        return false;
    }

    $search_engines = array(
        'google.com',
        'google.fr',
        'google.be',
        'google.ch',
        'bing.com',
        'yahoo.com',
        'duckduckgo.com',
        'qwant.com',
        'ecosia.org',
        'search.brave.com',
    );

    foreach ($search_engines as $engine) {
        if ($host === $engine || str_ends_with($host, '.' . $engine)) {
            return true;
        }
    }

    return false;
}

function crescendo_lead_referrer_is_social($referrer) {
    $host = crescendo_lead_referrer_host($referrer);

    if ($host === '') {
        return false;
    }

    $social_hosts = array(
        'facebook.com',
        'instagram.com',
        'linkedin.com',
        'twitter.com',
        'x.com',
        'tiktok.com',
        'youtube.com',
        'pinterest.com',
    );

    foreach ($social_hosts as $social_host) {
        if ($host === $social_host || str_ends_with($host, '.' . $social_host)) {
            return true;
        }
    }

    return false;
}

function crescendo_get_lead_channel_label($channel) {
    $labels = array(
        'SEA' => 'SEA (publicité)',
        'SEO' => 'SEO (référencement naturel)',
        'Direct' => 'Direct',
        'Referral' => 'Referral',
        'Social' => 'Social',
        'Email' => 'Email',
        'Autre' => 'Autre',
    );

    return $labels[$channel] ?? $channel;
}

function crescendo_format_lead_attribution_summary($lead_id) {
    $channel = get_post_meta($lead_id, 'lead_channel', true);

    if ($channel === '') {
        return '';
    }

    $map = array(
        'Canal' => crescendo_get_lead_channel_label($channel),
        'UTM source' => get_post_meta($lead_id, 'lead_utm_source', true),
        'UTM medium' => get_post_meta($lead_id, 'lead_utm_medium', true),
        'UTM campaign' => get_post_meta($lead_id, 'lead_utm_campaign', true),
        'UTM term' => get_post_meta($lead_id, 'lead_utm_term', true),
        'UTM content' => get_post_meta($lead_id, 'lead_utm_content', true),
        'GCLID' => get_post_meta($lead_id, 'lead_gclid', true),
        'MSCLKID' => get_post_meta($lead_id, 'lead_msclkid', true),
        'Landing page' => get_post_meta($lead_id, 'lead_landing_page', true),
        'Referrer' => get_post_meta($lead_id, 'lead_referrer', true),
    );

    $lines = array();
    foreach ($map as $label => $value) {
        if ($value !== '') {
            $lines[] = $label . ' : ' . $value;
        }
    }

    return implode("\n", $lines);
}
