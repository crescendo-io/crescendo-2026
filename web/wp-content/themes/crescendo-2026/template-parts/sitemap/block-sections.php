<?php
$sections = crescendo_get_sitemap_page_sections();

if (empty($sections)) {
    return;
}
?>
<section class="sitemap-sections">
    <div class="container sitemap-sections__grid">
        <?php foreach ($sections as $section) : ?>
            <article class="sitemap-sections__block<?php echo in_array($section['id'], array('realisations', 'services'), true) ? ' sitemap-sections__block--wide' : ''; ?>" id="sitemap-<?php echo esc_attr($section['id']); ?>">
                <h2>
                    <?php if (!empty($section['url'])) : ?>
                        <a href="<?php echo esc_url($section['url']); ?>"><?php echo esc_html($section['label']); ?></a>
                    <?php else : ?>
                        <?php echo esc_html($section['label']); ?>
                    <?php endif; ?>
                </h2>

                <?php if (!empty($section['items'])) : ?>
                    <ul class="sitemap-sections__list">
                        <?php foreach ($section['items'] as $item) : ?>
                            <li>
                                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
