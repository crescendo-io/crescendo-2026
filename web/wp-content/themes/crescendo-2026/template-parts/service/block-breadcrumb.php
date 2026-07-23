<?php
$items = crescendo_service_breadcrumb();
if (empty($items)) {
    return;
}
?>
<nav class="service-breadcrumb" aria-label="Fil d'Ariane">
    <div class="container">
        <ol class="service-breadcrumb__list">
            <?php foreach ($items as $index => $item) : ?>
                <li class="service-breadcrumb__item">
                    <?php if ($index < count($items) - 1) : ?>
                        <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                    <?php else : ?>
                        <span aria-current="page"><?php echo esc_html($item['label']); ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</nav>
