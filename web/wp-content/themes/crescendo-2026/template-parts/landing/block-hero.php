<?php
$title = crescendo_landing('landing-hero-title') ?: 'Votre site internet sur mesure';
$title = trim(preg_replace('/\s*à partir de\s+[\d\s,.]+(?:€|eur)(?:\s*HT)?/iu', '', $title));
if ($title === '') {
    $title = 'Votre site internet sur mesure';
}
$priceLabel = crescendo_landing('landing-hero-price-label') ?: 'À partir de';
$priceValue = crescendo_landing('landing-hero-price') ?: '2 999 € HT';
$intro = crescendo_landing('landing-hero-intro');
$reassurance = crescendo_landing('landing-hero-reassurance');
$ctaSecondary = crescendo_landing('landing-hero-cta-secondary');
$note = crescendo_landing('landing-hero-note') ?: 'Premier échange gratuit · Réponse sous 24h · Sans engagement';
$rating = crescendo_landing('landing-hero-rating');
$ratingLabel = crescendo_landing('landing-hero-rating-label') ?: '5 étoiles sur 5 sur Google';
$ratingUrl = crescendo_landing('landing-hero-rating-url');
$formTitle = crescendo_landing('landing-hero-form-title') ?: 'Recevez votre estimation gratuite';

if ($rating === '' || $rating === null) {
    $rating = 5;
}

$rating = (int) $rating;

if (empty($ctaSecondary) || empty($ctaSecondary['url'])) {
    $ctaSecondary = array(
        'title' => 'Voir des exemples',
        'url' => '#maquettes',
        'target' => '',
    );
}

$defaultReassurance = array(
    array('text' => 'Design sur mesure'),
    array('text' => 'WordPress'),
    array('text' => 'Optimisé SEO'),
    array('text' => 'Responsive'),
    array('text' => 'Accompagnement dédié'),
);

if (empty($reassurance)) {
    $reassurance = $defaultReassurance;
}
?>
<section class="landing-hero" id="contact">
    <div class="container landing-hero__inner">
        <div class="landing-hero__layout">
            <div class="landing-hero__content">
                <?php if ($rating > 0) : ?>
                    <div class="landing-hero__meta">
                        <?php if ($ratingUrl) : ?>
                            <a class="landing-hero__trust landing-hero__trust--link" href="<?php echo esc_url($ratingUrl); ?>" target="_blank" rel="noopener noreferrer">
                        <?php else : ?>
                            <div class="landing-hero__trust">
                        <?php endif; ?>
                            <span class="landing-hero__google" aria-hidden="true">
                                <?php get_template_part('template-parts/icons/icon-google'); ?>
                            </span>
                            <div class="landing-hero__trust-body">
                                <span class="landing-hero__stars" role="img" aria-label="<?php echo esc_attr($rating . ' sur 5'); ?>">
                                    <?php for ($i = 0; $i < $rating; $i++) : ?>
                                        <span class="landing-hero__star" aria-hidden="true">★</span>
                                    <?php endfor; ?>
                                </span>
                                <?php if ($ratingLabel) : ?>
                                    <span class="landing-hero__rating-label"><?php echo esc_html($ratingLabel); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php echo $ratingUrl ? '</a>' : '</div>'; ?>
                    </div>
                <?php endif; ?>

                <h1 class="landing-hero__title">
                    <?php echo esc_html($title); ?>
                    <?php if ($priceValue) : ?>
                        <a class="landing-hero__price" href="#tarifs">
                            <span class="landing-hero__price-label"><?php echo esc_html($priceLabel); ?></span>
                            <strong class="landing-hero__price-value"><?php echo esc_html($priceValue); ?></strong>
                        </a>
                    <?php endif; ?>
                </h1>

                <?php if ($intro) : ?>
                    <p class="landing-hero__intro"><?php echo esc_html($intro); ?></p>
                <?php endif; ?>

                <?php if (!empty($reassurance)) : ?>
                    <ul class="landing-hero__checks">
                        <?php foreach ($reassurance as $item) : ?>
                            <?php $line = is_array($item) ? ($item['text'] ?? '') : $item; ?>
                            <?php if ($line) : ?><li><?php echo esc_html($line); ?></li><?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <div class="landing-hero__actions landing-hero__actions--secondary">
                    <?php echo crescendo_link($ctaSecondary, 'btn btn--outline'); ?>
                </div>

                <?php if ($note) : ?>
                    <p class="landing-hero__note"><?php echo esc_html($note); ?></p>
                <?php endif; ?>
            </div>

            <aside class="landing-hero__form-card">
                <?php if ($formTitle) : ?>
                    <p class="landing-hero__form-title"><?php echo esc_html($formTitle); ?></p>
                <?php endif; ?>
                <?php
                crescendo_render_contact_form(array_merge(
                    crescendo_get_landing_contact_form_args(),
                    array(
                        'wrapper_class' => 'landing-hero__form',
                    )
                ));
                ?>
            </aside>
        </div>
    </div>
</section>
