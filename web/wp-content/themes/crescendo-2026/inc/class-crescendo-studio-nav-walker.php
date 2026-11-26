<?php

class Crescendo_Studio_Nav_Walker extends Walker_Nav_Menu {
    /** @var string */
    public $submenu_label = '';

    /** @var string */
    public $submenu_url = '';

    /** @var int */
    public $submenu_index = 0;

    public function start_lvl(&$output, $depth = 0, $args = null) {
        if ($depth !== 0) {
            return;
        }

        $this->submenu_index = 0;
        $indent = "\t\t";
        $label = esc_attr($this->submenu_label);
        $output .= "\n{$indent}<div class=\"studio-mast-nav__submenu\" role=\"region\" aria-label=\"{$label}\">\n";
        $output .= "{$indent}\t<div class=\"studio-mast-nav__submenu-intro\">\n";
        $output .= "{$indent}\t\t<span class=\"studio-mast-nav__submenu-kicker\">" . esc_html($this->submenu_label) . "</span>\n";
        if ($this->submenu_url !== '') {
            $output .= "{$indent}\t\t<a class=\"studio-mast-nav__submenu-all\" href=\"" . esc_url($this->submenu_url) . "\">"
                . esc_html__('Voir tout', 'crescendo-2026') . '<span class="studio-mast-nav__submenu-all-mark" aria-hidden="true">→</span></a>' . "\n";
        }
        $output .= "{$indent}\t</div>\n";
        $output .= "{$indent}\t<ul class=\"studio-mast-nav__subrows\">\n";
    }

    public function end_lvl(&$output, $depth = 0, $args = null) {
        if ($depth !== 0) {
            return;
        }

        $indent = "\t\t";
        $output .= "{$indent}\t</ul>\n";
        $output .= "{$indent}</div>\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = $depth ? "\t\t\t" : "\t";
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $hasChildren = in_array('menu-item-has-children', $classes, true);

        if ($depth === 0) {
            $itemClasses = array('studio-mast-nav__item');
            if ($hasChildren) {
                $itemClasses[] = 'studio-mast-nav__item--has-children';
            }
            if (in_array('current-menu-item', $classes, true) || in_array('current_page_item', $classes, true)) {
                $itemClasses[] = 'is-current';
            }
            if (in_array('current-menu-ancestor', $classes, true) || in_array('current-menu-parent', $classes, true)) {
                $itemClasses[] = 'is-current-ancestor';
            }

            $title = apply_filters('the_title', $item->title, $item->ID);
            if ($hasChildren) {
                $this->submenu_label = $title;
                $this->submenu_url = !empty($item->url) ? $item->url : '';
            }

            $linkClasses = array('studio-mast-nav__link');
            if ($hasChildren) {
                $linkClasses[] = 'studio-mast-nav__link--has-sub';
            }
            if (in_array('current-menu-item', $classes, true) || in_array('current_page_item', $classes, true)) {
                $linkClasses[] = 'is-active';
            }

            $output .= $indent . '<li class="' . esc_attr(implode(' ', $itemClasses)) . '">';
            $output .= '<div class="studio-mast-nav__item-head">';
            $output .= '<a href="' . esc_url($item->url) . '" class="' . esc_attr(implode(' ', $linkClasses)) . '"';
            if (in_array('current-menu-item', $classes, true) || in_array('current_page_item', $classes, true)) {
                $output .= ' aria-current="page"';
            }
            $output .= '>' . esc_html($title) . '</a>';

            if ($hasChildren) {
                $output .= '<button type="button" class="studio-mast-nav__subtoggle" aria-expanded="false" aria-haspopup="true" aria-label="'
                    . esc_attr(sprintf(__('Ouvrir le sous-menu %s', 'crescendo-2026'), $title))
                    . '"><span aria-hidden="true"></span></button>';
            }
            $output .= '</div>';
            return;
        }

        $this->submenu_index++;
        $isActive = in_array('current-menu-item', $classes, true) || in_array('current_page_item', $classes, true);
        $rowClasses = array('studio-mast-nav__subrow');
        if ($isActive) {
            $rowClasses[] = 'is-current';
        }

        $linkClasses = array('studio-mast-nav__subrow-link');
        if ($isActive) {
            $linkClasses[] = 'is-active';
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $output .= $indent . "\t\t<li class=\"" . esc_attr(implode(' ', $rowClasses)) . "\">\n";
        $output .= $indent . "\t\t\t<a href=\"" . esc_url($item->url) . "\" class=\"" . esc_attr(implode(' ', $linkClasses)) . "\"";
        if ($isActive) {
            $output .= ' aria-current="page"';
        }
        $output .= '>';
        $output .= '<span class="studio-mast-nav__subrow-index" aria-hidden="true">' . esc_html(sprintf('%02d', $this->submenu_index)) . '</span>';
        $output .= '<span class="studio-mast-nav__subrow-label">' . esc_html($title) . '</span>';
        $output .= '<span class="studio-mast-nav__subrow-mark" aria-hidden="true">+</span>';
        $output .= '</a>';
    }

    public function end_el(&$output, $item, $depth = 0, $args = null) {
        $indent = $depth ? "\t\t\t" : "\t";
        $output .= $depth === 0 ? "</li>\n" : "{$indent}\t\t</li>\n";
    }
}