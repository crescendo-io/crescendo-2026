<?php
$eyebrow = crescendo_service('service-included-eyebrow');
$title = crescendo_service('service-included-title');
$text = crescendo_service('service-included-text');
$cta = crescendo_service('service-included-cta');
$features = crescendo_service('service-included-features');

if (!$title && empty($features) && !$cta) {
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

            <?php if ($cta) : ?>
                <div class="service-included__actions">
                    <?php echo crescendo_link($cta, 'btn btn--primary'); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($features)) : ?>
            <div class="service-included__panel">
                <ul class="service-included__features">
                    <?php foreach ($features as $feature) : ?>
                        <?php $line = is_array($feature) ? ($feature['text'] ?? '') : $feature; ?>
                        <?php if ($line) : ?><li><?php echo esc_html($line); ?></li><?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</section>
