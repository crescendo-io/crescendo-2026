<?php
$title = crescendo_service('service-final-cta-title');
$reassurance = crescendo_service('service-final-reassurance');
$button = crescendo_service('service-cta-button');
$buttonTitle = is_array($button) ? ($button['title'] ?? '') : '';
$buttonUrl = is_array($button) ? ($button['url'] ?? '') : '';

if (!$title) {
    return;
}

if (!$buttonTitle) {
    $buttonTitle = 'Demander ma maquette gratuite';
}

$contactUrl = crescendo_resolve_link_url($buttonUrl ?: '/contact/');
?>
<section class="service-final-cta">
    <div class="container service-final-cta__inner">
        <h2 class="service-final-cta__title"><?php echo esc_html($title); ?></h2>

        <?php if (!empty($reassurance)) : ?>
            <ul class="service-final-cta__reassurance">
                <?php foreach ($reassurance as $item) : ?>
                    <?php $text = is_array($item) ? ($item['text'] ?? '') : $item; ?>
                    <?php if ($text) : ?><li><?php echo esc_html($text); ?></li><?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="service-final-cta__actions">
            <a class="btn btn--dark" href="<?php echo esc_url($contactUrl); ?>"><?php echo esc_html($buttonTitle); ?></a>
        </div>
    </div>
</section>
