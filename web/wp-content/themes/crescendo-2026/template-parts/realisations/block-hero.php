<?php
$eyebrow = crescendo_realisations('realisations-hero-eyebrow');
$title = crescendo_realisations('realisations-hero-title') ?: get_the_title();
$intro = crescendo_realisations('realisations-hero-intro');
$ctaPrimary = crescendo_realisations('realisations-hero-cta-primary');
$items = crescendo_realisations_breadcrumb();
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

        <div class="realisations-hero__inner">
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
    </div>
</section>
