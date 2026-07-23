<?php
$eyebrow = crescendo_services_hub('services-hero-eyebrow');
$title = crescendo_services_hub('services-hero-title') ?: get_the_title();
$intro = crescendo_services_hub('services-hero-intro');
$ctaPrimary = crescendo_services_hub('services-hero-cta-primary');
$items = crescendo_services_hub_breadcrumb();
?>
<section class="services-hero">
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

        <div class="services-hero__inner">
            <?php if ($eyebrow) : ?>
                <p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <h1 class="services-hero__title"><?php echo esc_html($title); ?></h1>

            <?php if ($intro) : ?>
                <p class="services-hero__intro"><?php echo esc_html($intro); ?></p>
            <?php endif; ?>

            <?php if (!empty($ctaPrimary['url'])) : ?>
                <div class="services-hero__actions">
                    <?php echo crescendo_link($ctaPrimary, 'btn btn--primary'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
