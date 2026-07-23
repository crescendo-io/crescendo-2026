<?php
$eyebrow = crescendo_local('local-method-eyebrow');
$title = crescendo_local('local-method-title');
$steps = crescendo_local('local-method-steps');
if (!$title && empty($steps)) {
    return;
}
?>
<section class="local-method service-section--alt" id="notre-methode">
    <div class="container">
        <?php if ($eyebrow) : ?><p class="service-eyebrow service-eyebrow--center"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
        <?php if ($title) : ?><h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <?php if (!empty($steps)) : ?>
            <ol class="service-method__steps">
                <?php foreach ($steps as $index => $step) : ?>
                    <li class="service-method__step">
                        <span class="service-method__number"><?php echo esc_html($index + 1); ?></span>
                        <?php if (!empty($step['title'])) : ?><h3><?php echo esc_html($step['title']); ?></h3><?php endif; ?>
                        <?php if (!empty($step['text'])) : ?><p><?php echo esc_html($step['text']); ?></p><?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>
</section>
