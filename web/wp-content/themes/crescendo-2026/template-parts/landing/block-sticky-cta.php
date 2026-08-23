<?php
$label = crescendo_landing('landing-sticky-cta-label') ?: 'Recevoir une estimation gratuite';
$url = crescendo_landing('landing-sticky-cta-url') ?: '#contact';
?>
<aside class="landing-sticky-cta" aria-label="Action rapide" hidden>
    <a href="<?php echo esc_url($url); ?>" class="btn btn--primary landing-sticky-cta__btn"><?php echo esc_html($label); ?></a>
</aside>
