<?php
$eyebrow = crescendo_service('service-projects-eyebrow');
$title = crescendo_service('service-projects-title');
$projects = crescendo_resolve_project_cards(crescendo_service('service-projects'), array());

if (!$title && empty($projects)) {
    return;
}
?>
<section class="studio-service-projects" id="realisations" aria-labelledby="studio-service-projects-title">
    <div class="shell">
    <div class="studio-section-head" data-studio-text-reveal>
        <?php if ($eyebrow) : ?>
            <p class="studio-eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>
        <?php if ($title) : ?>
            <h2 id="studio-service-projects-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
        <?php endif; ?>
    </div>

    <?php if (!empty($projects)) : ?>
        <ul class="studio-service-projects__list">
            <?php foreach ($projects as $project) : ?>
                <?php $url = !empty($project['url']) ? $project['url'] : ''; ?>
                <li data-studio-text-reveal>
                    <?php if ($url) : ?>
                        <a class="studio-service-projects__row" href="<?php echo esc_url($url); ?>">
                    <?php else : ?>
                        <div class="studio-service-projects__row">
                    <?php endif; ?>
                        <div class="studio-service-projects__meta">
                            <?php if (!empty($project['title'])) : ?>
                                <h3><?php echo esc_html($project['title']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($project['category'])) : ?>
                                <p><?php echo esc_html($project['category']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($project['tags'])) : ?>
                                <p class="studio-service-projects__tags"><?php echo esc_html($project['tags']); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php if ($url) : ?>
                            <span class="studio-service-projects__open" aria-hidden="true">+</span>
                        <?php endif; ?>
                    <?php echo $url ? '</a>' : '</div>'; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    </div>
</section>