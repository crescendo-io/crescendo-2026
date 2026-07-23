<?php
$eyebrow = crescendo_realisations('realisations-hero-eyebrow');
$title = crescendo_realisations('realisations-hero-title') ?: get_the_title();
$intro = crescendo_realisations('realisations-hero-intro');
$ctaPrimary = crescendo_realisations('realisations-hero-cta-primary');
$panelText = crescendo_realisations('realisations-intro-text');
$stats = crescendo_realisations('realisations-intro-stats');
$items = crescendo_realisations_breadcrumb();
$hasPanel = $panelText || !empty($stats);
?>
<section class="realisations-hero">
    <div class="container">
        <?php if (!empty($items)) : ?>
            <nav class="service-breadcrumb" aria-label="Fil d'Ariane">
                <ol class="service-breadcrumb__list">
                    <?php foreach ($items as $index => $item) : ?>
                        <li class="service-breadcrumb__item">
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

        <div class="realisations-hero__layout<?php echo $hasPanel ? ' realisations-hero__layout--split' : ''; ?>">
            <div class="realisations-hero__content">
                <?php if ($eyebrow) : ?>
                    <p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <h1 class="realisations-hero__title"><?php echo esc_html($title); ?></h1>

                <?php if ($intro) : ?>
                    <p class="realisations-hero__intro"><?php echo esc_html($intro); ?></p>
                <?php endif; ?>

                <?php if (!empty($ctaPrimary['url'])) : ?>
                    <div class="realisations-hero__actions">
                        <?php echo crescendo_link($ctaPrimary, 'btn btn--primary'); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($hasPanel) : ?>
                <aside class="realisations-hero__panel">
                    <?php if ($panelText) : ?>
                        <p class="realisations-hero__panel-text"><?php echo esc_html($panelText); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($stats)) : ?>
                        <ul class="realisations-hero__stats">
                            <?php foreach ($stats as $stat) : ?>
                                <li>
                                    <?php if (!empty($stat['value'])) : ?>
                                        <strong><?php echo esc_html($stat['value']); ?></strong>
                                    <?php endif; ?>
                                    <?php if (!empty($stat['label'])) : ?>
                                        <span><?php echo esc_html($stat['label']); ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </aside>
            <?php endif; ?>
        </div>
    </div>
</section>
