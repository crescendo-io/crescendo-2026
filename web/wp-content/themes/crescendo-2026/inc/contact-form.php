<?php

define('CRESCENDO_LEAD_NOTIFY_EMAIL', 'b.vidal@crescendo-studio.io');

function crescendo_get_contact_thank_you_url() {
    static $url = null;

    if ($url !== null) {
        return $url;
    }

    $page = get_page_by_path('merci', OBJECT, 'page');
    $url = $page ? get_permalink($page) : home_url('/merci/');

    return apply_filters('crescendo_contact_thank_you_url', $url);
}

function crescendo_ensure_thank_you_page() {
    if (get_option('crescendo_thank_you_page_v1')) {
        return;
    }

    if (!did_action('init') || !function_exists('crescendo_import_socle_from_json_file') || !function_exists('crescendo_find_content_import_file')) {
        return;
    }

    $file = crescendo_find_content_import_file('socle', 'merci.json');
    if ($file) {
        crescendo_import_socle_from_json_file($file);
    }

    update_option('crescendo_thank_you_page_v1', 1, false);
}
add_action('init', 'crescendo_ensure_thank_you_page', 5);

function crescendo_register_lead_post_type() {
    register_post_type('crescendo_lead', array(
        'labels' => array(
            'name' => 'Demandes contact',
            'singular_name' => 'Demande contact',
            'menu_name' => 'Demandes contact',
            'all_items' => 'Toutes les demandes',
            'view_item' => 'Voir la demande',
            'search_items' => 'Rechercher',
            'not_found' => 'Aucune demande',
            'not_found_in_trash' => 'Aucune demande dans la corbeille',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-email-alt',
        'menu_position' => 26,
        'capability_type' => 'post',
        'map_meta_cap' => true,
        'supports' => array('title'),
        'has_archive' => false,
    ));
}
add_action('init', 'crescendo_register_lead_post_type');

function crescendo_lead_meta_keys() {
    return array_merge(array(
        'lead_prenom',
        'lead_nom',
        'lead_email',
        'lead_entreprise',
        'lead_telephone',
        'lead_projet',
        'lead_besoin',
        'lead_source',
        'lead_source_url',
        'lead_step2_completed',
        'lead_secteur_activite',
        'lead_site_existant',
        'lead_site_etat',
        'lead_charte',
        'lead_charte_details',
        'lead_objectifs',
        'lead_pages',
        'lead_fonctionnalites',
        'lead_contenu_pret',
        'lead_budget',
        'lead_delai',
        'lead_references',
        'lead_commentaires',
        'lead_prestations',
        'lead_attachment_ids',
        'lead_ip',
        'lead_rgpd_consent',
        'lead_rgpd_consent_date',
        'lead_rgpd_consent_version',
    ), crescendo_lead_attribution_meta_keys());
}

function crescendo_get_contact_projet_options() {
    return array(
        'site' => 'Création de site',
        'crm' => 'CRM sur mesure',
        'location' => 'Location 350€/mois',
        'refonte' => 'Refonte de site',
        'ecommerce' => 'E-commerce',
        'seo' => 'SEO / visibilité',
        'maintenance' => 'Maintenance WordPress',
        'autre' => 'Autre besoin',
    );
}

function crescendo_get_contact_site_etat_options() {
    return array(
        '' => 'Sélectionner',
        'aucun' => 'Pas de site actuellement',
        'refonte_complete' => 'Site existant à refondre entièrement',
        'refonte_partielle' => 'Site existant à améliorer partiellement',
        'maintenance' => 'Site existant — besoin de maintenance',
    );
}

function crescendo_get_contact_charte_options() {
    return array(
        '' => 'Sélectionner',
        'complete' => 'Oui, charte complète (logo, couleurs, typos)',
        'partielle' => 'Partielle (logo ou couleurs seulement)',
        'a_creer' => 'Non, à créer avec vous',
        'inconnue' => 'Je ne sais pas encore',
    );
}

function crescendo_get_contact_contenu_options() {
    return array(
        '' => 'Sélectionner',
        'oui' => 'Oui, contenu prêt',
        'partiel' => 'Partiellement',
        'non' => 'Non, besoin d\'aide rédactionnelle',
    );
}

function crescendo_get_contact_budget_options() {
    return array(
        '' => 'Sélectionner',
        'location' => 'Location (~350€/mois)',
        '3000-5000' => '3 000 – 5 000 €',
        '5000-8000' => '5 000 – 8 000 €',
        '8000+' => 'Plus de 8 000 €',
        'a_definir' => 'À définir ensemble',
    );
}

function crescendo_get_contact_delai_options() {
    return array(
        '' => 'Sélectionner',
        'urgent' => 'Dès que possible (< 1 mois)',
        '1-2-mois' => '1 à 2 mois',
        '3-6-mois' => '3 à 6 mois',
        'exploratoire' => 'Projet exploratoire, pas de deadline',
    );
}

function crescendo_sanitize_lead_text($value, $max = 5000) {
    $value = sanitize_textarea_field((string) $value);

    return mb_substr($value, 0, $max);
}

function crescendo_sanitize_lead_email($email) {
    return sanitize_email((string) $email);
}

function crescendo_sanitize_lead_phone($phone) {
    return preg_replace('/[^\d\s+\-().]/', '', (string) $phone);
}

function crescendo_sanitize_lead_url($url) {
    $url = esc_url_raw((string) $url);

    return $url ?: '';
}

function crescendo_get_lead_client_ip() {
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR') as $key) {
        if (empty($_SERVER[$key])) {
            continue;
        }
        $ip = sanitize_text_field(wp_unslash($_SERVER[$key]));
        if (strpos($ip, ',') !== false) {
            $ip = trim(explode(',', $ip)[0]);
        }
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }
    }

    return '';
}

