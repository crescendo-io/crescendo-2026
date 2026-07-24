<?php
$headerCta = get_field('params-header-cta', 'option');
if (empty($headerCta) || empty($headerCta['url'])) {
    $headerCta = array(
        'title' => 'Maquette gratuite en 48h',
        'url' => home_url('/contact/'),
        'target' => '',
    );
}

$fallbackLinks = crescendo_get_header_nav_links();
?>
<header class="site-header" role="banner">
    <div class="site-header__inner container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="<?php bloginfo('name'); ?> — Accueil">
            <img
                src="<?php echo esc_url(THEME_URL . 'assets/images/logo.png'); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                width="186"
                height="27"
                decoding="async"
            >
        </a>

        <button class="site-header__toggle" type="button" aria-expanded="false" aria-controls="site-nav" data-nav-toggle>
            <span class="visually-hidden">Menu</span>
            <span></span>
            <span></span>
            <span></span>
        </button>

        <nav id="site-nav" class="site-nav" role="navigation" aria-label="Navigation principale">
            <?php if (has_nav_menu('menu-header')) : ?>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'menu-header',
                    'menu_id' => 'menu-header',
                    'menu_class' => 'site-nav__list',
                    'container' => false,
                    'depth' => 2,
                ));
                ?>
            <?php else : ?>
                <ul class="site-nav__list">
                    <?php foreach ($fallbackLinks as $link) : ?>
                        <?php
                        $isActive = crescendo_nav_link_is_active($link);
                        $itemClass = 'site-nav__item';
                        if (!empty($link['children'])) {
                            $itemClass .= ' site-nav__item--has-children';
                        }
                        if ($isActive) {
                            $itemClass .= ' is-active';
                        }
                        ?>
                        <li class="<?php echo esc_attr($itemClass); ?>">
                            <a
                                href="<?php echo esc_url($link['url']); ?>"
                                class="<?php echo $isActive ? 'is-active' : ''; ?>"
                                <?php echo $isActive ? 'aria-current="page"' : ''; ?>
                            ><?php echo esc_html($link['label']); ?></a>
                            <?php if (!empty($link['children'])) : ?>
                                <ul class="site-nav__submenu">
                                    <?php foreach ($link['children'] as $child) : ?>
                                        <?php $childActive = !empty($child['url']) && crescendo_nav_is_current($child['url']); ?>
                                        <li class="<?php echo $childActive ? 'is-active' : ''; ?>">
                                            <a
                                                href="<?php echo esc_url($child['url']); ?>"
                                                class="<?php echo $childActive ? 'is-active' : ''; ?>"
                                                <?php echo $childActive ? 'aria-current="page"' : ''; ?>
                                            ><?php echo esc_html($child['label']); ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php echo crescendo_link($headerCta, 'btn btn--primary btn--sm site-nav__cta'); ?>
        </nav>
    </div>
</header>
