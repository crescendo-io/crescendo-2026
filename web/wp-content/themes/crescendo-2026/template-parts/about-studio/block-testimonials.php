<?php
$testimonials = crescendo_get_studio_testimonials();
$count = count($testimonials);
$eyebrow = function_exists('crescendo_home') ? crescendo_home('home-testimonials-eyebrow') : '';
if ($eyebrow === null || $eyebrow === '') {
    $eyebrow = __('Nos clients parlent de nous', 'crescendo-2026');
}

if ($count === 0) {
    return;
}

$sliderId = 'studio-about-testimonials-slider';
?>
<section class="studio-about-voices" id="temoignages" aria-labelledby="studio-about-voices-title">
    <div class="shell">
        <div class="studio-about-voices__head" data-studio-text-reveal>
            <?php if ($eyebrow) : ?>
                <p class="studio-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <h2 id="studio-about-voices-title">
                <?php esc_html_e('La parole aux', 'crescendo-2026'); ?>
                <br>
                <?php esc_html_e('équipes qu’on accompagne', 'crescendo-2026'); ?><span class="studio-red">.</span>
            </h2>
        </div>

        <div
            class="studio-testimonials-slider studio-about-voices__slider"
            id="<?php echo esc_attr($sliderId); ?>"
            data-studio-testimonials-slider
            data-slide-count="<?php echo (int) $count; ?>"
            data-studio-text-reveal
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
                            aria-label="<?php echo esc_attr(sprintf(__('Témoignage %d', 'crescendo-2026'), $index + 1)); ?>"
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