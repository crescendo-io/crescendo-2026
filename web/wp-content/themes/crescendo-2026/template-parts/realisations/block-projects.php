<?php
$eyebrow = crescendo_realisations('realisations-projects-eyebrow');
$title = crescendo_realisations('realisations-projects-title');
$projects = crescendo_realisations('realisations-projects');

if (!$title && empty($projects)) {
    return;
}
?>
<section class="realisations-projects" id="projets">
    <div class="container">
        <?php if ($eyebrow) : ?><p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
        <?php if ($title) : ?><h2 class="service-section__title"><?php echo esc_html($title); ?></h2><?php endif; ?>

        <?php if (!empty($projects)) : ?>
            <div class="realisations-projects__grid">
                <?php foreach ($projects as $project) : ?>
                    <?php
                    $url = !empty($project['url']) ? $project['url'] : '';
                    $tag = $url ? 'a' : 'article';
                    ?>
                    <<?php echo $tag; ?> class="realisations-projects__card"<?php echo $url ? ' href="' . esc_url($url) . '"' : ''; ?>>
                        <?php if (!empty($project['image']['url'])) : ?>
                            <img src="<?php echo esc_url($project['image']['url']); ?>" alt="<?php echo esc_attr($project['title'] ?? ''); ?>" class="realisations-projects__image">
                        <?php else : ?>
                            <div class="realisations-projects__placeholder" aria-hidden="true"></div>
                        <?php endif; ?>

                        <div class="realisations-projects__content">
                            <?php if (!empty($project['has_crm'])) : ?>
                                <span class="realisations-projects__badge">CRM</span>
                            <?php endif; ?>

                            <?php if (!empty($project['category'])) : ?>
                                <p class="realisations-projects__category"><?php echo esc_html($project['category']); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($project['title'])) : ?>
                                <h3><?php echo esc_html($project['title']); ?></h3>
                            <?php endif; ?>

                            <?php if (!empty($project['tags'])) : ?>
                                <p class="realisations-projects__tags"><?php echo esc_html($project['tags']); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($project['text'])) : ?>
                                <p class="realisations-projects__text"><?php echo esc_html($project['text']); ?></p>
                            <?php endif; ?>

                            <?php if ($url) : ?>
                                <span class="realisations-projects__link">Voir le projet →</span>
                            <?php endif; ?>
                        </div>
                    </<?php echo $tag; ?>>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
