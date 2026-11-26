<?php
$eyebrow = crescendo_contact('contact-hero-eyebrow');
$title = crescendo_contact('contact-hero-title') ?: get_the_title();
$intro = crescendo_contact('contact-hero-intro');
$note = crescendo_contact('contact-hero-note');
$formTitle = crescendo_contact('contact-form-title') ?: __('Discutons de votre projet', 'crescendo-2026');
$formIntro = crescendo_contact('contact-form-intro') ?: __('Décrivez votre besoin en quelques lignes. Nous vous répondons rapidement avec une proposition adaptée à votre budget et vos objectifs.', 'crescendo-2026');
$formShortcode = crescendo_contact('contact-form-shortcode');
$reassurance = $note ? array_filter(array_map('trim', preg_split('/\s*[·|]\s*/', $note))) : array();
?>
<section class="studio-contact-page-hero" aria-labelledby="studio-contact-page-hero-title">
    <div class="shell studio-contact-page-hero__inner">
        <div class="studio-contact-page-hero__layout">
            <div class="studio-contact-page-hero__copy">
                <?php if ($eyebrow) : ?>
                    <p class="studio-eyebrow" data-studio-text-reveal>
                        <span class="studio-signal" aria-hidden="true"></span>
                        <?php echo esc_html($eyebrow); ?>
                    </p>
                <?php endif; ?>

                <h1 id="studio-contact-page-hero-title" data-studio-text-reveal>
                    <?php echo esc_html($title); ?><span class="studio-red">.</span>
                </h1>

                <?php if ($intro) : ?>
                    <p class="studio-contact-page-hero__intro" data-studio-text-reveal><?php echo esc_html($intro); ?></p>
                <?php endif; ?>

                <?php if (!empty($reassurance)) : ?>
                    <ul class="studio-contact-page-hero__reassurance" data-studio-text-reveal>
                        <?php foreach ($reassurance as $index => $line) : ?>
                            <li>
                                <span class="studio-contact-page-hero__reassurance-index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                                <span><?php echo esc_html($line); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="studio-contact-page-hero__form" id="formulaire" data-studio-text-reveal>
                <?php
                crescendo_render_contact_form(array(
                    'title' => $formTitle,
                    'intro' => $formIntro,
                    'form_shortcode' => $formShortcode,
                    'source' => __('Page contact', 'crescendo-2026'),
                    'source_url' => function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : get_permalink(),
                    'submit_label' => __('Envoyer ma demande', 'crescendo-2026'),
                    'wrapper_class' => 'crescendo-contact-form-shell--studio',
                ));
                ?>
            </div>
        </div>
    </div>
</section>