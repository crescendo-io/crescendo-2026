<?php
$eyebrow = crescendo_home('home-pricing-eyebrow');
$title = crescendo_home('home-pricing-title');
$price = crescendo_home('home-pricing-location-price');
$features = crescendo_home('home-pricing-location-features');
$cta = crescendo_home('home-pricing-location-cta');
$table = crescendo_home('home-pricing-table');
?>
<section class="home-pricing" id="tarifs">
    <div class="container">
        <p class="home-eyebrow home-eyebrow--center"><?php echo esc_html($eyebrow); ?></p>
        <h2 class="home-section-head__title home-section-head__title--center"><?php echo esc_html($title); ?></h2>

        <div class="home-pricing__layout">
            <div class="home-pricing__card">
                <p class="home-pricing__card-label">Location tout inclus</p>
                <p class="home-pricing__price">
                    <strong><?php echo esc_html($price); ?></strong>
                    <span>/mois</span>
                </p>

                <?php if (!empty($features)) : ?>
                    <ul class="home-pricing__features">
                        <?php foreach ($features as $feature) : ?>
                            <?php $text = is_array($feature) ? ($feature['text'] ?? '') : $feature; ?>
                            <li><?php echo esc_html($text); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php echo crescendo_link($cta, 'btn btn--dark'); ?>
            </div>

            <?php if (!empty($table)) : ?>
                <div class="home-pricing__table-wrap">
                    <table class="home-pricing__table">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Location</th>
                                <th scope="col">Achat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($table as $row) : ?>
                                <tr>
                                    <th scope="row"><?php echo esc_html($row['label'] ?? ''); ?></th>
                                    <td><?php echo esc_html($row['location'] ?? ''); ?></td>
                                    <td><?php echo esc_html($row['achat'] ?? ''); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <p class="home-pricing__note">Comparatif sur 5 ans</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
