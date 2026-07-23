<?php
/**
 * Template Name: Page Légale
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main legal-page" data-module="legalPage">
        <?php lsdGetTemplatePart('legal', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('legal', 'block', 'sections'); ?>
    </main>
    <?php
    crescendo_output_legal_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
