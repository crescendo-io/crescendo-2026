<?php
$title = crescendo_secteur('secteur-area-title');
$text = crescendo_secteur('secteur-area-text');
$cities = crescendo_secteur('secteur-area-cities');
$seeAll = crescendo_secteur('secteur-area-see-all');
if (!$title && empty($cities)) {
    return;
}
?>
<section class="studio-secteur-area" aria-labelledby="studio-secteur-area-title">
    <div class="shell">
    <div class="studio-secteur-area__intro" data-studio-text-reveal>
        <?php if ($title) : ?>
            <h2 id="studio-secteur-area-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
        <?php endif; ?>
        <?php if ($text) : ?>
            <p class="studio-secteur-area__text"><?php echo esc_html($text); ?></p>
        <?php endif; ?>
    </div>
    <?php if (!empty($cities)) : ?>
        <ul class="studio-secteur-area__cities" data-studio-text-reveal>
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
        <p class="studio-secteur-area__more" data-studio-text-reveal>
            <a class="studio-text-link" href="<?php echo esc_url($seeAll['url']); ?>">
                <?php echo esc_html($seeAll['title'] ?? __('Toutes les villes', 'crescendo-2026')); ?>
            </a>
        </p>
    <?php endif; ?>
    </div>
</section>