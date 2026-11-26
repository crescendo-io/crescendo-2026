<?php
$services = array(
    array(
        'title' => 'Sites internet',
        'text' => 'Un site vitrine pour expliquer votre métier, une boutique pour vendre en ligne. Nous dessinons les pages, développons votre site WordPress et vous formons à la publication.',
        'tags' => 'Design UX/UI · WordPress · WooCommerce',
        'open' => true,
    ),
    array(
        'title' => 'CRM & développement',
        'text' => 'Qui a demandé un devis ? Qui doit rappeler ? Nous construisons l’outil qui rassemble les demandes de votre site, les échanges et les prochaines actions de votre équipe.',
        'tags' => 'CRM sur mesure · Connexions API · Automatisation',
        'open' => false,
    ),
    array(
        'title' => 'Référencement naturel',
        'text' => 'Nous partons des recherches de vos futurs clients pour organiser vos pages, écrire des contenus précis et suivre leur visibilité, notamment sur votre zone d’activité.',
        'tags' => 'Audit · SEO local · Suivi des recherches',
        'open' => false,
    ),
    array(
        'title' => 'Accompagnement',
        'text' => 'Après la mise en ligne, nous assurons les mises à jour et les sauvegardes. Vos retours d’usage nous aident à décider des prochaines évolutions.',
        'tags' => 'Formation · Maintenance · Évolutions',
        'open' => false,
    ),
);
?>
<section class="studio-expertises" id="expertises" aria-labelledby="studio-expertises-title">
    <div class="shell studio-expertise-layout">
        <div class="studio-expert-intro">
            <p class="studio-eyebrow" data-studio-text-reveal><?php esc_html_e('Expertises', 'crescendo-2026'); ?></p>
            <h2 id="studio-expertises-title" data-studio-text-reveal>
                <?php esc_html_e('Ce que l’on', 'crescendo-2026'); ?>
                <br>
                <?php esc_html_e('construit', 'crescendo-2026'); ?><span class="studio-red">.</span>
            </h2>
        </div>
        <div class="studio-services" data-studio-text-reveal>
            <?php foreach ($services as $service) : ?>
                <details name="studio-services"<?php echo !empty($service['open']) ? ' open' : ''; ?>>
                    <summary>
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <i aria-hidden="true"></i>
                    </summary>
                    <div class="studio-service-body">
                        <p><?php echo esc_html($service['text']); ?></p>
                        <span><?php echo esc_html($service['tags']); ?></span>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>