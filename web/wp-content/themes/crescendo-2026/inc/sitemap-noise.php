<?php

/**
 * Purge blog noise from index and WordPress XML sitemaps.
 */

function crescendo_is_seo_noise_query() {
    return is_category()
        || is_tag()
        || is_author()
        || is_date()
        || (is_home() && !is_front_page())
        || is_singular('post');
}

function crescendo_noise_robots_meta() {
    if (!crescendo_is_seo_noise_query()) {
        return;
    }

    echo '<meta name="robots" content="noindex, nofollow">' . "\n";
}
add_action('wp_head', 'crescendo_noise_robots_meta', 0);

function crescendo_exclude_posts_from_sitemap($post_types) {
    unset($post_types['post']);

    return $post_types;
}
add_filter('wp_sitemaps_post_types', 'crescendo_exclude_posts_from_sitemap');

function crescendo_exclude_taxonomies_from_sitemap($taxonomies) {
    unset($taxonomies['category'], $taxonomies['post_tag']);

    return $taxonomies;
}
add_filter('wp_sitemaps_taxonomies', 'crescendo_exclude_taxonomies_from_sitemap');

function crescendo_exclude_users_from_sitemap($provider, $name) {
    if ($name === 'users') {
        return false;
    }

    return $provider;
}
add_filter('wp_sitemaps_add_provider', 'crescendo_exclude_users_from_sitemap', 10, 2);

function crescendo_purge_hello_world_post() {
    if (get_option('crescendo_hello_world_purged_v1')) {
        return;
    }

    $default = get_post(1);
    if ($default && $default->post_type === 'post') {
        wp_trash_post(1);
    }

    $posts = get_posts(array(
        'post_type' => 'post',
        'post_status' => array('publish', 'draft', 'pending', 'future', 'private'),
        'posts_per_page' => -1,
        's' => 'Hello world',
        'suppress_filters' => true,
    ));

    foreach ($posts as $post) {
        if (stripos($post->post_title, 'hello world') !== false) {
            wp_trash_post($post->ID);
        }
    }

    update_option('crescendo_hello_world_purged_v1', 1, false);
}
add_action('init', 'crescendo_purge_hello_world_post', 5);

function crescendo_noise_fallback_noindex($seo) {
    if (crescendo_is_seo_noise_query()) {
        $seo['noindex'] = true;
    }

    return $seo;
}
add_filter('crescendo_fallback_seo', 'crescendo_noise_fallback_noindex');
