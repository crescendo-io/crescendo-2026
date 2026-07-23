<?php
get_header();
get_header('nav');
?>
    <main id="main" class="main" data-module="homePage" data-context="@visible true">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                get_template_part('template-parts/content', 'post');
            endwhile;
        endif;
        ?>
        <br>
        <a href="" class="rgpd-link">Manage cookies</a>
    </main>
<?php
    get_template_part('template-parts/general/block', 'rgpd');
?>

<?php
get_footer();
