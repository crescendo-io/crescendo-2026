<?php
$eyebrow = crescendo_service('service-hero-eyebrow');
$title = crescendo_service('service-hero-title') ?: get_the_title();
$intro = crescendo_service('service-hero-intro');
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
<section class="studio-page-hero studio-page-hero--dark studio-service-page-hero" aria-labelledby="studio-service-hero-title">
    <div class="shell studio-page-hero__inner">
        <div class="studio-page-hero__layout" data-studio-text-reveal>
            <div class="studio-page-hero__main">
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
                        <?php echo esc_html($title); ?><span class="studio-red">.</span>
                    <?php endif; ?>
                </h1>

                <div class="studio-page-hero__actions studio-hero__actions">
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

            <?php if ($intro) : ?>
                <div class="studio-page-hero__aside">
                    <p class="studio-intro studio-service-page-hero__intro"><?php echo esc_html($intro); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>