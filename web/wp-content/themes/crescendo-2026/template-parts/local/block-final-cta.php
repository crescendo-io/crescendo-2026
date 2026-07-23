<?php
$title = crescendo_local('local-final-cta-title');
$text = crescendo_local('local-final-cta-text');
$points = crescendo_local('local-final-cta-points');
$reassurance = crescendo_local('local-final-reassurance');
$formShortcode = crescendo_local('local-contact-form-shortcode');
$jobLabel = crescendo_local('local-final-form-job-label') ?: 'Métier';
if (!$title) {
    return;
}
?>
<section class="secteur-final-cta" id="contact">
    <div class="container secteur-final-cta__inner">
        <div class="secteur-final-cta__content">
            <h2 class="secteur-final-cta__title"><?php echo esc_html($title); ?></h2>
            <?php if ($text) : ?><p class="secteur-final-cta__text"><?php echo esc_html($text); ?></p><?php endif; ?>
            <?php if (!empty($points)) : ?>
                <ul class="secteur-final-cta__points">
                    <?php foreach ($points as $point) : ?>
                        <?php $line = is_array($point) ? ($point['text'] ?? '') : $point; ?>
                        <?php if ($line) : ?><li><?php echo esc_html($line); ?></li><?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div class="secteur-final-cta__form-wrap">
            <?php if ($formShortcode) : ?>
                <?php echo do_shortcode($formShortcode); ?>
            <?php else : ?>
                <form class="service-final-cta__form secteur-final-cta__form" action="<?php echo esc_url(home_url('/')); ?>" method="post">
                    <input type="text" name="nom" placeholder="Nom" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="tel" name="telephone" placeholder="Téléphone">
                    <select name="metier">
                        <option value=""><?php echo esc_html($jobLabel); ?></option>
                        <option value="artisan">Artisan</option>
                        <option value="pme">PME</option>
                        <option value="liberal">Profession libérale</option>
                        <option value="startup">Startup</option>
                    </select>
                    <button type="submit" class="btn btn--dark">Demander ma maquette gratuite</button>
                </form>
            <?php endif; ?>
        </div>
        <?php if (!empty($reassurance)) : ?>
            <ul class="service-final-cta__reassurance secteur-final-cta__reassurance">
                <?php foreach ($reassurance as $item) : ?>
                    <?php $line = is_array($item) ? ($item['text'] ?? '') : $item; ?>
                    <?php if ($line) : ?><li><?php echo esc_html($line); ?></li><?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
