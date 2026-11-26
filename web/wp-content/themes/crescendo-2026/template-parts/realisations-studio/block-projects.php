<?php
$eyebrow = crescendo_realisations('realisations-projects-eyebrow');
$title = crescendo_realisations('realisations-projects-title');
$rawProjects = crescendo_realisations('realisations-projects');
$projects = crescendo_map_studio_portfolio_projects(is_array($rawProjects) ? $rawProjects : array());

if (!$title && empty($projects)) {
    return;
}
?>
<section class="studio-projects studio-realisations-hub" id="projets" aria-labelledby="studio-realisations-projects-title">
    <div class="shell">
        <div class="studio-section-head" data-studio-text-reveal>
            <?php if ($eyebrow) : ?>
                <p class="studio-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($title) : ?>
                <h2 id="studio-realisations-projects-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
            <?php endif; ?>
        </div>

        <?php if (!empty($projects)) : ?>
            <div class="studio-realisations-hub__grid">
                <?php foreach ($projects as $project) : ?>
                    <article class="studio-realisations-hub__item">
                        <a
                            class="studio-case-link"
                            href="<?php echo esc_url($project['url']); ?>"
                            aria-label="<?php echo esc_attr(sprintf(__('Découvrir le projet %s', 'crescendo-2026'), $project['title'])); ?>"
                        >
                            <div
                                class="studio-cover <?php echo esc_attr($project['cover_class']); ?>"
                                data-studio-reveal
                            >
                                <span class="studio-cover__veil" aria-hidden="true">
                                    <span class="studio-cover__veil-shine"></span>
                                </span>
                                <div class="studio-cover__media">
                                    <?php if (crescendo_project_image_has_source($project['image'] ?? null)) : ?>
                                        <?php
                                        echo crescendo_image($project['image'], 'crescendo-card', array(
                                            'alt' => $project['alt'],
                                            'sizes' => '(min-width: 992px) 42vw, 100vw',
                                            'loading' => 'lazy',
                                        ));
                                        ?>
                                    <?php elseif (!empty($project['image_url'])) : ?>
                                        <img
                                            src="<?php echo esc_url($project['image_url']); ?>"
                                            loading="lazy"
                                            decoding="async"
                                            alt="<?php echo esc_attr($project['alt']); ?>"
                                        >
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="studio-project-title">
                                <div class="studio-reveal studio-reveal--title" data-studio-reveal>
                                    <span class="studio-reveal__veil" aria-hidden="true">
                                        <span class="studio-reveal__veil-shine"></span>
                                    </span>
                                    <h3 class="studio-reveal__content"><?php echo esc_html($project['title']); ?></h3>
                                </div>
                                <span class="studio-project-open" aria-hidden="true">+</span>
                            </div>
                            <?php if (!empty($project['excerpt'])) : ?>
                                <div class="studio-reveal studio-reveal--excerpt" data-studio-reveal>
                                    <span class="studio-reveal__veil" aria-hidden="true">
                                        <span class="studio-reveal__veil-shine"></span>
                                    </span>
                                    <p class="studio-reveal__content"><?php echo esc_html($project['excerpt']); ?></p>
                                </div>
                            <?php endif; ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>