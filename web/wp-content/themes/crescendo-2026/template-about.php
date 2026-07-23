<?php
/**
 * Template Name: Page À propos
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main about-page" data-module="aboutPage">
        <?php lsdGetTemplatePart('about', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('about', 'block', 'story'); ?>
        <?php lsdGetTemplatePart('about', 'block', 'values'); ?>
        <?php lsdGetTemplatePart('about', 'block', 'expertise'); ?>
        <?php lsdGetTemplatePart('about', 'block', 'cta'); ?>
    </main>
    <?php
    crescendo_output_about_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
