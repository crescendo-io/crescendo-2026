<?php
$title = crescendo_project('project-gallery-title') ?: 'Aperçu du site';
$intro = crescendo_project('project-gallery-intro');
$gallery = crescendo_project('project-gallery');
$slots = (int) (crescendo_project('project-gallery-slots') ?: 0);

if (empty($gallery) && $slots <= 0) {
    return;
}
?>
<section class="project-gallery" id="galerie">
    <div class="container">
        <div class="project-gallery__header">
            <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
            <?php if ($intro) : ?>
                <p class="project-gallery__intro"><?php echo esc_html($intro); ?></p>
            <?php endif; ?>
        </div>

        <div class="project-gallery__grid">
            <?php if (!empty($gallery)) : ?>
                <?php foreach ($gallery as $item) : ?>
                    <figure class="project-gallery__item">
                        <?php if (!empty($item['image']['url']) || !empty($item['image']['ID']) || !empty($item['image']['id'])) : ?>
                            <?php
                            echo crescendo_image($item['image'], 'crescendo-content', array(
                                'alt' => $item['caption'] ?? ($item['image']['alt'] ?? ''),
                                'sizes' => '(min-width: 768px) 50vw, 100vw',
                                'loading' => 'lazy',
                            ));
                            ?>
                        <?php else : ?>
                            <div class="project-gallery__placeholder" aria-hidden="true"></div>
                        <?php endif; ?>

                        <?php if (!empty($item['caption'])) : ?>
                            <figcaption><?php echo esc_html($item['caption']); ?></figcaption>
                        <?php endif; ?>
                    </figure>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php
            $filled = is_array($gallery) ? count($gallery) : 0;
            $emptySlots = max($slots - $filled, 0);
            for ($i = 0; $i < $emptySlots; $i++) :
                ?>
                <figure class="project-gallery__item project-gallery__item--empty">
                    <div class="project-gallery__placeholder" aria-hidden="true">
                        <span>Capture 16:9</span>
                    </div>
                </figure>
            <?php endfor; ?>
        </div>
    </div>
</section>
