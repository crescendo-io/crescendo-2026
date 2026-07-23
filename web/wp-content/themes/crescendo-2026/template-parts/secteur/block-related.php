<?php
$title = crescendo_secteur('secteur-related-title');
$sectors = crescendo_secteur('secteur-related-sectors');
if (!$title && empty($sectors)) {
    return;
}
?>
<section class="secteur-related">
    <div class="container">
        <?php if ($title) : ?><h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <?php if (!empty($sectors)) : ?>
            <div class="secteur-related__grid">
                <?php foreach ($sectors as $index => $sector) : ?>
                    <a href="<?php echo esc_url($sector['url'] ?? '#'); ?>" class="secteur-related__card">
                        <span class="secteur-related__icon" aria-hidden="true"><?php echo esc_html($index + 1); ?></span>
                        <strong><?php echo esc_html($sector['title'] ?? ''); ?></strong>
                        <span>En savoir plus →</span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
