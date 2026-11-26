<?php
/**
 * Accueil — maquette éditoriale Crescendo Studio.
 *
 * @package crescendo-2026
 */

get_header();
get_header('nav');
?>
<main id="contenu" class="main home-studio">
    <?php get_template_part('template-parts/home-studio/block', 'hero'); ?>
    <?php get_template_part('template-parts/home-studio/block', 'projects'); ?>
    <?php get_template_part('template-parts/home-studio/block', 'expertises'); ?>
    <?php get_template_part('template-parts/home-studio/block', 'studio'); ?>
    <?php get_template_part('template-parts/home-studio/block', 'contact'); ?>
</main>
<?php
get_template_part('template-parts/general/block', 'rgpd');
get_footer();