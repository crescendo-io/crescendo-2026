<?php
$theme = THEME_URL . 'assets/images/studio/';
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');
?>
<section class="studio-hero studio-hero--immersive" aria-labelledby="studio-hero-title">
    <div class="studio-hero__scene studio-hero__scene--static" aria-hidden="true">
        <div class="studio-hero__media-wrap">
            <div class="studio-hero__media-zoom">
                <img
                    class="studio-hero__media"
                    src="<?php echo esc_url($theme . 'hero.jpg'); ?>"
                    width="1024"
                    height="682"
                    alt=""
                    decoding="async"
                    loading="eager"
                >
            </div>
        </div>
        <div class="studio-hero__glows">
            <div class="studio-hero__glows-track">
                <span class="studio-hero__glow studio-hero__glow--warm"></span>
                <span class="studio-hero__glow studio-hero__glow--cool"></span>
                <span class="studio-hero__glow studio-hero__glow--rose" aria-hidden="true"></span>
            </div>
        </div>
        <div class="studio-hero__mesh"></div>
        <div class="studio-hero__grain"></div>
        <div class="studio-hero__veil"></div>
    </div>

    <div class="shell studio-hero__overlay">
        <div class="studio-hero__layout">
            <div class="studio-hero__copy">
                <div class="studio-hero__copy-inner">
                    <p class="studio-eyebrow">
                        <span class="studio-signal" aria-hidden="true"></span>
                        <?php esc_html_e('Sites web & CRM', 'crescendo-2026'); ?>
                        <span class="studio-divider">/</span>
                        <?php esc_html_e('Nantes — Saint-Nazaire', 'crescendo-2026'); ?>
                    </p>
                    <h1 id="studio-hero-title">
                        <span><?php esc_html_e('Votre site doit', 'crescendo-2026'); ?></span>
                        <span><?php esc_html_e('vous rapporter', 'crescendo-2026'); ?></span>
                        <strong><?php esc_html_e('des clients.', 'crescendo-2026'); ?></strong>
                    </h1>
                    <p class="studio-intro">
                        <?php esc_html_e('Nous créons votre site pour générer des demandes de devis. Votre CRM sur mesure les centralise et indique à votre équipe qui relancer.', 'crescendo-2026'); ?>
                    </p>
                    <div class="studio-hero__actions">
                        <a class="studio-hero-offer" href="<?php echo esc_url($contactUrl); ?>"><?php esc_html_e('Demander ma maquette gratuite', 'crescendo-2026'); ?></a>
                        <a class="studio-text-link studio-hero__projects" href="#projets"><?php esc_html_e('Voir les projets', 'crescendo-2026'); ?></a>
                    </div>
                </div>
            </div>

            <figure class="studio-hero__mockup">
                <img
                    class="studio-hero__mockup-img"
                    src="<?php echo esc_url($theme . 'hero-mockup-phone.png'); ?>"
                    width="655"
                    height="819"
                    alt="<?php esc_attr_e('Aperçu de site sur mobile', 'crescendo-2026'); ?>"
                    decoding="async"
                    loading="eager"
                >
            </figure>
        </div>

        <a class="studio-hero__scroll" href="#projets">
            <span class="studio-hero__scroll-line" aria-hidden="true"></span>
            <span class="visually-hidden"><?php esc_html_e('Voir les projets', 'crescendo-2026'); ?></span>
        </a>
    </div>
</section>