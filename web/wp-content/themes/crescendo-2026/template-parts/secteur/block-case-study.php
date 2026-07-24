<?php
$title = crescendo_secteur('secteur-case-title');
$caseProject = crescendo_resolve_case_study_project('secteur-case', 'crescendo_secteur');
$projectTitle = $caseProject['title'] ?? '';
$projectTags = $caseProject['tags'] ?? '';
$projectPoints = $caseProject['points'] ?? array();
$projectUrl = $caseProject['url'] ?? '';
if (!$title && !$projectTitle) {
    return;
}
?>
<section class="secteur-case">
    <div class="container">
        <?php if ($title) : ?><h2 class="service-section__title"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <div class="secteur-case__inner">
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
