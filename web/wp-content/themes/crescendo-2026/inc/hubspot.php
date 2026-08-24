<?php

/**
 * HubSpot CRM sync for contact form leads.
 */

function crescendo_hubspot_is_enabled() {
    return crescendo_hubspot_get_access_token() !== '';
}

function crescendo_hubspot_get_access_token() {
    if (defined('HUBSPOT_ACCESS_TOKEN') && HUBSPOT_ACCESS_TOKEN) {
        return (string) HUBSPOT_ACCESS_TOKEN;
    }

    $token = getenv('HUBSPOT_ACCESS_TOKEN');
    return is_string($token) ? trim($token) : '';
}

function crescendo_hubspot_normalize_access_token($token) {
    $token = trim((string) $token);
    if ($token === '') {
        return '';
    }

    if (stripos($token, 'pat-') !== 0 && preg_match('/^(eu1|na1|ap1)-/i', $token)) {
        $token = 'pat-' . $token;
    }

    return $token;
}

function crescendo_hubspot_is_valid_token_format($token) {
    $token = crescendo_hubspot_normalize_access_token($token);

    return (bool) preg_match('/^pat-(eu1|na1|ap1)-[a-f0-9-]{20,}$/i', $token);
}

function crescendo_hubspot_get_token_format_error() {
    return 'Le token HubSpot configuré est invalide. Utilisez un access token Private App (format pat-eu1-… ou pat-na1-…), copié depuis HubSpot > Paramètres > Intégrations > Applications privées > Auth > Afficher le token.';
}

function crescendo_hubspot_request($method, $path, ?array $body = null) {
    $token = crescendo_hubspot_normalize_access_token(crescendo_hubspot_get_access_token());
    if ($token === '') {
        return new WP_Error('hubspot_disabled', 'HubSpot token missing.');
    }

    if (!crescendo_hubspot_is_valid_token_format($token)) {
        return new WP_Error('hubspot_invalid_token', crescendo_hubspot_get_token_format_error());
    }

    $args = array(
        'method' => strtoupper($method),
        'timeout' => 12,
        'headers' => array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ),
    );

    if ($body !== null) {
        $args['body'] = wp_json_encode($body);
    }

    $response = wp_remote_request('https://api.hubapi.com' . $path, $args);
    if (is_wp_error($response)) {
        return $response;
    }

    $status = (int) wp_remote_retrieve_response_code($response);
    $raw = wp_remote_retrieve_body($response);
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        $data = array();
    }

    if ($status < 200 || $status >= 300) {
        $message = $data['message'] ?? $raw;
        if (!empty($data['errors']) && is_array($data['errors'])) {
            $message = wp_json_encode($data['errors']);
        }

        return new WP_Error(
            'hubspot_http_' . $status,
            is_string($message) ? $message : 'HubSpot API error.',
            array('status' => $status, 'body' => $data)
        );
    }

    return $data;
}

function crescendo_hubspot_build_lead_properties($lead_id) {
    $email = sanitize_email(get_post_meta($lead_id, 'lead_email', true));
    if ($email === '') {
        return new WP_Error('hubspot_missing_email', 'Lead email missing.');
    }

    $properties = array(
        'email' => $email,
        'firstname' => (string) get_post_meta($lead_id, 'lead_prenom', true),
        'lastname' => (string) get_post_meta($lead_id, 'lead_nom', true),
        'phone' => (string) get_post_meta($lead_id, 'lead_telephone', true),
        'company' => (string) get_post_meta($lead_id, 'lead_entreprise', true),
        'lifecyclestage' => 'lead',
        'hs_lead_status' => 'NEW',
    );

    $source_url = (string) get_post_meta($lead_id, 'lead_source_url', true);
    if ($source_url !== '') {
        $properties['website'] = $source_url;
    }

    return array_filter($properties, static function ($value) {
        return $value !== '';
    });
}

function crescendo_hubspot_build_lead_note_body($lead_id) {
    $lines = array('Demande reçue depuis le site Crescendo.');

    $summary = crescendo_format_lead_summary($lead_id);
    if ($summary !== '') {
        $lines[] = '';
        $lines[] = $summary;
    }

    if (get_post_meta($lead_id, 'lead_step2_completed', true)) {
        $step2 = crescendo_format_lead_step2_summary($lead_id);
        if ($step2 !== '') {
            $lines[] = '';
            $lines[] = '--- Précisions projet ---';
            $lines[] = $step2;
        }

        $attachments = crescendo_format_lead_attachments_summary($lead_id);
        if ($attachments !== '') {
            $lines[] = '';
            $lines[] = '--- Fichiers joints ---';
            $lines[] = $attachments;
        }
    }

    return implode("\n", $lines);
}

