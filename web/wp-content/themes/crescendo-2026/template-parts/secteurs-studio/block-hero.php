<?php
$eyebrow = crescendo_secteurs_hub('secteurs-hero-eyebrow');
$title = crescendo_secteurs_hub('secteurs-hero-title') ?: get_the_title();
$intro = crescendo_secteurs_hub('secteurs-hero-intro');
$panelText = crescendo_secteurs_hub('secteurs-intro-text');
$ctaPrimary = crescendo_secteurs_hub('secteurs-hero-cta-primary');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');
$ctaUrl = !empty($ctaPrimary['url']) ? crescendo_resolve_link_url($ctaPrimary['url']) : $contactUrl;
$ctaLabel = !empty($ctaPrimary['title']) ? $ctaPrimary['title'] : __('Demander ma maquette gratuite', 'crescendo-2026');
?>
<section class="studio-secteurs-hub-hero studio-page-hero--dark" aria-labelledby="studio-secteurs-hub-hero-title">
    <div class="shell studio-secteurs-hub-hero__inner studio-page-hero__inner">
        <div class="studio-page-hero__layout" data-studio-text-reveal>
            <div class="studio-page-hero__main">
                <?php if ($eyebrow) : ?>
                    <p class="studio-eyebrow">
                        <span class="studio-signal" aria-hidden="true"></span>
                        <?php echo esc_html($eyebrow); ?>
                    </p>
                <?php endif; ?>

                <h1 id="studio-secteurs-hub-hero-title">
                    <?php echo esc_html($title); ?><span class="studio-red">.</span>
                </h1>

                <p class="studio-services-hub-hero__actions studio-page-hero__actions">
                    <a class="studio-services-hub-hero__button" href="<?php echo esc_url($ctaUrl); ?>"><?php echo esc_html($ctaLabel); ?></a>
                    <a class="studio-text-link" href="#secteurs"><?php esc_html_e('Voir les secteurs', 'crescendo-2026'); ?></a>
                </p>
            </div>

            <?php if ($intro || $panelText) : ?>
                <div class="studio-page-hero__aside">
                    <?php if ($intro) : ?>
                        <p class="studio-services-hub-hero__intro"><?php echo esc_html($intro); ?></p>
                    <?php endif; ?>
                    <?php if ($panelText) : ?>
                        <p class="studio-services-hub-hero__lede"><?php echo esc_html($panelText); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>