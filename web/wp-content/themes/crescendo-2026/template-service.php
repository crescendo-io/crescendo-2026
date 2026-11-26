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
    $studioServiceLayout = function_exists('crescendo_uses_studio_service_layout') && crescendo_uses_studio_service_layout();
    $mainClass = 'main service-page' . ($studioServiceLayout ? ' service-page--studio' : '');
    ?>
    <main id="contenu" class="<?php echo esc_attr($mainClass); ?>" data-module="servicePage">
        <?php lsdGetTemplatePart('service', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'benefits'); ?>
        <?php if (!$studioServiceLayout) : ?>
            <?php lsdGetTemplatePart('service', 'block', 'problem'); ?>
            <?php lsdGetTemplatePart('service', 'block', 'solution'); ?>
        <?php endif; ?>
        <?php lsdGetTemplatePart('service', 'block', 'included'); ?>
        <?php if (!$studioServiceLayout) : ?>
            <?php lsdGetTemplatePart('service', 'block', 'compare'); ?>
        <?php endif; ?>
        <?php lsdGetTemplatePart('service', 'block', 'audience'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'projects'); ?>
        <?php lsdGetTemplatePart('service', 'block', 'method'); ?>
        <?php if (!$studioServiceLayout) : ?>
            <?php lsdGetTemplatePart('service', 'block', 'pricing'); ?>
            <?php lsdGetTemplatePart('service', 'block', 'area'); ?>
        <?php endif; ?>
        <?php lsdGetTemplatePart('service', 'block', 'faq'); ?>
        <?php if ($studioServiceLayout) : ?>
            <?php lsdGetTemplatePart('service', 'block', 'related'); ?>
            <?php lsdGetTemplatePart('service', 'block', 'contact'); ?>
        <?php else : ?>
            <?php lsdGetTemplatePart('service', 'block', 'related'); ?>
            <?php lsdGetTemplatePart('service', 'block', 'final-cta'); ?>
        <?php endif; ?>
    </main>
    <?php
    crescendo_output_service_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
