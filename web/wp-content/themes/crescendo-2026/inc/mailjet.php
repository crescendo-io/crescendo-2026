<?php

function crescendo_mailjet_is_configured() {
    return defined('MAILJET_API_KEY') && MAILJET_API_KEY !== ''
        && defined('MAILJET_API_SECRET') && MAILJET_API_SECRET !== ''
        && defined('MAILJET_SENDER_EMAIL') && MAILJET_SENDER_EMAIL !== '';
}

function crescendo_mailjet_get_sender_email() {
    return defined('MAILJET_SENDER_EMAIL') ? MAILJET_SENDER_EMAIL : '';
}

function crescendo_mailjet_get_sender_name() {
    if (defined('MAILJET_SENDER_NAME') && MAILJET_SENDER_NAME !== '') {
        return MAILJET_SENDER_NAME;
    }

    return function_exists('crescendo_brand_name') ? crescendo_brand_name() : 'Crescendo Studio';
}

function crescendo_mailjet_normalize_recipients($to) {
    $recipients = array();

    if (is_array($to)) {
        foreach ($to as $key => $value) {
            if (is_int($key) && is_email($value)) {
                $recipients[] = array('Email' => $value);
                continue;
            }

            if (is_string($key) && is_email($key)) {
                $recipients[] = array(
                    'Email' => $key,
                    'Name' => is_string($value) ? $value : '',
                );
            }
        }
    } elseif (is_string($to)) {
        foreach (preg_split('/[\s,;]+/', $to) as $email) {
            $email = trim($email);
            if ($email !== '' && is_email($email)) {
                $recipients[] = array('Email' => $email);
            }
        }
    }

    return $recipients;
}

function crescendo_mailjet_prepare_attachments(array $attachments) {
    $prepared = array();

    foreach ($attachments as $attachment) {
        $path = '';

        if (is_string($attachment)) {
            $path = $attachment;
        } elseif (is_array($attachment)) {
            $path = $attachment[0] ?? $attachment['path'] ?? '';
        }

        if ($path === '' || !is_readable($path)) {
            continue;
        }

        $content = file_get_contents($path);
        if ($content === false) {
            continue;
        }

        $filename = wp_basename($path);
        $mime = wp_check_filetype($filename);
        $content_type = $mime['type'] ?: 'application/octet-stream';

        $prepared[] = array(
            'ContentType' => $content_type,
            'Filename' => $filename,
            'Base64Content' => base64_encode($content),
        );
    }

    return $prepared;
}

function crescendo_mailjet_send($to, $subject, $message, array $attachments = array()) {
    if (!crescendo_mailjet_is_configured()) {
        return false;
    }

    $recipients = crescendo_mailjet_normalize_recipients($to);
    if (empty($recipients)) {
        return false;
    }

    $payload = array(
        'Messages' => array(
            array(
                'From' => array(
                    'Email' => crescendo_mailjet_get_sender_email(),
                    'Name' => crescendo_mailjet_get_sender_name(),
                ),
                'To' => $recipients,
                'Subject' => wp_specialchars_decode((string) $subject),
                'TextPart' => (string) $message,
            ),
        ),
    );

    $mail_attachments = crescendo_mailjet_prepare_attachments($attachments);
    if (!empty($mail_attachments)) {
        $payload['Messages'][0]['Attachments'] = $mail_attachments;
    }

    $response = wp_remote_post(
        'https://api.mailjet.com/v3.1/send',
        array(
            'timeout' => 20,
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode(MAILJET_API_KEY . ':' . MAILJET_API_SECRET),
                'Content-Type' => 'application/json',
            ),
            'body' => wp_json_encode($payload),
        )
    );

    if (is_wp_error($response)) {
        error_log('[Mailjet] ' . $response->get_error_message());
        return false;
    }

    $status_code = (int) wp_remote_retrieve_response_code($response);
    $body = json_decode(wp_remote_retrieve_body($response), true);

    if ($status_code < 200 || $status_code >= 300) {
        $error_message = is_array($body) ? wp_json_encode($body) : wp_remote_retrieve_body($response);
        error_log('[Mailjet] HTTP ' . $status_code . ' — ' . $error_message);
        return false;
    }

    $message_status = $body['Messages'][0]['Status'] ?? '';
    if ($message_status !== 'success') {
        error_log('[Mailjet] Send status: ' . wp_json_encode($body));
        return false;
    }

    return true;
}

function crescendo_mailjet_pre_wp_mail($short_circuit, $atts) {
    if (!crescendo_mailjet_is_configured()) {
        return $short_circuit;
    }

    $to = $atts['to'] ?? '';
    $subject = $atts['subject'] ?? '';
    $message = $atts['message'] ?? '';
    $attachments = $atts['attachments'] ?? array();

    if (!is_array($attachments)) {
        $attachments = $attachments ? array($attachments) : array();
    }

    $sent = crescendo_mailjet_send($to, $subject, $message, $attachments);

    if (!$sent) {
        do_action(
            'wp_mail_failed',
            new WP_Error('mailjet_send_failed', 'Échec de l’envoi via Mailjet.', $atts)
        );
    }

    return $sent;
}
add_filter('pre_wp_mail', 'crescendo_mailjet_pre_wp_mail', 10, 2);

function crescendo_mailjet_wp_mail_from($email) {
    if (crescendo_mailjet_is_configured()) {
        return crescendo_mailjet_get_sender_email();
    }

    return $email;
}
add_filter('wp_mail_from', 'crescendo_mailjet_wp_mail_from');

function crescendo_mailjet_wp_mail_from_name($name) {
    if (crescendo_mailjet_is_configured()) {
        return crescendo_mailjet_get_sender_name();
    }

    return $name;
}
add_filter('wp_mail_from_name', 'crescendo_mailjet_wp_mail_from_name');
