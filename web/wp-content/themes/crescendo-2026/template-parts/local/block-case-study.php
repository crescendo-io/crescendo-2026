<?php
$title = crescendo_local('local-case-title');
$caseProject = crescendo_resolve_case_study_project('local-case', 'crescendo_local');

if (empty($caseProject['project_id'])) {
    return;
}

$projectTitle = $caseProject['title'] ?? '';
$projectTags = $caseProject['tags'] ?? '';
$projectPoints = $caseProject['points'] ?? array();
$projectUrl = $caseProject['url'] ?? '';
$projectImage = $caseProject['image'] ?? null;
$hasProjectImage = crescendo_project_image_has_source($projectImage);
?>
<section class="secteur-case">
    <div class="container">
        <?php if ($title) : ?><h2 class="service-section__title"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <div class="secteur-case__inner<?php echo $hasProjectImage ? ' secteur-case__inner--with-visual' : ''; ?>">
            <?php if ($hasProjectImage) : ?>
                <div class="secteur-case__visual">
                    <?php
                    echo crescendo_image($projectImage, 'crescendo-content', array(
                        'alt' => $projectTitle,
                        'sizes' => '(min-width: 768px) 50vw, 100vw',
                        'loading' => 'lazy',
                    ));
                    ?>
                </div>
            <?php endif; ?>
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
