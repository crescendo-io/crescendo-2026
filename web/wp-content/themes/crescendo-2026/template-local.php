<?php
/**
 * Template Name: Page Local SEO
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main local-page secteur-page" data-module="localPage">
        <?php lsdGetTemplatePart('local', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'toc'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'sections'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'pain'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'features'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'method'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'solution'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'projects'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'case-study'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'pricing'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'area'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'faq'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'related'); ?>
        <?php lsdGetTemplatePart('local', 'block', 'final-cta'); ?>
    </main>
    <?php
    crescendo_output_local_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
