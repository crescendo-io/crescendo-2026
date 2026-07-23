<?php
$title = crescendo_service('service-area-title');
$text = crescendo_service('service-area-text');
$cities = crescendo_service('service-area-cities');

if (!$title && !$text && empty($cities)) {
    return;
}
?>
<section class="service-section service-section--alt">
    <div class="container service-area">
        <?php if ($title) : ?>
            <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($text) : ?>
            <p class="service-section__intro"><?php echo esc_html($text); ?></p>
        <?php endif; ?>

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
    </div>
</section>
