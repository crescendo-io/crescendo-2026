<?php
$title = crescendo_about('about-cta-title');
$text = crescendo_about('about-cta-text');
$button = crescendo_about('about-cta-button');

if (!$title) {
    return;
}
?>
<section class="about-cta">
    <div class="container about-cta__inner">
        <h2 class="about-cta__title"><?php echo esc_html($title); ?></h2>

        <?php if ($text) : ?>
            <p class="about-cta__text"><?php echo esc_html($text); ?></p>
        <?php endif; ?>

        <?php echo crescendo_link($button, 'btn btn--primary'); ?>
    </div>
</section>
