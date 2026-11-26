<?php
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');
$logoMarkup = function_exists('crescendo_studio_logo_markup') ? crescendo_studio_logo_markup() : '';
?>
<a class="skip-link studio-skip" href="#contenu"><?php esc_html_e('Aller au contenu', 'crescendo-2026'); ?></a>
<header class="studio-mast" role="banner">
    <div class="shell studio-mast__inner">
        <a class="brand studio-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?> — <?php esc_attr_e('Accueil', 'crescendo-2026'); ?>">
            <?php
            if ($logoMarkup !== '') {
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG markup from theme file.
                echo $logoMarkup;
            }
            ?>
        </a>
        <nav aria-label="<?php esc_attr_e('Navigation principale', 'crescendo-2026'); ?>">
            <a href="<?php echo esc_url(home_url('/#projets')); ?>"><?php esc_html_e('Projets', 'crescendo-2026'); ?></a>
            <a href="<?php echo esc_url(home_url('/#expertises')); ?>"><?php esc_html_e('Expertises', 'crescendo-2026'); ?></a>
            <a href="<?php echo esc_url(home_url('/#studio')); ?>"><?php esc_html_e('Studio', 'crescendo-2026'); ?></a>
        </nav>
        <a class="contact-button studio-contact-button" href="<?php echo esc_url($contactUrl); ?>"><?php esc_html_e('Parler d’un projet', 'crescendo-2026'); ?></a>
    </div>
</header>