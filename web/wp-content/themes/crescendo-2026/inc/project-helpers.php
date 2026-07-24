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

add_filter('acf/fields/post_object/query/name=project', 'crescendo_acf_project_page_query');
add_filter('acf/fields/post_object/query/name=secteur-case-project', 'crescendo_acf_project_page_query');
add_filter('acf/fields/post_object/query/name=local-case-project', 'crescendo_acf_project_page_query');
add_filter('acf/fields/relationship/query/name=project', 'crescendo_acf_project_page_query');
