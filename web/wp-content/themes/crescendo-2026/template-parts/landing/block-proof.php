<?php
$stats = crescendo_landing('landing-proof-stats');

if (empty($stats)) {
    return;
}
?>
<section class="landing-proof">
    <div class="container">
        <ul class="landing-proof__stats">
            <?php foreach ($stats as $stat) : ?>
                <li>
                    <?php if (!empty($stat['value'])) : ?><strong><?php echo esc_html($stat['value']); ?></strong><?php endif; ?>
                    <?php if (!empty($stat['label'])) : ?><span><?php echo esc_html($stat['label']); ?></span><?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
