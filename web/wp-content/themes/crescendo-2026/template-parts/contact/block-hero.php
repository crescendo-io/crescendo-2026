<?php
$eyebrow = crescendo_contact('contact-hero-eyebrow');
$title = crescendo_contact('contact-hero-title') ?: get_the_title();
$intro = crescendo_contact('contact-hero-intro');
$note = crescendo_contact('contact-hero-note');
$items = crescendo_contact_breadcrumb();
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

        <?php if ($eyebrow) : ?>
            <p class="service-eyebrow"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <div class="contact-hero__layout">
            <h1 class="contact-hero__title"><?php echo esc_html($title); ?></h1>

            <div class="contact-hero__content">
                <?php if ($intro) : ?>
                    <p class="contact-hero__intro"><?php echo esc_html($intro); ?></p>
                <?php endif; ?>

                <?php if ($note) : ?>
                    <p class="contact-hero__note">
                        <span class="contact-hero__note-icon" aria-hidden="true">⏱</span>
                        <?php echo esc_html($note); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
