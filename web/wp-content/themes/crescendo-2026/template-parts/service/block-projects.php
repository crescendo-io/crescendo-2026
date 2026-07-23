<?php
$eyebrow = crescendo_service('service-projects-eyebrow');
$title = crescendo_service('service-projects-title');
$projects = crescendo_service('service-projects');

if (!$title && empty($projects)) {
    return;
}
?>
<section class="service-projects" id="realisations">
    <div class="container">
        <div class="service-projects__head">
            <?php if ($eyebrow) : ?>
                <p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($title) : ?>
                <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
        </div>

        <?php if (!empty($projects)) : ?>
            <div class="service-projects__list">
                <?php foreach ($projects as $project) : ?>
                    <?php $url = !empty($project['url']) ? $project['url'] : ''; ?>
                    <?php if ($url) : ?>
                        <a href="<?php echo esc_url($url); ?>" class="service-project-row">
                    <?php else : ?>
                        <div class="service-project-row">
                    <?php endif; ?>
                        <?php if (!empty($project['image']['url'])) : ?>
                            <img src="<?php echo esc_url($project['image']['url']); ?>" alt="<?php echo esc_attr($project['title'] ?? ''); ?>" class="service-project-row__image">
                        <?php else : ?>
                            <div class="service-project-row__placeholder"></div>
                        <?php endif; ?>
                        <div class="service-project-row__content">
                            <?php if (!empty($project['title'])) : ?>
                                <h3><?php echo esc_html($project['title']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($project['category'])) : ?>
                                <p class="service-project-row__meta"><?php echo esc_html($project['category']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($project['tags'])) : ?>
                                <p class="service-project-row__tags"><?php echo esc_html($project['tags']); ?></p>
                            <?php endif; ?>
                            <?php if ($url) : ?>
                                <span class="service-project-row__link">Découvrir le projet →</span>
                            <?php endif; ?>
                        </div>
                    <?php echo $url ? '</a>' : '</div>'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
