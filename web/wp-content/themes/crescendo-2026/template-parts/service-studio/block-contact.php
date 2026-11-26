<?php
$formShortcode = crescendo_service('service-contact-form-shortcode');
$email = get_field('params-footer-email', 'option') ?: 'b.vidal@crescendo-studio.io';
?>
<section class="studio-contact studio-contact--service" id="contact" aria-labelledby="studio-service-contact-title">
    <div class="shell studio-contact--service__inner">
        <div class="studio-contact--service__layout">
            <div class="studio-contact--service__intro">
                <p class="studio-eyebrow" data-studio-text-reveal><?php esc_html_e('Démarrer', 'crescendo-2026'); ?></p>
                <h2 id="studio-service-contact-title" data-studio-text-reveal>
                    <?php esc_html_e('Parlons de', 'crescendo-2026'); ?>
                    <br>
                    <?php esc_html_e('votre projet', 'crescendo-2026'); ?><span class="studio-red">.</span>
                </h2>
                <p class="studio-contact--service__text" data-studio-text-reveal>
                    <?php esc_html_e('Laissez quelques coordonnées : nous vous répondons avec une première direction visuelle sous 48 h.', 'crescendo-2026'); ?>
                </p>
                <p class="studio-contact--service__mail" data-studio-text-reveal>
                    <a class="studio-mail" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </p>
            </div>

            <div class="studio-contact--service__form" data-studio-text-reveal>
                <?php
                crescendo_render_contact_form(array(
                    'title' => '',
                    'form_shortcode' => $formShortcode,
                    'source' => get_the_title(),
                    'submit_label' => __('Envoyer ma demande', 'crescendo-2026'),
                    'wrapper_class' => 'crescendo-contact-form-shell--studio',
                ));
                ?>
            </div>
        </div>
    </div>
</section>