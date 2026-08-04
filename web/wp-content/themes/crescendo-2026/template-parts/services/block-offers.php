<?php
$eyebrow = crescendo_services_hub('services-offers-eyebrow') ?: 'Nos formules';
$title = crescendo_services_hub('services-offers-title') ?: 'Trois façons de lancer votre projet web';
$intro = crescendo_services_hub('services-offers-intro') ?: 'Que vous souhaitiez acheter, louer ou connecter votre site à un CRM, chaque offre inclut un accompagnement de proximité à Nantes et une approche SEO dès la conception.';
$offers = crescendo_get_services_hub_offers();

if (empty($offers)) {
    return;
}
?>
<section class="services-offers" id="offres">
    <div class="container">
        <?php if ($eyebrow) : ?><p class="service-eyebrow service-eyebrow--center"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
        <?php if ($title) : ?><h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <?php if ($intro) : ?><p class="service-section__intro service-section__intro--center"><?php echo esc_html($intro); ?></p><?php endif; ?>

        <?php if (!empty($offers)) : ?>
            <div class="services-offers__grid">
                <?php foreach ($offers as $offer) : ?>
                    <?php
                    $isFeatured = !empty($offer['featured']);
                    $cardClass = 'services-offers__card' . ($isFeatured ? ' services-offers__card--featured' : '');
                    $tag = !empty($offer['url']) ? 'a' : 'article';
                    ?>
                    <<?php echo $tag; ?>
                        class="<?php echo esc_attr($cardClass); ?>"
                        <?php echo !empty($offer['url']) ? ' href="' . esc_url($offer['url']) . '"' : ''; ?>
                    >
                        <?php if (!empty($offer['eyebrow'])) : ?>
                            <p class="services-offers__eyebrow"><?php echo esc_html($offer['eyebrow']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($offer['title'])) : ?>
                            <h3 class="services-offers__title"><?php echo esc_html($offer['title']); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($offer['text'])) : ?>
                            <p class="services-offers__text"><?php echo esc_html($offer['text']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($offer['price'])) : ?>
                            <p class="services-offers__price">
                                <strong><?php echo esc_html($offer['price']); ?></strong>
                                <?php if (!empty($offer['price_suffix'])) : ?>
                                    <span><?php echo esc_html($offer['price_suffix']); ?></span>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>

                        <?php if (!empty($offer['features'])) : ?>
                            <ul class="services-offers__features">
                                <?php foreach ($offer['features'] as $feature) : ?>
                                    <?php
                                    $featureText = is_array($feature) ? ($feature['text'] ?? '') : $feature;
                                    ?>
                                    <?php if ($featureText) : ?><li><?php echo esc_html($featureText); ?></li><?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if (!empty($offer['url'])) : ?>
                            <span class="services-offers__link">
                                <?php echo esc_html($offer['cta_title'] ?? 'Découvrir l\'offre →'); ?>
                            </span>
                        <?php endif; ?>
                    </<?php echo $tag; ?>>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
