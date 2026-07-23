<?php
$title = crescendo_service('service-problem-title');
$content = crescendo_service('service-problem-content');
$points = crescendo_service('service-problem-points');

if (!$title && !$content && empty($points)) {
    return;
}
?>
<section class="service-section service-section--alt">
    <div class="container service-section__inner">
        <?php if ($title) : ?>
            <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($content) : ?>
            <div class="service-section__content"><?php echo wp_kses_post($content); ?></div>
        <?php endif; ?>

        <?php if (!empty($points)) : ?>
            <ul class="service-checklist">
                <?php foreach ($points as $point) : ?>
                    <?php $text = is_array($point) ? ($point['text'] ?? '') : $point; ?>
                    <?php if ($text) : ?><li><?php echo esc_html($text); ?></li><?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
