<?php
$title = crescendo_secteur('secteur-pain-title');
$items = crescendo_secteur('secteur-pain-items');
if (!$title && empty($items)) {
    return;
}
?>
<section class="studio-service-benefits studio-secteur-pain" aria-labelledby="studio-secteur-pain-title">
    <div class="shell">
    <div class="studio-section-head" data-studio-text-reveal>
        <?php if ($title) : ?>
            <h2 id="studio-secteur-pain-title">
                <?php echo esc_html($title); ?><span class="studio-red">.</span>
            </h2>
        <?php endif; ?>
    </div>
    <?php if (!empty($items)) : ?>
        <ul class="studio-service-benefits__grid">
            <?php foreach ($items as $index => $item) : ?>
                <li data-studio-text-reveal>
                    <span class="studio-service-benefits__index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
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