<?php
$title = crescendo_home('home-why-eyebrow');
$items = crescendo_home('home-why-items');
$projects = crescendo_home('home-why-projects');
$realisationsUrl = crescendo_nav_url('realisations');

$projectUrlMap = array(
    'Ludovic Géhéniaux' => 'realisations/ludovic-geheniaux',
    'Maison Jaden' => 'realisations/maison-jaden',
    'Be Focus' => 'realisations/be-focus',
    'Atelier Gambetta' => 'realisations/atelier-gambetta',
    'Ta Kifé' => 'realisations/ta-kife',
    'CM&A Associés' => 'realisations/cma-associes',
    'Padam Immo' => 'realisations/padam-immo',
    'Car Design' => 'realisations/car-design',
);
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
                    $url = !empty($project['url']) ? $project['url'] : '';
                    if (!$url && $projectTitle && isset($projectUrlMap[$projectTitle])) {
                        $url = crescendo_nav_url($projectUrlMap[$projectTitle]);
                    }
                    if (!$url) {
                        $url = $realisationsUrl;
                    }
                    ?>
                    <a class="home-project-card" href="<?php echo esc_url($url); ?>">
                        <?php if (!empty($project['image']['url'])) : ?>
                            <img src="<?php echo esc_url($project['image']['url']); ?>" alt="<?php echo esc_attr($projectTitle); ?>" class="home-project-card__image">
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
