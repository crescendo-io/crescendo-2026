<?php
$title = crescendo_secteur('secteur-related-title') ?: __('Autres secteurs', 'crescendo-2026');
$sectors = crescendo_secteur('secteur-related-sectors');
if (empty($sectors)) {
    return;
}
?>
<section class="studio-secteur-related" aria-labelledby="studio-secteur-related-title">
    <div class="shell">
    <div class="studio-section-head" data-studio-text-reveal>
        <h2 id="studio-secteur-related-title">
            <?php echo esc_html($title); ?><span class="studio-red">.</span>
        </h2>
    </div>
    <ul class="studio-secteur-related__grid">
        <?php foreach ($sectors as $index => $sector) : ?>
            <li data-studio-text-reveal>
                <a class="studio-secteur-related__card" href="<?php echo esc_url($sector['url'] ?? '#'); ?>">
                    <span class="studio-service-benefits__index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                    <span class="studio-secteur-related__title"><?php echo esc_html($sector['title'] ?? ''); ?></span>
                    <span class="studio-secteur-related__link" aria-hidden="true">→</span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    </div>
</section>