<?php
$theme = THEME_URL . 'assets/images/studio/';
$eyebrow = crescendo_home('home-crm-eyebrow');
$title = crescendo_home('home-crm-title');
$subtitle = crescendo_home('home-crm-subtitle');
$text = crescendo_home('home-crm-text');
$list = crescendo_home('home-crm-list');
$cta = crescendo_home('home-crm-cta');
$image = crescendo_home('home-crm-image');
$contactUrl = function_exists('crescendo_nav_url') ? crescendo_nav_url('contact') : home_url('/contact/');
$ctaUrl = !empty($cta['url']) ? crescendo_resolve_link_url($cta['url']) : home_url('/services/crm-sur-mesure-nantes/');
$ctaLabel = !empty($cta['title']) ? $cta['title'] : __('Découvrir le CRM sur mesure', 'crescendo-2026');
$hasImage = !empty($image['url']) || !empty($image['ID']) || !empty($image['id']);

if (!$title && !$text && empty($list)) {
    return;
}

$listItems = array();
if (!empty($list)) {
    foreach ($list as $item) {
        $line = is_array($item) ? ($item['text'] ?? '') : $item;
        if ($line !== '') {
            $listItems[] = $line;
        }
    }
}
?>
<section class="studio-crm" id="crm" aria-labelledby="studio-crm-title">
    <div class="shell studio-crm__inner">
        <div class="studio-crm__layout">
            <div class="studio-crm__copy" data-studio-text-reveal>
                <?php if ($eyebrow) : ?>
                    <p class="studio-eyebrow">
                        <span class="studio-signal" aria-hidden="true"></span>
                        <?php echo esc_html($eyebrow); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h2 id="studio-crm-title">
                        <?php echo esc_html($title); ?><span class="studio-contact__period" aria-hidden="true">.</span>
                    </h2>
                <?php endif; ?>

                <?php if ($subtitle) : ?>
                    <p class="studio-crm__deck"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <p class="studio-crm__text"><?php echo esc_html($text); ?></p>
                <?php endif; ?>

                <?php if (!empty($listItems)) : ?>
                    <ul class="studio-crm__chips" aria-label="<?php esc_attr_e('Prestations CRM', 'crescendo-2026'); ?>">
                        <?php foreach ($listItems as $line) : ?>
                            <li><?php echo esc_html($line); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <div class="studio-crm__actions">
                    <a class="studio-mail studio-mail--cta" href="<?php echo esc_url($ctaUrl); ?>">
                        <?php echo esc_html($ctaLabel); ?>
                    </a>
                    <a class="studio-mail studio-mail--email" href="<?php echo esc_url($contactUrl); ?>">
                        <?php esc_html_e('Parler d’un outil métier', 'crescendo-2026'); ?>
                    </a>
                </div>
            </div>

            <figure class="studio-crm__figure" data-studio-reveal>
                <div class="studio-crm__stage">
                    <?php if ($hasImage) : ?>
                        <?php
                        echo crescendo_image($image, 'large', array(
                            'alt' => $image['alt'] ?? $title,
                            'class' => 'studio-crm__stage-img',
                            'sizes' => '(min-width: 992px) 46vw, calc(100vw - var(--studio-margin) * 2)',
                            'loading' => 'lazy',
                        ));
                        ?>
                    <?php else : ?>
                        <div class="studio-crm__stage-mock" aria-hidden="true">
                            <span class="studio-crm__stage-ui"></span>
                            <img
                                class="studio-crm__stage-phone"
                                src="<?php echo esc_url($theme . 'hero-mockup-phone.png'); ?>"
                                width="655"
                                height="819"
                                alt=""
                                loading="lazy"
                                decoding="async"
                            >
                        </div>
                    <?php endif; ?>
                </div>
            </figure>
        </div>
    </div>
</section>