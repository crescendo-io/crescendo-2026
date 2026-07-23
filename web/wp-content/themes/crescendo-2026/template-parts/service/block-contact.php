<?php
$formShortcode = crescendo_service('service-contact-form-shortcode');
?>
<section class="service-section service-contact" id="contact">
    <div class="container">
        <div class="home-form service-contact__form">
            <h2 class="home-form__title">Discutons de votre projet</h2>

            <?php if ($formShortcode) : ?>
                <?php echo do_shortcode($formShortcode); ?>
            <?php else : ?>
                <form class="home-form__fields" action="<?php echo esc_url(home_url('/')); ?>" method="post">
                    <label>
                        <span>Nom</span>
                        <input type="text" name="nom" required>
                    </label>
                    <label>
                        <span>Email</span>
                        <input type="email" name="email" required>
                    </label>
                    <label>
                        <span>Téléphone</span>
                        <input type="tel" name="telephone">
                    </label>
                    <label>
                        <span>Type de projet</span>
                        <select name="projet">
                            <option value="">Sélectionner</option>
                            <option value="site">Création de site</option>
                            <option value="crm">CRM sur mesure</option>
                            <option value="location">Location 350€/mois</option>
                            <option value="refonte">Refonte</option>
                            <option value="ecommerce">E-commerce</option>
                        </select>
                    </label>
                    <label class="home-form__full">
                        <span>Message</span>
                        <textarea name="message" rows="5"></textarea>
                    </label>
                    <button type="submit" class="btn btn--primary">Envoyer ma demande</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>
