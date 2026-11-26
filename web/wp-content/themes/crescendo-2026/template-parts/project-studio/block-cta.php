<?php
$title = crescendo_project('project-cta-title');
$text = crescendo_project('project-cta-text');
$button = crescendo_project('project-cta-button');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');

if (!$title && empty($button['url'])) {
    return;
}

$ctaUrl = !empty($button['url']) ? $button['url'] : $contactUrl;
$ctaLabel = !empty($button['title']) ? $button['title'] : __('Demander ma maquette gratuite', 'crescendo-2026');
?>
<section class="studio-project-cta" aria-labelledby="studio-project-cta-title">
    <div class="shell">
        <?php if ($title) : ?>
            <h2 id="studio-project-cta-title" data-studio-text-reveal>
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