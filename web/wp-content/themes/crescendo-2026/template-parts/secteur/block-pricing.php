<?php
$title = crescendo_secteur('secteur-pricing-title');
$price = crescendo_secteur('secteur-pricing-price');
$priceSuffix = crescendo_secteur('secteur-pricing-price-suffix') ?: '/mois';
$features = crescendo_secteur('secteur-pricing-features');
$cta = crescendo_secteur('secteur-pricing-cta');
$table = crescendo_secteur('secteur-pricing-table');
$col1 = crescendo_secteur('secteur-pricing-col1-label') ?: 'Location 350€/mois';
$col2 = crescendo_secteur('secteur-pricing-col2-label') ?: 'Achat classique';
if (!$title && !$price) {
    return;
}
?>
<section class="secteur-pricing service-section--alt" id="tarifs">
    <div class="container">
        <?php if ($title) : ?><h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2><?php endif; ?>
        <div class="secteur-pricing__layout">
            <?php if ($price) : ?>
                <div class="service-included__offer service-included__price-box-wrap">
                    <div class="service-included__price-box">
                        <span class="service-included__price"><?php echo esc_html($price); ?></span>
                        <span class="service-included__suffix"><?php echo esc_html($priceSuffix); ?></span>
                    </div>
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
                <div class="service-compare__table-wrap">
                    <table class="service-compare__table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
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
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
