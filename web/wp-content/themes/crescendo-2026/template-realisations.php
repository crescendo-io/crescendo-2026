<?php
/**
 * Template Name: Page Réalisations
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    $studioRealisationsLayout = function_exists('crescendo_uses_studio_realisations_layout') && crescendo_uses_studio_realisations_layout();
    $mainClass = 'main realisations-page' . ($studioRealisationsLayout ? ' realisations-page--studio' : '');
    ?>
    <main id="main" class="<?php echo esc_attr($mainClass); ?>" data-module="realisationsPage">
        <?php lsdGetTemplatePart('realisations', 'block', 'hero'); ?>
        <?php if (!$studioRealisationsLayout) : ?>
            <?php lsdGetTemplatePart('realisations', 'block', 'intro'); ?>
        <?php endif; ?>
        <?php lsdGetTemplatePart('realisations', 'block', 'projects'); ?>
        <?php lsdGetTemplatePart('realisations', 'block', 'cta'); ?>
    </main>
    <?php
    crescendo_output_realisations_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
