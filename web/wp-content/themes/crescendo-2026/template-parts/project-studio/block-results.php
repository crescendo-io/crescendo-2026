<?php
$title = crescendo_project('project-results-title');
$items = crescendo_project('project-results');

if (empty($items)) {
    return;
}
?>
<section class="studio-project-results" aria-labelledby="studio-project-results-title">
    <div class="shell">
        <?php if ($title) : ?>
            <div class="studio-section-head" data-studio-text-reveal>
                <h2 id="studio-project-results-title"><?php echo esc_html($title); ?><span class="studio-red">.</span></h2>
            </div>
        <?php endif; ?>

        <ul class="studio-project-results__grid">
            <?php foreach ($items as $index => $item) : ?>
                <li data-studio-text-reveal>
                    <span class="studio-project-results__index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                    <strong><?php echo esc_html($item['value'] ?? ''); ?></strong>
                    <span><?php echo esc_html($item['label'] ?? ''); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>