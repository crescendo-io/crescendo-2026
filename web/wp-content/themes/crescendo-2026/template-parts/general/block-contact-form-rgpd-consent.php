<?php
$privacyUrl = crescendo_nav_url('politique-de-confidentialite');
$consentVersion = crescendo_get_contact_rgpd_consent_version();
?>
<div class="home-form__full crescendo-contact-form__rgpd">
    <label class="crescendo-contact-form__rgpd-label">
        <input type="checkbox" name="rgpd_consent" value="1" required aria-required="true">
        <span>
            J'accepte que mes données personnelles soient collectées et traitées par <?php echo esc_html(crescendo_brand_name()); ?>
            afin de répondre à ma demande de contact, conformément à la
            <a href="<?php echo esc_url($privacyUrl); ?>" target="_blank" rel="noopener noreferrer">politique de confidentialité</a>.
            Je peux exercer mes droits (accès, rectification, suppression) en contactant
            <a href="mailto:<?php echo esc_attr(CRESCENDO_LEAD_NOTIFY_EMAIL); ?>"><?php echo esc_html(CRESCENDO_LEAD_NOTIFY_EMAIL); ?></a>.
            *
        </span>
    </label>
    <input type="hidden" name="rgpd_consent_version" value="<?php echo esc_attr($consentVersion); ?>">
</div>
