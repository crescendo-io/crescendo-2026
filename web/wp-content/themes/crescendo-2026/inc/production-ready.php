<?php

function crescendo_is_crescendo_production_site() {
    if (defined('ENV_CRESCENDO_PROD') && ENV_CRESCENDO_PROD) {
        return true;
    }

    $host = isset($_SERVER['HTTP_HOST']) ? (string) wp_unslash($_SERVER['HTTP_HOST']) : '';

    return in_array($host, array('crescendo-studio.io', 'www.crescendo-studio.io'), true);
}

function crescendo_filter_brand_bloginfo($output, $show) {
    if ($show !== 'name') {
        return $output;
    }

    $brand = crescendo_brand_name();

    if ($brand === '' || $brand === $output) {
        return $output;
    }

    if (stripos($output, '2026') !== false || stripos($output, 'crescendo') === false) {
        return $brand;
    }

    return $output;
}
add_filter('bloginfo', 'crescendo_filter_brand_bloginfo', 20, 2);

function crescendo_filter_option_blogname($value) {
    if ($value === '' || stripos((string) $value, '2026') !== false) {
        return crescendo_brand_name();
    }

    return $value;
}
add_filter('option_blogname', 'crescendo_filter_option_blogname');

function crescendo_default_footer_email() {
    return 'b.vidal@crescendo-studio.io';
}

function crescendo_default_footer_address() {
    return 'Nantes et Loire-Atlantique (44) — siège : Saint-Nazaire';
}

function crescendo_maybe_apply_launch_ready_settings() {
    if (get_option('crescendo_launch_ready_v2')) {
        return;
    }

    if (!did_action('init') || !function_exists('update_field')) {
        return;
    }

    $blogname = (string) get_option('blogname');
    if ($blogname === '' || stripos($blogname, '2026') !== false) {
        update_option('blogname', crescendo_brand_name());
    }

    $blogdescription = (string) get_option('blogdescription');
    if ($blogdescription === '' || stripos($blogdescription, 'WordPress') !== false) {
        update_option('blogdescription', 'Agence web à Nantes — WordPress sur mesure, CRM et location dès 350€/mois.');
    }

    if (!get_field('params-footer-email', 'option')) {
        update_field('params-footer-email', crescendo_default_footer_email(), 'option');
    }

    if (!get_field('params-footer-address', 'option')) {
        update_field('params-footer-address', crescendo_default_footer_address(), 'option');
    }

    if (crescendo_is_crescendo_production_site()) {
        update_option('blog_public', 1);
    }

    if (function_exists('crescendo_import_socle_from_json_file') && function_exists('crescendo_find_content_import_file')) {
        foreach (array('politique-de-confidentialite.json', 'mentions-legales.json') as $file_name) {
            $file = crescendo_find_content_import_file('socle', $file_name);
            if ($file) {
                crescendo_import_socle_from_json_file($file);
            }
        }
    }

    if (function_exists('crescendo_import_contact_from_json_file') && function_exists('crescendo_find_content_import_file')) {
        $contact_file = crescendo_find_content_import_file('contact', 'contact.json');
        if ($contact_file) {
            crescendo_import_contact_from_json_file($contact_file);
        }
    }

    if (function_exists('crescendo_import_secteurs_hub_from_json_file') && function_exists('crescendo_find_content_import_file')) {
        $secteurs_file = crescendo_find_content_import_file('secteurs', 'secteurs.json');
        if ($secteurs_file) {
            crescendo_import_secteurs_hub_from_json_file($secteurs_file);
        }
    }

    if (function_exists('crescendo_import_project_from_json_file') && function_exists('crescendo_list_project_import_files')) {
        foreach (crescendo_list_project_import_files() as $project_file) {
            crescendo_import_project_from_json_file($project_file);
        }
    }

    flush_rewrite_rules(false);
    update_option('crescendo_launch_ready_v2', 1, false);
    delete_option('crescendo_launch_ready_v1');
}
add_action('init', 'crescendo_maybe_apply_launch_ready_settings', 35);
