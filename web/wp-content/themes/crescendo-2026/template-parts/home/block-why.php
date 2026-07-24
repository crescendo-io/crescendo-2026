<?php
$title = crescendo_home('home-why-eyebrow');
$items = crescendo_home('home-why-items');
$projects = crescendo_resolve_project_cards(crescendo_home('home-why-projects'));
$realisationsUrl = crescendo_nav_url('realisations');
?>
<section class="home-why">
    <div class="container home-why__inner">
        <div class="home-why__content">
            <?php if ($title) : ?>
                <h2 class="home-why__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if (!empty($items)) : ?>
                <ul class="home-why__list">
                    <?php foreach ($items as $item) : ?>
                        <?php $text = is_array($item) ? ($item['text'] ?? '') : $item; ?>
                        <li><?php echo esc_html($text); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="home-why__projects">
            <p class="home-why__projects-label">Réalisations</p>
            <div class="home-why__grid">
                <?php foreach ($projects as $project) : ?>
                    <?php
                    $projectTitle = $project['title'] ?? '';
                    $url = !empty($project['url']) ? $project['url'] : $realisationsUrl;
                    ?>
                    <a class="home-project-card" href="<?php echo esc_url($url); ?>">
                        <?php if (!empty($project['image']['url']) || !empty($project['image']['ID']) || !empty($project['image']['id'])) : ?>
                            <?php
                            echo crescendo_image($project['image'], 'crescendo-card', array(
                                'alt' => $projectTitle,
                                'class' => 'home-project-card__image',
                                'sizes' => '(min-width: 992px) 33vw, (min-width: 768px) 50vw, 100vw',
                                'loading' => 'lazy',
                            ));
                            ?>
                        <?php else : ?>
                            <div class="home-project-card__placeholder" aria-hidden="true"></div>
                        <?php endif; ?>
                        <div class="home-project-card__overlay">
                            <?php if (!empty($project['has_crm'])) : ?>
                                <span class="home-project-card__badge">CRM</span>
                            <?php endif; ?>
                            <strong><?php echo esc_html($projectTitle); ?></strong>
                            <span><?php echo esc_html($project['category'] ?? ''); ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
