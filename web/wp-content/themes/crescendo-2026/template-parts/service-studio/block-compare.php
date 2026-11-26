<?php
$eyebrow = crescendo_service('service-compare-eyebrow');
$title = crescendo_service('service-compare-title');
$text = crescendo_service('service-compare-text');
$cta = crescendo_service('service-compare-cta');
$table = crescendo_service('service-compare-table');
$note = crescendo_service('service-compare-note');
$col1 = crescendo_service('service-compare-col1-label') ?: 'Location';
$col2 = crescendo_service('service-compare-col2-label') ?: 'Achat';

if (!$title && empty($table)) {
    return;
}
?>
<section class="studio-service-compare" id="tarifs" aria-labelledby="studio-service-compare-title">
    <div class="shell">
    <div class="studio-service-compare__head">
        <?php if ($eyebrow) : ?>
            <p class="studio-eyebrow" data-studio-text-reveal><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>
        <?php if ($title) : ?>
            <h2 id="studio-service-compare-title" data-studio-text-reveal>
                <?php echo esc_html($title); ?><span class="studio-red">.</span>
            </h2>
        <?php endif; ?>
        <?php if ($text) : ?>
            <p class="studio-intro studio-intro--narrow" data-studio-text-reveal><?php echo esc_html($text); ?></p>
        <?php endif; ?>
    </div>

    <?php if (!empty($table)) : ?>
        <div class="studio-service-compare__table-wrap" data-studio-text-reveal>
            <table class="studio-service-compare__table">
                <thead>
                    <tr>
                        <th scope="col"><?php esc_html_e('Critère', 'crescendo-2026'); ?></th>
                        <th scope="col" class="is-highlight"><?php echo esc_html($col1); ?></th>
                        <th scope="col"><?php echo esc_html($col2); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($table as $row) : ?>
                        <tr>
                            <th scope="row"><?php echo esc_html($row['label'] ?? ''); ?></th>
                            <td class="is-highlight"><?php echo esc_html($row['col1'] ?? ''); ?></td>
                            <td><?php echo esc_html($row['col2'] ?? ''); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if ($note) : ?>
                <p class="studio-service-compare__note"><?php echo esc_html($note); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($cta) : ?>
        <p class="studio-service-compare__cta" data-studio-text-reveal>
            <a class="studio-text-link" href="<?php echo esc_url(crescendo_resolve_link_url($cta['url'] ?? '')); ?>">
                <?php echo esc_html($cta['title'] ?? ''); ?>
            </a>
        </p>
    <?php endif; ?>
    </div>
</section>