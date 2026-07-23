<?php
$eyebrow = crescendo_service('service-audience-eyebrow');
$title = crescendo_service('service-audience-title');
$cards = crescendo_service('service-audience-cards');

if (!$title && empty($cards)) {
    return;
}
?>
<section class="service-audience">
    <div class="container">
        <?php if ($eyebrow) : ?>
            <p class="service-eyebrow service-eyebrow--center"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <?php if ($title) : ?>
            <h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if (!empty($cards)) : ?>
            <div class="service-audience__grid">
                <?php foreach ($cards as $index => $card) : ?>
                    <article class="service-audience__card">
                        <span class="service-audience__icon" aria-hidden="true"><?php echo esc_html($index + 1); ?></span>
                        <?php if (!empty($card['title'])) : ?>
                            <h3><?php echo esc_html($card['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($card['text'])) : ?>
                            <p><?php echo esc_html($card['text']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($card['url'])) : ?>
                            <a href="<?php echo esc_url($card['url']); ?>" class="service-audience__link">En savoir plus →</a>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
