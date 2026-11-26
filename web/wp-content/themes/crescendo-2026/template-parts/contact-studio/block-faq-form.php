<?php
$faqItems = crescendo_contact('contact-faq-items');

if (empty($faqItems)) {
    return;
}

$half = (int) ceil(count($faqItems) / 2);
$columns = array(
    array_slice($faqItems, 0, $half),
    array_slice($faqItems, $half),
);
?>
<section class="studio-service-faq studio-contact-page-faq" aria-labelledby="studio-contact-page-faq-title">
    <div class="shell">
        <div class="studio-service-faq__layout">
            <div class="studio-service-faq__intro">
                <p class="studio-eyebrow" data-studio-text-reveal><?php esc_html_e('FAQ', 'crescendo-2026'); ?></p>
                <h2 id="studio-contact-page-faq-title" data-studio-text-reveal>
                    <?php esc_html_e('Questions fréquentes', 'crescendo-2026'); ?><span class="studio-red">.</span>
                </h2>
            </div>

            <div class="studio-service-faq__grid" data-studio-text-reveal>
                <?php foreach ($columns as $column) : ?>
                    <?php if (empty($column)) {
                        continue;
                    } ?>
                    <div class="studio-service-faq__col">
                        <?php foreach ($column as $item) : ?>
                            <details class="studio-service-faq__item" name="studio-contact-faq">
                                <summary>
                                    <span class="studio-service-faq__question"><?php echo esc_html($item['question'] ?? ''); ?></span>
                                    <i aria-hidden="true"></i>
                                </summary>
                                <div class="studio-service-faq__answer">
                                    <p><?php echo esc_html($item['answer'] ?? ''); ?></p>
                                </div>
                            </details>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>