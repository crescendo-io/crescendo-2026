<?php

require_once get_template_directory() . '/inc/class-crescendo-studio-nav-walker.php';

/**
 * @param array<int, array{label: string, url: string}> $children
 */
function crescendo_studio_nav_submenu_panel_open($label, $url, array $children) {
    $childCount = count($children);
    $wideClass = $childCount > 6 ? ' studio-mast-nav__submenu--wide' : '';
    echo '<div class="studio-mast-nav__submenu' . esc_attr($wideClass) . '" role="region" aria-label="' . esc_attr($label) . '">';
    echo '<div class="studio-mast-nav__submenu-intro">';
    echo '<span class="studio-mast-nav__submenu-kicker">' . esc_html($label) . '</span>';
    echo '<a class="studio-mast-nav__submenu-all" href="' . esc_url($url) . '">'
        . esc_html__('Voir tout', 'crescendo-2026')
        . '<span class="studio-mast-nav__submenu-all-mark" aria-hidden="true">→</span></a>';
    echo '</div>';
    echo '<ul class="studio-mast-nav__subrows">';
}

function crescendo_studio_nav_submenu_panel_close() {
    echo '</ul></div>';
}

function crescendo_render_studio_primary_nav_fallback($args = null) {
    $links = crescendo_get_header_nav_links();
    if (empty($links)) {
        return;
    }

    echo '<ul class="studio-mast-nav__list">';
    foreach ($links as $link) {
        $hasChildren = !empty($link['children']) && is_array($link['children']);
        $isActive = crescendo_nav_link_is_active($link);
        $itemClasses = array('studio-mast-nav__item');
        if ($hasChildren) {
            $itemClasses[] = 'studio-mast-nav__item--has-children';
            if (count($link['children']) > 6) {
                $itemClasses[] = 'studio-mast-nav__item--submenu-wide';
            }
        }
        if ($isActive) {
            $itemClasses[] = 'is-current-ancestor';
            if (!empty($link['url']) && crescendo_nav_is_current($link['url'])) {
                $itemClasses[] = 'is-current';
            }
        }

        echo '<li class="' . esc_attr(implode(' ', $itemClasses)) . '">';
        echo '<div class="studio-mast-nav__item-head">';
        echo '<a class="studio-mast-nav__link' . ($hasChildren ? ' studio-mast-nav__link--has-sub' : '') . ($isActive && !empty($link['url']) && crescendo_nav_is_current($link['url']) ? ' is-active' : '') . '" href="' . esc_url($link['url']) . '"';
        if (!empty($link['url']) && crescendo_nav_is_current($link['url'])) {
            echo ' aria-current="page"';
        }
        echo '>' . esc_html($link['label']) . '</a>';

        if ($hasChildren) {
            echo '<button type="button" class="studio-mast-nav__subtoggle" aria-expanded="false" aria-haspopup="true" aria-label="'
                . esc_attr(sprintf(__('Ouvrir le sous-menu %s', 'crescendo-2026'), $link['label']))
                . '"><span aria-hidden="true"></span></button>';
        }
        echo '</div>';

        if ($hasChildren) {
            crescendo_studio_nav_submenu_panel_open($link['label'], $link['url'], $link['children']);
            foreach ($link['children'] as $index => $child) {
                $childActive = !empty($child['url']) && crescendo_nav_is_current($child['url']);
                echo '<li class="studio-mast-nav__subrow' . ($childActive ? ' is-current' : '') . '">';
                echo '<a class="studio-mast-nav__subrow-link' . ($childActive ? ' is-active' : '') . '" href="' . esc_url($child['url']) . '"';
                if ($childActive) {
                    echo ' aria-current="page"';
                }
                echo '>';
                echo '<span class="studio-mast-nav__subrow-index" aria-hidden="true">' . esc_html(sprintf('%02d', $index + 1)) . '</span>';
                echo '<span class="studio-mast-nav__subrow-label">' . esc_html($child['label']) . '</span>';
                echo '<span class="studio-mast-nav__subrow-mark" aria-hidden="true">+</span>';
                echo '</a></li>';
            }
            crescendo_studio_nav_submenu_panel_close();
        }
        echo '</li>';
    }
    echo '</ul>';
}

function crescendo_render_studio_primary_nav() {
    if (has_nav_menu('menu-header')) {
        wp_nav_menu(array(
            'theme_location' => 'menu-header',
            'container' => false,
            'menu_class' => 'studio-mast-nav__list',
            'depth' => 2,
            'walker' => new Crescendo_Studio_Nav_Walker(),
            'fallback_cb' => 'crescendo_render_studio_primary_nav_fallback',
        ));
        return;
    }

    crescendo_render_studio_primary_nav_fallback();
}

/**
 * Header Studio : Secteurs et Réalisations = liens simples, sans sous-menu.
 *
 * @param WP_Post[] $items
 * @return WP_Post[]
 */
function crescendo_studio_filter_header_nav_menu_objects($items, $args) {
    if (!is_object($args) || empty($args->theme_location) || $args->theme_location !== 'menu-header') {
        return $items;
    }
    if (!function_exists('crescendo_uses_studio_design') || !crescendo_uses_studio_design()) {
        return $items;
    }

    $flatPaths = array(
        crescendo_nav_normalize_path(crescendo_nav_url('secteurs')),
        crescendo_nav_normalize_path(crescendo_nav_url('realisations')),
    );
    $parentIds = array();

    foreach ($items as $item) {
        if ((string) $item->menu_item_parent !== '0') {
            continue;
        }
        $path = crescendo_nav_normalize_path($item->url);
        if (in_array($path, $flatPaths, true)) {
            $parentIds[(int) $item->ID] = true;
        }
    }

    if ($parentIds === array()) {
        return $items;
    }

    $filtered = array();
    foreach ($items as $item) {
        $parentId = (int) $item->menu_item_parent;
        if ($parentId !== 0 && isset($parentIds[$parentId])) {
            continue;
        }
        if (isset($parentIds[(int) $item->ID])) {
            $item->classes = array_values(array_diff((array) $item->classes, array('menu-item-has-children')));
        }
        $filtered[] = $item;
    }

    return $filtered;
}

add_filter('wp_nav_menu_objects', 'crescendo_studio_filter_header_nav_menu_objects', 20, 2);