<?php
$title = crescendo_service('service-pricing-title');
$intro = crescendo_service('service-pricing-intro');
$price = crescendo_service('service-pricing-highlight-price');
$priceLabel = crescendo_service('service-pricing-highlight-label') ?: 'Tout inclus';
$features = crescendo_service('service-pricing-features');
$cta = crescendo_service('service-pricing-cta');
$table = crescendo_service('service-pricing-table');

if (!$title && !$price && empty($table)) {
    return;
}

$col1Label = crescendo_service('service-pricing-col1-label') ?: 'Location';
$col2Label = crescendo_service('service-pricing-col2-label') ?: 'Achat';
?>
<section class="service-section service-section--alt" id="tarifs">
    <div class="container">
        <?php if ($title) : ?>
            <h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($intro) : ?>
            <p class="service-section__intro service-section__intro--center"><?php echo esc_html($intro); ?></p>
        <?php endif; ?>

        <div class="home-pricing__layout service-pricing__layout">
            <?php if ($price) : ?>
                <div class="home-pricing__card">
                    <p class="home-pricing__card-label"><?php echo esc_html($priceLabel); ?></p>
                    <p class="home-pricing__price">
                        <strong><?php echo esc_html($price); ?></strong>
                        <span>/mois</span>
                    </p>

                    <?php if (!empty($features)) : ?>
                        <ul class="home-pricing__features">
                            <?php foreach ($features as $feature) : ?>
                                <?php $text = is_array($feature) ? ($feature['text'] ?? '') : $feature; ?>
                                <?php if ($text) : ?><li><?php echo esc_html($text); ?></li><?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php echo crescendo_link($cta, 'btn btn--dark'); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($table)) : ?>
                <div class="home-pricing__table-wrap">
                    <table class="home-pricing__table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"><?php echo esc_html($col1Label); ?></th>
                                <th scope="col"><?php echo esc_html($col2Label); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($table as $row) : ?>
                                <tr>
                                    <th scope="row"><?php echo esc_html($row['label'] ?? ''); ?></th>
                                    <td><?php echo esc_html($row['col1'] ?? ''); ?></td>
                                    <td><?php echo esc_html($row['col2'] ?? ''); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
