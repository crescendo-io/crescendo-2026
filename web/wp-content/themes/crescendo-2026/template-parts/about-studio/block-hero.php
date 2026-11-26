<?php
$eyebrow = crescendo_about('about-hero-eyebrow');
$title = crescendo_about('about-hero-title') ?: get_the_title();
$intro = crescendo_about('about-hero-intro');
$stats = crescendo_about('about-story-stats');
$storyText = crescendo_about('about-story-text');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');

$manifesto = '';
if ($storyText) {
    $manifesto = wp_trim_words(wp_strip_all_tags($storyText), 22, '…');
}
?>
<header class="studio-about-hero" aria-labelledby="studio-about-hero-title">
    <div class="shell">
        <div class="studio-about-hero__copy">
            <div class="studio-about-hero__copy-inner">
                <?php if ($eyebrow) : ?>
                    <p class="studio-eyebrow studio-about-hero__eyebrow" data-studio-text-reveal>
                        <span class="studio-signal" aria-hidden="true"></span>
                        <?php echo esc_html($eyebrow); ?>
                    </p>
                <?php endif; ?>

                <h1 id="studio-about-hero-title" data-studio-text-reveal>
                    <?php echo esc_html($title); ?><span class="studio-red">.</span>
                </h1>

                <?php if ($intro) : ?>
                    <p class="studio-about-hero__intro" data-studio-text-reveal><?php echo esc_html($intro); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($stats)) : ?>
            <ul class="studio-about-hero__stats" data-studio-text-reveal>
                <?php foreach ($stats as $index => $stat) : ?>
                    <li>
                        <span class="studio-about-hero__stat-index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                        <?php if (!empty($stat['value'])) : ?>
                            <strong><?php echo esc_html($stat['value']); ?></strong>
                        <?php endif; ?>
                        <?php if (!empty($stat['label'])) : ?>
                            <span><?php echo esc_html($stat['label']); ?></span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <p class="studio-about-hero__actions" data-studio-text-reveal>
            <a class="studio-about-hero__button" href="<?php echo esc_url($contactUrl); ?>">
                <?php esc_html_e('Demander ma maquette gratuite', 'crescendo-2026'); ?>
            </a>
            <a class="studio-text-link" href="#histoire"><?php esc_html_e('Notre histoire', 'crescendo-2026'); ?></a>
        </p>
    </div>

    <?php if ($manifesto !== '') : ?>
        <aside class="studio-about-manifesto" data-studio-text-reveal>
            <div class="shell">
                <p class="studio-about-manifesto__text"><?php echo esc_html($manifesto); ?></p>
            </div>
        </aside>
    <?php endif; ?>
</header>