<?php
$eyebrow = crescendo_about('about-hero-eyebrow');
$title = crescendo_about('about-hero-title') ?: get_the_title();
$intro = crescendo_about('about-hero-intro');
$stats = crescendo_about('about-story-stats');
$items = crescendo_about_breadcrumb();
$hasPanel = !empty($stats);
?>
<section class="about-hero">
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

        <?php if ($eyebrow) : ?>
            <p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <h1 class="about-hero__title"><?php echo esc_html($title); ?></h1>

        <div class="about-hero__layout<?php echo $hasPanel ? ' about-hero__layout--split' : ''; ?>">
            <?php if ($intro) : ?>
                <p class="about-hero__intro"><?php echo esc_html($intro); ?></p>
            <?php endif; ?>

            <?php if ($hasPanel) : ?>
                <ul class="about-hero__stats">
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
        </div>
    </div>
</section>
