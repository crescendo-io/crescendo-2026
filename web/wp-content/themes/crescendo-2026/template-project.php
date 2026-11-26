<?php
/**
 * Template Name: Fiche Projet
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    $studioProjectLayout = function_exists('crescendo_uses_studio_project_layout') && crescendo_uses_studio_project_layout();
    $mainClass = 'main project-page' . ($studioProjectLayout ? ' project-page--studio' : '');
    ?>
    <main id="main" class="<?php echo esc_attr($mainClass); ?>" data-module="projectPage">
        <?php lsdGetTemplatePart('project', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('project', 'block', 'meta'); ?>
        <?php lsdGetTemplatePart('project', 'block', 'gallery'); ?>
        <?php lsdGetTemplatePart('project', 'block', 'content'); ?>
        <?php lsdGetTemplatePart('project', 'block', 'results'); ?>
        <?php lsdGetTemplatePart('project', 'block', 'cta'); ?>
    </main>
    <?php
    crescendo_output_project_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
