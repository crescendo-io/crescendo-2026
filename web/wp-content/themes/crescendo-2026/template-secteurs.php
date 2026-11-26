<?php
/**
 * Template Name: Page Secteurs (hub)
 * Template Post Type: page
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');

while (have_posts()) :
    the_post();
    $studioSecteursHubLayout = function_exists('crescendo_uses_studio_secteurs_hub_layout') && crescendo_uses_studio_secteurs_hub_layout();
    $mainClass = 'main secteurs-page' . ($studioSecteursHubLayout ? ' secteurs-page--studio' : '');
    ?>
    <main id="contenu" class="<?php echo esc_attr($mainClass); ?>" data-module="secteursPage">
        <?php lsdGetTemplatePart('secteurs', 'block', 'hero'); ?>
        <?php if (!$studioSecteursHubLayout) : ?>
            <?php lsdGetTemplatePart('secteurs', 'block', 'intro'); ?>
        <?php endif; ?>
        <?php lsdGetTemplatePart('secteurs', 'block', 'list'); ?>
        <?php lsdGetTemplatePart('secteurs', 'block', 'cta'); ?>
    </main>
    <?php
    crescendo_output_secteurs_hub_schema(get_the_ID());
endwhile;

get_template_part('template-parts/general/block', 'rgpd');
get_footer();
