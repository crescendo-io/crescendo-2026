<?php
$args = get_query_var('crescendo_contact_form_args', array());
$args = wp_parse_args($args, array(
    'title' => '',
    'intro' => '',
    'variant' => 'default',
    'source' => '',
    'source_url' => '',
    'projet_default' => '',
    'submit_label' => 'Envoyer ma demande',
    'wrapper_class' => '',
));

$variant = $args['variant'] === 'compact' ? 'compact' : 'default';
$defaultPrestations = $args['projet_default'] ? array($args['projet_default']) : array();
$wrapperClasses = array('crescendo-contact-form', 'crescendo-contact-form--' . $variant);
if ($args['wrapper_class']) {
    $wrapperClasses[] = $args['wrapper_class'];
}
?>
<div class="<?php echo esc_attr(implode(' ', $wrapperClasses)); ?>">
    <form class="home-form__fields crescendo-contact-form__step1" novalidate>
        <input type="hidden" name="source" value="<?php echo esc_attr($args['source']); ?>">
        <input type="hidden" name="source_url" value="<?php echo esc_attr($args['source_url']); ?>">
        <input type="hidden" name="attribution_utm_source" value="">
        <input type="hidden" name="attribution_utm_medium" value="">
        <input type="hidden" name="attribution_utm_campaign" value="">
        <input type="hidden" name="attribution_utm_term" value="">
        <input type="hidden" name="attribution_utm_content" value="">
        <input type="hidden" name="attribution_gclid" value="">
        <input type="hidden" name="attribution_msclkid" value="">
        <input type="hidden" name="attribution_fbclid" value="">
        <input type="hidden" name="attribution_landing_page" value="">
        <input type="hidden" name="attribution_referrer" value="">
        <input type="hidden" name="action" value="crescendo_contact_step1">
        <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="crescendo-contact-form__honeypot" aria-hidden="true">

        <label>
            <span>Prénom *</span>
            <input type="text" name="prenom" required autocomplete="given-name">
        </label>

        <label>
            <span>Nom *</span>
            <input type="text" name="nom" required autocomplete="family-name">
        </label>

        <label>
            <span>Email professionnel *</span>
            <input type="email" name="email" required autocomplete="email">
        </label>

        <label>
            <span>Entreprise *</span>
            <input type="text" name="entreprise" required autocomplete="organization">
        </label>

        <label>
            <span>Téléphone</span>
            <input type="tel" name="telephone" autocomplete="tel">
        </label>

        <?php
        crescendo_render_prestation_tags(array(
            'legend' => 'Prestations souhaitées',
            'hint' => 'Plusieurs choix possibles',
            'required' => true,
            'default_values' => $defaultPrestations,
        ));
        ?>

        <?php if ($variant === 'default') : ?>
            <label class="home-form__full">
                <span>Votre besoin en quelques mots *</span>
                <textarea name="besoin" rows="4" required placeholder="Ex. : refonte de notre site vitrine, génération de leads, connexion CRM…"></textarea>
            </label>
        <?php endif; ?>

        <?php get_template_part('template-parts/general/block', 'contact-form-rgpd-consent'); ?>

        <div class="home-form__full crescendo-contact-form__feedback" role="status" aria-live="polite" hidden></div>

        <div class="home-form__full">
            <button type="submit" class="btn btn--primary crescendo-contact-form__submit">
                <?php echo esc_html($args['submit_label']); ?>
            </button>
        </div>
    </form>
</div>
