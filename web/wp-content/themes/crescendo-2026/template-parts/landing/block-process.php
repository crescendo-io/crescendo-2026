<?php
$title = crescendo_landing('landing-process-title') ?: 'Un processus simple et rassurant';
$steps = crescendo_landing('landing-process-steps');

if (empty($steps)) {
    return;
}
?>
<section class="landing-process service-section--alt">
    <div class="container">
        <h2 class="service-section__title service-section__title--center"><?php echo esc_html($title); ?></h2>

        <ol class="landing-process__steps">
            <?php foreach ($steps as $index => $step) : ?>
                <li class="landing-process__step">
                    <span class="landing-process__index" aria-hidden="true"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                    <div>
                        <?php if (!empty($step['title'])) : ?>
                            <h3><?php echo esc_html($step['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($step['text'])) : ?>
                            <p><?php echo esc_html($step['text']); ?></p>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>
