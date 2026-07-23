<?php
/**
 * Template Name: Page Service SEO
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main service-page" data-module="servicePage">
        <?php lsdGetTemplatePart('service', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'benefits'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'problem'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'solution'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'included'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'compare'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'audience'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'projects'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'method'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'pricing'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'area'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'faq'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'related'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'final-cta'); ?>
    </main>
    <?php
    crescendo_output_service_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
