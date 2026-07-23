<?php
/**
 * Template Name: Page Plan du site
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    ?>
    <main id="main" class="main sitemap-page" data-module="sitemapPage">
        <?php lsdGetTemplatePart('sitemap', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('sitemap', 'block', 'sections'); ?>
    </main>
    <?php
    crescendo_output_sitemap_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