function crescendo_contact_form_is_honeypot_triggered() {
    return !empty($_POST['website']);
}

function crescendo_get_contact_rgpd_consent_version() {
    return '2026-07';
}

function crescendo_contact_form_has_rgpd_consent() {
    return !empty($_POST['rgpd_consent']) && (string) wp_unslash($_POST['rgpd_consent']) === '1';
}

function crescendo_get_lead_full_name($lead_id) {
    $prenom = get_post_meta($lead_id, 'lead_prenom', true);
    $nom = get_post_meta($lead_id, 'lead_nom', true);

    if ($prenom !== '' && $nom !== '') {
        return trim($prenom . ' ' . $nom);
    }

    return $nom ?: $prenom;
}

function crescendo_create_lead_key($lead_id) {
    return wp_hash('crescendo_lead_' . (int) $lead_id . wp_salt('auth'));
}

function crescendo_verify_lead_key($lead_id, $key) {
    if (!$lead_id || !$key) {
        return false;
    }

    return hash_equals(crescendo_create_lead_key($lead_id), (string) $key);
}

function crescendo_get_lead_projet_label($slug) {
    $options = crescendo_get_contact_projet_options();

    return $options[$slug] ?? $slug;
}

function crescendo_get_lead_upload_mimes() {
    return apply_filters('crescendo_lead_upload_mimes', array(
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ));
}

function crescendo_get_lead_upload_max_bytes() {
    return (int) apply_filters('crescendo_lead_upload_max_bytes', 5 * 1024 * 1024);
}

function crescendo_get_lead_upload_max_files() {
    return (int) apply_filters('crescendo_lead_upload_max_files', 5);
}

function crescendo_sanitize_lead_prestations($raw) {
    if (!is_array($raw)) {
        return array();
    }

    $options = crescendo_get_contact_projet_options();
    $labels = array();

    foreach ($raw as $slug) {
        $slug = sanitize_key($slug);
        if (isset($options[$slug])) {
            $labels[] = $options[$slug];
        }
    }

    return array_values(array_unique($labels));
}

