<?php
/**
 * CTA de fin de hub Studio — charte bloc contact accueil (fond orange, typo noire).
 *
 * @package crescendo-2026
 */

$eyebrow = $args['eyebrow'] ?? __('Un projet avec Crescendo', 'crescendo-2026');
$title = $args['title'] ?? '';
$text = $args['text'] ?? '';
$title_id = $args['title_id'] ?? 'studio-hub-cta-title';
$section_class = $args['section_class'] ?? 'studio-contact studio-contact--hub';
$cta_url = $args['cta_url'] ?? '';
$cta_label = $args['cta_label'] ?? __('Parler de mon projet', 'crescendo-2026');
$mailto = $args['mailto'] ?? '';

if (!$title && !$text && !$cta_url && !$mailto) {
    return;
}

$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');
$actionUrl = $cta_url ?: $contactUrl;
$actionLabel = $cta_label ?: __('Demander ma maquette gratuite', 'crescendo-2026');

if (!$mailto) {
    $mailto = get_field('params-footer-email', 'option') ?: 'b.vidal@crescendo-studio.io';
}
?>
<section class="<?php echo esc_attr($section_class); ?>" aria-labelledby="<?php echo esc_attr($title_id); ?>">
    <div class="shell">
        <?php if ($eyebrow) : ?>
            <p class="studio-eyebrow" data-studio-text-reveal><?php echo esc_html($eyebrow); ?></p>
        <?php endif; ?>

        <?php if ($title) : ?>
            <h2 id="<?php echo esc_attr($title_id); ?>" data-studio-text-reveal>
                <?php echo esc_html($title); ?><span class="studio-contact__period" aria-hidden="true">.</span>
            </h2>
        <?php endif; ?>

        <div class="studio-contact-line" data-studio-text-reveal>
            <?php if ($text) : ?>
                <p class="studio-contact-line__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>
            <div class="studio-contact-line__actions">
                <a class="studio-mail studio-mail--cta" href="<?php echo esc_url($actionUrl); ?>"><?php echo esc_html($actionLabel); ?></a>
                <a class="studio-mail studio-mail--email" href="mailto:<?php echo esc_attr($mailto); ?>"><?php echo esc_html($mailto); ?></a>
            </div>
        </div>
    </div>
</section>