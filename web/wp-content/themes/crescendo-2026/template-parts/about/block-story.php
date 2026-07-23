<?php
$title = crescendo_about('about-story-title');
$text = crescendo_about('about-story-text');

if (!$title && !$text) {
    return;
}
?>
<section class="about-story">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($text) : ?>
            <div class="about-story__text">
                <?php echo wp_kses_post(wpautop($text)); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