function crescendo_upload_lead_file(array $file, $lead_id, $title = '') {
    if (empty($file['name']) || (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return new WP_Error('no_file', 'Aucun fichier.');
    }

    if ((int) $file['error'] !== UPLOAD_ERR_OK) {
        return new WP_Error('upload', 'Erreur lors du téléversement du fichier.');
    }

    if ((int) $file['size'] > crescendo_get_lead_upload_max_bytes()) {
        return new WP_Error('upload', 'Fichier trop volumineux (max 5 Mo).');
    }

    $check = wp_check_filetype_and_ext($file['tmp_name'], $file['name']);
    if (empty($check['type']) || !in_array($check['type'], crescendo_get_lead_upload_mimes(), true)) {
        return new WP_Error('upload', 'Type de fichier non autorisé.');
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $upload = wp_handle_upload($file, array('test_form' => false));
    if (!empty($upload['error'])) {
        return new WP_Error('upload', $upload['error']);
    }

    $attachment = array(
        'post_mime_type' => $upload['type'],
        'post_title' => $title !== '' ? $title : sanitize_file_name($file['name']),
        'post_content' => '',
        'post_status' => 'inherit',
        'post_parent' => (int) $lead_id,
    );

    $attach_id = wp_insert_attachment($attachment, $upload['file'], (int) $lead_id);
    if (is_wp_error($attach_id)) {
        return $attach_id;
    }

    $metadata = wp_generate_attachment_metadata($attach_id, $upload['file']);
    wp_update_attachment_metadata($attach_id, $metadata);

    return (int) $attach_id;
}

function crescendo_process_lead_uploads($lead_id) {
    $lead_id = (int) $lead_id;
    $attachment_ids = array();
    $errors = array();

    if (!empty($_FILES['logo']['name'])) {
        $entreprise = get_post_meta($lead_id, 'lead_entreprise', true);
        $result = crescendo_upload_lead_file(
            $_FILES['logo'],
            $lead_id,
            'Logo — ' . ($entreprise ?: get_the_title($lead_id))
        );

        if (is_wp_error($result)) {
            $errors[] = 'Logo : ' . $result->get_error_message();
        } else {
            $attachment_ids[] = $result;
        }
    }

    if (!empty($_FILES['attachments']['name']) && is_array($_FILES['attachments']['name'])) {
        $files = $_FILES['attachments'];
        $count = min(count($files['name']), crescendo_get_lead_upload_max_files());

        for ($i = 0; $i < $count; $i++) {
            if (empty($files['name'][$i])) {
                continue;
            }

            $file = array(
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i],
            );

            $result = crescendo_upload_lead_file($file, $lead_id);
            if (is_wp_error($result)) {
                $errors[] = sanitize_file_name($files['name'][$i]) . ' : ' . $result->get_error_message();
            } else {
                $attachment_ids[] = $result;
            }
        }
    }

    if (!empty($attachment_ids)) {
        $existing = get_post_meta($lead_id, 'lead_attachment_ids', true);
        if (!is_array($existing)) {
            $existing = array();
        }
        update_post_meta($lead_id, 'lead_attachment_ids', array_values(array_unique(array_merge($existing, $attachment_ids))));
    }

    return $errors;
}

function crescendo_get_lead_attachment_paths($lead_id) {
    $ids = get_post_meta($lead_id, 'lead_attachment_ids', true);
    if (!is_array($ids)) {
        return array();
    }

    $paths = array();
    foreach ($ids as $id) {
        $path = get_attached_file((int) $id);
        if ($path && file_exists($path)) {
            $paths[] = $path;
        }
    }

    return $paths;
}

function crescendo_format_lead_attachments_summary($lead_id) {
    $ids = get_post_meta($lead_id, 'lead_attachment_ids', true);
    if (!is_array($ids) || empty($ids)) {
        return '';
    }

    $lines = array();
    foreach ($ids as $id) {
        $url = wp_get_attachment_url((int) $id);
        $title = get_the_title((int) $id);
        if ($url) {
            $lines[] = ($title ?: 'Fichier') . ' : ' . $url;
        }
    }

    return implode("\n", $lines);
}

function crescendo_format_lead_summary($lead_id) {
    $lines = array();
    $map = array(
        'Prénom' => get_post_meta($lead_id, 'lead_prenom', true),
        'Nom' => get_post_meta($lead_id, 'lead_nom', true),
        'Email' => get_post_meta($lead_id, 'lead_email', true),
        'Entreprise' => get_post_meta($lead_id, 'lead_entreprise', true),
        'Téléphone' => get_post_meta($lead_id, 'lead_telephone', true),
        'Prestations' => get_post_meta($lead_id, 'lead_prestations', true) ?: crescendo_get_lead_projet_label(get_post_meta($lead_id, 'lead_projet', true)),
        'Besoin' => get_post_meta($lead_id, 'lead_besoin', true),
        'Source' => get_post_meta($lead_id, 'lead_source', true),
        'Page source' => get_post_meta($lead_id, 'lead_source_url', true),
        'Consentement RGPD' => get_post_meta($lead_id, 'lead_rgpd_consent', true) ? 'Oui' : '',
        'Date consentement RGPD' => get_post_meta($lead_id, 'lead_rgpd_consent_date', true),
    );

    foreach ($map as $label => $value) {
        if ($value !== '') {
            $lines[] = $label . ' : ' . $value;
        }
    }

    $attribution = crescendo_format_lead_attribution_summary($lead_id);
    if ($attribution !== '') {
        $lines[] = '';
        $lines[] = '--- Acquisition ---';
        $lines[] = $attribution;
    }

    return implode("\n", $lines);
}

function crescendo_format_lead_step2_summary($lead_id) {
    $labels = array(
        'lead_secteur_activite' => 'Secteur d\'activité',
        'lead_site_existant' => 'Site existant',
        'lead_site_etat' => 'État du site',
        'lead_charte' => 'Charte graphique',
        'lead_charte_details' => 'Détails charte / identité',
        'lead_objectifs' => 'Objectifs principaux',
        'lead_pages' => 'Pages / sections prévues',
        'lead_fonctionnalites' => 'Fonctionnalités souhaitées',
        'lead_contenu_pret' => 'Contenu prêt',
        'lead_budget' => 'Budget',
        'lead_delai' => 'Délai souhaité',
        'lead_references' => 'Références / sites inspirants',
        'lead_commentaires' => 'Commentaires',
    );

    $lines = array();
    foreach ($labels as $key => $label) {
        $value = get_post_meta($lead_id, $key, true);
        if ($value !== '') {
            $lines[] = $label . ' : ' . $value;
        }
    }

    return implode("\n", $lines);
}

function crescendo_send_lead_notification($lead_id, $subject_prefix, $body_intro) {
    $to = apply_filters('crescendo_lead_notify_email', CRESCENDO_LEAD_NOTIFY_EMAIL);
    $full_name = crescendo_get_lead_full_name($lead_id);
    $entreprise = get_post_meta($lead_id, 'lead_entreprise', true);
    $channel = get_post_meta($lead_id, 'lead_channel', true);
    if ($channel !== '') {
        $subject = sprintf('[%s] [%s] %s — %s', crescendo_brand_name(), $channel, $subject_prefix, $entreprise ?: $full_name);
    } else {
        $subject = sprintf('[%s] %s — %s', crescendo_brand_name(), $subject_prefix, $entreprise ?: $full_name);
    }
    $body = $body_intro . "\n\n";
    $body .= crescendo_format_lead_summary($lead_id);

    if (get_post_meta($lead_id, 'lead_step2_completed', true)) {
        $step2 = crescendo_format_lead_step2_summary($lead_id);
        if ($step2 !== '') {
            $body .= "\n\n--- Précisions projet ---\n" . $step2;
        }

        $attachments_summary = crescendo_format_lead_attachments_summary($lead_id);
        if ($attachments_summary !== '') {
            $body .= "\n\n--- Fichiers joints ---\n" . $attachments_summary;
        }
    }

    $body .= "\n\nVoir en back-office : " . admin_url('post.php?post=' . $lead_id . '&action=edit');

    $headers = array('Content-Type: text/plain; charset=UTF-8');
    $mail_attachments = array();

    if (get_post_meta($lead_id, 'lead_step2_completed', true)) {
        $mail_attachments = crescendo_get_lead_attachment_paths($lead_id);
    }

    return wp_mail($to, $subject, $body, $headers, $mail_attachments);
}

function crescendo_save_lead_meta($lead_id, array $data) {
    foreach ($data as $key => $value) {
        if (strpos($key, 'lead_') !== 0) {
            $key = 'lead_' . $key;
        }
        update_post_meta($lead_id, $key, $value);
    }
}

function crescendo_contact_form_is_rate_limited() {
    $ip = crescendo_get_lead_client_ip();
    if ($ip === '') {
        return false;
    }

    $key = 'crescendo_lead_rate_' . md5($ip);
    $attempts = (int) get_transient($key);

    return $attempts >= 8;
}

function crescendo_contact_form_register_attempt() {
    $ip = crescendo_get_lead_client_ip();
    if ($ip === '') {
        return;
    }

    $key = 'crescendo_lead_rate_' . md5($ip);
    $attempts = (int) get_transient($key);
    set_transient($key, $attempts + 1, 15 * MINUTE_IN_SECONDS);
}

function crescendo_contact_form_step1_callback() {
    check_ajax_referer('crescendo_contact_form', 'nonce');

    if (crescendo_contact_form_is_honeypot_triggered()) {
        wp_send_json(array('status' => 200, 'message' => 'OK'));
    }

    if (crescendo_contact_form_is_rate_limited()) {
        wp_send_json(array(
            'status' => 429,
            'message' => 'Trop de demandes envoyées récemment. Merci de réessayer dans quelques minutes ou de nous écrire par email.',
        ));
    }

    $prenom = sanitize_text_field(wp_unslash($_POST['prenom'] ?? ''));
    $nom = sanitize_text_field(wp_unslash($_POST['nom'] ?? ''));
    $email = crescendo_sanitize_lead_email($_POST['email'] ?? '');
    $entreprise = sanitize_text_field(wp_unslash($_POST['entreprise'] ?? ''));
    $telephone = crescendo_sanitize_lead_phone($_POST['telephone'] ?? '');
    $besoin = crescendo_sanitize_lead_text($_POST['besoin'] ?? '', 2000);
    $source = sanitize_text_field(wp_unslash($_POST['source'] ?? ''));
    $source_url = crescendo_sanitize_lead_url($_POST['source_url'] ?? '');
    $prestation_slugs = crescendo_get_lead_prestation_slugs_from_post();
    $prestation_labels = crescendo_sanitize_lead_prestations($prestation_slugs);
    $rgpd_consent_version = sanitize_text_field(wp_unslash($_POST['rgpd_consent_version'] ?? ''));

    if ($prenom === '' || $nom === '' || $email === '' || !is_email($email) || $entreprise === '' || empty($prestation_slugs)) {
        wp_send_json(array(
            'status' => 400,
            'message' => 'Merci de renseigner votre prénom, nom, email, entreprise et au moins une prestation.',
        ));
    }

    if (!crescendo_contact_form_has_rgpd_consent()) {
        wp_send_json(array(
            'status' => 400,
            'message' => 'Vous devez accepter le traitement de vos données pour envoyer votre demande.',
        ));
    }

    if ($rgpd_consent_version !== crescendo_get_contact_rgpd_consent_version()) {
        wp_send_json(array(
            'status' => 400,
            'message' => 'La page a expiré. Merci de recharger la page avant d\'envoyer le formulaire.',
        ));
    }

    if ($besoin === '' && $source !== '') {
        $besoin = 'Demande depuis : ' . $source;
    }

    if ($besoin === '') {
        wp_send_json(array(
            'status' => 400,
            'message' => 'Merci de décrire brièvement votre besoin.',
        ));
    }

    $title = trim($entreprise . ' — ' . $prenom . ' ' . $nom);
    $lead_id = wp_insert_post(array(
        'post_type' => 'crescendo_lead',
        'post_status' => 'publish',
        'post_title' => $title,
    ), true);

    if (is_wp_error($lead_id)) {
        wp_send_json(array(
            'status' => 500,
            'message' => 'Une erreur est survenue. Merci de réessayer ou de nous contacter par email.',
        ));
    }

    crescendo_save_lead_meta($lead_id, array_merge(array(
        'lead_prenom' => $prenom,
        'lead_nom' => $nom,
        'lead_email' => $email,
        'lead_entreprise' => $entreprise,
        'lead_telephone' => $telephone,
        'lead_projet' => $prestation_slugs[0],
        'lead_prestations' => implode(', ', $prestation_labels),
        'lead_besoin' => $besoin,
        'lead_source' => $source,
        'lead_source_url' => $source_url,
        'lead_step2_completed' => '0',
        'lead_ip' => crescendo_get_lead_client_ip(),
        'lead_rgpd_consent' => '1',
        'lead_rgpd_consent_date' => current_time('mysql'),
        'lead_rgpd_consent_version' => $rgpd_consent_version,
    ), crescendo_get_lead_attribution_from_post()));

    crescendo_send_lead_notification($lead_id, 'Nouvelle demande', 'Nouvelle demande de contact reçue.');
    crescendo_contact_form_register_attempt();

    wp_send_json(array(
        'status' => 200,
        'message' => 'Merci ! Quelques précisions supplémentaires nous aideront à mieux cadrer votre projet.',
        'lead_id' => (int) $lead_id,
        'lead_key' => crescendo_create_lead_key($lead_id),
    ));
}
add_action('wp_ajax_crescendo_contact_step1', 'crescendo_contact_form_step1_callback');
add_action('wp_ajax_nopriv_crescendo_contact_step1', 'crescendo_contact_form_step1_callback');

function crescendo_contact_form_step2_callback() {
    check_ajax_referer('crescendo_contact_form', 'nonce');

    if (crescendo_contact_form_is_honeypot_triggered()) {
        wp_send_json(array('status' => 200, 'message' => 'OK'));
    }

    if (crescendo_contact_form_is_rate_limited()) {
        wp_send_json(array(
            'status' => 429,
            'message' => 'Trop de demandes envoyées récemment. Merci de réessayer dans quelques minutes ou de nous écrire par email.',
        ));
    }

    $lead_id = (int) ($_POST['lead_id'] ?? 0);
    $lead_key = sanitize_text_field(wp_unslash($_POST['lead_key'] ?? ''));

    if (!crescendo_verify_lead_key($lead_id, $lead_key) || get_post_type($lead_id) !== 'crescendo_lead') {
        wp_send_json(array(
            'status' => 403,
            'message' => 'Session expirée. Merci de renvoyer le formulaire initial.',
        ));
    }

    $site_etat_options = crescendo_get_contact_site_etat_options();
    $charte_options = crescendo_get_contact_charte_options();
    $contenu_options = crescendo_get_contact_contenu_options();
    $budget_options = crescendo_get_contact_budget_options();
    $delai_options = crescendo_get_contact_delai_options();

    $site_etat = sanitize_key($_POST['site_etat'] ?? '');
    $charte = sanitize_key($_POST['charte'] ?? '');
    $contenu_pret = sanitize_key($_POST['contenu_pret'] ?? '');
    $budget = sanitize_text_field(wp_unslash($_POST['budget'] ?? ''));
    $delai = sanitize_text_field(wp_unslash($_POST['delai'] ?? ''));

    $meta = array(
        'lead_secteur_activite' => sanitize_text_field(wp_unslash($_POST['secteur_activite'] ?? '')),
        'lead_site_existant' => crescendo_sanitize_lead_url($_POST['site_existant'] ?? ''),
        'lead_site_etat' => isset($site_etat_options[$site_etat]) ? ($site_etat_options[$site_etat] ?: '') : '',
        'lead_charte' => isset($charte_options[$charte]) ? ($charte_options[$charte] ?: '') : '',
        'lead_charte_details' => crescendo_sanitize_lead_text($_POST['charte_details'] ?? '', 2000),
        'lead_objectifs' => crescendo_sanitize_lead_text($_POST['objectifs'] ?? '', 2000),
        'lead_pages' => sanitize_text_field(wp_unslash($_POST['pages'] ?? '')),
        'lead_fonctionnalites' => crescendo_sanitize_lead_text($_POST['fonctionnalites'] ?? '', 2000),
        'lead_contenu_pret' => isset($contenu_options[$contenu_pret]) ? ($contenu_options[$contenu_pret] ?: '') : '',
        'lead_budget' => isset($budget_options[$budget]) ? ($budget_options[$budget] ?: '') : '',
        'lead_delai' => isset($delai_options[$delai]) ? ($delai_options[$delai] ?: '') : '',
        'lead_references' => crescendo_sanitize_lead_text($_POST['references'] ?? '', 2000),
        'lead_commentaires' => crescendo_sanitize_lead_text($_POST['commentaires'] ?? '', 2000),
        'lead_step2_completed' => '1',
    );

    crescendo_save_lead_meta($lead_id, $meta);

    $upload_errors = crescendo_process_lead_uploads($lead_id);

    crescendo_send_lead_notification($lead_id, 'Projet précisé', 'Le prospect a complété les informations sur son projet.');
    crescendo_contact_form_register_attempt();

    $message = 'Merci ! Votre projet est bien enregistré. Nous revenons vers vous rapidement.';
    if (!empty($upload_errors)) {
        $message .= ' Certains fichiers n\'ont pas pu être envoyés : ' . implode(' ', $upload_errors);
    }

    wp_send_json(array(
        'status' => 200,
        'message' => $message,
        'redirect_url' => crescendo_get_contact_thank_you_url(),
    ));
}
add_action('wp_ajax_crescendo_contact_step2', 'crescendo_contact_form_step2_callback');
add_action('wp_ajax_nopriv_crescendo_contact_step2', 'crescendo_contact_form_step2_callback');

function crescendo_render_prestation_tags(array $args = array()) {
    $args = wp_parse_args($args, array(
        'legend' => 'Type de projet',
        'hint' => 'Plusieurs choix possibles',
        'required' => false,
        'wrapper_class' => 'home-form__full',
        'default_values' => array(),
    ));

    set_query_var('crescendo_prestation_tags_args', $args);
    get_template_part('template-parts/general/block', 'contact-form-prestation-tags');
}

function crescendo_get_lead_prestation_slugs_from_post() {
    $options = crescendo_get_contact_projet_options();
    $slugs = array();

    if (!empty($_POST['prestations']) && is_array($_POST['prestations'])) {
        foreach ($_POST['prestations'] as $slug) {
            $slug = sanitize_key($slug);
            if (isset($options[$slug])) {
                $slugs[] = $slug;
            }
        }
    } elseif (!empty($_POST['projet'])) {
        $slug = sanitize_key($_POST['projet']);
        if (isset($options[$slug])) {
            $slugs[] = $slug;
        }
    }

    return array_values(array_unique($slugs));
}

function crescendo_render_contact_form(array $args = array()) {
    $args = wp_parse_args($args, array(
        'title' => '',
        'intro' => '',
        'variant' => 'default',
        'source' => '',
        'source_url' => '',
        'projet_default' => '',
        'submit_label' => 'Envoyer ma demande',
        'wrapper_class' => '',
        'form_shortcode' => '',
    ));

    if ($args['source'] === '' && is_singular()) {
        $args['source'] = get_the_title();
    }
    if ($args['source_url'] === '') {
        $args['source_url'] = is_singular() ? get_permalink() : home_url(add_query_arg(array()));
    }

    if (!empty($args['form_shortcode'])) {
        echo do_shortcode($args['form_shortcode']);
        return;
    }

    $shell_classes = array('crescendo-contact-form-shell');
    if ($args['wrapper_class']) {
        $shell_classes[] = $args['wrapper_class'];
    }

    echo '<div class="' . esc_attr(implode(' ', $shell_classes)) . '">';

    if ($args['title']) {
        echo '<h2 class="crescendo-contact-form-shell__title">' . esc_html($args['title']) . '</h2>';
    }

    if ($args['intro']) {
        echo '<p class="crescendo-contact-form-shell__intro">' . esc_html($args['intro']) . '</p>';
    }

    set_query_var('crescendo_contact_form_args', $args);
    get_template_part('template-parts/general/block', 'contact-form');

    echo '</div>';
}

function crescendo_render_contact_form_modal() {
    static $rendered = false;
    if ($rendered) {
        return;
    }
    $rendered = true;
    get_template_part('template-parts/general/block', 'contact-form-modal');
}

function crescendo_lead_admin_columns($columns) {
    $new = array();
    foreach ($columns as $key => $label) {
        $new[$key] = $label;
        if ($key === 'title') {
            $new['lead_email'] = 'Email';
            $new['lead_channel'] = 'Canal';
            $new['lead_projet'] = 'Projet';
            $new['lead_step2'] = 'Détails';
        }
    }

    return $new;
}
add_filter('manage_crescendo_lead_posts_columns', 'crescendo_lead_admin_columns');

function crescendo_lead_admin_column_content($column, $post_id) {
    switch ($column) {
        case 'lead_email':
            echo esc_html(get_post_meta($post_id, 'lead_email', true));
            break;
        case 'lead_channel':
            $channel = get_post_meta($post_id, 'lead_channel', true);
            echo esc_html($channel ? crescendo_get_lead_channel_label($channel) : '—');
            break;
        case 'lead_projet':
            $prestations = get_post_meta($post_id, 'lead_prestations', true);
            echo esc_html($prestations ?: crescendo_get_lead_projet_label(get_post_meta($post_id, 'lead_projet', true)));
            break;
        case 'lead_step2':
            echo get_post_meta($post_id, 'lead_step2_completed', true) ? '✓ Complet' : '— Étape 1';
            break;
    }
}
add_action('manage_crescendo_lead_posts_custom_column', 'crescendo_lead_admin_column_content', 10, 2);

function crescendo_lead_admin_meta_box() {
    add_meta_box(
        'crescendo_lead_details',
        'Détails de la demande',
        'crescendo_render_lead_admin_meta_box',
        'crescendo_lead',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'crescendo_lead_admin_meta_box');

function crescendo_render_lead_admin_meta_box($post) {
    $sections = array(
        'Contact' => array(
            'lead_prenom' => 'Prénom',
            'lead_nom' => 'Nom',
            'lead_email' => 'Email',
            'lead_entreprise' => 'Entreprise',
            'lead_telephone' => 'Téléphone',
            'lead_prestations' => 'Prestations',
            'lead_projet' => 'Prestation principale',
            'lead_besoin' => 'Besoin',
            'lead_source' => 'Source',
            'lead_source_url' => 'URL source',
        ),
        'Acquisition' => array(
            'lead_channel' => 'Canal',
            'lead_utm_source' => 'UTM source',
            'lead_utm_medium' => 'UTM medium',
            'lead_utm_campaign' => 'UTM campaign',
            'lead_utm_term' => 'UTM term',
            'lead_utm_content' => 'UTM content',
            'lead_gclid' => 'GCLID',
            'lead_msclkid' => 'MSCLKID',
            'lead_landing_page' => 'Landing page',
            'lead_referrer' => 'Referrer',
        ),
        'Conformité' => array(
            'lead_rgpd_consent' => 'Consentement RGPD',
            'lead_rgpd_consent_date' => 'Date consentement RGPD',
            'lead_rgpd_consent_version' => 'Version consentement RGPD',
        ),
        'Projet détaillé' => array(
            'lead_secteur_activite' => 'Secteur',
            'lead_site_existant' => 'Site existant',
            'lead_site_etat' => 'État site',
            'lead_charte' => 'Charte',
            'lead_charte_details' => 'Détails charte',
            'lead_objectifs' => 'Objectifs',
            'lead_pages' => 'Pages',
            'lead_fonctionnalites' => 'Fonctionnalités',
            'lead_prestations' => 'Prestations souhaitées',
            'lead_contenu_pret' => 'Contenu prêt',
            'lead_budget' => 'Budget',
            'lead_delai' => 'Délai',
            'lead_references' => 'Références',
            'lead_commentaires' => 'Commentaires',
        ),
    );

    foreach ($sections as $heading => $fields) {
        echo '<h3 style="margin:1.5em 0 .5em;">' . esc_html($heading) . '</h3>';
        echo '<table class="widefat striped"><tbody>';
        foreach ($fields as $key => $label) {
            $value = get_post_meta($post->ID, $key, true);
            if ($key === 'lead_projet') {
                $value = crescendo_get_lead_projet_label($value);
            }
            if ($key === 'lead_channel') {
                $value = crescendo_get_lead_channel_label($value);
            }
            if ($key === 'lead_rgpd_consent') {
                $value = $value ? 'Oui' : '';
            }
            if ($value === '') {
                continue;
            }
            echo '<tr><th style="width:180px;">' . esc_html($label) . '</th><td>' . nl2br(esc_html($value)) . '</td></tr>';
        }
        echo '</tbody></table>';
    }

    $attachment_ids = get_post_meta($post->ID, 'lead_attachment_ids', true);
    if (is_array($attachment_ids) && !empty($attachment_ids)) {
        echo '<h3 style="margin:1.5em 0 .5em;">Fichiers joints</h3>';
        echo '<ul style="margin:0;padding-left:1.2em;">';
        foreach ($attachment_ids as $attachment_id) {
            $url = wp_get_attachment_url((int) $attachment_id);
            $title = get_the_title((int) $attachment_id);
            if (!$url) {
                continue;
            }
            echo '<li><a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer">' . esc_html($title ?: 'Fichier') . '</a></li>';
        }
        echo '</ul>';
    }
}
