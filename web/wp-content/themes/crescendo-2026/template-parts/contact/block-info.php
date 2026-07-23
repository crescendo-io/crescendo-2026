<?php
$phone = crescendo_contact('contact-info-phone');
$email = crescendo_contact('contact-info-email');
$address = crescendo_contact('contact-info-address');
$hours = crescendo_contact('contact-info-hours');
$zone = crescendo_contact('contact-info-zone');

if (!$phone && !$email && !$address) {
    $phone = get_field('params-footer-phone', 'option');
    $email = get_field('params-footer-email', 'option');
    $address = get_field('params-footer-address', 'option');
}

if (!$phone && !$email && !$address && !$hours && !$zone) {
    return;
}
?>
<section class="contact-info">
    <div class="container">
        <div class="contact-info__grid">
            <?php if ($phone) : ?>
                <div class="contact-info__item">
                    <p class="contact-info__label">Téléphone</p>
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>" class="contact-info__value"><?php echo esc_html($phone); ?></a>
                </div>
            <?php endif; ?>

            <?php if ($email) : ?>
                <div class="contact-info__item">
                    <p class="contact-info__label">Email</p>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-info__value"><?php echo esc_html($email); ?></a>
                </div>
            <?php endif; ?>

            <?php if ($address) : ?>
                <div class="contact-info__item">
                    <p class="contact-info__label">Adresse</p>
                    <p class="contact-info__value"><?php echo esc_html($address); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($hours) : ?>
                <div class="contact-info__item">
                    <p class="contact-info__label">Disponibilité</p>
                    <p class="contact-info__value"><?php echo esc_html($hours); ?></p>
                </div>
            <?php endif; ?>

            <?php if ($zone) : ?>
                <div class="contact-info__item contact-info__item--wide">
                    <p class="contact-info__label">Zone d'intervention</p>
                    <p class="contact-info__value"><?php echo esc_html($zone); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
