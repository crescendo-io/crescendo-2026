<?php
$eyebrow = crescendo_home('home-method-eyebrow');
$title = crescendo_home('home-method-title');
$steps = crescendo_home('home-method-steps');
?>
<section class="home-method">
    <div class="container">
        <?php if ($eyebrow) : ?>
            <p class="home-eyebrow home-eyebrow--center"><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>
        <h2 class="home-section-head__title home-section-head__title--center"><?php echo esc_html($title); ?></h2>

        <?php if (!empty($steps)) : ?>
            <ol class="home-method__steps">
                <?php foreach ($steps as $index => $step) : ?>
                    <li class="home-method__step">
                        <span class="home-method__number"><?php echo esc_html($index + 1); ?></span>
                        <h3><?php echo esc_html($step['title'] ?? ''); ?></h3>
                        <p><?php echo esc_html($step['text'] ?? ''); ?></p>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </div>
</section>
