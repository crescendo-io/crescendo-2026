<?php
$projects = crescendo_get_studio_featured_projects(2);
?>
<section class="shell studio-projects" id="projets" aria-labelledby="studio-projets-title">
    <div class="studio-section-head" data-studio-text-reveal>
        <h2 id="studio-projets-title"><?php esc_html_e('Projets choisis', 'crescendo-2026'); ?><span class="studio-red">.</span></h2>
        <p><?php esc_html_e('Sites internet', 'crescendo-2026'); ?><br><?php esc_html_e('et outils métier', 'crescendo-2026'); ?></p>
    </div>
    <?php if (!empty($projects)) : ?>
        <div class="studio-project-pair">
            <?php foreach ($projects as $project) : ?>
                <article class="studio-project<?php echo !empty($project['secondary']) ? ' studio-project--secondary' : ''; ?>">
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
</section>