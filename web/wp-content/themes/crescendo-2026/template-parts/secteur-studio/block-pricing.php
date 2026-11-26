<?php
$title = crescendo_secteur('secteur-pricing-title');
$price = crescendo_secteur('secteur-pricing-price');
$priceSuffix = crescendo_secteur('secteur-pricing-price-suffix') ?: '/mois';
$features = crescendo_secteur('secteur-pricing-features');
$cta = crescendo_secteur('secteur-pricing-cta');
if (!$title && !$price) {
    return;
}
?>
<section class="studio-secteur-pricing shell" id="tarifs" aria-labelledby="studio-secteur-pricing-title">
    <?php if ($title) : ?>
        <div class="studio-service-compare__head" data-studio-text-reveal>
            <h2 id="studio-secteur-pricing-title">
                <?php echo esc_html($title); ?><span class="studio-red">.</span>
            </h2>
        </div>
    <?php endif; ?>

    <div class="studio-secteur-pricing__layout">
        <?php if ($price) : ?>
            <div class="studio-secteur-pricing__offer" data-studio-text-reveal>
                <p class="studio-secteur-pricing__price">
                    <span class="studio-secteur-pricing__amount"><?php echo esc_html($price); ?></span>
                    <span class="studio-secteur-pricing__suffix"><?php echo esc_html($priceSuffix); ?></span>
                </p>
                <?php if (!empty($features)) : ?>
                    <ul class="studio-service-included__list studio-secteur-pricing__features">
                        <?php foreach ($features as $feature) : ?>
                            <?php $text = is_array($feature) ? ($feature['text'] ?? '') : $feature; ?>
                            <?php if ($text) : ?>
                                <li><?php echo esc_html($text); ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php if ($cta) : ?>
                    <p class="studio-secteur-pricing__cta">
                        <?php echo crescendo_link($cta, 'studio-hero-offer studio-hero-offer--inline'); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>