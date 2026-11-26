<?php
$email = crescendo_contact('contact-info-email');
$address = crescendo_contact('contact-info-address');
$hours = crescendo_contact('contact-info-hours');
$zone = crescendo_contact('contact-info-zone');

if (!$email) {
    $email = get_field('params-footer-email', 'option') ?: crescendo_default_footer_email();
}

if (!$address) {
    $address = get_field('params-footer-address', 'option') ?: crescendo_default_footer_address();
}

$items = array();
if ($email) {
    $items[] = array(
        'label' => __('Email', 'crescendo-2026'),
        'value' => $email,
        'url' => 'mailto:' . $email,
    );
}
if ($address) {
    $items[] = array(
        'label' => __('Adresse', 'crescendo-2026'),
        'value' => $address,
    );
}
if ($hours) {
    $items[] = array(
        'label' => __('Disponibilité', 'crescendo-2026'),
        'value' => $hours,
    );
}
if ($zone) {
    $items[] = array(
        'label' => __('Zone d\'intervention', 'crescendo-2026'),
        'value' => $zone,
        'wide' => true,
    );
}

if (empty($items)) {
    return;
}
?>
<section class="studio-contact-page-info" aria-label="<?php esc_attr_e('Coordonnées', 'crescendo-2026'); ?>">
    <div class="shell">
        <ul class="studio-contact-page-info__grid">
            <?php foreach ($items as $index => $item) : ?>
                <li class="studio-contact-page-info__item<?php echo !empty($item['wide']) ? ' studio-contact-page-info__item--wide' : ''; ?>" data-studio-text-reveal>
                    <span class="studio-contact-page-info__index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                    <p class="studio-contact-page-info__label"><?php echo esc_html($item['label']); ?></p>
                    <?php if (!empty($item['url'])) : ?>
                        <a class="studio-contact-page-info__value" href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['value']); ?></a>
                    <?php else : ?>
                        <p class="studio-contact-page-info__value"><?php echo esc_html($item['value']); ?></p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>