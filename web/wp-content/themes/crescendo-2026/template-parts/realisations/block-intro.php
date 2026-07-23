<?php
$text = crescendo_realisations('realisations-intro-text');
$stats = crescendo_realisations('realisations-intro-stats');

if (!$text && empty($stats)) {
    return;
}
?>
<section class="realisations-intro">
    <div class="container realisations-intro__inner">
        <?php if ($text) : ?>
            <p class="realisations-intro__text"><?php echo esc_html($text); ?></p>
        <?php endif; ?>

        <?php if (!empty($stats)) : ?>
            <ul class="realisations-intro__stats">
                <?php foreach ($stats as $stat) : ?>
                    <li>
                        <strong><?php echo esc_html($stat['value'] ?? ''); ?></strong>
                        <span><?php echo esc_html($stat['label'] ?? ''); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
