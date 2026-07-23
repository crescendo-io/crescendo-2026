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
    ?>
    <main id="main" class="main realisations-page" data-module="realisationsPage">
        <?php lsdGetTemplatePart('realisations', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('realisations', 'block', 'intro'); ?>
        <?php lsdGetTemplatePart('realisations', 'block', 'projects'); ?>
        <?php lsdGetTemplatePart('realisations', 'block', 'cta'); ?>
    </main>
    <?php
    crescendo_output_realisations_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
