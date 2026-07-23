<?php
$title = crescendo_home('home-cta-title');
$text = crescendo_home('home-cta-text');
$button = crescendo_home('home-cta-button');
?>
<section class="home-cta-band">
    <div class="container home-cta-band__inner">
        <div>
            <h2 class="home-cta-band__title"><?php echo esc_html($title); ?></h2>
            <?php if ($text) : ?>
                <p class="home-cta-band__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
        </div>
        <?php echo crescendo_link($button, 'btn btn--outline-dark'); ?>
    </div>
</section>
