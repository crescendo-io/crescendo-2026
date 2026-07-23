<?php
$title = crescendo_local('local-solution-title');
$text = crescendo_local('local-solution-text');
$price = crescendo_local('local-solution-price');
$priceLabel = crescendo_local('local-solution-price-label');
$usps = crescendo_local('local-solution-usps');
if (!$title && !$text && empty($usps)) {
    return;
}
?>
<section class="secteur-solution">
    <div class="container local-solution__inner">
        <div class="secteur-solution__content">
            <?php if ($title) : ?><h2 class="service-section__title"><?php echo esc_html($title); ?></h2><?php endif; ?>
            <?php if ($text) : ?><p class="service-section__text"><?php echo esc_html($text); ?></p><?php endif; ?>
            <?php if ($price) : ?>
                <div class="secteur-solution__highlight">
                    <strong><?php echo esc_html($price); ?></strong>
                    <?php if ($priceLabel) : ?><span><?php echo esc_html($priceLabel); ?></span><?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php if (!empty($usps)) : ?>
            <div class="secteur-solution__usps">
                <?php foreach ($usps as $index => $usp) : ?>
                    <article class="secteur-solution__usp">
                        <span aria-hidden="true"><?php echo esc_html($index + 1); ?></span>
                        <div>
                            <?php if (!empty($usp['title'])) : ?><h3><?php echo esc_html($usp['title']); ?></h3><?php endif; ?>
                            <?php if (!empty($usp['text'])) : ?><p><?php echo esc_html($usp['text']); ?></p><?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
