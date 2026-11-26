<?php
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');
$logoMarkup = function_exists('crescendo_studio_logo_markup') ? crescendo_studio_logo_markup() : '';
$ctaLabel = apply_filters('crescendo_studio_mast_cta_label', __('Parler d’un projet', 'crescendo-2026'));
?>
<a class="skip-link studio-skip" href="#contenu"><?php esc_html_e('Aller au contenu', 'crescendo-2026'); ?></a>
<header class="studio-mast" role="banner" data-studio-mast>
    <div class="shell studio-mast__inner">
        <a class="brand studio-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?> — <?php esc_attr_e('Accueil', 'crescendo-2026'); ?>">
            <?php
            if ($logoMarkup !== '') {
                // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG markup from theme file.
                echo $logoMarkup;
            }
            ?>
        </a>

        <button
            type="button"
            class="studio-mast-nav__toggle"
            data-studio-nav-toggle
            aria-expanded="false"
            aria-controls="studio-mast-nav-panel"
        >
            <span class="visually-hidden"><?php esc_html_e('Menu', 'crescendo-2026'); ?></span>
            <span class="studio-mast-nav__toggle-bar" aria-hidden="true"></span>
            <span class="studio-mast-nav__toggle-bar" aria-hidden="true"></span>
            <span class="studio-mast-nav__toggle-bar" aria-hidden="true"></span>
        </button>

        <div class="studio-mast-nav" id="studio-mast-nav-panel" data-studio-nav-panel>
            <nav class="studio-mast-nav__primary" aria-label="<?php esc_attr_e('Navigation principale', 'crescendo-2026'); ?>">
                <?php
                if (function_exists('crescendo_render_studio_primary_nav')) {
                    crescendo_render_studio_primary_nav();
                }
                ?>
            </nav>
            <a class="contact-button studio-contact-button studio-mast-nav__cta studio-mast-nav__cta--in-panel" href="<?php echo esc_url($contactUrl); ?>">
                <?php echo esc_html($ctaLabel); ?>
            </a>
        </div>

        <a class="contact-button studio-contact-button studio-mast-nav__cta studio-mast-nav__cta--desktop" href="<?php echo esc_url($contactUrl); ?>">
            <?php echo esc_html($ctaLabel); ?>
        </a>
    </div>
</header>
<div class="studio-mast-nav__backdrop" data-studio-nav-backdrop hidden></div>