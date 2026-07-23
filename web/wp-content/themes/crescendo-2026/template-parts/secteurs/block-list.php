<?php
$eyebrow = crescendo_secteurs_hub('secteurs-list-eyebrow');
$title = crescendo_secteurs_hub('secteurs-list-title');
$cards = crescendo_get_secteurs_hub_cards();

if (!$title && empty($cards)) {
    return;
}
?>
<section class="secteurs-list" id="secteurs">
    <div class="container">
        <?php if ($eyebrow) : ?><p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p><?php endif; ?>
        <?php if ($title) : ?><h2 class="service-section__title"><?php echo esc_html($title); ?></h2><?php endif; ?>

        <?php if (!empty($cards)) : ?>
            <div class="secteurs-list__grid">
                <?php foreach ($cards as $index => $card) : ?>
                    <a class="secteurs-list__card" href="<?php echo esc_url($card['url']); ?>">
                        <span class="secteurs-list__index" aria-hidden="true"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>

                        <?php if (!empty($card['eyebrow'])) : ?>
                            <p class="secteurs-list__eyebrow"><?php echo esc_html($card['eyebrow']); ?></p>
                        <?php endif; ?>

                        <h3><?php echo esc_html($card['title']); ?></h3>

                        <?php if (!empty($card['text'])) : ?>
                            <p class="secteurs-list__text"><?php echo esc_html($card['text']); ?></p>
                        <?php endif; ?>

                        <span class="secteurs-list__link">Découvrir le secteur →</span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
