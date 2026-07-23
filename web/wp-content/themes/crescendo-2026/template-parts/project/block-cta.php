<?php
$title = crescendo_project('project-cta-title');
$text = crescendo_project('project-cta-text');
$button = crescendo_project('project-cta-button');
$backLink = crescendo_project('project-back-link');

if (!$title && empty($button['url'])) {
    return;
}

$realisations = get_page_by_path('realisations', OBJECT, 'page');
if (empty($backLink['url']) && $realisations) {
    $backLink = array(
        'title' => '← Toutes les réalisations',
        'url' => get_permalink($realisations),
        'target' => '',
    );
}
?>
<section class="project-cta">
    <div class="container project-cta__inner">
        <?php if (!empty($backLink['url'])) : ?>
            <?php echo crescendo_link($backLink, 'project-cta__back'); ?>
        <?php endif; ?>

        <?php if ($title) : ?>
            <h2 class="project-cta__title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if ($text) : ?>
            <p class="project-cta__text"><?php echo esc_html($text); ?></p>
        <?php endif; ?>

        <?php echo crescendo_link($button, 'btn btn--primary'); ?>
    </div>
</section>
