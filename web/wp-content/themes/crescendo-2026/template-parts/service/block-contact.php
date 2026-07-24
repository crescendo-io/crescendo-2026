<?php
$formShortcode = crescendo_service('service-contact-form-shortcode');
?>
<section class="service-section service-contact" id="contact">
    <div class="container">
        <div class="home-form service-contact__form">
            <?php
            crescendo_render_contact_form(array(
                'title' => 'Discutons de votre projet',
                'form_shortcode' => $formShortcode,
                'source' => get_the_title(),
                'submit_label' => 'Envoyer ma demande',
            ));
            ?>
        </div>
    </div>
</section>
