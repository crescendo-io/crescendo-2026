<?php
/**
 * Template Name: Page Merci
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main thank-you-page" data-module="thankYouPage">
        <?php lsdGetTemplatePart('thank-you', 'block', 'hero'); ?>
    </main>
    <?php
    crescendo_output_thank_you_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
