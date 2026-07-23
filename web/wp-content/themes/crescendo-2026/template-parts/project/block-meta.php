<?php
$client = crescendo_project('project-client-name');
$sector = crescendo_project('project-sector');
$year = crescendo_project('project-year');
$tags = crescendo_project('project-tags');
$tech = crescendo_project('project-tech-tags');
$clientUrl = crescendo_project('project-client-url');
$hasCrm = crescendo_project('project-has-crm');

if (!$client && !$sector && !$tags && !$clientUrl) {
    return;
}
?>
<section class="project-meta">
    <div class="container">
        <div class="project-meta__grid">
            <?php if ($client) : ?>
                <div class="project-meta__item">
                    <p class="project-meta__label">Client</p>
                    <p class="project-meta__value"><?php echo esc_html($client); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($sector) : ?>
                <div class="project-meta__item">
                    <p class="project-meta__label">Secteur</p>
                    <p class="project-meta__value"><?php echo esc_html($sector); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($year) : ?>
                <div class="project-meta__item">
                    <p class="project-meta__label">Année</p>
                    <p class="project-meta__value"><?php echo esc_html($year); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($tags) : ?>
                <div class="project-meta__item project-meta__item--wide">
                    <p class="project-meta__label">Prestations</p>
                    <p class="project-meta__value"><?php echo esc_html($tags); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($tech) : ?>
                <div class="project-meta__item project-meta__item--wide">
                    <p class="project-meta__label">Technologies</p>
                    <p class="project-meta__value"><?php echo esc_html($tech); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <div class="project-meta__actions">
            <?php if ($hasCrm) : ?>
                <span class="project-meta__badge">CRM intégré</span>
            <?php endif; ?>

            <?php if ($clientUrl) : ?>
                <a href="<?php echo esc_url($clientUrl); ?>" class="btn btn--outline" target="_blank" rel="noopener noreferrer">Visiter le site →</a>
            <?php endif; ?>
        </div>
    </div>
</section>
