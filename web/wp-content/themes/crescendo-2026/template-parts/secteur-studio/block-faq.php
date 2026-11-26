<?php
$eyebrow = crescendo_secteur('secteur-faq-eyebrow');
$title = crescendo_secteur('secteur-faq-title') ?: __('Questions fréquentes', 'crescendo-2026');
$items = crescendo_secteur('secteur-faq-items');

if (empty($items)) {
    return;
}

$half = (int) ceil(count($items) / 2);
$columns = array(
    array_slice($items, 0, $half),
    array_slice($items, $half),
);
?>
<section class="studio-service-faq" aria-labelledby="studio-secteur-faq-title">
    <div class="shell">
    <div class="studio-service-faq__layout">
        <div class="studio-service-faq__intro">
            <?php if ($eyebrow) : ?>
                <p class="studio-eyebrow" data-studio-text-reveal><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <h2 id="studio-secteur-faq-title" data-studio-text-reveal>
                <?php echo esc_html($title); ?><span class="studio-red">.</span>
            </h2>
        </div>

        <div class="studio-service-faq__grid" data-studio-text-reveal>
            <?php foreach ($columns as $column) : ?>
                <?php if (empty($column)) {
                    continue;
                } ?>
                <div class="studio-service-faq__col">
                    <?php foreach ($column as $item) : ?>
                        <details class="studio-service-faq__item" name="studio-secteur-faq">
                            <summary>
                                <span class="studio-service-faq__question"><?php echo esc_html($item['question'] ?? ''); ?></span>
                                <i aria-hidden="true"></i>
                            </summary>
                            <div class="studio-service-faq__answer">
                                <p><?php echo esc_html($item['answer'] ?? ''); ?></p>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
</section>