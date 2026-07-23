<?php
$title = crescendo_service('service-cta-title');
$text = crescendo_service('service-cta-text');
$button = crescendo_service('service-cta-button');

if (!$title && !$button) {
    return;
}
?>
<section class="home-cta-band service-cta-band">
    <div class="container home-cta-band__inner">
        <div>
            <?php if ($title) : ?>
                <h2 class="home-cta-band__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            <?php if ($text) : ?>
                <p class="home-cta-band__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>
        <?php echo crescendo_link($button, 'btn btn--outline-dark'); ?>
    </div>
</section>
