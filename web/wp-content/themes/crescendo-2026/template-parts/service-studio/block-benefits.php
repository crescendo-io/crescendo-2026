<?php
$benefits = crescendo_service('service-benefits');
if (empty($benefits)) {
    return;
}
?>
<section class="studio-service-benefits" aria-labelledby="studio-service-benefits-title">
    <div class="shell">
    <div class="studio-section-head" data-studio-text-reveal>
        <h2 id="studio-service-benefits-title">
            <?php esc_html_e('Ce que vous', 'crescendo-2026'); ?>
            <br>
            <?php esc_html_e('y gagnez', 'crescendo-2026'); ?><span class="studio-red">.</span>
        </h2>
    </div>
    <ul class="studio-service-benefits__grid">
        <?php foreach ($benefits as $index => $item) : ?>
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
    </div>
</section>