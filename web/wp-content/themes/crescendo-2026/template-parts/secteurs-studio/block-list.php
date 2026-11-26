<?php
$eyebrow = crescendo_secteurs_hub('secteurs-list-eyebrow');
$title = crescendo_secteurs_hub('secteurs-list-title');
$cards = crescendo_get_secteurs_hub_cards();

if (!$title && empty($cards)) {
    return;
}
?>
<section class="studio-secteurs-hub-list studio-services-hub-list" id="secteurs" aria-labelledby="studio-secteurs-hub-list-title">
    <div class="shell">
        <div class="studio-section-head" data-studio-text-reveal>
            <?php if ($eyebrow) : ?>
                <p class="studio-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($title) : ?>
                <h2 id="studio-secteurs-hub-list-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
            <?php endif; ?>
        </div>

        <?php if (!empty($cards)) : ?>
            <ul class="studio-services-hub-list__rows">
                <?php foreach ($cards as $index => $card) : ?>
                    <li data-studio-text-reveal>
                        <a class="studio-services-hub-list__row" href="<?php echo esc_url($card['url']); ?>">
                            <span class="studio-services-hub-list__index" aria-hidden="true"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                            <div class="studio-services-hub-list__meta">
                                <?php if (!empty($card['eyebrow'])) : ?>
                                    <p class="studio-services-hub-list__eyebrow"><?php echo esc_html($card['eyebrow']); ?></p>
                                <?php endif; ?>
                                <h3><?php echo esc_html($card['title']); ?></h3>
                                <?php if (!empty($card['text'])) : ?>
                                    <p><?php echo esc_html($card['text']); ?></p>
                                <?php endif; ?>
                            </div>
                            <span class="studio-services-hub-list__open" aria-hidden="true">+</span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>