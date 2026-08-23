<?php
$mockups = crescendo_get_landing_mockups();

if (count($mockups) < 2) {
    return;
}

$placement = get_query_var('landing_mockups_placement', 'standalone');
$inHero = $placement === 'hero-top';
$count = count($mockups);
$duration = max(20, $count * 5);
$wrapperTag = $inHero ? 'div' : 'section';
$wrapperClass = 'landing-mockups' . ($inHero ? ' landing-mockups--hero-top' : '');
?>
<<?php echo $wrapperTag; ?> class="<?php echo esc_attr($wrapperClass); ?>" id="maquettes" aria-label="Maquettes de sites internet">
    <div class="landing-mockups__viewport">
        <div
            class="landing-mockups__track"
            style="--mockup-count: <?php echo (int) $count; ?>; --mockup-duration: <?php echo (int) $duration; ?>s;"
        >
            <?php for ($loop = 0; $loop < 2; $loop++) : ?>
                <?php foreach ($mockups as $index => $item) : ?>
                    <?php
                    $isDuplicate = $loop === 1;
                    $alt = $item['alt'] ?? '';
                    ?>
                    <figure class="landing-mockups__item"<?php echo $isDuplicate ? ' aria-hidden="true"' : ''; ?>>
                        <?php
                        echo crescendo_image($item['image'], 'crescendo-card', array(
                            'alt' => $alt,
                            'class' => 'landing-mockups__image',
                            'sizes' => '(min-width: 1100px) 25vw, (min-width: 768px) 33vw, 75vw',
                            'loading' => $loop === 0 && $index < 4 ? 'eager' : 'lazy',
                        ));
                        ?>
                    </figure>
                <?php endforeach; ?>
            <?php endfor; ?>
        </div>
    </div>
</<?php echo $wrapperTag; ?>>
