<?php
$title = crescendo_secteur('secteur-case-title');
$caseProject = crescendo_resolve_case_study_project('secteur-case', 'crescendo_secteur');

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
<section class="studio-secteur-case" aria-labelledby="studio-secteur-case-title">
    <div class="shell">
    <div class="studio-section-head" data-studio-text-reveal>
        <?php if ($title) : ?>
            <h2 id="studio-secteur-case-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
        <?php endif; ?>
    </div>

    <div class="studio-secteur-case__layout<?php echo $hasProjectImage ? ' studio-secteur-case__layout--with-visual' : ''; ?>" data-studio-text-reveal>
        <?php if ($hasProjectImage) : ?>
            <figure class="studio-secteur-case__visual">
                <?php
                echo crescendo_image($projectImage, 'crescendo-content', array(
                    'alt' => $projectTitle,
                    'sizes' => '(min-width: 1024px) 44vw, 100vw',
                    'loading' => 'lazy',
                ));
                ?>
            </figure>
        <?php endif; ?>

        <div class="studio-secteur-case__content">
            <?php if ($projectTitle) : ?>
                <h3><?php echo esc_html($projectTitle); ?></h3>
            <?php endif; ?>
            <?php if ($projectTags) : ?>
                <p class="studio-secteur-case__tags"><?php echo esc_html($projectTags); ?></p>
            <?php endif; ?>
            <?php if (!empty($projectPoints)) : ?>
                <ul class="studio-service-included__list studio-secteur-case__points">
                    <?php foreach ($projectPoints as $point) : ?>
                        <?php $line = is_array($point) ? ($point['text'] ?? '') : $point; ?>
                        <?php if ($line) : ?>
                            <li><?php echo esc_html($line); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if ($projectUrl) : ?>
                <p class="studio-secteur-case__cta">
                    <a class="studio-text-link" href="<?php echo esc_url($projectUrl); ?>">
                        <?php esc_html_e('Voir le projet', 'crescendo-2026'); ?>
                    </a>
                </p>
            <?php endif; ?>
        </div>
    </div>
    </div>
</section>