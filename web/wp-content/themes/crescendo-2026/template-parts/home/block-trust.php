<?php
$label = crescendo_home('home-trust-label');
$logos = crescendo_home('home-trust-logos');
?>
<section class="home-trust">
    <div class="container home-trust__inner">
        <?php if ($label) : ?>
            <p class="home-trust__label"><?php echo esc_html($label); ?></p>
        <?php endif; ?>

        <div class="home-trust__logos">
            <?php if (!empty($logos)) : ?>
                <?php foreach ($logos as $item) : ?>
                    <?php if (empty($item['logo']['url']) && empty($item['logo']['ID']) && empty($item['logo']['id'])) {
                        continue;
                    } ?>
                    <?php
                    $logoHtml = crescendo_image($item['logo'], 'crescendo-logo', array(
                        'alt' => $item['logo']['alt'] ?? '',
                        'sizes' => '120px',
                        'loading' => 'lazy',
                    ));
                    ?>
                    <?php if (!empty($item['link'])) : ?>
                        <a href="<?php echo esc_url($item['link']); ?>" class="home-trust__logo">
                            <?php echo $logoHtml; ?>
                        </a>
                    <?php else : ?>
                        <div class="home-trust__logo">
                            <?php echo $logoHtml; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else : ?>
                <?php
                $fallbackLogos = array(
                    'Ludovic Géhéniaux', 'Maison Jaden', 'Be Focus', 'Atelier Gambetta',
                    'Ta Kifé', 'CM&A', 'Padam Immo', 'Frénésie', 'Car Design',
                );
                foreach ($fallbackLogos as $logoName) :
                ?>
                    <span class="home-trust__name"><?php echo esc_html($logoName); ?></span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
