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
    $studioServicesHubLayout = function_exists('crescendo_uses_studio_services_hub_layout') && crescendo_uses_studio_services_hub_layout();
    $mainClass = 'main services-page' . ($studioServicesHubLayout ? ' services-page--studio' : '');
    ?>
    <main id="main" class="<?php echo esc_attr($mainClass); ?>" data-module="servicesPage">
        <?php lsdGetTemplatePart('services', 'block', 'hero'); ?>
        <?php lsdGetTemplatePart('services', 'block', 'offers'); ?>
        <?php lsdGetTemplatePart('services', 'block', 'list'); ?>
        <?php lsdGetTemplatePart('services', 'block', 'cta'); ?>
    </main>
    <?php
    crescendo_output_services_hub_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
