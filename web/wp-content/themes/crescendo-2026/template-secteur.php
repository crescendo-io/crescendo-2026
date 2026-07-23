<?php
/**
 * Template Name: Page Secteur SEO
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main secteur-page" data-module="secteurPage">
        <?php lsdGetTemplatePart('secteur', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('secteur', 'block', 'pain'); ?>
        <?php lsdGetTemplatePart('secteur', 'block', 'solution'); ?>
        <?php lsdGetTemplatePart('secteur', 'block', 'features'); ?>
        <?php lsdGetTemplatePart('secteur', 'block', 'case-study'); ?>
        <?php lsdGetTemplatePart('secteur', 'block', 'pricing'); ?>
        <?php lsdGetTemplatePart('secteur', 'block', 'area'); ?>
        <?php lsdGetTemplatePart('secteur', 'block', 'faq'); ?>
        <?php lsdGetTemplatePart('secteur', 'block', 'related'); ?>
        <?php lsdGetTemplatePart('secteur', 'block', 'final-cta'); ?>
    </main>
    <?php
    crescendo_output_secteur_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
