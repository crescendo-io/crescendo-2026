<?php
$title = crescendo_project('project-gallery-title') ?: 'Aperçu du site';
$intro = crescendo_project('project-gallery-intro');
$gallery = crescendo_project('project-gallery');

if (!crescendo_project_gallery_has_images($gallery)) {
    return;
}

if ($intro && stripos($intro, 'Ajoutez vos captures') !== false) {
    $intro = '';
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
            <?php foreach ($gallery as $index => $item) : ?>
                <?php if (empty($item['image']['url']) && empty($item['image']['ID']) && empty($item['image']['id'])) : ?>
                    <?php continue; ?>
                <?php endif; ?>
                <figure class="project-gallery__item">
                    <?php
                    $imageAlt = crescendo_project_gallery_item_alt($index, $item['image'] ?? null);
                    $imageAttr = array(
                        'sizes' => '(min-width: 768px) 50vw, 100vw',
                        'loading' => 'lazy',
                    );
                    if ($imageAlt !== '') {
                        $imageAttr['alt'] = $imageAlt;
                    }

                    echo crescendo_image($item['image'], 'crescendo-content', $imageAttr);
                    ?>

                    <?php if (!empty($item['caption'])) : ?>
                        <figcaption><?php echo esc_html($item['caption']); ?></figcaption>
                    <?php endif; ?>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
