<?php
$title = crescendo_realisations('realisations-cta-title');
$text = crescendo_realisations('realisations-cta-text');
$button = crescendo_realisations('realisations-cta-button');

if (!$title) {
    return;
}
?>
<section class="realisations-cta">
    <div class="container realisations-cta__inner">
        <h2 class="realisations-cta__title"><?php echo esc_html($title); ?></h2>

        <?php if ($text) : ?>
            <p class="realisations-cta__text"><?php echo esc_html($text); ?></p>
        <?php endif; ?>

        <?php echo crescendo_link($button, 'btn btn--primary'); ?>
    </div>
</section>
