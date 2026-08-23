<?php

function crescendo_import_landing_from_array(array $data) {
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
        'page_template' => 'template-landing.php',
        'post_parent' => 0,
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

    update_post_meta($post_id, '_wp_page_template', 'template-landing.php');

    if (!empty($data['seo']) && is_array($data['seo'])) {
        foreach ($data['seo'] as $key => $value) {
            $field = 'landing-seo-' . str_replace('_', '-', sanitize_key($key));
            update_field($field, $value, $post_id);
        }
    }

    if (!empty($data['fields']) && is_array($data['fields'])) {
        foreach ($data['fields'] as $field => $value) {
            if (strpos($field, 'landing-') !== 0) {
                continue;
            }
            update_field($field, $value, $post_id);
        }
    }

    if (function_exists('crescendo_get_canonical_url')) {
        update_field('landing-seo-canonical', crescendo_get_canonical_url($post_id), $post_id);
    }

    return array(
        'post_id' => $post_id,
        'edit_url' => get_edit_post_link($post_id, 'raw'),
        'view_url' => get_permalink($post_id),
        'updated' => (bool) $existing,
    );
}

function crescendo_import_landing_from_json_file($file_path) {
    if (!file_exists($file_path)) {
        return new WP_Error('missing_file', 'Fichier introuvable : ' . $file_path);
    }

    $raw = file_get_contents($file_path);
    $data = json_decode($raw, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return new WP_Error('invalid_json', 'JSON invalide : ' . json_last_error_msg());
    }

    return crescendo_import_landing_from_array($data);
}

function crescendo_get_landing_import_file() {
    return crescendo_find_content_import_file('landing', 'creation-site-sea.json');
}

function crescendo_register_landing_import_page() {
    add_management_page(
        'Import Landing SEA',
        'Import Landing SEA JSON',
        'manage_options',
        'crescendo-landing-import',
        'crescendo_render_landing_import_page'
    );
}
add_action('admin_menu', 'crescendo_register_landing_import_page');

function crescendo_render_landing_import_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $messages = array();

    if (!empty($_POST['crescendo_import_nonce']) && wp_verify_nonce($_POST['crescendo_import_nonce'], 'crescendo_import_landing')) {
        $file = !empty($_POST['import_file']) ? sanitize_text_field(wp_unslash($_POST['import_file'])) : crescendo_get_landing_import_file();

        if (!file_exists($file)) {
            $messages[] = array('type' => 'error', 'text' => 'Fichier introuvable : ' . esc_html($file));
        } else {
            $result = crescendo_import_landing_from_json_file($file);
            if (is_wp_error($result)) {
                $messages[] = array('type' => 'error', 'text' => $result->get_error_message());
            } else {
                $action = $result['updated'] ? 'mise à jour' : 'création';
                $messages[] = array(
                    'type' => 'success',
                    'text' => sprintf(
                        'Landing %s réussie (ID %d). <a href="%s">Voir</a> · <a href="%s">Modifier</a>',
                        $action,
                        $result['post_id'],
                        esc_url($result['view_url']),
                        esc_url($result['edit_url'])
                    ),
                );
            }
        }
    }

    $dir = crescendo_get_content_import_dir('landing');
    $files = glob(trailingslashit($dir) . '*.json') ?: array();
    $files = array_filter($files, function ($file) {
        return basename($file) !== '_schema.json';
    });
    ?>
    <div class="wrap">
        <h1>Import Landing SEA (JSON)</h1>
        <p>Importez une landing Google Ads depuis <code>content-import/landing/*.json</code></p>

        <?php foreach ($messages as $message) : ?>
            <div class="notice notice-<?php echo esc_attr($message['type']); ?> is-dismissible"><p><?php echo wp_kses_post($message['text']); ?></p></div>
        <?php endforeach; ?>

        <?php if (!empty($files)) : ?>
            <form method="post">
                <?php wp_nonce_field('crescendo_import_landing', 'crescendo_import_nonce'); ?>
                <p>
                    <label for="import_file">Fichier JSON</label><br>
                    <select name="import_file" id="import_file">
                        <?php foreach ($files as $file) : ?>
                            <option value="<?php echo esc_attr($file); ?>"><?php echo esc_html(basename($file)); ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <?php submit_button('Importer la landing'); ?>
            </form>
        <?php else : ?>
            <p>Aucun fichier JSON trouvé dans <code>content-import/landing/</code>.</p>
        <?php endif; ?>
    </div>
    <?php
}

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('crescendo import-landing', function ($args) {
        $file = $args[0] ?? crescendo_get_landing_import_file();
        $result = crescendo_import_landing_from_json_file($file);
        if (is_wp_error($result)) {
            WP_CLI::error($result->get_error_message());
        }
        WP_CLI::success('Landing importée (ID ' . $result['post_id'] . ')');
    });
}
