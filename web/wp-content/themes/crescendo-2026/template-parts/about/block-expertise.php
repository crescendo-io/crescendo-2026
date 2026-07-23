<?php
$eyebrow = crescendo_about('about-expertise-eyebrow');
$title = crescendo_about('about-expertise-title');
$text = crescendo_about('about-expertise-text');
$items = crescendo_about('about-expertise-items');

if (!$title && empty($items)) {
    return;
}
?>
<section class="about-expertise">
    <div class="container about-expertise__inner">
        <div class="about-expertise__intro">
            <?php if ($eyebrow) : ?><p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
            <?php if ($title) : ?><h2 class="service-section__title"><?php echo esc_html($title); ?></h2><?php endif; ?>
            <?php if ($text) : ?><p class="about-expertise__text"><?php echo esc_html($text); ?></p><?php endif; ?>
        </div>

        <?php if (!empty($items)) : ?>
            <ul class="about-expertise__list">
                <?php foreach ($items as $item) : ?>
                    <li><?php echo esc_html($item['text'] ?? ''); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
