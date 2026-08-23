<?php
$title = crescendo_landing('landing-faq-title') ?: 'Questions fréquentes';
$items = crescendo_landing('landing-faq-items');
$count = count($items);

if (empty($items)) {
    return;
}
?>
<section class="landing-faq" id="faq">
    <div class="container">
        <div class="landing-faq__shell">
            <header class="landing-faq__head">
                <p class="landing-faq__eyebrow">Réponses rapides</p>
                <h2 class="landing-faq__title"><?php echo esc_html($title); ?></h2>
                <p class="landing-faq__text">Tout ce qu'il faut savoir avant de demander votre estimation — tarifs, délais, autonomie et formules.</p>
                <?php if ($count > 0) : ?>
                    <p class="landing-faq__count"><?php echo esc_html($count); ?> questions</p>
                <?php endif; ?>
            </header>

            <div class="landing-faq__list">
                <?php foreach ($items as $index => $item) : ?>
                    <details class="landing-faq__item"<?php echo $index === 0 ? ' open' : ''; ?>>
                        <summary class="landing-faq__question">
                            <span class="landing-faq__question-text"><?php echo esc_html($item['question'] ?? ''); ?></span>
                            <span class="landing-faq__toggle" aria-hidden="true"></span>
                        </summary>
                        <div class="landing-faq__answer">
                            <p><?php echo esc_html($item['answer'] ?? ''); ?></p>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
