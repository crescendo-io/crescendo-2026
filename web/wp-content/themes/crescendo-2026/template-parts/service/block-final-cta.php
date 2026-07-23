<?php
$title = crescendo_service('service-final-cta-title');
$formShortcode = crescendo_service('service-contact-form-shortcode');
$reassurance = crescendo_service('service-final-reassurance');

if (!$title) {
    return;
}
?>
<section class="service-final-cta" id="contact">
    <div class="container service-final-cta__inner">
        <h2 class="service-final-cta__title"><?php echo esc_html($title); ?></h2>

        <div class="service-final-cta__form-wrap">
            <?php if ($formShortcode) : ?>
                <?php echo do_shortcode($formShortcode); ?>
            <?php else : ?>
                <form class="service-final-cta__form" action="<?php echo esc_url(home_url('/')); ?>" method="post">
                    <label class="visually-hidden" for="service-nom">Nom</label>
                    <input id="service-nom" type="text" name="nom" placeholder="Nom" required>
                    <label class="visually-hidden" for="service-email">Email</label>
                    <input id="service-email" type="email" name="email" placeholder="Email" required>
                    <label class="visually-hidden" for="service-tel">Téléphone</label>
                    <input id="service-tel" type="tel" name="telephone" placeholder="Téléphone">
                    <label class="visually-hidden" for="service-projet">Type de projet</label>
                    <select id="service-projet" name="projet">
                        <option value="">Type de projet</option>
                        <option value="location">Location 350€/mois</option>
                        <option value="site">Création de site</option>
                        <option value="crm">CRM sur mesure</option>
                        <option value="refonte">Refonte</option>
                    </select>
                    <button type="submit" class="btn btn--dark">Demander ma maquette gratuite</button>
                </form>
            <?php endif; ?>
        </div>

        <?php if (!empty($reassurance)) : ?>
            <ul class="service-final-cta__reassurance">
                <?php foreach ($reassurance as $item) : ?>
                    <?php $text = is_array($item) ? ($item['text'] ?? '') : $item; ?>
                    <?php if ($text) : ?><li><?php echo esc_html($text); ?></li><?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
