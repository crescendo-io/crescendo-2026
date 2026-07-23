<?php
$title = crescendo_secteur('secteur-case-title');
$projectTitle = crescendo_secteur('secteur-case-project-title');
$projectTags = crescendo_secteur('secteur-case-project-tags');
$projectPoints = crescendo_secteur('secteur-case-project-points');
$projectUrl = crescendo_secteur('secteur-case-project-url');
$projectImage = crescendo_secteur('secteur-case-project-image');
if (!$title && !$projectTitle) {
    return;
}
?>
<section class="secteur-case">
    <div class="container">
        <?php if ($title) : ?><h2 class="service-section__title"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <div class="secteur-case__inner">
            <div class="secteur-case__visual">
                <?php if (!empty($projectImage['url'])) : ?>
                    <img src="<?php echo esc_url($projectImage['url']); ?>" alt="<?php echo esc_attr($projectTitle); ?>">
                <?php else : ?>
                    <div class="secteur-case__placeholder"></div>
                <?php endif; ?>
            </div>
            <div class="secteur-case__content">
                <?php if ($projectTitle) : ?><h3><?php echo esc_html($projectTitle); ?></h3><?php endif; ?>
                <?php if ($projectTags) : ?><p class="secteur-case__tags"><?php echo esc_html($projectTags); ?></p><?php endif; ?>
                <?php if (!empty($projectPoints)) : ?>
                    <ul class="service-checklist">
                        <?php foreach ($projectPoints as $point) : ?>
                            <?php $line = is_array($point) ? ($point['text'] ?? '') : $point; ?>
                            <?php if ($line) : ?><li><?php echo esc_html($line); ?></li><?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php if ($projectUrl) : ?>
                    <a href="<?php echo esc_url($projectUrl); ?>" class="secteur-case__link">Voir le projet →</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
