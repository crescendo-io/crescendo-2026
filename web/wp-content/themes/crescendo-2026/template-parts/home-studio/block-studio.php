<?php
$testimonials = crescendo_home('home-testimonials-items');
if (is_array($testimonials)) {
    $testimonials = array_values(array_filter($testimonials, static function ($item) {
        return is_array($item) && trim((string) ($item['quote'] ?? '')) !== '';
    }));
}
if (empty($testimonials) || !is_array($testimonials)) {
    $homeDefaults = require get_template_directory() . '/inc/home-defaults.php';
    $testimonials = $homeDefaults['home-testimonials-items'] ?? array();
}
$count = count($testimonials);
$sliderId = 'studio-testimonials-slider';
?>
<section class="shell studio-about" id="studio" aria-labelledby="studio-about-title">
    <p class="studio-eyebrow" data-studio-text-reveal>
        <span class="studio-signal" aria-hidden="true"></span>
        <?php esc_html_e('Le studio', 'crescendo-2026'); ?>
    </p>
    <h2 id="studio-about-title" data-studio-text-reveal>
        <?php esc_html_e('Du premier échange', 'crescendo-2026'); ?>
        <br>
        <?php esc_html_e('à la mise en ligne', 'crescendo-2026'); ?><span class="studio-red">.</span>
    </h2>
    <div class="studio-about-grid">
        <div class="studio-about-copy" data-studio-text-reveal>
            <p>
                <?php esc_html_e('Entre Nantes et Saint-Nazaire, Crescendo réunit design et développement. Notre point de départ, c’est votre journée de travail. Comment un client vous trouve-t-il ? Que devient sa demande une fois le formulaire envoyé ?', 'crescendo-2026'); ?>
            </p>
            <p>
                <?php esc_html_e('Nous dessinons ce parcours avec vous. Vous validez les écrans avant le développement. À la livraison, nous vous montrons comment publier une page ou retrouver un dossier client.', 'crescendo-2026'); ?>
            </p>
        </div>

        <div
            class="studio-testimonials-slider"
            id="<?php echo esc_attr($sliderId); ?>"
            data-studio-testimonials-slider
            data-slide-count="<?php echo (int) $count; ?>"
        >
            <div class="studio-testimonials-slider__viewport">
                <div class="studio-testimonials-slider__track" role="list">
                    <?php foreach ($testimonials as $index => $item) : ?>
                        <?php
                        $quote = $item['quote'] ?? '';
                        $name = $item['name'] ?? '';
                        $company = $item['company'] ?? '';
                        $rating = (int) ($item['rating'] ?? 5);
                        ?>
                        <figure
                            class="studio-testimonial studio-testimonials-slider__slide"
                            role="listitem"
                            aria-roledescription="slide"
                            aria-label="<?php echo esc_attr(sprintf(/* translators: %d: slide number */ __('Témoignage %d', 'crescendo-2026'), $index + 1)); ?>"
                            data-slide-index="<?php echo (int) $index; ?>"
                            <?php echo $index > 0 ? ' hidden' : ''; ?>
                            aria-hidden="<?php echo $index > 0 ? 'true' : 'false'; ?>"
                        >
                            <span class="studio-quote-mark" aria-hidden="true">“</span>
                            <?php if ($rating > 0) : ?>
                                <div class="studio-testimonial__stars" role="img" aria-label="<?php echo esc_attr($rating . ' sur 5'); ?>">
                                    <?php for ($i = 0; $i < min(5, $rating); $i++) : ?>
                                        <span aria-hidden="true">★</span>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>
                            <blockquote>
                                «&nbsp;<?php echo esc_html($quote); ?>&nbsp;»
                            </blockquote>
                            <figcaption>
                                <?php echo esc_html($name); ?>
                                <?php if ($company !== '') : ?>
                                    <span>/</span>
                                    <?php echo esc_html($company); ?>
                                <?php endif; ?>
                            </figcaption>
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($count > 1) : ?>
                <div class="studio-testimonials-slider__controls">
                    <button
                        type="button"
                        class="studio-testimonials-slider__btn"
                        data-slider-prev
                        aria-controls="<?php echo esc_attr($sliderId); ?>"
                        aria-label="<?php esc_attr_e('Témoignage précédent', 'crescendo-2026'); ?>"
                    >
                        <?php esc_html_e('Préc.', 'crescendo-2026'); ?>
                    </button>
                    <p class="studio-testimonials-slider__status" aria-live="polite">
                        <span data-slider-current>1</span>
                        <span aria-hidden="true">/</span>
                        <span data-slider-total><?php echo (int) $count; ?></span>
                    </p>
                    <button
                        type="button"
                        class="studio-testimonials-slider__btn"
                        data-slider-next
                        aria-controls="<?php echo esc_attr($sliderId); ?>"
                        aria-label="<?php esc_attr_e('Témoignage suivant', 'crescendo-2026'); ?>"
                    >
                        <?php esc_html_e('Suiv.', 'crescendo-2026'); ?>
                    </button>
                </div>
                <div class="studio-testimonials-slider__dots" role="tablist" aria-label="<?php esc_attr_e('Choisir un témoignage', 'crescendo-2026'); ?>">
                    <?php for ($dot = 0; $dot < $count; $dot++) : ?>
                        <button
                            type="button"
                            class="studio-testimonials-slider__dot<?php echo $dot === 0 ? ' is-active' : ''; ?>"
                            role="tab"
                            data-slider-dot="<?php echo (int) $dot; ?>"
                            aria-selected="<?php echo $dot === 0 ? 'true' : 'false'; ?>"
                            aria-label="<?php echo esc_attr(sprintf(__('Témoignage %d', 'crescendo-2026'), $dot + 1)); ?>"
                        ></button>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>