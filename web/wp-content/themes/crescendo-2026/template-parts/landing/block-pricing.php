<?php
$title = crescendo_landing('landing-pricing-title') ?: 'Deux façons de créer votre site';
$altIntro = crescendo_landing('landing-pricing-alt-intro') ?: 'Vous préférez éviter l\'investissement initial ?';
$buyCard = crescendo_landing('landing-pricing-buy');
$rentCard = crescendo_landing('landing-pricing-rent');

if (empty($buyCard) && empty($rentCard)) {
    return;
}
?>
<section class="landing-pricing service-section--alt" id="tarifs">
    <div class="container">
        <h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2>

        <div class="landing-pricing__panel">
            <?php if (!empty($buyCard)) : ?>
                <article class="landing-pricing__option landing-pricing__option--buy">
                    <div class="landing-pricing__body">
                        <p class="landing-pricing__label"><?php echo esc_html($buyCard['label'] ?? 'Achat'); ?></p>
                        <?php if (!empty($buyCard['price'])) : ?>
                            <p class="landing-pricing__price"><?php echo esc_html($buyCard['price']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($buyCard['text'])) : ?>
                            <p class="landing-pricing__text"><?php echo esc_html($buyCard['text']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($buyCard['cta'])) : ?>
                        <div class="landing-pricing__footer">
                            <?php echo crescendo_link($buyCard['cta'], 'btn btn--dark'); ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endif; ?>

            <?php if (!empty($buyCard) && !empty($rentCard)) : ?>
                <div class="landing-pricing__divider" aria-hidden="true"><span>ou</span></div>
            <?php endif; ?>

            <?php if (!empty($rentCard)) : ?>
                <article class="landing-pricing__option landing-pricing__option--rent">
                    <div class="landing-pricing__body">
                        <?php if ($altIntro) : ?>
                            <p class="landing-pricing__hook"><?php echo esc_html($altIntro); ?></p>
                        <?php endif; ?>
                        <p class="landing-pricing__label"><?php echo esc_html($rentCard['label'] ?? 'Formule tout compris'); ?></p>
                        <?php if (!empty($rentCard['price'])) : ?>
                            <p class="landing-pricing__price"><?php echo esc_html($rentCard['price']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($rentCard['badge'])) : ?>
                            <p class="landing-pricing__badge"><?php echo esc_html($rentCard['badge']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($rentCard['text'])) : ?>
                            <p class="landing-pricing__text"><?php echo esc_html($rentCard['text']); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($rentCard['cta'])) : ?>
                        <div class="landing-pricing__footer">
                            <?php echo crescendo_link($rentCard['cta'], 'btn btn--primary'); ?>
                        </div>
                    <?php endif; ?>
                </article>
            <?php endif; ?>
        </div>
    </div>
</section>
