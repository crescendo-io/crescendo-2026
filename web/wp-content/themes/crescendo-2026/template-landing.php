<?php
/**
 * Template Name: Landing SEA
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav-minimal');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main landing-page" data-module="landingPage">
        <?php lsdGetTemplatePart('landing', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('landing', 'block', 'mockups'); ?>
        <?php lsdGetTemplatePart('landing', 'block', 'projects'); ?>
        <?php lsdGetTemplatePart('landing', 'block', 'testimonials'); ?>
        <?php lsdGetTemplatePart('landing', 'block', 'included'); ?>
        <?php lsdGetTemplatePart('landing', 'block', 'pricing'); ?>
        <?php lsdGetTemplatePart('landing', 'block', 'proof'); ?>
        <?php lsdGetTemplatePart('landing', 'block', 'faq'); ?>
        <?php lsdGetTemplatePart('landing', 'block', 'form'); ?>
        <?php lsdGetTemplatePart('landing', 'block', 'sticky-cta'); ?>
    </main>
    <?php
    crescendo_output_landing_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
