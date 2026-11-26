<?php
$title = crescendo_about('about-story-title');
$text = crescendo_about('about-story-text');

if (!$title && !$text) {
    return;
}
?>
<section class="studio-about-story" id="histoire" aria-labelledby="studio-about-story-title">
    <div class="shell studio-about-story__layout">
        <div class="studio-about-story__intro" data-studio-text-reveal>
            <?php if ($title) : ?>
                <h2 id="studio-about-story-title">
                    <?php echo esc_html($title); ?><span class="studio-red">.</span>
                </h2>
            <?php endif; ?>
        </div>

        <?php if ($text) : ?>
            <div class="studio-about-story__content" data-studio-text-reveal>
                <?php echo wp_kses_post($text); ?>
            </div>
        <?php endif; ?>
    </div>
</section>