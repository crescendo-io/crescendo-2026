<?php
$title = crescendo_sitemap('sitemap-hero-title') ?: get_the_title();
$intro = crescendo_sitemap('sitemap-hero-intro');
$items = crescendo_sitemap_breadcrumb();
?>
<section class="sitemap-hero">
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

        <h1 class="sitemap-hero__title"><?php echo esc_html($title); ?></h1>

        <?php if ($intro) : ?>
            <p class="sitemap-hero__intro"><?php echo esc_html($intro); ?></p>
        <?php endif; ?>
    </div>
</section>
