<?php
$eyebrow = crescendo_service('service-hero-eyebrow');
$title = crescendo_service('service-hero-title') ?: get_the_title();
$intro = crescendo_service('service-hero-intro');
$ctaPrimary = crescendo_service('service-hero-cta-primary');
$ctaSecondary = crescendo_service('service-hero-cta-secondary');
$image = crescendo_service('service-hero-image');
$note = crescendo_service('service-hero-note');
$items = crescendo_service_breadcrumb();
?>
<section class="service-hero">
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

        <div class="service-hero__inner">
            <div class="service-hero__content">
                <?php if ($eyebrow) : ?>
                    <p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <h1 class="service-hero__title"><?php echo esc_html($title); ?></h1>

                <?php if ($intro) : ?>
                    <p class="service-hero__intro"><?php echo esc_html($intro); ?></p>
                <?php endif; ?>

                <div class="service-hero__actions">
                    <?php echo crescendo_link($ctaPrimary, 'btn btn--primary'); ?>
                    <?php echo crescendo_link($ctaSecondary, 'btn btn--outline btn--arrow-down'); ?>
                </div>

                <?php if ($note) : ?>
                    <p class="service-hero__note">
                        <span class="service-hero__note-icon" aria-hidden="true">⏱</span>
                        <?php echo esc_html($note); ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="service-hero__visual">
                <?php if (!empty($image['url'])) : ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $title); ?>">
                <?php else : ?>
                    <div class="service-hero__placeholder" aria-hidden="true"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
