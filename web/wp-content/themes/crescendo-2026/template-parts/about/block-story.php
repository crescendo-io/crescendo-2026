<?php
$title = crescendo_about('about-story-title');
$text = crescendo_about('about-story-text');
$stats = crescendo_about('about-story-stats');

if (!$title && !$text) {
    return;
}
?>
<section class="about-story">
    <div class="container about-story__inner">
        <div class="about-story__content">
            <?php if ($title) : ?>
                <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <div class="about-story__text">
                    <?php echo wp_kses_post(wpautop($text)); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($stats)) : ?>
            <ul class="about-story__stats">
                <?php foreach ($stats as $stat) : ?>
                    <li>
                        <strong><?php echo esc_html($stat['value'] ?? ''); ?></strong>
                        <span><?php echo esc_html($stat['label'] ?? ''); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
