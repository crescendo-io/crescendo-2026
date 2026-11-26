<?php
$theme = THEME_URL . 'assets/images/studio/';
$eyebrow = crescendo_service('service-hero-eyebrow');
$title = crescendo_service('service-hero-title') ?: get_the_title();
$ctaPrimary = crescendo_service('service-hero-cta-primary');
$ctaSecondary = crescendo_service('service-hero-cta-secondary');
$note = crescendo_service('service-hero-note');
$primaryUrl = is_array($ctaPrimary) ? crescendo_resolve_link_url($ctaPrimary['url'] ?? '#contact') : '#contact';
$primaryTitle = is_array($ctaPrimary) ? ($ctaPrimary['title'] ?? __('Demander ma maquette gratuite', 'crescendo-2026')) : __('Demander ma maquette gratuite', 'crescendo-2026');
$secondaryUrl = is_array($ctaSecondary) ? ($ctaSecondary['url'] ?? '') : '';
$secondaryTitle = is_array($ctaSecondary) ? ($ctaSecondary['title'] ?? '') : '';
$titleLead = $title;
$titleAccent = '';
if (preg_match('/^(.+?)\s+à\s+(.+)$/u', $title, $titleParts)) {
    $titleLead = $titleParts[1];
    $titleAccent = 'à ' . $titleParts[2];
} elseif (preg_match('/^(.+?)\s+(sur mesure)$/iu', $title, $titleParts)) {
    $titleLead = $titleParts[1];
    $titleAccent = $titleParts[2];
}
?>
<section class="studio-hero studio-hero--immersive studio-hero--service-page" aria-labelledby="studio-service-hero-title">
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
                    <?php if ($eyebrow) : ?>
                        <p class="studio-eyebrow">
                            <span class="studio-signal" aria-hidden="true"></span>
                            <?php
                            $eyebrowParts = preg_split('/\s*\/\s*|\s*·\s*/u', $eyebrow, 2);
                            if (count($eyebrowParts) > 1) {
                                echo esc_html($eyebrowParts[0]);
                                echo '<span class="studio-divider">/</span>';
                                echo esc_html($eyebrowParts[1]);
                            } else {
                                echo esc_html($eyebrow);
                            }
                            ?>
                        </p>
                    <?php endif; ?>

                    <h1 id="studio-service-hero-title">
                        <?php if ($titleAccent !== '') : ?>
                            <span><?php echo esc_html($titleLead); ?></span>
                            <strong><?php echo esc_html($titleAccent); ?></strong>
                        <?php else : ?>
                            <?php echo esc_html($title); ?>
                        <?php endif; ?>
                    </h1>

                    <div class="studio-hero__actions">
                        <a class="studio-hero-offer" href="<?php echo esc_url($primaryUrl); ?>"><?php echo esc_html($primaryTitle); ?></a>
                        <?php if ($secondaryTitle && $secondaryUrl) : ?>
                            <a class="studio-text-link" href="<?php echo esc_url(crescendo_resolve_link_url($secondaryUrl)); ?>"><?php echo esc_html($secondaryTitle); ?></a>
                        <?php else : ?>
                            <a class="studio-text-link" href="#inclus"><?php esc_html_e('Voir le périmètre', 'crescendo-2026'); ?></a>
                        <?php endif; ?>
                    </div>

                    <?php if ($note) : ?>
                        <p class="studio-service-hero__note"><?php echo esc_html($note); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <a class="studio-hero__scroll" href="#inclus">
            <span class="studio-hero__scroll-line" aria-hidden="true"></span>
            <span class="visually-hidden"><?php esc_html_e('Descendre', 'crescendo-2026'); ?></span>
        </a>
    </div>
</section>