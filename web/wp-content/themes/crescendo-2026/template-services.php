<?php
/**
 * Template Name: Page Services (hub)
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main services-page" data-module="servicesPage">
        <?php lsdGetTemplatePart('services', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('services', 'block', 'intro'); ?>
        <?php lsdGetTemplatePart('services', 'block', 'list'); ?>
        <?php lsdGetTemplatePart('services', 'block', 'cta'); ?>
    </main>
    <?php
    crescendo_output_services_hub_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
