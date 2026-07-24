<?php
$faqItems = crescendo_contact('contact-faq-items');

if (empty($faqItems)) {
    return;
}
?>
<section class="contact-form-section">
    <div class="container contact-form-section__inner">
        <div class="contact-faq">
            <h2 class="contact-faq__title">Questions fréquentes</h2>
            <div class="home-faq__list">
                <?php foreach ($faqItems as $index => $item) : ?>
                    <details class="home-faq__item"<?php echo $index === 0 ? ' open' : ''; ?>>
                        <summary class="home-faq__question">
                            <?php echo esc_html($item['question'] ?? ''); ?>
                            <span class="home-faq__toggle" aria-hidden="true"></span>
                        </summary>
                        <div class="home-faq__answer">
                            <p><?php echo esc_html($item['answer'] ?? ''); ?></p>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
