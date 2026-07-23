<?php
$title = crescendo_home('home-why-eyebrow');
$items = crescendo_home('home-why-items');
$projects = crescendo_home('home-why-projects');
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
                    $url = !empty($project['url']) ? $project['url'] : '#';
                    $tag = ($url && $url !== '#') ? 'a' : 'div';
                    ?>
                    <<?php echo $tag; ?> class="home-project-card"<?php echo $tag === 'a' ? ' href="' . esc_url($url) . '"' : ''; ?>>
                        <?php if (!empty($project['image']['url'])) : ?>
                            <img src="<?php echo esc_url($project['image']['url']); ?>" alt="<?php echo esc_attr($project['title'] ?? ''); ?>" class="home-project-card__image">
                        <?php else : ?>
                            <div class="home-project-card__placeholder"></div>
                        <?php endif; ?>
                        <div class="home-project-card__overlay">
                            <?php if (!empty($project['has_crm'])) : ?>
                                <span class="home-project-card__badge">CRM</span>
                            <?php endif; ?>
                            <strong><?php echo esc_html($project['title'] ?? ''); ?></strong>
                            <span><?php echo esc_html($project['category'] ?? ''); ?></span>
                        </div>
                    </<?php echo $tag; ?>>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
