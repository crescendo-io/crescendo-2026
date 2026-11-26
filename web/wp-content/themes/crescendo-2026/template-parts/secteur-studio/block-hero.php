<?php
$items = crescendo_secteur_breadcrumb();
$eyebrow = crescendo_secteur('secteur-hero-eyebrow');
$title = crescendo_secteur('secteur-hero-title') ?: get_the_title();
$intro = crescendo_secteur('secteur-hero-intro');
$ctaPrimary = crescendo_secteur('secteur-hero-cta-primary');
$ctaSecondary = crescendo_secteur('secteur-hero-cta-secondary');
$note = crescendo_secteur('secteur-hero-note');
$benefits = crescendo_secteur('secteur-benefits');
$primaryUrl = is_array($ctaPrimary) ? crescendo_resolve_link_url($ctaPrimary['url'] ?? '#contact') : '#contact';
$primaryTitle = is_array($ctaPrimary) ? ($ctaPrimary['title'] ?? __('Demander ma maquette gratuite', 'crescendo-2026')) : __('Demander ma maquette gratuite', 'crescendo-2026');
$secondaryUrl = is_array($ctaSecondary) ? ($ctaSecondary['url'] ?? '') : '';
$secondaryTitle = is_array($ctaSecondary) ? ($ctaSecondary['title'] ?? '') : '';
$titleLead = $title;
$titleAccent = '';
if (preg_match('/^(.+?)\s+à\s+(.+)$/u', $title, $titleParts)) {
    $titleLead = $titleParts[1];
    $titleAccent = 'à ' . $titleParts[2];
}
?>
<header class="studio-about-hero studio-secteur-hero">
    <section class="studio-page-hero studio-page-hero--dark studio-secteur-page-hero" aria-labelledby="studio-secteur-hero-title">
        <div class="shell studio-page-hero__inner">
            <?php if (!empty($items)) : ?>
                <nav class="studio-service-breadcrumb studio-service-breadcrumb--hero" aria-label="<?php esc_attr_e('Fil d\'Ariane', 'crescendo-2026'); ?>">
                    <ol>
                        <?php foreach ($items as $index => $item) : ?>
                            <li>
                                <?php if ($index < count($items) - 1) : ?>
                                    <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                                <?php else : ?>
                                    <span aria-current="page"><?php echo esc_html($item['label']); ?></span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            <?php endif; ?>

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

                    <h1 id="studio-secteur-hero-title">
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
                            <a class="studio-text-link" href="#fonctionnalites"><?php esc_html_e('Voir le périmètre', 'crescendo-2026'); ?></a>
                        <?php endif; ?>
                    </div>

                    <?php if ($note) : ?>
                        <p class="studio-service-hero__note"><?php echo esc_html($note); ?></p>
                    <?php endif; ?>
                </div>

                <?php if ($intro) : ?>
                    <div class="studio-page-hero__aside">
                        <p class="studio-intro studio-secteur-hero__intro"><?php echo esc_html($intro); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if (!empty($benefits)) : ?>
        <div class="studio-secteur-hero__benefits-wrap">
            <div class="shell">
                <ul class="studio-service-benefits__grid studio-secteur-hero__benefits" id="engagements">
                    <?php foreach ($benefits as $index => $item) : ?>
                        <li data-studio-text-reveal>
                            <span class="studio-service-benefits__index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                            <?php if (!empty($item['title'])) : ?>
                                <h3 class="studio-secteur-hero__benefit-title"><?php echo esc_html($item['title']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($item['text'])) : ?>
                                <p><?php echo esc_html($item['text']); ?></p>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
</header>