function crescendo_hubspot_upsert_contact(array $properties) {
    $email = $properties['email'] ?? '';
    if ($email === '') {
        return new WP_Error('hubspot_missing_email', 'HubSpot contact email missing.');
    }

    return crescendo_hubspot_request('POST', '/crm/v3/objects/contacts/batch/upsert', array(
        'inputs' => array(
            array(
                'idProperty' => 'email',
                'id' => $email,
                'properties' => $properties,
            ),
        ),
    ));
}

function crescendo_hubspot_create_contact_note($contact_id, $body) {
    $body = trim((string) $body);
    if ($body === '') {
        return true;
    }

    return crescendo_hubspot_request('POST', '/crm/v3/objects/notes', array(
        'properties' => array(
            'hs_note_body' => $body,
            'hs_timestamp' => (string) (time() * 1000),
        ),
        'associations' => array(
            array(
                'to' => array('id' => (string) $contact_id),
                'types' => array(
                    array(
                        'associationCategory' => 'HUBSPOT_DEFINED',
                        'associationTypeId' => 202,
                    ),
                ),
            ),
        ),
    ));
}

function crescendo_hubspot_extract_contact_id($response) {
    if (!is_array($response)) {
        return 0;
    }

    if (!empty($response['results'][0]['id'])) {
        return (int) $response['results'][0]['id'];
    }

    if (!empty($response['id'])) {
        return (int) $response['id'];
    }

    return 0;
}

function crescendo_hubspot_sync_lead($lead_id, $context = 'step1') {
    $lead_id = (int) $lead_id;
    if ($lead_id <= 0 || get_post_type($lead_id) !== 'crescendo_lead') {
        return new WP_Error('hubspot_invalid_lead', 'Invalid lead.');
    }

    if (!crescendo_hubspot_is_enabled()) {
        return new WP_Error('hubspot_disabled', 'HubSpot disabled.');
    }

    $properties = crescendo_hubspot_build_lead_properties($lead_id);
    if (is_wp_error($properties)) {
        return $properties;
    }

    $response = crescendo_hubspot_upsert_contact($properties);
    if (is_wp_error($response)) {
        crescendo_hubspot_log_error($lead_id, $context, $response);
        return $response;
    }

    $contact_id = crescendo_hubspot_extract_contact_id($response);
    if ($contact_id > 0) {
        update_post_meta($lead_id, 'lead_hubspot_contact_id', (string) $contact_id);
        update_post_meta($lead_id, 'lead_hubspot_synced_at', current_time('mysql'));
    }

    $note_context = $context === 'step2' ? 'step2' : 'step1';
    $note_key = 'lead_hubspot_note_' . $note_context;
    if (!get_post_meta($lead_id, $note_key, true)) {
        $note_body = crescendo_hubspot_build_lead_note_body($lead_id);
        if ($contact_id > 0 && $note_body !== '') {
            $note_response = crescendo_hubspot_create_contact_note($contact_id, $note_body);
            if (is_wp_error($note_response)) {
                crescendo_hubspot_log_error($lead_id, $context . '_note', $note_response);
            } else {
                update_post_meta($lead_id, $note_key, '1');
            }
        }
    }

    return $response;
}

function crescendo_hubspot_log_error($lead_id, $context, WP_Error $error) {
    error_log(sprintf(
        'HubSpot sync failed (lead #%d, %s): %s',
        (int) $lead_id,
        (string) $context,
        $error->get_error_message()
    ));

    update_post_meta($lead_id, 'lead_hubspot_last_error', wp_json_encode(array(
        'context' => (string) $context,
        'message' => $error->get_error_message(),
        'code' => $error->get_error_code(),
        'at' => current_time('mysql'),
    ), JSON_UNESCAPED_UNICODE));
}

function crescendo_hubspot_after_lead_created($lead_id, $context = 'step1') {
    if (!crescendo_hubspot_is_enabled()) {
        return;
    }

    crescendo_hubspot_sync_lead($lead_id, $context);
}
