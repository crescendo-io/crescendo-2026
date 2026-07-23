<?php
/**
 * Template Name: Page Secteurs (hub)
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main secteurs-page" data-module="secteursPage">
        <?php lsdGetTemplatePart('secteurs', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('secteurs', 'block', 'intro'); ?>
        <?php lsdGetTemplatePart('secteurs', 'block', 'list'); ?>
        <?php lsdGetTemplatePart('secteurs', 'block', 'cta'); ?>
    </main>
    <?php
    crescendo_output_secteurs_hub_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
