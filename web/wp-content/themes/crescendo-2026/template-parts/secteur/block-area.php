<?php
$title = crescendo_secteur('secteur-area-title');
$text = crescendo_secteur('secteur-area-text');
$cities = crescendo_secteur('secteur-area-cities');
$seeAll = crescendo_secteur('secteur-area-see-all');
if (!$title && empty($cities)) {
    return;
}
?>
<section class="secteur-area">
    <div class="container service-area">
        <?php if ($title) : ?><h2 class="service-section__title"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <?php if ($text) : ?><p class="service-section__text"><?php echo esc_html($text); ?></p><?php endif; ?>
        <?php if (!empty($cities)) : ?>
            <ul class="service-area__cities">
                <?php foreach ($cities as $city) : ?>
                    <li>
                        <?php if (!empty($city['url'])) : ?>
                            <a href="<?php echo esc_url($city['url']); ?>"><?php echo esc_html($city['name'] ?? ''); ?></a>
                        <?php else : ?>
                            <?php echo esc_html($city['name'] ?? ''); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <?php if (!empty($seeAll['url'])) : ?>
            <?php echo crescendo_link($seeAll, 'secteur-area__see-all'); ?>
        <?php endif; ?>
    </div>
</section>
