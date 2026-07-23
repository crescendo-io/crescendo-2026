<?php
$title = crescendo_services_hub('services-cta-title');
$text = crescendo_services_hub('services-cta-text');
$button = crescendo_services_hub('services-cta-button');

if (!$title && !$text && empty($button['url'])) {
    return;
}
?>
<section class="services-cta">
    <div class="container">
        <div class="services-cta__inner">
            <?php if ($title) : ?>
                <h2 class="services-cta__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p class="services-cta__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if (!empty($button['url'])) : ?>
                <div class="services-cta__actions">
                    <?php echo crescendo_link($button, 'btn btn--primary'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
