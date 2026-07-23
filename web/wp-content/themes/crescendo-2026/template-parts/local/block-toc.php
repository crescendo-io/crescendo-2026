<?php
$showToc = crescendo_local('local-show-toc');
$tocTitle = crescendo_local('local-toc-title') ?: 'Sommaire';
$sections = crescendo_local('local-sections') ?: array();
$anchors = array();

if ($showToc === false || $showToc === '0' || $showToc === 0) {
    return;
}

$blocks = array(
    array('id' => 'enjeux-digitaux', 'label' => 'Enjeux digitaux à Saint-Nazaire'),
    array('id' => 'nos-services', 'label' => 'Nos services web'),
    array('id' => 'notre-methode', 'label' => 'Notre méthode'),
    array('id' => 'tarifs', 'label' => 'Tarifs et formules'),
    array('id' => 'realisations', 'label' => 'Réalisations'),
    array('id' => 'faq', 'label' => 'Questions fréquentes'),
    array('id' => 'zone-intervention', 'label' => 'Zone d\'intervention'),
    array('id' => 'contact', 'label' => 'Prendre rendez-vous'),
);

foreach ($sections as $index => $section) {
    if (empty($section['title'])) {
        continue;
    }
    $id = !empty($section['anchor']) ? sanitize_title($section['anchor']) : sanitize_title($section['title']);
    $anchors[] = array('id' => $id, 'label' => $section['title']);
}

$anchors = array_merge($anchors, $blocks);
if (count($anchors) < 4) {
    return;
}
?>
<nav class="local-toc service-section--alt" aria-label="Sommaire de la page">
    <div class="container">
        <?php if ($tocTitle) : ?><p class="local-toc__label"><?php echo esc_html($tocTitle); ?></p><?php endif; ?>
        <ol class="local-toc__list">
            <?php foreach ($anchors as $item) : ?>
                <li><a href="#<?php echo esc_attr($item['id']); ?>"><?php echo esc_html($item['label']); ?></a></li>
            <?php endforeach; ?>
        </ol>
    </div>
</nav>
