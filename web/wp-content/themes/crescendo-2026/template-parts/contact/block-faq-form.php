<?php
$faqItems = crescendo_contact('contact-faq-items');
$formTitle = crescendo_contact('contact-form-title');
$formIntro = crescendo_contact('contact-form-intro');
$formShortcode = crescendo_contact('contact-form-shortcode');
?>
<section class="contact-form-section" id="formulaire">
    <div class="container contact-form-section__inner">
        <div class="contact-faq">
            <?php if (!empty($faqItems)) : ?>
                <h2 class="contact-faq__title">Questions fréquentes</h2>
                <div class="home-faq__list">
                    <?php foreach ($faqItems as $index => $item) : ?>
                        <details class="home-faq__item"<?php echo $index === 0 ? ' open' : ''; ?>>
                            <summary class="home-faq__question">
                                <?php echo esc_html($item['question'] ?? ''); ?>
                                <span class="home-faq__toggle" aria-hidden="true"></span>
                            </summary>
                            <div class="home-faq__answer">
                                <p><?php echo esc_html($item['answer'] ?? ''); ?></p>
                            </div>
                        </details>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="home-form">
            <?php if ($formTitle) : ?>
                <h2 class="home-form__title"><?php echo esc_html($formTitle); ?></h2>
            <?php endif; ?>

            <?php if ($formIntro) : ?>
                <p class="contact-form__intro"><?php echo esc_html($formIntro); ?></p>
            <?php endif; ?>

            <?php if ($formShortcode) : ?>
                <?php echo do_shortcode($formShortcode); ?>
            <?php else : ?>
                <form class="home-form__fields" action="<?php echo esc_url(home_url('/contact/')); ?>" method="post">
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
                    <button type="submit" class="btn btn--primary">Envoyer ma demande →</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</section>
