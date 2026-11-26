<?php
$title = crescendo_secteurs_hub('secteurs-cta-title');
$text = crescendo_secteurs_hub('secteurs-cta-text');
$button = crescendo_secteurs_hub('secteurs-cta-button');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');

if (!$title && !$text && empty($button['url'])) {
    return;
}

$ctaUrl = !empty($button['url']) ? crescendo_resolve_link_url($button['url']) : $contactUrl;
$ctaLabel = !empty($button['title']) ? $button['title'] : __('Demander ma maquette gratuite', 'crescendo-2026');
?>
<section class="studio-project-cta studio-secteurs-hub-cta" aria-labelledby="studio-secteurs-hub-cta-title">
    <div class="shell">
        <?php if ($title) : ?>
            <h2 id="studio-secteurs-hub-cta-title" data-studio-text-reveal>
                <?php echo esc_html($title); ?><span class="studio-red">.</span>
            </h2>
        <?php endif; ?>

        <div class="studio-project-cta__line" data-studio-text-reveal>
            <?php if ($text) : ?>
                <p class="studio-project-cta__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
            <a class="studio-project-cta__button" href="<?php echo esc_url($ctaUrl); ?>"><?php echo esc_html($ctaLabel); ?></a>
        </div>
    </div>
</section>