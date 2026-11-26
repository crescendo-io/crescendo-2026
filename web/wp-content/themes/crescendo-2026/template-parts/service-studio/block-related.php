<?php
$title = crescendo_service('service-related-title') ?: __('Pour aller plus loin', 'crescendo-2026');
$links = crescendo_service('service-related-links');

if (empty($links)) {
    return;
}
?>
<section class="studio-service-related" aria-labelledby="studio-service-related-title">
    <div class="shell">
    <h2 id="studio-service-related-title" class="visually-hidden"><?php echo esc_html($title); ?></h2>
    <p class="studio-eyebrow" data-studio-text-reveal><?php echo esc_html($title); ?></p>
    <ul class="studio-service-related__links">
        <?php foreach ($links as $item) : ?>
            <?php if (empty($item['link']['url'])) {
                continue;
            } ?>
            <li data-studio-text-reveal>
                <a
                    href="<?php echo esc_url($item['link']['url']); ?>"
                    <?php echo !empty($item['link']['target']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>
                >
                    <?php echo esc_html($item['link']['title'] ?? $item['link']['url']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    </div>
</section>