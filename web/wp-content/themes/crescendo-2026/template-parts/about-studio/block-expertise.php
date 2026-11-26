<?php
$eyebrow = crescendo_about('about-expertise-eyebrow');
$title = crescendo_about('about-expertise-title');
$text = crescendo_about('about-expertise-text');
$items = crescendo_about('about-expertise-items');

if (!$title && empty($items)) {
    return;
}
?>
<section class="studio-about-expertise" aria-labelledby="studio-about-expertise-title">
    <div class="shell studio-about-expertise__layout">
        <div class="studio-about-expertise__intro" data-studio-text-reveal>
            <?php if ($eyebrow) : ?>
                <p class="studio-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($title) : ?>
                <h2 id="studio-about-expertise-title">
                    <?php echo esc_html($title); ?><span class="studio-red">.</span>
                </h2>
            <?php endif; ?>
            <?php if ($text) : ?>
                <p class="studio-about-expertise__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>

        <?php if (!empty($items)) : ?>
            <div class="studio-about-expertise__panel" data-studio-text-reveal>
                <p class="studio-about-expertise__panel-label"><?php esc_html_e('Ce que nous livrons', 'crescendo-2026'); ?></p>
                <ul class="studio-about-expertise__list">
                    <?php foreach ($items as $item) : ?>
                        <?php if (!empty($item['text'])) : ?>
                            <li><?php echo esc_html($item['text']); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</section>