<?php
$title = crescendo_secteur('secteur-final-cta-title');
$text = crescendo_secteur('secteur-final-cta-text');
$points = crescendo_secteur('secteur-final-cta-points');
$reassurance = crescendo_secteur('secteur-final-reassurance');
$formShortcode = crescendo_secteur('secteur-contact-form-shortcode');
$email = get_field('params-footer-email', 'option') ?: 'b.vidal@crescendo-studio.io';

if (!$title) {
    return;
}
?>
<section class="studio-contact studio-contact--service studio-contact--secteur" id="contact" aria-labelledby="studio-secteur-contact-title">
    <div class="shell studio-contact--service__inner">
        <div class="studio-contact--service__layout">
            <div class="studio-contact--service__intro">
                <p class="studio-eyebrow" data-studio-text-reveal><?php esc_html_e('Démarrer', 'crescendo-2026'); ?></p>
                <h2 id="studio-secteur-contact-title" data-studio-text-reveal>
                    <?php echo esc_html($title); ?><span class="studio-red">.</span>
                </h2>
                <?php if ($text) : ?>
                    <p class="studio-contact--service__text" data-studio-text-reveal><?php echo esc_html($text); ?></p>
                <?php endif; ?>
                <?php if (!empty($points)) : ?>
                    <ul class="studio-service-included__list studio-contact--secteur__points" data-studio-text-reveal>
                        <?php foreach ($points as $point) : ?>
                            <?php $line = is_array($point) ? ($point['text'] ?? '') : $point; ?>
                            <?php if ($line) : ?>
                                <li><?php echo esc_html($line); ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <p class="studio-contact--service__mail" data-studio-text-reveal>
                    <a class="studio-mail" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                </p>
            </div>

            <div class="studio-contact--service__form" data-studio-text-reveal>
                <?php
                crescendo_render_contact_form(array(
                    'title' => '',
                    'form_shortcode' => $formShortcode,
                    'variant' => 'compact',
                    'source' => get_the_title(),
                    'projet_default' => 'site',
                    'submit_label' => __('Demander ma maquette gratuite', 'crescendo-2026'),
                    'wrapper_class' => 'crescendo-contact-form-shell--studio',
                ));
                ?>
            </div>
        </div>
        <?php if (!empty($reassurance)) : ?>
            <ul class="studio-contact--secteur__reassurance" data-studio-text-reveal>
                <?php foreach ($reassurance as $item) : ?>
                    <?php $line = is_array($item) ? ($item['text'] ?? '') : $item; ?>
                    <?php if ($line) : ?>
                        <li><?php echo esc_html($line); ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>