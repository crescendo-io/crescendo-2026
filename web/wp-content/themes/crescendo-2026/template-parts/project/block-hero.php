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
$items = crescendo_project_breadcrumb();

$visualTags = array();
if ($client) {
    $visualTags[] = array('label' => 'Client', 'value' => $client);
}
if ($sector) {
    $visualTags[] = array('label' => 'Secteur', 'value' => $sector);
}
if ($year) {
    $visualTags[] = array('label' => 'Année', 'value' => $year);
}
if ($tags) {
    $visualTags[] = array('label' => 'Prestations', 'value' => $tags);
}
if ($tech) {
    $visualTags[] = array('label' => 'Technologies', 'value' => $tech);
}
if ($hasCrm) {
    $visualTags[] = array('label' => 'CRM', 'value' => 'Intégré');
}

$hasVisual = !empty($image['url']) || !empty($visualTags);
?>
<section class="project-hero">
    <div class="container">
        <?php if (!empty($items)) : ?>
            <nav class="service-breadcrumb" aria-label="Fil d'Ariane">
                <ol class="service-breadcrumb__list">
                    <?php foreach ($items as $index => $item) : ?>
                        <li class="service-breadcrumb__item">
                            <?php if ($index < count($items) - 1) : ?>
                                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                            <?php else : ?>
                                <span aria-current="page"><?php echo esc_html($item['label']); ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </nav>
        <?php endif; ?>

        <?php if ($eyebrow) : ?>
            <p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <h1 class="project-hero__title"><?php echo esc_html($title); ?></h1>

        <?php if ($intro) : ?>
            <p class="project-hero__intro"><?php echo esc_html($intro); ?></p>
        <?php endif; ?>

        <?php if ($clientUrl) : ?>
            <div class="project-hero__actions">
                <a href="<?php echo esc_url($clientUrl); ?>" class="btn btn--outline" target="_blank" rel="noopener noreferrer">Visiter le site →</a>
            </div>
        <?php endif; ?>

        <?php if ($hasVisual) : ?>
            <figure class="project-hero__visual">
                <?php if (!empty($image['url']) || !empty($image['ID']) || !empty($image['id'])) : ?>
                    <?php
                    echo crescendo_image($image, 'crescendo-hero', array(
                        'alt' => $image['alt'] ?: $title,
                        'sizes' => '(min-width: 1240px) 1240px, 100vw',
                        'loading' => 'eager',
                        'fetchpriority' => 'high',
                    ));
                    ?>
                <?php else : ?>
                    <div class="project-hero__visual-placeholder" aria-hidden="true"></div>
                <?php endif; ?>

                <div class="project-hero__visual-overlay">
                    <?php if (!empty($visualTags)) : ?>
                        <ul class="project-hero__tags">
                            <?php foreach ($visualTags as $tag) : ?>
                                <li>
                                    <span class="project-hero__tag-label"><?php echo esc_html($tag['label']); ?></span>
                                    <strong class="project-hero__tag-value"><?php echo esc_html($tag['value']); ?></strong>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </figure>
        <?php endif; ?>
    </div>
</section>
