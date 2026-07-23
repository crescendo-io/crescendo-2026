<?php
$description = get_field('params-footer-description', 'option') ?: 'Agence web à Nantes spécialisée WordPress sur mesure, CRM et location de site dès 350€/mois.';
$phone = get_field('params-footer-phone', 'option');
$email = get_field('params-footer-email', 'option');
$address = get_field('params-footer-address', 'option') ?: 'Nantes, Loire-Atlantique (44)';

$footerServices = array(
    'Création de site internet', 'CRM sur mesure', 'Location 350€/mois',
    'Refonte WordPress', 'Site e-commerce', 'Maintenance',
);
$footerSectors = array(
    'Artisan', 'Avocat', 'Immobilier', 'Restaurant', 'Coach', 'B2B',
);
$footerCities = array(
    'Saint-Herblain', 'Rezé', 'Orvault', 'Carquefou', 'Bouguenais',
);
?>
<footer class="site-footer" role="contentinfo" data-module="footer" data-context="@visible true">
    <div class="container site-footer__top">
        <div class="site-footer__brand">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo site-logo--footer">crescendo</a>
            <p><?php echo esc_html($description); ?></p>
        </div>

        <div class="site-footer__col">
            <h3>Services</h3>
            <ul>
                <?php foreach ($footerServices as $item) : ?>
                    <li><a href="#"><?php echo esc_html($item); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="site-footer__col">
            <h3>Secteurs</h3>
            <ul>
                <?php foreach ($footerSectors as $item) : ?>
                    <li><a href="#"><?php echo esc_html($item); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="site-footer__col">
            <h3>Villes</h3>
            <ul>
                <?php foreach ($footerCities as $item) : ?>
                    <li><a href="#"><?php echo esc_html($item); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="site-footer__col">
            <h3>Contact</h3>
            <ul class="site-footer__contact">
                <?php if ($phone) : ?><li><a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></li><?php endif; ?>
                <?php if ($email) : ?><li><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></li><?php endif; ?>
                <li><?php echo esc_html($address); ?></li>
            </ul>
        </div>
    </div>

    <div class="site-footer__bottom">
        <div class="container site-footer__bottom-inner">
            <p>© <?php echo esc_html(date('Y')); ?> Crescendo Studio — Tous droits réservés</p>
            <ul class="site-footer__legal">
                <li><a href="<?php echo esc_url(home_url('/mentions-legales/')); ?>">Mentions légales</a></li>
                <li><a href="<?php echo esc_url(home_url('/politique-de-confidentialite/')); ?>">Politique de confidentialité</a></li>
                <li><a href="#">Plan du site</a></li>
            </ul>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</div>
</body>
</html>
