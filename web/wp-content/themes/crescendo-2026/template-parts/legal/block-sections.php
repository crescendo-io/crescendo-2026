<?php
$sections = crescendo_legal('legal-sections');

if (empty($sections)) {
    return;
}
?>
<section class="legal-sections">
    <div class="container legal-sections__inner">
        <?php foreach ($sections as $section) : ?>
            <article class="legal-sections__block">
                <?php if (!empty($section['title'])) : ?>
                    <h2><?php echo esc_html($section['title']); ?></h2>
                <?php endif; ?>

                <?php if (!empty($section['content'])) : ?>
                    <div class="legal-sections__content">
                        <?php echo wp_kses_post(wpautop($section['content'])); ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>
