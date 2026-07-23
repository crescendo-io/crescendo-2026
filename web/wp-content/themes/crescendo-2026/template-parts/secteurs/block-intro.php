<?php
$text = crescendo_secteurs_hub('secteurs-intro-text');
$stats = crescendo_secteurs_hub('secteurs-intro-stats');

if (!$text && empty($stats)) {
    return;
}
?>
<section class="secteurs-intro">
    <div class="container">
        <div class="secteurs-intro__inner">
            <?php if ($text) : ?>
                <p class="secteurs-intro__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if (!empty($stats)) : ?>
                <ul class="secteurs-intro__stats">
                    <?php foreach ($stats as $stat) : ?>
                        <li>
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
        </div>
    </div>
</section>
