<?php
$title = crescendo_landing('landing-why-title') ?: 'Pourquoi confier votre site à Crescendo ?';
$items = crescendo_landing('landing-why-items');

if (empty($items)) {
    return;
}
?>
<section class="landing-why">
    <div class="container landing-why__inner">
        <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
        <ul class="landing-why__list">
            <?php foreach ($items as $item) : ?>
                <?php $line = is_array($item) ? ($item['text'] ?? '') : $item; ?>
                <?php if ($line) : ?><li><?php echo esc_html($line); ?></li><?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
