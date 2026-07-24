<?php
$eyebrow = crescendo_contact('contact-hero-eyebrow');
$title = crescendo_contact('contact-hero-title') ?: get_the_title();
$intro = crescendo_contact('contact-hero-intro');
$note = crescendo_contact('contact-hero-note');
$items = crescendo_contact_breadcrumb();
$formTitle = crescendo_contact('contact-form-title') ?: 'Discutons de votre projet';
$formIntro = crescendo_contact('contact-form-intro') ?: 'Décrivez votre besoin en quelques lignes. Nous vous répondons rapidement avec une proposition adaptée à votre budget et vos objectifs.';
$formShortcode = crescendo_contact('contact-form-shortcode');
?>
<section class="contact-hero">
    <div class="container">
        <?php if (!empty($items)) : ?>
            <nav class="service-breadcrumb" aria-label="Fil d'Ariane">
                <ol class="service-breadcrumb__list">
                    <?php foreach ($items as $index => $item) : ?>
                        <li class="service-breadcrumb__item">
                            <?php if ($index < count($items) - 1) : ?>
                                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                            <?php else : ?>
                                <span aria-current="page"><?php echo esc_html($item['label']); ?></span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </nav>
        <?php endif; ?>

        <div class="contact-hero__layout">
            <div class="contact-hero__aside">
                <?php if ($eyebrow) : ?>
                    <p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <h1 class="contact-hero__title"><?php echo esc_html($title); ?></h1>

                <div class="contact-hero__content">
                    <?php if ($intro) : ?>
                        <p class="contact-hero__intro"><?php echo esc_html($intro); ?></p>
                    <?php endif; ?>

                    <?php if ($note) : ?>
                        <ul class="contact-hero__reassurance">
                            <?php foreach (array_map('trim', preg_split('/\s*[·|]\s*/', $note)) as $line) : ?>
                                <?php if ($line !== '') : ?>
                                    <li><?php echo esc_html($line); ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <div class="contact-hero__form" id="formulaire">
                <?php
                crescendo_render_contact_form(array(
                    'title' => $formTitle,
                    'intro' => $formIntro,
                    'form_shortcode' => $formShortcode,
                    'source' => 'Page contact',
                    'source_url' => crescendo_nav_url('contact'),
                    'submit_label' => 'Envoyer ma demande',
                    'wrapper_class' => 'crescendo-contact-form-shell--hero',
                ));
                ?>
            </div>
        </div>
    </div>
</section>
