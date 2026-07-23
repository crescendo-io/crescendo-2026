<?php
$title = crescendo_secteur('secteur-pain-title');
$items = crescendo_secteur('secteur-pain-items');
if (!$title && empty($items)) {
    return;
}
?>
<section class="secteur-pain service-section--alt">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <?php if (!empty($items)) : ?>
            <div class="secteur-pain__grid">
                <?php foreach ($items as $index => $item) : ?>
                    <article class="secteur-pain__card">
                        <span class="secteur-pain__icon" aria-hidden="true"><?php echo esc_html($index + 1); ?></span>
                        <?php if (!empty($item['title'])) : ?><h3><?php echo esc_html($item['title']); ?></h3><?php endif; ?>
                        <?php if (!empty($item['text'])) : ?><p><?php echo esc_html($item['text']); ?></p><?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
