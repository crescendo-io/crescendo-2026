<?php
$eyebrow = crescendo_services_hub('services-offers-eyebrow') ?: __('Nos formules', 'crescendo-2026');
$title = crescendo_services_hub('services-offers-title');
$intro = crescendo_services_hub('services-offers-intro');
$offers = crescendo_get_services_hub_offers();

if (empty($offers)) {
    return;
}
?>
<section class="studio-services-hub-offers" id="offres" aria-labelledby="studio-services-hub-offers-title">
    <div class="shell">
        <div class="studio-section-head studio-section-head--stacked" data-studio-text-reveal>
            <?php if ($eyebrow) : ?>
                <p class="studio-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($title) : ?>
                <h2 id="studio-services-hub-offers-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
            <?php endif; ?>
            <?php if ($intro) : ?>
                <p class="studio-services-hub-offers__intro"><?php echo esc_html($intro); ?></p>
            <?php endif; ?>
        </div>

        <div class="studio-services-hub-offers__grid">
            <?php foreach ($offers as $index => $offer) : ?>
                <?php
                $tag = !empty($offer['url']) ? 'a' : 'article';
                $cardClass = 'studio-services-hub-offers__card';
                if (!empty($offer['featured'])) {
                    $cardClass .= ' studio-services-hub-offers__card--featured';
                }
                ?>
                <<?php echo $tag; ?>
                    class="<?php echo esc_attr($cardClass); ?>"
                    <?php echo !empty($offer['url']) ? ' href="' . esc_url($offer['url']) . '"' : ''; ?>
                    data-studio-text-reveal
                >
                    <span class="studio-services-hub-offers__index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>

                    <?php if (!empty($offer['eyebrow'])) : ?>
                        <p class="studio-services-hub-offers__eyebrow"><?php echo esc_html($offer['eyebrow']); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($offer['title'])) : ?>
                        <h3><?php echo esc_html($offer['title']); ?></h3>
                    <?php endif; ?>

                    <?php if (!empty($offer['text'])) : ?>
                        <p><?php echo esc_html($offer['text']); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($offer['price'])) : ?>
                        <p class="studio-services-hub-offers__price">
                            <strong><?php echo esc_html($offer['price']); ?></strong>
                            <?php if (!empty($offer['price_suffix'])) : ?>
                                <span><?php echo esc_html($offer['price_suffix']); ?></span>
                            <?php endif; ?>
                        </p>
                    <?php endif; ?>

                    <?php if (!empty($offer['features'])) : ?>
                        <ul class="studio-services-hub-offers__features">
                            <?php foreach ($offer['features'] as $feature) : ?>
                                <?php if (!empty($feature['text'])) : ?>
                                    <li><?php echo esc_html($feature['text']); ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php if (!empty($offer['url'])) : ?>
                        <span class="studio-text-link studio-services-hub-offers__cta">
                            <?php echo esc_html($offer['cta_title'] ?? __('Découvrir l\'offre', 'crescendo-2026')); ?>
                        </span>
                    <?php endif; ?>
                </<?php echo $tag; ?>>
            <?php endforeach; ?>
        </div>
    </div>
</section>