<?php

function crescendo_resolve_project_page_id($reference) {
    static $cache = array();

    if ($reference === null || $reference === false || $reference === '') {
        return null;
    }

    if (is_array($reference)) {
        foreach (array('project', 'project_page', 'page') as $key) {
            if (!empty($reference[$key])) {
                $resolved = crescendo_resolve_project_page_id($reference[$key]);
                if ($resolved) {
                    return $resolved;
                }
            }
        }

        if (!empty($reference['url'])) {
            return crescendo_resolve_project_page_id($reference['url']);
        }

        return null;
    }

    if ($reference instanceof WP_Post) {
        return crescendo_is_project_page($reference->ID) ? (int) $reference->ID : null;
    }

    if (is_numeric($reference)) {
        $post_id = (int) $reference;
        return crescendo_is_project_page($post_id) ? $post_id : null;
    }

    if (!is_string($reference)) {
        return null;
    }

    $cache_key = md5($reference);
    if (isset($cache[$cache_key])) {
        return $cache[$cache_key];
    }

    $path = wp_parse_url($reference, PHP_URL_PATH);
    if (!$path) {
        $path = $reference;
    }
    $path = trim($path, '/');

    if ($path !== '' && strpos($path, 'realisations/') === 0) {
        $page = get_page_by_path($path, OBJECT, 'page');
        if ($page && crescendo_is_project_page($page->ID)) {
            return $cache[$cache_key] = (int) $page->ID;
        }
    }

    $url = (strpos($reference, 'http') === 0) ? $reference : home_url('/' . $path . '/');
    $post_id = url_to_postid($url);
    if ($post_id && crescendo_is_project_page($post_id)) {
        return $cache[$cache_key] = (int) $post_id;
    }

    return $cache[$cache_key] = null;
}

function crescendo_project_image_has_source($image) {
    return is_array($image) && (
        !empty($image['url']) || !empty($image['ID']) || !empty($image['id'])
    );
}

function crescendo_get_project_card($post_id) {
    $post_id = (int) $post_id;
    if (!$post_id || !crescendo_is_project_page($post_id)) {
        return null;
    }

    return array(
        'project_id' => $post_id,
        'title' => crescendo_project('project-hero-title', $post_id) ?: get_the_title($post_id),
        'category' => crescendo_project('project-sector', $post_id),
        'tags' => crescendo_project('project-tags', $post_id),
        'text' => crescendo_project('project-hero-intro', $post_id),
        'url' => get_permalink($post_id),
        'has_crm' => (bool) crescendo_project('project-has-crm', $post_id),
        'image' => crescendo_project('project-hero-image', $post_id),
    );
}

function crescendo_resolve_project_card($item, $override_keys = array('text')) {
    if (!is_array($item)) {
        return $item;
    }

    $project_id = crescendo_resolve_project_page_id($item);
    if (!$project_id) {
        return $item;
    }

    $card = crescendo_get_project_card($project_id);
    if (!$card) {
        return $item;
    }

    foreach ($override_keys as $key) {
        if (!empty($item[$key])) {
            $card[$key] = $item[$key];
        }
    }

    return $card;
}

function crescendo_resolve_project_cards($items, $override_keys = array('text')) {
    if (!is_array($items) || empty($items)) {
        return $items ?: array();
    }

    $resolved = array();
    foreach ($items as $item) {
        $resolved[] = crescendo_resolve_project_card($item, $override_keys);
    }

    return $resolved;
}

function crescendo_resolve_case_study_project($prefix, $getter) {
    $fields = array(
        'project' => $getter($prefix . '-project'),
        'url' => $getter($prefix . '-project-url'),
        'title' => $getter($prefix . '-project-title'),
        'tags' => $getter($prefix . '-project-tags'),
        'image' => $getter($prefix . '-project-image'),
        'points' => $getter($prefix . '-project-points') ?: array(),
    );

    $project_id = crescendo_resolve_project_page_id(array(
        'project' => $fields['project'],
        'url' => $fields['url'],
    ));

    if ($project_id) {
        $card = crescendo_get_project_card($project_id);
        if ($card) {
            $card['points'] = $fields['points'];
            return $card;
        }
    }

    return array(
        'project_id' => null,
        'title' => $fields['title'],
        'tags' => $fields['tags'],
        'url' => $fields['url'],
        'image' => $fields['image'],
        'points' => $fields['points'],
    );
}

function crescendo_acf_project_page_query($args) {
    $args['post_type'] = array('page');
    $args['meta_key'] = '_wp_page_template';
    $args['meta_value'] = 'template-project.php';
    $args['orderby'] = 'title';
    $args['order'] = 'ASC';

    return $args;
}

function crescendo_resolve_attachment_id($image) {
    if (is_numeric($image)) {
        return (int) $image;
    }

    if (is_array($image)) {
        return (int) ($image['ID'] ?? $image['id'] ?? 0);
    }

    return 0;
}

function crescendo_attachment_alt($image, $fallback = '') {
    if (is_array($image) && !empty($image['alt'])) {
        return trim((string) $image['alt']);
    }

    $attachment_id = crescendo_resolve_attachment_id($image);
    if ($attachment_id > 0) {
        $alt = trim((string) get_post_meta($attachment_id, '_wp_attachment_image_alt', true));
        if ($alt !== '') {
            return $alt;
        }
    }

    return trim((string) $fallback);
}

function crescendo_project_stored_gallery_alts($post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $stored = get_post_meta($post_id, '_crescendo_project_gallery_alts', true);

    return is_array($stored) ? $stored : array();
}

function crescendo_project_stored_hero_image_alt($post_id = null) {
    $post_id = $post_id ?: get_the_ID();

    return trim((string) get_post_meta($post_id, '_crescendo_project_hero_image_alt', true));
}

function crescendo_project_gallery_item_alt($index, $image, $post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $stored_alts = crescendo_project_stored_gallery_alts($post_id);
    $preferred = '';

    if (isset($stored_alts[$index]) && trim((string) $stored_alts[$index]) !== '') {
        $preferred = trim((string) $stored_alts[$index]);
    }

    $title = crescendo_project('project-hero-title', $post_id) ?: get_the_title($post_id);
    $generated = $title !== '' ? sprintf('%s — capture %d', $title, $index + 1) : '';

    if ($preferred !== '') {
        return crescendo_attachment_alt($image, $preferred);
    }

    return crescendo_attachment_alt($image, $generated);
}

function crescendo_project_hero_image_alt($image, $post_id = null) {
    $post_id = $post_id ?: get_the_ID();
    $title = crescendo_project('project-hero-title', $post_id) ?: get_the_title($post_id);
    $stored = crescendo_project_stored_hero_image_alt($post_id);
    $fallback = $stored !== '' ? $stored : $title;

    return crescendo_attachment_alt($image, $fallback);
}

function crescendo_project_gallery_has_images($gallery) {
    if (empty($gallery) || !is_array($gallery)) {
        return false;
    }

    foreach ($gallery as $item) {
        if (!is_array($item)) {
            continue;
        }

        $image = $item['image'] ?? null;
        if (is_array($image) && (!empty($image['url']) || !empty($image['ID']) || !empty($image['id']))) {
            return true;
        }
    }

    return false;
}

add_filter('acf/fields/post_object/query/name=project', 'crescendo_acf_project_page_query');
add_filter('acf/fields/post_object/query/name=secteur-case-project', 'crescendo_acf_project_page_query');
add_filter('acf/fields/post_object/query/name=local-case-project', 'crescendo_acf_project_page_query');
add_filter('acf/fields/relationship/query/name=project', 'crescendo_acf_project_page_query');
