<?php
$headerCta = get_field('params-header-cta', 'option');
if (empty($headerCta) || empty($headerCta['url'])) {
    $headerCta = array(
        'title' => 'Maquette gratuite en 48h',
        'url' => home_url('/contact/'),
        'target' => '',
    );
}

$fallbackLinks = array(
    array('label' => 'Services', 'url' => '#', 'children' => array(
        array('label' => 'Création de site internet', 'url' => '#'),
        array('label' => 'CRM sur mesure', 'url' => '#'),
        array('label' => 'Location de site internet', 'url' => '#tarifs'),
        array('label' => 'Refonte WordPress', 'url' => '#'),
        array('label' => 'Site e-commerce', 'url' => '#'),
        array('label' => 'Maintenance WordPress', 'url' => '#'),
    )),
    array('label' => 'CRM sur mesure', 'url' => '#'),
    array('label' => 'Réalisations', 'url' => home_url('/realisations/')),
    array('label' => 'Blog', 'url' => '#'),
    array('label' => 'À propos', 'url' => home_url('/a-propos/')),
    array('label' => 'Contact', 'url' => home_url('/contact/')),
);
?>
<header class="site-header" role="banner">
    <div class="site-header__inner container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="<?php bloginfo('name'); ?> — Accueil">
            crescendo
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
                        <li class="site-nav__item<?php echo !empty($link['children']) ? ' site-nav__item--has-children' : ''; ?>">
                            <a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a>
                            <?php if (!empty($link['children'])) : ?>
                                <ul class="site-nav__submenu">
                                    <?php foreach ($link['children'] as $child) : ?>
                                        <li><a href="<?php echo esc_url($child['url']); ?>"><?php echo esc_html($child['label']); ?></a></li>
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
