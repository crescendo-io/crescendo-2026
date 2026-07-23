<?php
$title = crescendo_local('local-area-title');
$text = crescendo_local('local-area-text');
$cities = crescendo_local('local-area-cities');
$seeAll = crescendo_local('local-area-see-all');
if (!$title && empty($cities)) {
    return;
}
?>
<section class="secteur-area" id="zone-intervention">
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
            <?php echo crescendo_link($seeAll, 'local-area__see-all'); ?>
        <?php endif; ?>
    </div>
</section>
