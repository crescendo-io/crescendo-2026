<?php
get_header();
get_header('nav');
?>
<main id="main" class="main home-page" data-module="homePage" data-context="@visible true">
    <?php lsdGetTemplatePart('home', 'block', 'hero'); ?>
    <?php lsdGetTemplatePart('home', 'block', 'trust'); ?>
    <?php lsdGetTemplatePart('home', 'block', 'services'); ?>
    <?php lsdGetTemplatePart('home', 'block', 'why'); ?>
    <?php lsdGetTemplatePart('home', 'block', 'method'); ?>
    <?php lsdGetTemplatePart('home', 'block', 'pricing'); ?>
    <?php lsdGetTemplatePart('home', 'block', 'crm'); ?>
    <?php lsdGetTemplatePart('home', 'block', 'testimonials'); ?>
    <?php lsdGetTemplatePart('home', 'block', 'cta'); ?>
    <?php lsdGetTemplatePart('home', 'block', 'faq-contact'); ?>
</main>
<?php
get_template_part('template-parts/general/block', 'rgpd');
get_footer();
