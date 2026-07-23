<?php

function crescendo_import_contact_from_array(array $data) {
    if (empty($data['page']['title']) || empty($data['page']['slug'])) {
        return new WP_Error('missing_page', 'Le JSON doit contenir page.title et page.slug.');
    }

    $slug = sanitize_title($data['page']['slug']);
    $existing = get_page_by_path($slug, OBJECT, 'page');

    $pageArgs = array(
        'post_title' => sanitize_text_field($data['page']['title']),
        'post_name' => $slug,
        'post_type' => 'page',
        'post_status' => sanitize_key($data['page']['status'] ?? 'publish'),
        'post_content' => wp_kses_post($data['page']['content'] ?? ''),
        'menu_order' => (int) ($data['page']['menu_order'] ?? 0),
        'page_template' => 'template-contact.php',
    );

    if ($existing) {
        $pageArgs['ID'] = $existing->ID;
        $post_id = wp_update_post($pageArgs, true);
    } else {
        $post_id = wp_insert_post($pageArgs, true);
    }

    if (is_wp_error($post_id)) {
        return $post_id;
    }

    if (!empty($data['seo']) && is_array($data['seo'])) {
        foreach ($data['seo'] as $key => $value) {
            $field = 'contact-seo-' . str_replace('_', '-', sanitize_key($key));
            update_field($field, $value, $post_id);
        }
    }

    if (!empty($data['fields']) && is_array($data['fields'])) {
        foreach ($data['fields'] as $field => $value) {
            if (strpos($field, 'contact-') !== 0) {
                continue;
            }
            update_field($field, $value, $post_id);
        }
    }

    return array(
        'post_id' => $post_id,
        'edit_url' => get_edit_post_link($post_id, 'raw'),
        'view_url' => get_permalink($post_id),
        'updated' => (bool) $existing,
    );
}

function crescendo_import_contact_from_json_file($file_path) {
    if (!file_exists($file_path)) {
        return new WP_Error('missing_file', 'Fichier introuvable : ' . $file_path);
    }

    $raw = file_get_contents($file_path);
    $data = json_decode($raw, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return new WP_Error('invalid_json', 'JSON invalide : ' . json_last_error_msg());
    }

    return crescendo_import_contact_from_array($data);
}

function crescendo_get_contact_import_dir() {
    return crescendo_get_content_import_dir('contact/');
}

function crescendo_list_contact_import_files() {
    $dir = crescendo_get_contact_import_dir();
    if (!is_dir($dir)) {
        return array();
    }

    $files = glob($dir . '*.json') ?: array();
    $files = array_filter($files, function ($file) {
        return basename($file) !== '_schema.json';
    });

    sort($files);
    return array_values($files);
}

function crescendo_register_contact_import_page() {
    add_management_page(
        'Import page Contact',
        'Import Contact JSON',
        'manage_options',
        'crescendo-contact-import',
        'crescendo_render_contact_import_page'
    );
}
add_action('admin_menu', 'crescendo_register_contact_import_page');

function crescendo_render_contact_import_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $messages = array();

    if (!empty($_POST['crescendo_import_nonce']) && wp_verify_nonce($_POST['crescendo_import_nonce'], 'crescendo_import_contact')) {
        if (!empty($_POST['import_file'])) {
            $file = sanitize_text_field(wp_unslash($_POST['import_file']));
            $allowed = crescendo_list_contact_import_files();
            if (in_array($file, $allowed, true)) {
                $result = crescendo_import_contact_from_json_file($file);
                if (is_wp_error($result)) {
                    $messages[] = array('type' => 'error', 'text' => $result->get_error_message());
                } else {
                    $action = $result['updated'] ? 'mise à jour' : 'création';
                    $messages[] = array(
                        'type' => 'success',
                        'text' => sprintf(
                            'Page %s réussie (ID %d). <a href="%s">Voir</a> · <a href="%s">Modifier</a>',
                            $action,
                            $result['post_id'],
                            esc_url($result['view_url']),
                            esc_url($result['edit_url'])
                        ),
                    );
                }
            }
        }

        if (!empty($_FILES['json_upload']['tmp_name']) && is_uploaded_file($_FILES['json_upload']['tmp_name'])) {
            $filename = sanitize_file_name(wp_unslash($_FILES['json_upload']['name'] ?? ''));
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            if ($extension !== 'json') {
                $messages[] = array('type' => 'error', 'text' => 'Seuls les fichiers .json sont acceptés.');
            } else {
                $raw = file_get_contents($_FILES['json_upload']['tmp_name']);
                $data = json_decode($raw, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $messages[] = array('type' => 'error', 'text' => 'JSON invalide : ' . json_last_error_msg());
                } else {
                    $result = crescendo_import_contact_from_array($data);
                    if (is_wp_error($result)) {
                        $messages[] = array('type' => 'error', 'text' => $result->get_error_message());
                    } else {
                        $action = $result['updated'] ? 'mise à jour' : 'création';
                        $messages[] = array(
                            'type' => 'success',
                            'text' => sprintf(
                                'Import %s réussi (ID %d). <a href="%s">Voir</a> · <a href="%s">Modifier</a>',
                                $action,
                                $result['post_id'],
                                esc_url($result['view_url']),
                                esc_url($result['edit_url'])
                            ),
                        );
                    }
                }
            }
        }
    }

    $files = crescendo_list_contact_import_files();
    ?>
    <div class="wrap">
        <h1>Import page Contact (JSON)</h1>
        <p>Importez la page contact depuis un fichier JSON. Dossier : <code><?php echo esc_html(crescendo_get_contact_import_dir()); ?></code></p>

        <?php foreach ($messages as $message) : ?>
            <div class="notice notice-<?php echo esc_attr($message['type']); ?> is-dismissible"><p><?php echo wp_kses_post($message['text']); ?></p></div>
        <?php endforeach; ?>

        <h2>Fichiers disponibles</h2>
        <?php if (empty($files)) : ?>
            <p>Aucun fichier JSON trouvé. Ajoutez des fichiers dans <code>content-import/contact/</code>.</p>
        <?php else : ?>
            <table class="widefat striped">
                <thead><tr><th>Fichier</th><th>Action</th></tr></thead>
                <tbody>
                <?php foreach ($files as $file) : ?>
                    <tr>
                        <td><code><?php echo esc_html(basename($file)); ?></code></td>
                        <td>
                            <form method="post">
                                <?php wp_nonce_field('crescendo_import_contact', 'crescendo_import_nonce'); ?>
                                <input type="hidden" name="import_file" value="<?php echo esc_attr($file); ?>">
                                <?php submit_button('Importer', 'primary', 'submit', false); ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <h2>Uploader un JSON</h2>
        <form method="post" enctype="multipart/form-data">
            <?php wp_nonce_field('crescendo_import_contact', 'crescendo_import_nonce'); ?>
            <input type="file" name="json_upload" accept=".json,application/json" required>
            <?php submit_button('Importer le fichier'); ?>
        </form>
    </div>
    <?php
}

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('crescendo import-contact', function ($args) {
        $file = $args[0] ?? '';
        if (!$file) {
            WP_CLI::error('Usage: wp crescendo import-contact path/to/file.json');
        }
        $result = crescendo_import_contact_from_json_file($file);
        if (is_wp_error($result)) {
            WP_CLI::error($result->get_error_message());
        }
        WP_CLI::success('Page importée (ID ' . $result['post_id'] . ')');
    });
}
