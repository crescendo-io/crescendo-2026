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
    $studioAboutLayout = function_exists('crescendo_uses_studio_about_layout') && crescendo_uses_studio_about_layout();
    $mainClass = 'main about-page' . ($studioAboutLayout ? ' about-page--studio' : '');
    ?>
    <main id="main" class="<?php echo esc_attr($mainClass); ?>" data-module="aboutPage">
        <?php lsdGetTemplatePart('about', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('about', 'block', 'story'); ?>
        <?php lsdGetTemplatePart('about', 'block', 'values'); ?>
        <?php lsdGetTemplatePart('about', 'block', 'expertise'); ?>
        <?php if ($studioAboutLayout) : ?>
            <?php lsdGetTemplatePart('about', 'block', 'testimonials'); ?>
        <?php endif; ?>
        <?php lsdGetTemplatePart('about', 'block', 'cta'); ?>
    </main>
    <?php
    crescendo_output_about_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
