<?php
$title = crescendo_legal('legal-hero-title') ?: get_the_title();
$intro = crescendo_legal('legal-hero-intro');
$updated = crescendo_legal('legal-updated-at');
$items = crescendo_legal_breadcrumb();
?>
<section class="legal-hero">
    <div class="container">
        <?php if (!empty($items)) : ?>
            <nav class="service-breadcrumb" aria-label="Fil d'Ariane">
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

        <h1 class="legal-hero__title"><?php echo esc_html($title); ?></h1>

        <?php if ($intro) : ?>
            <p class="legal-hero__intro"><?php echo esc_html($intro); ?></p>
        <?php endif; ?>

        <?php if ($updated) : ?>
            <p class="legal-hero__updated">Dernière mise à jour : <?php echo esc_html($updated); ?></p>
        <?php endif; ?>
    </div>
</section>
