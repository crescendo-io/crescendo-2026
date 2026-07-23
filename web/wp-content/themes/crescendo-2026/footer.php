<?php
$description = get_field('params-footer-description', 'option') ?: 'Agence web à Nantes spécialisée WordPress sur mesure, CRM et location de site dès 350€/mois.';
$phone = get_field('params-footer-phone', 'option');
$email = get_field('params-footer-email', 'option');
$address = get_field('params-footer-address', 'option') ?: 'Nantes, Loire-Atlantique (44)';
$footerColumns = crescendo_get_footer_nav_columns();
?>
<footer class="site-footer" role="contentinfo" data-module="footer" data-context="@visible true">
    <div class="container site-footer__top">
        <div class="site-footer__brand">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo site-logo--footer" aria-label="<?php bloginfo('name'); ?> — Accueil">
                <img
                    src="<?php echo esc_url(THEME_URL . 'assets/images/logo.png'); ?>"
                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                    width="186"
                    height="27"
                    decoding="async"
                >
            </a>
            <p><?php echo esc_html($description); ?></p>
        </div>

        <?php foreach ($footerColumns as $column) : ?>
            <div class="site-footer__col">
                <h3><?php echo esc_html($column['title']); ?></h3>
                <ul>
                    <?php foreach ($column['items'] as $item) : ?>
                        <li><a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a></li>
                    <?php endforeach; ?>
                    <?php if ($column['title'] === 'Secteurs') : ?>
                        <li><a href="<?php echo esc_url(crescendo_nav_url('plan-du-site')); ?>#sitemap-secteurs">Tous les secteurs →</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endforeach; ?>

        <div class="site-footer__col">
            <h3>Contact</h3>
            <ul class="site-footer__contact">
                <?php if ($phone) : ?><li><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></li><?php endif; ?>
                <?php if ($email) : ?><li><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li><?php endif; ?>
                <li><?php echo esc_html($address); ?></li>
                <li><a href="<?php echo esc_url(crescendo_nav_url('contact')); ?>">Nous contacter →</a></li>
            </ul>
        </div>
    </div>

    <div class="site-footer__bottom">
        <div class="container site-footer__bottom-inner">
            <p>© <?php echo esc_html(date('Y')); ?> Crescendo Studio — Tous droits réservés</p>
            <ul class="site-footer__legal">
                <li><a href="<?php echo esc_url(crescendo_nav_url('mentions-legales')); ?>">Mentions légales</a></li>
                <li><a href="<?php echo esc_url(crescendo_nav_url('politique-de-confidentialite')); ?>">Politique de confidentialité</a></li>
                <li><a href="<?php echo esc_url(crescendo_nav_url('plan-du-site')); ?>">Plan du site</a></li>
            </ul>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</div>
</body>
</html>
