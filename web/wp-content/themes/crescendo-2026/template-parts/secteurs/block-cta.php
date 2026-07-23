<?php
$title = crescendo_secteurs_hub('secteurs-cta-title');
$text = crescendo_secteurs_hub('secteurs-cta-text');
$button = crescendo_secteurs_hub('secteurs-cta-button');

if (!$title && !$text && empty($button['url'])) {
    return;
}
?>
<section class="secteurs-cta">
    <div class="container">
        <div class="secteurs-cta__inner">
            <?php if ($title) : ?>
                <h2 class="secteurs-cta__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p class="secteurs-cta__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if (!empty($button['url'])) : ?>
                <div class="secteurs-cta__actions">
                    <?php echo crescendo_link($button, 'btn btn--primary'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
