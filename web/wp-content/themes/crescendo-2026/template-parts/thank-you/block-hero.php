<?php
$title = crescendo_thank_you('thank-you-hero-title') ?: 'Merci pour votre demande !';
$intro = crescendo_thank_you('thank-you-hero-intro') ?: 'Votre message est bien enregistré. Nous revenons vers vous rapidement avec une proposition adaptée à votre projet.';
$steps = crescendo_thank_you('thank-you-next-steps');
$items = crescendo_thank_you_breadcrumb();
?>
<section class="thank-you-hero">
    <div class="container">
        <?php if (!empty($items)) : ?>
            <nav class="service-breadcrumb thank-you-hero__breadcrumb" aria-label="Fil d'Ariane">
                <ol class="service-breadcrumb__list">
                    <?php foreach ($items as $index => $item) : ?>
                        <li class="service-breadcrumb__item">
                            <?php if ($index < count($items) - 1) : ?>
                                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                            <?php else : ?>
                                <span aria-current="page"><?php echo esc_html($item['label']); ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </nav>
        <?php endif; ?>

        <div class="thank-you-hero__content">
            <div class="thank-you-hero__icon" aria-hidden="true">
                <svg class="thank-you-hero__icon-svg" viewBox="0 0 120 120" focusable="false" aria-hidden="true">
                    <circle class="thank-you-hero__icon-badge" cx="60" cy="60" r="24" />
                    <path class="thank-you-hero__icon-check" d="M46 61 L55 70 L74 49" />
                    <g class="thank-you-hero__icon-sparks">
                        <circle class="thank-you-hero__icon-spark thank-you-hero__icon-spark--1" cx="14" cy="22" r="4" />
                        <rect class="thank-you-hero__icon-spark thank-you-hero__icon-spark--2" x="100" y="14" width="7" height="12" rx="2" />
                        <circle class="thank-you-hero__icon-spark thank-you-hero__icon-spark--3" cx="106" cy="96" r="3.5" />
                        <rect class="thank-you-hero__icon-spark thank-you-hero__icon-spark--4" x="8" y="86" width="6" height="10" rx="2" />
                        <rect class="thank-you-hero__icon-spark thank-you-hero__icon-spark--5" x="54" y="4" width="5" height="9" rx="2" />
                        <circle class="thank-you-hero__icon-spark thank-you-hero__icon-spark--6" cx="108" cy="56" r="3" />
                        <path class="thank-you-hero__icon-spark thank-you-hero__icon-spark--7" d="M6 52 L12 64 L0 64 Z" />
                        <rect class="thank-you-hero__icon-spark thank-you-hero__icon-spark--8" x="52" y="104" width="8" height="5" rx="2" />
                    </g>
                </svg>
            </div>

            <h1 class="thank-you-hero__title"><?php echo esc_html($title); ?></h1>

            <?php if ($intro) : ?>
                <p class="thank-you-hero__intro"><?php echo esc_html($intro); ?></p>
            <?php endif; ?>

            <?php if ($steps) : ?>
                <div class="thank-you-hero__steps">
                    <?php echo wp_kses_post($steps); ?>
                </div>
            <?php endif; ?>

            <div class="thank-you-hero__actions">
                <a class="btn btn--primary" href="<?php echo esc_url(home_url('/')); ?>">Retour à l'accueil</a>
                <a class="btn btn--outline" href="<?php echo esc_url(crescendo_nav_url('realisations')); ?>">Voir nos réalisations</a>
            </div>
        </div>
    </div>
</section>
