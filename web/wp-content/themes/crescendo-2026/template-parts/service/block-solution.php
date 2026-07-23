<?php
$title = crescendo_service('service-solution-title');
$content = crescendo_service('service-solution-content');
$usps = crescendo_service('service-solution-usps');

if (!$title && !$content && empty($usps)) {
    return;
}
?>
<section class="service-section">
    <div class="container service-section__inner">
        <?php if ($title) : ?>
            <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($content) : ?>
            <div class="service-section__content"><?php echo wp_kses_post($content); ?></div>
        <?php endif; ?>

        <?php if (!empty($usps)) : ?>
            <div class="service-usps">
                <?php foreach ($usps as $usp) : ?>
                    <article class="service-usp">
                        <?php if (!empty($usp['title'])) : ?>
                            <h3><?php echo esc_html($usp['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($usp['text'])) : ?>
                            <p><?php echo esc_html($usp['text']); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
