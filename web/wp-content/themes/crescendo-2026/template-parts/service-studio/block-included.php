<?php
$eyebrow = crescendo_service('service-included-eyebrow');
$title = crescendo_service('service-included-title');
$text = crescendo_service('service-included-text');
$cta = crescendo_service('service-included-cta');
$features = crescendo_service('service-included-features');

if (!$title && empty($features) && !$cta) {
    return;
}
?>
<section class="studio-service-included" id="inclus" aria-labelledby="studio-service-included-title">
    <div class="shell">
    <div class="studio-service-included__layout">
        <div class="studio-service-included__intro">
            <?php if ($eyebrow) : ?>
                <p class="studio-eyebrow" data-studio-text-reveal><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($title) : ?>
                <h2 id="studio-service-included-title" data-studio-text-reveal>
                    <?php echo esc_html($title); ?><span class="studio-red">.</span>
                </h2>
            <?php endif; ?>
            <?php if ($text) : ?>
                <p class="studio-service-included__text" data-studio-text-reveal><?php echo esc_html($text); ?></p>
            <?php endif; ?>
            <?php if ($cta) : ?>
                <p class="studio-service-included__cta" data-studio-text-reveal>
                    <?php echo crescendo_link($cta, 'studio-hero-offer studio-hero-offer--inline'); ?>
                </p>
            <?php endif; ?>
        </div>

        <?php if (!empty($features)) : ?>
            <div class="studio-service-included__panel" data-studio-text-reveal>
                <p class="studio-service-included__panel-label" aria-hidden="true">
                    <?php esc_html_e('Périmètre', 'crescendo-2026'); ?>
                </p>
                <ul class="studio-service-included__list">
                    <?php foreach ($features as $feature) : ?>
                        <?php $line = is_array($feature) ? ($feature['text'] ?? '') : $feature; ?>
                        <?php if ($line) : ?>
                            <li><?php echo esc_html($line); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    </div>
</section>