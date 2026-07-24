<?php
$faqItems = crescendo_home('home-faq-items');
$contactTitle = crescendo_home('home-contact-title');
$formShortcode = crescendo_home('home-contact-form-shortcode');
?>
<section class="home-contact" id="contact">
    <div class="container home-contact__inner">
        <div class="home-faq">
            <?php if (!empty($faqItems)) : ?>
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
            <?php
            crescendo_render_contact_form(array(
                'title' => $contactTitle,
                'form_shortcode' => $formShortcode,
                'source' => 'Accueil',
                'source_url' => home_url('/'),
                'submit_label' => 'Envoyer ma demande',
            ));
            ?>
        </div>
    </div>
</section>
