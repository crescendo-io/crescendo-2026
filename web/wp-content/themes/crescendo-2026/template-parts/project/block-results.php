<?php
$title = crescendo_project('project-results-title');
$items = crescendo_project('project-results');

if (empty($items)) {
    return;
}
?>
<section class="project-results">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <ul class="project-results__grid">
            <?php foreach ($items as $item) : ?>
                <li class="project-results__item">
                    <strong><?php echo esc_html($item['value'] ?? ''); ?></strong>
                    <span><?php echo esc_html($item['label'] ?? ''); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
