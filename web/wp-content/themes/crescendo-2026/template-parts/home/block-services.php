<?php
$eyebrow = crescendo_home('home-services-eyebrow');
$title = crescendo_home('home-services-title');
$link = crescendo_home('home-services-link');
$items = crescendo_home('home-services-items');
?>
<section class="home-services">
    <div class="container">
        <div class="home-section-head">
            <div>
                <?php if ($eyebrow) : ?>
                    <p class="home-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>
                <h2 class="home-section-head__title"><?php echo esc_html($title); ?></h2>
            </div>
            <?php echo crescendo_link($link, 'home-section-head__link'); ?>
        </div>

        <?php if (!empty($items)) : ?>
            <div class="home-services__grid">
                <?php foreach ($items as $index => $item) : ?>
                    <article class="home-service-card">
                        <div class="home-service-card__icon" aria-hidden="true"><?php echo esc_html($index + 1); ?></div>
                        <h3 class="home-service-card__title"><?php echo esc_html($item['title'] ?? ''); ?></h3>
                        <p class="home-service-card__text"><?php echo esc_html($item['text'] ?? ''); ?></p>
                        <?php if (!empty($item['url'])) : ?>
                            <a href="<?php echo esc_url($item['url']); ?>" class="home-service-card__link">En savoir plus →</a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
