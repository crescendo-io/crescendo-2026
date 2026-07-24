<?php
$items = crescendo_local_breadcrumb();
$eyebrow = crescendo_local('local-hero-eyebrow');
$title = crescendo_local('local-hero-title') ?: get_the_title();
$intro = crescendo_local('local-hero-intro');
$ctaPrimary = crescendo_local('local-hero-cta-primary');
$ctaSecondary = crescendo_local('local-hero-cta-secondary');
$image = crescendo_local('local-hero-image');
$note = crescendo_local('local-hero-note');
$benefits = crescendo_local('local-benefits');
?>
<section class="secteur-hero">
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

        <div class="secteur-hero__inner">
            <div class="secteur-hero__content">
                <?php if ($eyebrow) : ?><p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
                <h1 class="secteur-hero__title"><?php echo esc_html($title); ?></h1>
                <?php if ($intro) : ?><p class="secteur-hero__intro"><?php echo esc_html($intro); ?></p><?php endif; ?>
                <div class="secteur-hero__actions">
                    <?php echo crescendo_link($ctaPrimary, 'btn btn--primary'); ?>
                    <?php echo crescendo_link($ctaSecondary, 'btn btn--outline'); ?>
                </div>
                <?php if ($note) : ?>
                    <p class="service-hero__note"><span class="service-hero__note-icon" aria-hidden="true">⏱</span><?php echo esc_html($note); ?></p>
                <?php endif; ?>
            </div>
            <div class="secteur-hero__visual">
                <?php if (!empty($image['url']) || !empty($image['ID']) || !empty($image['id'])) : ?>
                    <?php
                    echo crescendo_image($image, 'crescendo-content', array(
                        'alt' => $image['alt'] ?: $title,
                        'sizes' => '(min-width: 768px) 45vw, 100vw',
                        'loading' => 'eager',
                        'fetchpriority' => 'high',
                    ));
                    ?>
                <?php else : ?>
                    <div class="secteur-hero__placeholder"></div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($benefits)) : ?>
            <ul class="secteur-hero__benefits">
                <?php foreach ($benefits as $index => $item) : ?>
                    <li>
                        <span class="secteur-hero__benefit-icon" aria-hidden="true"><?php echo esc_html($index + 1); ?></span>
                        <strong><?php echo esc_html($item['title'] ?? ''); ?></strong>
                        <?php if (!empty($item['text'])) : ?><span><?php echo esc_html($item['text']); ?></span><?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
