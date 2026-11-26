<?php
$title = crescendo_secteur('secteur-features-title');
$items = crescendo_secteur('secteur-features-items');
if (!$title && empty($items)) {
    return;
}
?>
<section class="studio-service-included" id="fonctionnalites" aria-labelledby="studio-secteur-features-title">
    <div class="shell">
    <div class="studio-service-included__layout">
        <div class="studio-service-included__intro">
            <?php if ($title) : ?>
                <h2 id="studio-secteur-features-title" data-studio-text-reveal>
                    <?php echo esc_html($title); ?><span class="studio-red">.</span>
                </h2>
            <?php endif; ?>
        </div>

        <?php if (!empty($items)) : ?>
            <div class="studio-service-included__panel" data-studio-text-reveal>
                <p class="studio-service-included__panel-label">
                    <?php esc_html_e('Fonctionnalités', 'crescendo-2026'); ?>
                </p>
                <ul class="studio-service-included__list">
                    <?php foreach ($items as $item) : ?>
                        <?php
                        $line = $item['title'] ?? '';
                        if ($line && !empty($item['text'])) {
                            $line .= ' — ' . $item['text'];
                        } elseif (!$line && !empty($item['text'])) {
                            $line = $item['text'];
                        }
                        ?>
                        <?php if ($line) : ?>
                            <li><?php echo esc_html($line); ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    </div>
</section>