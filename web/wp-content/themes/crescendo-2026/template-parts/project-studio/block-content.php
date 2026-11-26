<?php
$challengeTitle = crescendo_project('project-challenge-title');
$challengeText = crescendo_project('project-challenge-text');
$solutionTitle = crescendo_project('project-solution-title');
$solutionText = crescendo_project('project-solution-text');

if (!$challengeText && !$solutionText) {
    return;
}
?>
<section class="studio-project-story" aria-label="<?php esc_attr_e('Contexte et approche', 'crescendo-2026'); ?>">
    <div class="shell studio-project-story__layout">
        <?php if ($challengeText) : ?>
            <article class="studio-project-story__block" data-studio-text-reveal>
                <?php if ($challengeTitle) : ?>
                    <h2><?php echo esc_html($challengeTitle); ?></h2>
                <?php endif; ?>
                <div class="studio-project-story__text">
                    <?php echo wp_kses_post($challengeText); ?>
                </div>
            </article>
        <?php endif; ?>

        <?php if ($solutionText) : ?>
            <article class="studio-project-story__block studio-project-story__block--accent" data-studio-text-reveal>
                <?php if ($solutionTitle) : ?>
                    <h2><?php echo esc_html($solutionTitle); ?></h2>
                <?php endif; ?>
                <div class="studio-project-story__text">
                    <?php echo wp_kses_post($solutionText); ?>
                </div>
            </article>
        <?php endif; ?>
    </div>
</section>