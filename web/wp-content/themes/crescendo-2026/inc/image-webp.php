<?php

function crescendo_url_to_upload_path($url) {
    $upload_dir = wp_upload_dir();
    if (empty($upload_dir['baseurl']) || empty($upload_dir['basedir'])) {
        return '';
    }

    if (strpos($url, $upload_dir['baseurl']) !== 0) {
        return '';
    }

    $relative = substr($url, strlen($upload_dir['baseurl']));
    $path = $upload_dir['basedir'] . $relative;

    return file_exists($path) ? $path : '';
}

function crescendo_create_webp_variant($file_path) {
    $file_path = (string) $file_path;
    if ($file_path === '' || !file_exists($file_path)) {
        return null;
    }

    if (!preg_match('/\.(jpe?g|png)$/i', $file_path)) {
        return null;
    }

    $webp_path = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file_path);
    if (file_exists($webp_path) && filemtime($webp_path) >= filemtime($file_path)) {
        return $webp_path;
    }

    $editor = wp_get_image_editor($file_path);
    if (is_wp_error($editor)) {
        return null;
    }

    if (method_exists($editor, 'set_quality')) {
        $editor->set_quality(82);
    }

    $saved = $editor->save($webp_path, 'image/webp');
    if (is_wp_error($saved) || empty($saved['path'])) {
        return null;
    }

    return $saved['path'];
}

function crescendo_generate_attachment_webp_variants($metadata, $attachment_id) {
    unset($attachment_id);

    if (empty($metadata['file'])) {
        return $metadata;
    }

    $upload_dir = wp_upload_dir();
    $base_dir = trailingslashit($upload_dir['basedir']) . dirname($metadata['file']);
    $files = array(trailingslashit($upload_dir['basedir']) . $metadata['file']);

    if (!empty($metadata['sizes']) && is_array($metadata['sizes'])) {
        foreach ($metadata['sizes'] as $size) {
            if (!empty($size['file'])) {
                $files[] = $base_dir . '/' . $size['file'];
            }
        }
    }

    foreach (array_unique($files) as $file) {
        crescendo_create_webp_variant($file);
    }

    return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'crescendo_generate_attachment_webp_variants', 20, 2);

function crescendo_convert_srcset_to_webp($srcset) {
    if (!$srcset) {
        return '';
    }

    $entries = array();
    foreach (explode(',', $srcset) as $part) {
        $part = trim($part);
        if (!preg_match('#^(\S+)\s+(\d+w)$#', $part, $matches)) {
            continue;
        }

        $webp_url = preg_replace('/\.(jpe?g|png)$/i', '.webp', $matches[1]);
        if (crescendo_url_to_upload_path($webp_url) !== '') {
            $entries[] = $webp_url . ' ' . $matches[2];
        }
    }

    return implode(', ', $entries);
}

function crescendo_get_attachment_webp_src($attachment_id, $size) {
    $src = wp_get_attachment_image_src($attachment_id, $size);
    if (!$src || empty($src[0])) {
        return null;
    }

    $webp_url = preg_replace('/\.(jpe?g|png)$/i', '.webp', $src[0]);
    if (crescendo_url_to_upload_path($webp_url) === '') {
        return null;
    }

    return $webp_url;
}

function crescendo_wrap_attachment_in_picture($html, $attachment_id, $size, $attr) {
    $srcset = wp_get_attachment_image_srcset($attachment_id, $size);
    $webp_srcset = crescendo_convert_srcset_to_webp($srcset);
    $sizes = $attr['sizes'] ?? wp_get_attachment_image_sizes($attachment_id, $size);

    if ($webp_srcset === '') {
        $webp_src = crescendo_get_attachment_webp_src($attachment_id, $size);
        if (!$webp_src) {
            return $html;
        }

        return '<picture><source type="image/webp" srcset="' . esc_url($webp_src) . '">' . $html . '</picture>';
    }

    $picture = '<picture>';
    $picture .= '<source type="image/webp" srcset="' . esc_attr($webp_srcset) . '"';
    if ($sizes) {
        $picture .= ' sizes="' . esc_attr($sizes) . '"';
    }
    $picture .= '>';
    $picture .= $html;
    $picture .= '</picture>';

    return $picture;
}

function crescendo_theme_logo($variant = 'default', $attr = array()) {
    $variants = array(
        'default' => array(
            'png' => 'logo.png',
            'webp' => 'logo.webp',
            'webp2x' => 'logo@2x.webp',
            'width' => 186,
            'height' => 27,
        ),
        'white' => array(
            'png' => 'logo-white.png',
            'webp' => 'logo-white.webp',
            'webp2x' => '',
            'width' => 186,
            'height' => 27,
        ),
    );

    if (!isset($variants[$variant])) {
        $variant = 'default';
    }

    $files = $variants[$variant];
    $base = THEME_URL . 'assets/images/';
    $alt = $attr['alt'] ?? get_bloginfo('name');
    $class = trim($attr['class'] ?? '');
    $loading = $attr['loading'] ?? 'eager';
    $decoding = $attr['decoding'] ?? 'async';

    $picture = '<picture>';
    if (!empty($files['webp2x']) && file_exists(get_template_directory() . '/assets/images/' . $files['webp2x'])) {
        $picture .= '<source type="image/webp" srcset="' . esc_url($base . $files['webp']) . ' 1x, ' . esc_url($base . $files['webp2x']) . ' 2x">';
    } elseif (file_exists(get_template_directory() . '/assets/images/' . $files['webp'])) {
        $picture .= '<source type="image/webp" srcset="' . esc_url($base . $files['webp']) . '">';
    }

    $picture .= '<img src="' . esc_url($base . $files['png']) . '" alt="' . esc_attr($alt) . '" width="' . (int) $files['width'] . '" height="' . (int) $files['height'] . '" decoding="' . esc_attr($decoding) . '" loading="' . esc_attr($loading) . '"';
    if ($class !== '') {
        $picture .= ' class="' . esc_attr($class) . '"';
    }
    $picture .= '></picture>';

    return $picture;
}

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('crescendo generate-webp', function ($args, $assoc_args) {
        $query_args = array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'post_mime_type' => 'image',
            'posts_per_page' => -1,
            'fields' => 'ids',
        );

        if (!empty($assoc_args['id'])) {
            $query_args['post__in'] = array((int) $assoc_args['id']);
            $query_args['posts_per_page'] = 1;
        }

        $ids = get_posts($query_args);
        $count = 0;

        foreach ($ids as $attachment_id) {
            $file = get_attached_file($attachment_id);
            if (!$file) {
                continue;
            }

            $metadata = wp_get_attachment_metadata($attachment_id);
            if (empty($metadata)) {
                $metadata = array('file' => _wp_relative_upload_path($file));
            }

            crescendo_generate_attachment_webp_variants($metadata, $attachment_id);
            $count++;
            WP_CLI::log('WebP généré pour l’attachment ' . $attachment_id);
        }

        WP_CLI::success($count . ' image(s) traitée(s). Relancez `wp media regenerate` si de nouvelles tailles ont été ajoutées.');
    });
}
