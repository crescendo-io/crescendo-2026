<?php
$title = crescendo_project('project-gallery-title') ?: __('Aperçu du site', 'crescendo-2026');
$intro = crescendo_project('project-gallery-intro');
$gallery = crescendo_project('project-gallery');

if (!crescendo_project_gallery_has_images($gallery)) {
    return;
}

if ($intro && stripos($intro, 'Ajoutez vos captures') !== false) {
    $intro = '';
}
?>
<section class="studio-project-gallery" id="galerie" aria-labelledby="studio-project-gallery-title">
    <div class="shell">
        <div class="studio-section-head" data-studio-text-reveal>
            <h2 id="studio-project-gallery-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
            <?php if ($intro) : ?>
                <p><?php echo esc_html($intro); ?></p>
            <?php endif; ?>
        </div>

        <div class="studio-project-gallery__grid">
            <?php foreach ($gallery as $index => $item) : ?>
                <?php if (empty($item['image']['url']) && empty($item['image']['ID']) && empty($item['image']['id'])) : ?>
                    <?php continue; ?>
                <?php endif; ?>
                <figure class="studio-project-gallery__item" data-studio-text-reveal>
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