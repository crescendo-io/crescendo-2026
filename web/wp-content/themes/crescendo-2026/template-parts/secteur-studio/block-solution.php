<?php
$title = crescendo_secteur('secteur-solution-title');
$text = crescendo_secteur('secteur-solution-text');
$price = crescendo_secteur('secteur-solution-price');
$priceLabel = crescendo_secteur('secteur-solution-price-label');
$usps = crescendo_secteur('secteur-solution-usps');
if (!$title && !$text && empty($usps)) {
    return;
}
?>
<section class="studio-secteur-solution" aria-labelledby="studio-secteur-solution-title">
    <div class="shell studio-secteur-solution__inner">
        <header class="studio-secteur-solution__head" data-studio-text-reveal>
            <p class="studio-eyebrow studio-secteur-solution__eyebrow">
                <span class="studio-signal" aria-hidden="true"></span>
                <?php esc_html_e('Votre offre', 'crescendo-2026'); ?>
            </p>
            <?php if ($title) : ?>
                <h2 id="studio-secteur-solution-title">
                    <?php echo esc_html($title); ?><span class="studio-red">.</span>
                </h2>
            <?php endif; ?>
        </header>

        <?php if ($text) : ?>
            <p class="studio-secteur-solution__text" data-studio-text-reveal><?php echo esc_html($text); ?></p>
        <?php endif; ?>

        <?php if (!empty($usps)) : ?>
            <ul class="studio-secteur-solution__grid" data-studio-text-reveal>
                <?php foreach ($usps as $index => $usp) : ?>
                    <li>
                        <span class="studio-secteur-solution__index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <?php if (!empty($usp['title'])) : ?>
                            <h3><?php echo esc_html($usp['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($usp['text'])) : ?>
                            <p><?php echo esc_html($usp['text']); ?></p>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($price) : ?>
            <p class="studio-secteur-solution__price" data-studio-text-reveal>
                <strong><?php echo esc_html($price); ?></strong>
                <?php if ($priceLabel) : ?>
                    <span><?php echo esc_html($priceLabel); ?></span>
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>
</section>