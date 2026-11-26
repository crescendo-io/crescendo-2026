<?php
$eyebrow = crescendo_about('about-values-eyebrow');
$title = crescendo_about('about-values-title');
$items = crescendo_about('about-values-items');

if (!$title && empty($items)) {
    return;
}
?>
<section class="studio-about-values" aria-labelledby="studio-about-values-title">
    <div class="shell">
        <div class="studio-section-head studio-section-head--stacked" data-studio-text-reveal>
            <?php if ($eyebrow) : ?>
                <p class="studio-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($title) : ?>
                <h2 id="studio-about-values-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
            <?php endif; ?>
        </div>

        <?php if (!empty($items)) : ?>
            <ul class="studio-about-values__grid">
                <?php foreach ($items as $index => $item) : ?>
                    <li data-studio-text-reveal>
                        <span class="studio-about-values__index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <?php if (!empty($item['title'])) : ?>
                            <h3><?php echo esc_html($item['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($item['text'])) : ?>
                            <p><?php echo esc_html($item['text']); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>