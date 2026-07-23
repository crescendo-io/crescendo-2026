<?php
$eyebrow = crescendo_home('home-hero-eyebrow');
$title = crescendo_home('home-hero-title');
$text = crescendo_home('home-hero-text');
$ctaPrimary = crescendo_home('home-hero-cta-primary');
$ctaSecondary = crescendo_home('home-hero-cta-secondary');
$stats = crescendo_home('home-hero-stats');
$image = crescendo_home('home-hero-image');
?>
<section class="home-hero">
    <div class="home-hero__inner container">
        <div class="home-hero__content">
            <?php if ($eyebrow) : ?>
                <p class="home-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <h1 class="home-hero__title"><?php echo esc_html($title); ?></h1>

            <?php if ($text) : ?>
                <p class="home-hero__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <div class="home-hero__actions">
                <?php echo crescendo_link($ctaPrimary, 'btn btn--primary'); ?>
                <?php echo crescendo_link($ctaSecondary, 'btn btn--outline'); ?>
            </div>

            <?php if (!empty($stats)) : ?>
                <ul class="home-hero__stats">
                    <?php foreach ($stats as $stat) : ?>
                        <li class="home-hero__stat">
                            <strong><?php echo esc_html($stat['value'] ?? ''); ?></strong>
                            <span><?php echo esc_html($stat['label'] ?? ''); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="home-hero__visual">
            <?php if (!empty($image['url'])) : ?>
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $title); ?>" width="<?php echo esc_attr($image['width'] ?? ''); ?>" height="<?php echo esc_attr($image['height'] ?? ''); ?>">
            <?php else : ?>
                <div class="home-hero__placeholder" aria-hidden="true">
                    <span>Image hero — laptop & CRM</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
