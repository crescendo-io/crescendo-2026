<?php
$title = crescendo_landing('landing-projects-title') ?: 'Quelques réalisations récentes';
$projects = array_slice(crescendo_get_landing_projects(), 0, 3);
$realisationsUrl = crescendo_nav_url('realisations');

if (empty($projects)) {
    return;
}
?>
<section class="landing-projects" id="realisations">
    <div class="container">
        <h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2>

        <div class="landing-projects__grid">
            <?php foreach ($projects as $project) : ?>
                <?php
                $url = !empty($project['url']) ? $project['url'] : '';
                $tag = $url ? 'a' : 'article';
                $tags = array_filter(array_map('trim', preg_split('/\s*[·•|]\s*/', (string) ($project['tags'] ?? ''))));
                ?>
                <<?php echo $tag; ?> class="landing-projects__card"<?php echo $url ? ' href="' . esc_url($url) . '"' : ''; ?>>
                    <div class="landing-projects__media">
                        <?php if (!empty($project['image']['url']) || !empty($project['image']['ID']) || !empty($project['image']['id'])) : ?>
                            <?php
                            echo crescendo_image($project['image'], 'crescendo-card', array(
                                'alt' => $project['title'] ?? '',
                                'class' => 'landing-projects__image',
                                'sizes' => '(min-width: 992px) 33vw, (min-width: 768px) 50vw, 100vw',
                                'loading' => 'lazy',
                            ));
                            ?>
                        <?php else : ?>
                            <div class="landing-projects__placeholder" aria-hidden="true"></div>
                        <?php endif; ?>
                    </div>

                    <div class="landing-projects__content">
                        <?php if (!empty($project['category'])) : ?>
                            <p class="landing-projects__category"><?php echo esc_html($project['category']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($project['title'])) : ?>
                            <h3 class="landing-projects__title"><?php echo esc_html($project['title']); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($tags)) : ?>
                            <ul class="landing-projects__tags">
                                <?php foreach ($tags as $tagLabel) : ?>
                                    <li><?php echo esc_html($tagLabel); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ($url) : ?>
                            <span class="landing-projects__link">Voir le projet →</span>
                        <?php endif; ?>
                    </div>
                </<?php echo $tag; ?>>
            <?php endforeach; ?>
        </div>

        <?php if ($realisationsUrl) : ?>
            <div class="landing-projects__foot">
                <a class="btn btn--outline" href="<?php echo esc_url($realisationsUrl); ?>">Voir toutes nos réalisations</a>
            </div>
        <?php endif; ?>
    </div>
</section>
