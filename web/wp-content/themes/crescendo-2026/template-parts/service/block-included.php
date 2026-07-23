<?php
$eyebrow = crescendo_service('service-included-eyebrow');
$title = crescendo_service('service-included-title');
$text = crescendo_service('service-included-text');
$price = crescendo_service('service-included-price');
$priceSuffix = crescendo_service('service-included-price-suffix') ?: '/mois';
$cta = crescendo_service('service-included-cta');
$features = crescendo_service('service-included-features');

if (!$title && !$price && empty($features)) {
    return;
}
?>
<section class="service-included" id="inclus">
    <div class="container service-included__inner">
        <div class="service-included__offer">
            <?php if ($eyebrow) : ?>
                <p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title) : ?>
                <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p class="service-section__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if ($price) : ?>
                <div class="service-included__price-box">
                    <span class="service-included__price"><?php echo esc_html($price); ?></span>
                    <span class="service-included__suffix"><?php echo esc_html($priceSuffix); ?></span>
                </div>
            <?php endif; ?>

            <?php echo crescendo_link($cta, 'btn btn--primary'); ?>
        </div>

        <?php if (!empty($features)) : ?>
            <ul class="service-included__features">
                <?php foreach ($features as $feature) : ?>
                    <?php $line = is_array($feature) ? ($feature['text'] ?? '') : $feature; ?>
                    <?php if ($line) : ?><li><?php echo esc_html($line); ?></li><?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
