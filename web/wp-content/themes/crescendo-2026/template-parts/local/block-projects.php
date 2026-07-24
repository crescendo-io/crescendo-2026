<?php
$eyebrow = crescendo_local('local-projects-eyebrow');
$title = crescendo_local('local-projects-title');
$projects = crescendo_local('local-projects');
if (!$title && empty($projects)) {
    return;
}
?>
<section class="local-projects" id="realisations">
    <div class="container">
        <?php if ($eyebrow) : ?><p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
        <?php if ($title) : ?><h2 class="service-section__title"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <?php if (!empty($projects)) : ?>
            <div class="local-projects__grid">
                <?php foreach ($projects as $project) : ?>
                    <article class="local-projects__card">
                        <?php if (!empty($project['image']['url']) || !empty($project['image']['ID']) || !empty($project['image']['id'])) : ?>
                            <a href="<?php echo esc_url($project['url'] ?? '#'); ?>" class="local-projects__image">
                                <?php
                                echo crescendo_image($project['image'], 'crescendo-card', array(
                                    'alt' => $project['title'] ?? '',
                                    'sizes' => '(min-width: 768px) 33vw, 100vw',
                                    'loading' => 'lazy',
                                ));
                                ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($project['tags'])) : ?>
                            <p class="local-projects__tags"><?php echo esc_html($project['tags']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($project['title'])) : ?>
                            <h3><a href="<?php echo esc_url($project['url'] ?? '#'); ?>"><?php echo esc_html($project['title']); ?></a></h3>
                        <?php endif; ?>
                        <?php if (!empty($project['text'])) : ?><p><?php echo esc_html($project['text']); ?></p><?php endif; ?>
                        <?php if (!empty($project['url'])) : ?>
                            <a href="<?php echo esc_url($project['url']); ?>" class="secteur-case__link">Voir le projet →</a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
