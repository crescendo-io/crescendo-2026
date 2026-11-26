<?php
$logoMarkup = function_exists('crescendo_studio_logo_markup') ? crescendo_studio_logo_markup() : '';
?>
<footer class="shell studio-footer" role="contentinfo">
    <a class="brand studio-brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php esc_attr_e('Crescendo, retour en haut', 'crescendo-2026'); ?>">
        <?php
        if ($logoMarkup !== '') {
            // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG markup from theme file.
            echo $logoMarkup;
        }
        ?>
    </a>
    <span><?php esc_html_e('Sites web & CRM', 'crescendo-2026'); ?></span>
    <nav aria-label="<?php esc_attr_e('Liens complémentaires', 'crescendo-2026'); ?>">
        <a href="<?php echo esc_url(crescendo_instagram_url()); ?>" target="_blank" rel="noopener noreferrer">Instagram</a>
        <a href="<?php echo esc_url(crescendo_nav_url('mentions-legales')); ?>"><?php esc_html_e('Mentions légales', 'crescendo-2026'); ?></a>
        <a href="<?php echo esc_url(crescendo_nav_url('politique-de-confidentialite')); ?>"><?php esc_html_e('Confidentialité', 'crescendo-2026'); ?></a>
        <a href="#cookie-consent" data-cookie-open><?php esc_html_e('Cookies', 'crescendo-2026'); ?></a>
        <a href="<?php echo esc_url(crescendo_nav_url('plan-du-site')); ?>"><?php esc_html_e('Plan du site', 'crescendo-2026'); ?></a>
    </nav>
    <small>© <?php echo esc_html(date('Y')); ?> Crescendo Studio</small>
</footer>