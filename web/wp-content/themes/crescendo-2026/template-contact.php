<?php
/**
 * Template Name: Page Contact
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main contact-page" data-module="contactPage">
        <?php lsdGetTemplatePart('contact', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('contact', 'block', 'info'); ?>
        <?php lsdGetTemplatePart('contact', 'block', 'faq-form'); ?>
    </main>
    <?php
    crescendo_output_contact_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
