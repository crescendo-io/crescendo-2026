<?php
$eyebrow = crescendo_services_hub('services-hero-eyebrow');
$title = crescendo_services_hub('services-hero-title') ?: get_the_title();
$intro = crescendo_services_hub('services-hero-intro');
$panelText = crescendo_services_hub('services-intro-text');
$stats = crescendo_services_hub('services-intro-stats');
$ctaPrimary = crescendo_services_hub('services-hero-cta-primary');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');
$ctaUrl = !empty($ctaPrimary['url']) ? $ctaPrimary['url'] : $contactUrl;
$ctaLabel = !empty($ctaPrimary['title']) ? $ctaPrimary['title'] : __('Demander ma maquette gratuite', 'crescendo-2026');
?>
<section class="studio-services-hub-hero" aria-labelledby="studio-services-hub-hero-title">
    <div class="shell studio-services-hub-hero__inner">
        <?php if ($eyebrow) : ?>
            <p class="studio-eyebrow" data-studio-text-reveal><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <h1 id="studio-services-hub-hero-title" data-studio-text-reveal>
            <?php echo esc_html($title); ?><span class="studio-red">.</span>
        </h1>

        <?php if ($intro) : ?>
            <p class="studio-services-hub-hero__intro" data-studio-text-reveal><?php echo esc_html($intro); ?></p>
        <?php endif; ?>

        <?php if ($panelText) : ?>
            <p class="studio-services-hub-hero__lede" data-studio-text-reveal><?php echo esc_html($panelText); ?></p>
        <?php endif; ?>

        <?php if (!empty($stats)) : ?>
            <ul class="studio-services-hub-hero__stats" data-studio-text-reveal>
                <?php foreach ($stats as $index => $stat) : ?>
                    <li>
                        <span class="studio-services-hub-hero__stat-index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <?php if (!empty($stat['value'])) : ?>
                            <strong><?php echo esc_html($stat['value']); ?></strong>
                        <?php endif; ?>
                        <?php if (!empty($stat['label'])) : ?>
                            <span><?php echo esc_html($stat['label']); ?></span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <p class="studio-services-hub-hero__actions" data-studio-text-reveal>
            <a class="studio-services-hub-hero__button" href="<?php echo esc_url($ctaUrl); ?>"><?php echo esc_html($ctaLabel); ?></a>
            <a class="studio-text-link" href="#offres"><?php esc_html_e('Voir les formules', 'crescendo-2026'); ?></a>
        </p>
    </div>
</section>