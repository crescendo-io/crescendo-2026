<?php
$email = get_field('params-footer-email', 'option') ?: 'b.vidal@crescendo-studio.io';
?>
<section class="studio-contact" id="contact" aria-labelledby="studio-contact-title">
    <div class="shell">
        <p class="studio-eyebrow" data-studio-text-reveal><?php esc_html_e('Un projet avec Crescendo', 'crescendo-2026'); ?></p>
        <h2 id="studio-contact-title" data-studio-text-reveal>
            <?php esc_html_e('Qu’aimeriez-vous', 'crescendo-2026'); ?>
            <br>
            <?php esc_html_e('simplifier ?', 'crescendo-2026'); ?>
        </h2>
        <div class="studio-contact-line" data-studio-text-reveal>
            <p>
                <?php esc_html_e('Parlez-nous de votre prochain site ou d’une tâche qui prend trop de temps à votre équipe.', 'crescendo-2026'); ?>
            </p>
            <a class="studio-mail" href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
        </div>
    </div>
</section>