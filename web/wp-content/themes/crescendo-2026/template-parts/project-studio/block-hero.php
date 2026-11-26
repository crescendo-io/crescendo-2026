<?php
$eyebrow = crescendo_project('project-hero-eyebrow');
$title = crescendo_project('project-hero-title') ?: get_the_title();
$intro = crescendo_project('project-hero-intro');
$clientUrl = crescendo_project('project-client-url');
$image = crescendo_project('project-hero-image');
$client = crescendo_project('project-client-name');
$sector = crescendo_project('project-sector');
$year = crescendo_project('project-year');
$tags = crescendo_project('project-tags');
$tech = crescendo_project('project-tech-tags');
$hasCrm = crescendo_project('project-has-crm');

$realisations = get_page_by_path('realisations', OBJECT, 'page');
$backUrl = $realisations ? get_permalink($realisations) : home_url('/realisations/');

$metaRows = array();
if ($client) {
    $metaRows[] = array('label' => __('Client', 'crescendo-2026'), 'value' => $client);
}
if ($sector) {
    $metaRows[] = array('label' => __('Secteur', 'crescendo-2026'), 'value' => $sector);
}
if ($year) {
    $metaRows[] = array('label' => __('Année', 'crescendo-2026'), 'value' => $year);
}
if ($tags) {
    $metaRows[] = array('label' => __('Prestations', 'crescendo-2026'), 'value' => $tags);
}
if ($tech) {
    $metaRows[] = array('label' => __('Stack', 'crescendo-2026'), 'value' => $tech);
}
if ($hasCrm) {
    $metaRows[] = array('label' => __('CRM', 'crescendo-2026'), 'value' => __('Intégré', 'crescendo-2026'));
}

$hasHeroImage = crescendo_project_image_has_source($image);
?>
<section class="studio-project-hero studio-page-hero--dark studio-project-hero--dark" aria-labelledby="studio-project-hero-title">
    <div class="shell studio-project-hero__inner studio-page-hero__inner">
        <p class="studio-project-hero__back" data-studio-text-reveal>
            <a class="studio-text-link" href="<?php echo esc_url($backUrl); ?>"><?php esc_html_e('← Réalisations', 'crescendo-2026'); ?></a>
        </p>

        <div class="studio-page-hero__layout" data-studio-text-reveal>
            <div class="studio-page-hero__main">
                <?php if ($eyebrow) : ?>
                    <p class="studio-eyebrow">
                        <span class="studio-signal" aria-hidden="true"></span>
                        <?php echo esc_html($eyebrow); ?>
                    </p>
                <?php endif; ?>

                <h1 id="studio-project-hero-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h1>

                <?php if ($clientUrl) : ?>
                    <p class="studio-project-hero__actions studio-page-hero__actions">
                        <a class="studio-text-link" href="<?php echo esc_url($clientUrl); ?>" target="_blank" rel="noopener noreferrer">
                            <?php esc_html_e('Visiter le site', 'crescendo-2026'); ?>
                        </a>
                    </p>
                <?php endif; ?>
            </div>

            <?php if ($intro) : ?>
                <div class="studio-page-hero__aside">
                    <p class="studio-project-hero__intro"><?php echo esc_html($intro); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($metaRows)) : ?>
            <dl class="studio-project-hero__meta" data-studio-text-reveal>
                <?php foreach ($metaRows as $row) : ?>
                    <div class="studio-project-hero__meta-item">
                        <dt><?php echo esc_html($row['label']); ?></dt>
                        <dd><?php echo esc_html($row['value']); ?></dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        <?php endif; ?>

        <?php if ($hasHeroImage) : ?>
            <figure class="studio-project-hero__cover" data-studio-text-reveal>
                <?php
                $heroAlt = crescendo_project_hero_image_alt($image);
                $heroAttr = array(
                    'sizes' => '(min-width: 1240px) 1200px, 100vw',
                    'loading' => 'eager',
                    'fetchpriority' => 'high',
                );
                if ($heroAlt !== '') {
                    $heroAttr['alt'] = $heroAlt;
                }
                echo crescendo_image($image, 'crescendo-hero', $heroAttr);
                ?>
            </figure>
        <?php endif; ?>
    </div>
</section>