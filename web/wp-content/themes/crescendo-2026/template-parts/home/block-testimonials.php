<?php
$eyebrow = crescendo_home('home-testimonials-eyebrow');
$items = crescendo_home('home-testimonials-items');
?>
<section class="home-testimonials">
    <div class="container">
        <?php if ($eyebrow) : ?>
            <h2 class="home-section-head__title home-section-head__title--center"><?php echo esc_html($eyebrow); ?></h2>
        <?php endif; ?>

        <?php if (!empty($items)) : ?>
            <div class="home-testimonials__grid">
                <?php foreach ($items as $item) : ?>
                    <blockquote class="home-testimonial">
                        <div class="home-testimonial__stars" aria-label="<?php echo esc_attr(($item['rating'] ?? 5) . ' sur 5'); ?>">
                            <?php for ($i = 0; $i < (int) ($item['rating'] ?? 5); $i++) : ?>
                                <span aria-hidden="true">★</span>
                            <?php endfor; ?>
                        </div>
                        <p class="home-testimonial__quote">« <?php echo esc_html($item['quote'] ?? ''); ?> »</p>
                        <footer class="home-testimonial__author">
                            <?php if (!empty($item['photo']['url']) || !empty($item['photo']['ID']) || !empty($item['photo']['id'])) : ?>
                                <?php
                                echo crescendo_image($item['photo'], 'crescendo-avatar', array(
                                    'alt' => '',
                                    'class' => 'home-testimonial__photo',
                                    'sizes' => '48px',
                                    'loading' => 'lazy',
                                ));
                                ?>
                            <?php else : ?>
                                <span class="home-testimonial__avatar" aria-hidden="true"><?php echo esc_html(mb_substr($item['name'] ?? 'C', 0, 1)); ?></span>
                            <?php endif; ?>
                            <span>
                                <strong><?php echo esc_html($item['name'] ?? ''); ?></strong>
                                <?php if (!empty($item['company'])) : ?>
                                    <em><?php echo esc_html($item['company']); ?></em>
                                <?php endif; ?>
                            </span>
                        </footer>
                    </blockquote>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
