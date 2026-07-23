<?php
$eyebrow = crescendo_service('service-faq-eyebrow');
$title = crescendo_service('service-faq-title') ?: 'Questions fréquentes';
$items = crescendo_service('service-faq-items');

if (empty($items)) {
    return;
}

$half = (int) ceil(count($items) / 2);
$columns = array(
    array_slice($items, 0, $half),
    array_slice($items, $half),
);
?>
<section class="service-faq-section">
    <div class="container">
        <?php if ($eyebrow) : ?>
            <p class="service-eyebrow service-eyebrow--center"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2>

        <div class="service-faq-section__columns">
            <?php foreach ($columns as $column) : ?>
                <?php if (empty($column)) {
                    continue;
                } ?>
                <div class="service-faq-section__col">
                    <?php foreach ($column as $index => $item) : ?>
                        <details class="home-faq__item service-faq__item">
                            <summary class="home-faq__question">
                                <?php echo esc_html($item['question'] ?? ''); ?>
                                <span class="home-faq__toggle" aria-hidden="true"></span>
                            </summary>
                            <div class="home-faq__answer">
                                <p><?php echo esc_html($item['answer'] ?? ''); ?></p>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
