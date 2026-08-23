<?php
$title = crescendo_landing('landing-included-title') ?: 'Ce qui est compris à partir de 2 999 €';
$items = crescendo_landing('landing-included-items');
$whyItems = crescendo_landing('landing-why-items');
$whyTitle = crescendo_landing('landing-why-title') ?: 'Pourquoi Crescendo ?';

if (empty($items)) {
    return;
}
?>
<section class="landing-included">
    <div class="container">
        <h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2>

        <div class="landing-included__layout">
            <div class="landing-included__main">
                <ul class="landing-included__list">
                    <?php foreach ($items as $index => $item) : ?>
                        <li class="landing-included__item">
                            <span class="landing-included__index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                            <div class="landing-included__item-body">
                                <?php if (!empty($item['title'])) : ?>
                                    <h3 class="landing-included__item-title"><?php echo esc_html($item['title']); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($item['text'])) : ?>
                                    <p><?php echo esc_html($item['text']); ?></p>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if (!empty($whyItems)) : ?>
                <aside class="landing-included__aside">
                    <h3 class="landing-included__aside-title"><?php echo esc_html($whyTitle); ?></h3>
                    <ul class="landing-included__aside-list">
                        <?php foreach ($whyItems as $item) : ?>
                            <?php $line = is_array($item) ? ($item['text'] ?? '') : $item; ?>
                            <?php if ($line) : ?><li><?php echo esc_html($line); ?></li><?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </aside>
            <?php endif; ?>
        </div>
    </div>
</section>
