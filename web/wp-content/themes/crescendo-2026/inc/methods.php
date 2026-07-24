<?php
function is_login_page() {
    return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
}

function checkNonce($nonceContext) {
    $nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : 0;
    if (!wp_verify_nonce($nonce, $nonceContext)) {
        exit(__('not authorized', 'domain'));
    }
}

function dateMonthInFr($date) {
    $english_months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
    $french_months = array('Janv', 'Févr', 'Mars', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc');
    return str_replace($english_months, $french_months,  $date);
}

function lsdDebugBloc($folder = '', $slug, $name, $args = '') {
    $datasDebug['path'] = 'template-parts/'. $folder . '/' .  $slug .'-'.$name.'.php';
    $datasDebug['args'] = $args;
    return $datasDebug;
}

function crescendo_home($field, $default = null) {
    static $defaults = null;

    if ($defaults === null) {
        $defaults = require THEME_DIR . 'inc/home-defaults.php';
    }

    $value = get_field($field);

    if (is_array($value) && empty($value)) {
        $value = null;
    }

    if ($value !== null && $value !== false && $value !== '') {
        return $value;
    }

    if ($default !== null) {
        return $default;
    }

    return $defaults[$field] ?? (is_array($defaults[$field] ?? null) ? array() : '');
}

function crescendo_resolve_link_url($url) {
    if (!is_string($url) || $url === '') {
        return $url;
    }

    $map = array(
        '#contact' => '/contact/',
        '#tarifs' => '/services/location-site-internet/',
        '/#contact' => '/contact/',
        '/#tarifs' => '/services/location-site-internet/',
    );

    $normalized = trim($url);
    if (isset($map[$normalized])) {
        return home_url($map[$normalized]);
    }

    return $url;
}

function crescendo_link($link, $class = '') {
    if (empty($link) || empty($link['url'])) {
        return '';
    }

    $title = esc_html($link['title'] ?? '');
    $url = esc_url(crescendo_resolve_link_url($link['url']));
    $target = !empty($link['target']) ? ' target="' . esc_attr($link['target']) . '" rel="noopener noreferrer"' : '';
    $classAttr = $class ? ' class="' . esc_attr($class) . '"' : '';

    return '<a href="' . $url . '"' . $classAttr . $target . '>' . $title . '</a>';
}

/**
 * Render an ACF/attachment image with responsive srcset/sizes.
 *
 * @param array|int $image ACF image array or attachment ID.
 * @param string    $size  Registered image size for the default src.
 * @param array     $attr  Extra attributes (class, sizes, loading, alt…).
 * @return string
 */
function crescendo_image($image, $size = 'large', $attr = array()) {
    $id = 0;
    $fallbackUrl = '';
    $fallbackAlt = '';
    $fallbackW = '';
    $fallbackH = '';

    if (is_numeric($image)) {
        $id = (int) $image;
    } elseif (is_array($image)) {
        $id = (int) ($image['ID'] ?? $image['id'] ?? 0);
        $fallbackUrl = (string) ($image['url'] ?? '');
        $fallbackAlt = (string) ($image['alt'] ?? '');
        $fallbackW = $image['width'] ?? '';
        $fallbackH = $image['height'] ?? '';
    }

    if ($id > 0) {
        if (!isset($attr['alt']) && $fallbackAlt !== '') {
            $attr['alt'] = $fallbackAlt;
        }
        if (!isset($attr['decoding'])) {
            $attr['decoding'] = 'async';
        }

        $html = wp_get_attachment_image($id, $size, false, $attr);
        if ($html) {
            return $html;
        }
    }

    if ($fallbackUrl === '') {
        return '';
    }

    $attrs = array(
        'src' => $fallbackUrl,
        'alt' => $attr['alt'] ?? $fallbackAlt,
        'decoding' => $attr['decoding'] ?? 'async',
    );

    foreach (array('class', 'loading', 'fetchpriority', 'sizes') as $key) {
        if (!empty($attr[$key])) {
            $attrs[$key] = $attr[$key];
        }
    }

    if ($fallbackW !== '' && $fallbackW !== null) {
        $attrs['width'] = $fallbackW;
    }
    if ($fallbackH !== '' && $fallbackH !== null) {
        $attrs['height'] = $fallbackH;
    }

    $html = '<img';
    foreach ($attrs as $key => $value) {
        $html .= ' ' . esc_attr($key) . '="' . esc_attr((string) $value) . '"';
    }

    return $html . '>';
}

function crescendo_get_content_import_dir($subdir = '') {
    static $bases = null;

    if ($bases === null) {
        $bases = array();
        $candidates = array(
            dirname(ABSPATH) . '/content-import',
            get_template_directory() . '/content-import',
            dirname(get_template_directory(), 4) . '/content-import',
            dirname(get_template_directory(), 5) . '/content-import',
        );

        foreach ($candidates as $candidate) {
            $resolved = realpath($candidate);
            if ($resolved && is_dir($resolved)) {
                $path = trailingslashit($resolved);
                if (!in_array($path, $bases, true)) {
                    $bases[] = $path;
                }
            }
        }

        if (empty($bases)) {
            $bases[] = trailingslashit(dirname(ABSPATH)) . 'content-import/';
        }
    }

    $subdir = ltrim($subdir, '/');

    if ($subdir) {
        foreach ($bases as $base) {
            $path = $base . $subdir;
            if (is_dir($path)) {
                $files = glob(trailingslashit($path) . '*.json') ?: array();
                $files = array_filter($files, function ($file) {
                    return basename($file) !== '_schema.json';
                });
                if (!empty($files)) {
                    return trailingslashit($path);
                }
            }
        }
    }

    return $bases[0] . $subdir;
}

function crescendo_find_content_import_file($subdir, $filename) {
    $subdir = trim($subdir, '/') . '/';
    $filename = ltrim($filename, '/');
    $dir = crescendo_get_content_import_dir($subdir);
    $preferred = $dir . $filename;

    if (file_exists($preferred)) {
        return $preferred;
    }

    static $bases = null;

    if ($bases === null) {
        $bases = array();
        $candidates = array(
            dirname(ABSPATH) . '/content-import',
            get_template_directory() . '/content-import',
            dirname(get_template_directory(), 4) . '/content-import',
            dirname(get_template_directory(), 5) . '/content-import',
        );

        foreach ($candidates as $candidate) {
            $resolved = realpath($candidate);
            if ($resolved && is_dir($resolved)) {
                $path = trailingslashit($resolved);
                if (!in_array($path, $bases, true)) {
                    $bases[] = $path;
                }
            }
        }
    }

    foreach ($bases as $base) {
        $candidate = $base . $subdir . $filename;
        if (file_exists($candidate)) {
            return $candidate;
        }
    }

    return $preferred;
}

function lsdGetTemplatePart($folder = '', $slug, $name, $args = '') {
    if (is_plugin_active('lsd-debug-template-part/index.php')) {
        if (LSD_DEBUG === true) {
            $lsdDebugBloc = lsdDebugBloc($folder, $slug, $name, $args);
        }
    }

    if (!empty($args)) {
        set_query_var('args', $args);
    }

    if (isset($lsdDebugBloc)) {
        echo '<div style="border: 1px solid red; padding: 10px">';
        echo '<div style="padding-left: 5px; padding-top: 5px; font-size: 12px; font-weight: 800;">' . $lsdDebugBloc['path'] . '</div>';

        if ($lsdDebugBloc['args']) {
            echo '<div style="padding-top: 5px; padding-left: 5px; font-size: 11px; font-weight: 100; color: green; ">Params :</div>';
            foreach ($lsdDebugBloc['args'] as $key => $arg){
                echo "<div style='padding-left: 5px; font-size: 10px;'>". $key . " : <span style='font-weight: 800;'>". $arg . "</span></div>";
            }
        }
    }

    get_template_part('template-parts/'. $folder . '/' .  $slug .'', $name, $args);

    if (isset($lsdDebugBloc)) {
        echo '</div>';
    }
}
