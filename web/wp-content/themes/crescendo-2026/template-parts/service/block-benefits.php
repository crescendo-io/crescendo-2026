<?php
$benefits = crescendo_service('service-benefits');
if (empty($benefits)) {
    return;
}
?>
<section class="service-benefits">
    <div class="container">
        <ul class="service-benefits__grid">
            <?php foreach ($benefits as $index => $item) : ?>
                <li class="service-benefits__item">
                    <span class="service-benefits__icon" aria-hidden="true"><?php echo esc_html($index + 1); ?></span>
                    <?php if (!empty($item['title'])) : ?>
                        <strong><?php echo esc_html($item['title']); ?></strong>
                    <?php endif; ?>
                    <?php if (!empty($item['text'])) : ?>
                        <p><?php echo esc_html($item['text']); ?></p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
