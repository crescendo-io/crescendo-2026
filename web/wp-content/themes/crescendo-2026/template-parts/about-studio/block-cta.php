<?php
$title = crescendo_about('about-cta-title');
$text = crescendo_about('about-cta-text');
$button = crescendo_about('about-cta-button');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');

if (!$title) {
    return;
}

$ctaUrl = !empty($button['url']) ? $button['url'] : $contactUrl;
$ctaLabel = !empty($button['title']) ? $button['title'] : __('Demander ma maquette gratuite', 'crescendo-2026');
?>
<section class="studio-project-cta studio-about-cta" aria-labelledby="studio-about-cta-title">
    <div class="shell">
        <h2 id="studio-about-cta-title" data-studio-text-reveal>
            <?php echo esc_html($title); ?><span class="studio-red">.</span>
        </h2>

        <div class="studio-project-cta__line" data-studio-text-reveal>
            <?php if ($text) : ?>
                <p class="studio-project-cta__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
            <a class="studio-project-cta__button" href="<?php echo esc_url($ctaUrl); ?>"><?php echo esc_html($ctaLabel); ?></a>
        </div>
    </div>
</section>