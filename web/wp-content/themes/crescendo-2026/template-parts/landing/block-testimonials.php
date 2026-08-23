<?php
$testimonialsTitle = crescendo_landing('landing-testimonials-title') ?: 'Ce que disent nos clients';
$testimonials = crescendo_landing('landing-testimonials-items');
$ratingUrl = crescendo_landing('landing-hero-rating-url');

if (empty($testimonials)) {
    return;
}

$count = count($testimonials);
$duration = max(36, $count * 8);
?>
<section class="landing-testimonials" id="avis">
    <div class="container landing-testimonials__head-wrap">
        <div class="landing-testimonials__head">
            <h2 class="service-section__title service-section__title--center"><?php echo esc_html($testimonialsTitle); ?></h2>

            <?php if ($ratingUrl) : ?>
                <a class="landing-testimonials__google" href="<?php echo esc_url($ratingUrl); ?>" target="_blank" rel="noopener noreferrer">
                    <?php get_template_part('template-parts/icons/icon', 'google'); ?>
                    <span>5/5 sur Google</span>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="landing-testimonials__viewport">
            <div
                class="landing-testimonials__track"
                style="--testimonial-count: <?php echo (int) $count; ?>; --testimonial-duration: <?php echo (int) $duration; ?>s;"
            >
                <?php for ($loop = 0; $loop < 2; $loop++) : ?>
                    <?php foreach ($testimonials as $index => $item) : ?>
                        <?php $isDuplicate = $loop === 1; ?>
                        <blockquote class="landing-testimonial"<?php echo $isDuplicate ? ' aria-hidden="true"' : ''; ?>>
                            <div class="landing-testimonial__stars" role="img" aria-label="<?php echo esc_attr(($item['rating'] ?? 5) . ' sur 5'); ?>">
                                <?php for ($i = 0; $i < (int) ($item['rating'] ?? 5); $i++) : ?>
                                    <span aria-hidden="true">★</span>
                                <?php endfor; ?>
                            </div>
                            <p class="landing-testimonial__quote"><span class="landing-testimonial__mark" aria-hidden="true">«</span><?php echo esc_html($item['quote'] ?? ''); ?><span class="landing-testimonial__mark" aria-hidden="true">»</span></p>
                            <footer class="landing-testimonial__author">
                                <span class="landing-testimonial__avatar" aria-hidden="true"><?php echo esc_html(mb_substr($item['name'] ?? 'C', 0, 1)); ?></span>
                                <span class="landing-testimonial__meta">
                                    <strong><?php echo esc_html($item['name'] ?? ''); ?></strong>
                                    <?php if (!empty($item['company'])) : ?>
                                        <em><?php echo esc_html($item['company']); ?></em>
                                    <?php endif; ?>
                                </span>
                            </footer>
                        </blockquote>
                    <?php endforeach; ?>
                <?php endfor; ?>
            </div>
        </div>
</section>
