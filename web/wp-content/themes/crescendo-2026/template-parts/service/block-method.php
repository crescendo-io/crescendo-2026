<?php
$eyebrow = crescendo_service('service-method-eyebrow') ?: 'Notre méthode';
$title = crescendo_service('service-method-title');
$steps = crescendo_service('service-method-steps');

if (!$title && empty($steps)) {
    return;
}
?>
<section class="service-method">
    <div class="container">
        <p class="service-eyebrow service-eyebrow--center"><?php echo esc_html($eyebrow); ?></p>

        <?php if ($title) : ?>
            <h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if (!empty($steps)) : ?>
            <ol class="service-method__steps">
                <?php foreach ($steps as $index => $step) : ?>
                    <li class="service-method__step">
                        <span class="service-method__number"><?php echo esc_html($index + 1); ?></span>
                        <h3><?php echo esc_html($step['title'] ?? ''); ?></h3>
                        <p><?php echo esc_html($step['text'] ?? ''); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>
</section>
