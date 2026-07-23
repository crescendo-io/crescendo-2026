<?php
$title = crescendo_service('service-related-title') ?: 'Pages associées';
$links = crescendo_service('service-related-links');

if (empty($links)) {
    return;
}
?>
<section class="service-section">
    <div class="container">
        <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
        <ul class="service-related">
            <?php foreach ($links as $item) : ?>
                <?php if (empty($item['link']['url'])) {
                    continue;
                } ?>
                <li>
                    <a href="<?php echo esc_url($item['link']['url']); ?>"<?php echo !empty($item['link']['target']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <?php echo esc_html($item['link']['title'] ?? $item['link']['url']); ?> →
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
