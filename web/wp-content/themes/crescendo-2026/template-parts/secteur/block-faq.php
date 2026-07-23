<?php
$eyebrow = crescendo_secteur('secteur-faq-eyebrow');
$title = crescendo_secteur('secteur-faq-title');
$items = crescendo_secteur('secteur-faq-items');
if (empty($items)) {
    return;
}
$half = (int) ceil(count($items) / 2);
$columns = array(array_slice($items, 0, $half), array_slice($items, $half));
?>
<section class="service-faq-section service-section--alt">
    <div class="container">
        <?php if ($eyebrow) : ?><p class="service-eyebrow service-eyebrow--center"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
        <?php if ($title) : ?><h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <div class="service-faq-section__columns">
            <?php foreach ($columns as $column) : ?>
                <?php if (empty($column)) {
                    continue;
                } ?>
                <div class="service-faq-section__col">
                    <?php foreach ($column as $item) : ?>
                        <details class="home-faq__item service-faq__item">
                            <summary class="home-faq__question">
                                <?php echo esc_html($item['question'] ?? ''); ?>
                                <span class="home-faq__toggle" aria-hidden="true"></span>
                            </summary>
                            <div class="home-faq__answer"><p><?php echo esc_html($item['answer'] ?? ''); ?></p></div>
                        </details>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
