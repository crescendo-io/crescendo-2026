<?php
$ctaPrimary = crescendo_landing('landing-header-cta-primary');
if (empty($ctaPrimary) || empty($ctaPrimary['url'])) {
    $ctaPrimary = array(
        'title' => 'Recevoir une estimation gratuite',
        'url' => '#contact',
        'target' => '',
    );
}
?>
<header class="site-header site-header--minimal" role="banner">
    <div class="site-header__inner container">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="<?php bloginfo('name'); ?> — Accueil">
            <?php echo crescendo_theme_logo('default', array('alt' => get_bloginfo('name'))); ?>
        </a>

        <?php echo crescendo_link($ctaPrimary, 'btn btn--primary btn--sm site-header__cta-minimal'); ?>
    </div>
</header>
