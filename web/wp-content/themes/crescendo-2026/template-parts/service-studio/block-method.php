<?php
$eyebrow = crescendo_service('service-method-eyebrow') ?: __('Méthode', 'crescendo-2026');
$title = crescendo_service('service-method-title');
$steps = crescendo_service('service-method-steps');

if (!$title && empty($steps)) {
    return;
}
?>
<section class="studio-service-method" aria-labelledby="studio-service-method-title">
    <div class="shell">
    <div class="studio-section-head studio-section-head--center" data-studio-text-reveal>
        <p class="studio-eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php if ($title) : ?>
            <h2 id="studio-service-method-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
        <?php endif; ?>
    </div>

    <?php if (!empty($steps)) : ?>
        <ol class="studio-service-method__steps">
            <?php foreach ($steps as $index => $step) : ?>
                <li data-studio-text-reveal>
                    <span class="studio-service-method__index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                    <h3><?php echo esc_html($step['title'] ?? ''); ?></h3>
                    <p><?php echo esc_html($step['text'] ?? ''); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
    </div>
</section>