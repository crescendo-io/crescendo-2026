<?php
$title = crescendo_secteur('secteur-features-title');
$items = crescendo_secteur('secteur-features-items');
if (!$title && empty($items)) {
    return;
}
?>
<section class="secteur-features service-section--alt">
    <div class="container">
        <?php if ($title) : ?><h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <?php if (!empty($items)) : ?>
            <ul class="secteur-features__grid">
                <?php foreach ($items as $index => $item) : ?>
                    <li class="secteur-features__item">
                        <span class="secteur-features__icon" aria-hidden="true"><?php echo esc_html($index + 1); ?></span>
                        <div>
                            <?php if (!empty($item['title'])) : ?><strong><?php echo esc_html($item['title']); ?></strong><?php endif; ?>
                            <?php if (!empty($item['text'])) : ?><p><?php echo esc_html($item['text']); ?></p><?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
