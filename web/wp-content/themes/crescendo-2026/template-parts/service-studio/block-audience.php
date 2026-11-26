<?php
$eyebrow = crescendo_service('service-audience-eyebrow');
$title = crescendo_service('service-audience-title');
$cards = crescendo_service('service-audience-cards');

if (!$title && empty($cards)) {
    return;
}
?>
<section class="studio-service-audience" aria-labelledby="studio-service-audience-title">
    <div class="shell">
    <div class="studio-section-head" data-studio-text-reveal>
        <?php if ($eyebrow) : ?>
            <p class="studio-eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>
        <?php if ($title) : ?>
            <h2 id="studio-service-audience-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
        <?php endif; ?>
    </div>

    <?php if (!empty($cards)) : ?>
        <div class="studio-service-audience__grid">
            <?php foreach ($cards as $card) : ?>
                <article class="studio-service-audience__card" data-studio-text-reveal>
                    <?php if (!empty($card['title'])) : ?>
                        <h3><?php echo esc_html($card['title']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($card['text'])) : ?>
                        <p><?php echo esc_html($card['text']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($card['url'])) : ?>
                        <a class="studio-text-link" href="<?php echo esc_url(crescendo_resolve_link_url($card['url'])); ?>">
                            <?php esc_html_e('Voir le détail', 'crescendo-2026'); ?>
                        </a>
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </div>
</section>