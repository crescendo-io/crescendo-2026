<?php
$sections = crescendo_local('local-sections');
$facts = crescendo_local('local-facts');
$factsTitle = crescendo_local('local-facts-title');
if (empty($sections) && empty($facts)) {
    return;
}
?>
<section class="local-sections">
    <div class="container">
        <?php if (!empty($sections)) : ?>
            <div class="local-sections__list">
                <?php foreach ($sections as $section) : ?>
                    <?php if (empty($section['title']) && empty($section['text'])) {
                        continue;
                    } ?>
                    <article class="local-sections__item">
                        <?php if (!empty($section['title'])) : ?>
                            <?php $anchor = !empty($section['anchor']) ? sanitize_title($section['anchor']) : sanitize_title($section['title']); ?>
                            <h2 class="service-section__title" id="<?php echo esc_attr($anchor); ?>"><?php echo esc_html($section['title']); ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($section['text'])) : ?>
                            <div class="local-sections__text"><?php echo wp_kses_post($section['text']); ?></div>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($facts)) : ?>
            <aside class="local-facts">
                <?php if ($factsTitle) : ?><h3 class="local-facts__title"><?php echo esc_html($factsTitle); ?></h3><?php endif; ?>
                <ul class="local-facts__list">
                    <?php foreach ($facts as $fact) : ?>
                        <?php $line = is_array($fact) ? ($fact['text'] ?? '') : $fact; ?>
                        <?php if ($line) : ?><li><?php echo esc_html($line); ?></li><?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </aside>
        <?php endif; ?>
    </div>
</section>
