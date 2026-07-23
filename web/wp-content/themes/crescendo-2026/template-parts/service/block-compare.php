<?php
$eyebrow = crescendo_service('service-compare-eyebrow');
$title = crescendo_service('service-compare-title');
$text = crescendo_service('service-compare-text');
$cta = crescendo_service('service-compare-cta');
$table = crescendo_service('service-compare-table');
$note = crescendo_service('service-compare-note');
$col1 = crescendo_service('service-compare-col1-label') ?: 'Location 350€/mois';
$col2 = crescendo_service('service-compare-col2-label') ?: 'Achat classique';

if (!$title && empty($table)) {
    return;
}
?>
<section class="service-compare" id="tarifs">
    <div class="container service-compare__inner">
        <?php if (!empty($table)) : ?>
            <div class="service-compare__table-wrap">
                <table class="service-compare__table">
                    <thead>
                        <tr>
                            <th scope="col">Critères</th>
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
                    <p class="service-compare__note"><?php echo esc_html($note); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="service-compare__content">
            <?php if ($eyebrow) : ?>
                <p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>

            <?php if ($title) : ?>
                <h2 class="service-section__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($text) : ?>
                <p class="service-section__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php echo crescendo_link($cta, 'btn btn--outline'); ?>
        </div>
    </div>
</section>
