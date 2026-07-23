<?php
$challengeTitle = crescendo_project('project-challenge-title');
$challengeText = crescendo_project('project-challenge-text');
$solutionTitle = crescendo_project('project-solution-title');
$solutionText = crescendo_project('project-solution-text');

if (!$challengeText && !$solutionText) {
    return;
}
?>
<section class="project-content">
    <div class="container project-content__grid">
        <?php if ($challengeText) : ?>
            <article class="project-content__block">
                <?php if ($challengeTitle) : ?>
                    <h2><?php echo esc_html($challengeTitle); ?></h2>
                <?php endif; ?>
                <div class="project-content__text">
                    <?php echo wp_kses_post($challengeText); ?>
                </div>
            </article>
        <?php endif; ?>

        <?php if ($solutionText) : ?>
            <article class="project-content__block">
                <?php if ($solutionTitle) : ?>
                    <h2><?php echo esc_html($solutionTitle); ?></h2>
                <?php endif; ?>
                <div class="project-content__text">
                    <?php echo wp_kses_post($solutionText); ?>
                </div>
            </article>
        <?php endif; ?>
    </div>
</section>
