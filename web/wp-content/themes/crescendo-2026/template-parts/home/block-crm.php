<?php
$eyebrow = crescendo_home('home-crm-eyebrow');
$title = crescendo_home('home-crm-title');
$subtitle = crescendo_home('home-crm-subtitle');
$text = crescendo_home('home-crm-text');
$list = crescendo_home('home-crm-list');
$cta = crescendo_home('home-crm-cta');
$image = crescendo_home('home-crm-image');
?>
<section class="home-crm">
    <div class="container home-crm__inner">
        <div class="home-crm__content">
            <?php if ($eyebrow) : ?>
                <p class="home-eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <h2 class="home-crm__title"><?php echo esc_html($title); ?></h2>
            <?php if ($subtitle) : ?>
                <p class="home-crm__subtitle"><?php echo esc_html($subtitle); ?></p>
            <?php endif; ?>
            <?php if ($text) : ?>
                <p class="home-crm__text"><?php echo esc_html($text); ?></p>
            <?php endif; ?>

            <?php if (!empty($list)) : ?>
                <ul class="home-crm__list">
                    <?php foreach ($list as $item) : ?>
                        <?php $line = is_array($item) ? ($item['text'] ?? '') : $item; ?>
                        <li><?php echo esc_html($line); ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php echo crescendo_link($cta, 'btn btn--dark'); ?>
        </div>

        <div class="home-crm__visual">
            <?php if (!empty($image['url']) || !empty($image['ID']) || !empty($image['id'])) : ?>
                <?php
                echo crescendo_image($image, 'crescendo-content', array(
                    'alt' => $image['alt'] ?: $title,
                    'sizes' => '(min-width: 768px) 50vw, 100vw',
                    'loading' => 'lazy',
                ));
                ?>
            <?php else : ?>
                <div class="home-crm__placeholder" aria-hidden="true">
                    <span>Dashboard CRM</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
