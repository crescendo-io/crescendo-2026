<?php
$eyebrow = crescendo_about('about-values-eyebrow');
$title = crescendo_about('about-values-title');
$items = crescendo_about('about-values-items');

if (!$title && empty($items)) {
    return;
}
?>
<section class="about-values">
    <div class="container">
        <?php if ($eyebrow) : ?><p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
        <?php if ($title) : ?><h2 class="service-section__title"><?php echo esc_html($title); ?></h2><?php endif; ?>

        <?php if (!empty($items)) : ?>
            <div class="about-values__grid">
                <?php foreach ($items as $item) : ?>
                    <article class="about-values__card">
                        <?php if (!empty($item['title'])) : ?>
                            <h3><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($item['text'])) : ?>
                            <p><?php echo esc_html($item['text']); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
