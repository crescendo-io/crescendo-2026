<?php

function crescendo_import_project_from_array(array $data) {
    if (empty($data['page']['title']) || empty($data['page']['slug'])) {
        return new WP_Error('missing_page', 'Le JSON doit contenir page.title et page.slug.');
    }

    $slug = sanitize_title($data['page']['slug']);
    $parentSlug = sanitize_title($data['page']['parent'] ?? 'realisations');
    $parent = get_page_by_path($parentSlug, OBJECT, 'page');
    $path = $parent ? $parentSlug . '/' . $slug : $slug;
    $existing = get_page_by_path($path, OBJECT, 'page');

    $pageArgs = array(
        'post_title' => sanitize_text_field($data['page']['title']),
        'post_name' => $slug,
        'post_type' => 'page',
        'post_status' => sanitize_key($data['page']['status'] ?? 'publish'),
        'post_content' => wp_kses_post($data['page']['content'] ?? ''),
        'menu_order' => (int) ($data['page']['menu_order'] ?? 0),
        'page_template' => 'template-project.php',
    );

    if ($parent) {
        $pageArgs['post_parent'] = $parent->ID;
    }

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
            $field = 'project-seo-' . str_replace('_', '-', sanitize_key($key));
            update_field($field, $value, $post_id);
        }
    }

    if (!empty($data['fields']) && is_array($data['fields'])) {
        foreach ($data['fields'] as $field => $value) {
            if (strpos($field, 'project-') !== 0) {
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

function crescendo_import_project_from_json_file($file_path) {
    if (!file_exists($file_path)) {
        return new WP_Error('missing_file', 'Fichier introuvable : ' . $file_path);
    }

    $raw = file_get_contents($file_path);
    $data = json_decode($raw, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return new WP_Error('invalid_json', 'JSON invalide : ' . json_last_error_msg());
    }

    return crescendo_import_project_from_array($data);
}

function crescendo_get_project_import_dir() {
    return crescendo_get_content_import_dir('projets/');
}

function crescendo_list_project_import_files() {
    $dir = crescendo_get_project_import_dir();
    if (!is_dir($dir)) {
        return array();
    }

    $files = glob($dir . '*.json') ?: array();
    $files = array_filter($files, function ($file) {
        $base = basename($file);
        return $base !== '_schema.json';
    });

    sort($files);
    return array_values($files);
}

function crescendo_register_project_import_page() {
    add_management_page(
        'Import fiches Projet',
        'Import Projet JSON',
        'manage_options',
        'crescendo-project-import',
        'crescendo_render_project_import_page'
    );
}
add_action('admin_menu', 'crescendo_register_project_import_page');

function crescendo_render_project_import_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $messages = array();

    if (!empty($_POST['crescendo_import_nonce']) && wp_verify_nonce($_POST['crescendo_import_nonce'], 'crescendo_import_project')) {
        if (!empty($_POST['import_all'])) {
            foreach (crescendo_list_project_import_files() as $file) {
                $result = crescendo_import_project_from_json_file($file);
                if (is_wp_error($result)) {
                    $messages[] = array('type' => 'error', 'text' => basename($file) . ' : ' . $result->get_error_message());
                } else {
                    $messages[] = array(
                        'type' => 'success',
                        'text' => sprintf('%s importé (ID %d). <a href="%s">Voir</a>', basename($file), $result['post_id'], esc_url($result['view_url'])),
                    );
                }
            }
        }

        if (!empty($_POST['import_file'])) {
            $file = sanitize_text_field(wp_unslash($_POST['import_file']));
            $allowed = crescendo_list_project_import_files();
            if (in_array($file, $allowed, true)) {
                $result = crescendo_import_project_from_json_file($file);
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
            $raw = file_get_contents($_FILES['json_upload']['tmp_name']);
            $data = json_decode($raw, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $messages[] = array('type' => 'error', 'text' => 'JSON invalide : ' . json_last_error_msg());
            } else {
                $result = crescendo_import_project_from_array($data);
                if (is_wp_error($result)) {
                    $messages[] = array('type' => 'error', 'text' => $result->get_error_message());
                } else {
                    $messages[] = array(
                        'type' => 'success',
                        'text' => sprintf('Import réussi (ID %d). <a href="%s">Voir</a>', $result['post_id'], esc_url($result['view_url'])),
                    );
                }
            }
        }
    }

    $files = crescendo_list_project_import_files();
    ?>
    <div class="wrap">
        <h1>Import fiches Projet (JSON)</h1>
        <p>Importez les fiches projet sous <code>/realisations/{slug}/</code>. Dossier : <code><?php echo esc_html(crescendo_get_project_import_dir()); ?></code></p>
        <p><strong>Prérequis :</strong> la page parente <code>realisations</code> doit exister avant l'import.</p>

        <?php foreach ($messages as $message) : ?>
            <div class="notice notice-<?php echo esc_attr($message['type']); ?> is-dismissible"><p><?php echo wp_kses_post($message['text']); ?></p></div>
        <?php endforeach; ?>

        <?php if (!empty($files)) : ?>
            <form method="post" style="margin-bottom: 1.5rem;">
                <?php wp_nonce_field('crescendo_import_project', 'crescendo_import_nonce'); ?>
                <input type="hidden" name="import_all" value="1">
                <?php submit_button('Importer tous les projets', 'primary', 'submit', false); ?>
            </form>
        <?php endif; ?>

        <h2>Fichiers disponibles</h2>
        <?php if (empty($files)) : ?>
            <p>Aucun fichier JSON trouvé. Ajoutez des fichiers dans <code>content-import/projets/</code>.</p>
        <?php else : ?>
            <table class="widefat striped">
                <thead><tr><th>Fichier</th><th>Action</th></tr></thead>
                <tbody>
                <?php foreach ($files as $file) : ?>
                    <tr>
                        <td><code><?php echo esc_html(basename($file)); ?></code></td>
                        <td>
                            <form method="post">
                                <?php wp_nonce_field('crescendo_import_project', 'crescendo_import_nonce'); ?>
                                <input type="hidden" name="import_file" value="<?php echo esc_attr($file); ?>">
                                <?php submit_button('Importer', 'secondary', 'submit', false); ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('crescendo import-project', function ($args, $assoc_args) {
        if (!empty($assoc_args['all'])) {
            foreach (crescendo_list_project_import_files() as $file) {
                $result = crescendo_import_project_from_json_file($file);
                if (is_wp_error($result)) {
                    WP_CLI::warning(basename($file) . ' : ' . $result->get_error_message());
                } else {
                    WP_CLI::success(basename($file) . ' → ID ' . $result['post_id']);
                }
            }
            return;
        }

        $file = $args[0] ?? '';
        if (!$file) {
            WP_CLI::error('Usage: wp crescendo import-project file.json [--all]');
        }
        $result = crescendo_import_project_from_json_file($file);
        if (is_wp_error($result)) {
            WP_CLI::error($result->get_error_message());
        }
        WP_CLI::success('Page importée (ID ' . $result['post_id'] . ')');
    });
}
