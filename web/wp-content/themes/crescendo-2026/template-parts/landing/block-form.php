<?php
$title = crescendo_landing('landing-form-title') ?: 'Parlons de votre projet';
$intro = crescendo_landing('landing-form-intro') ?: 'Décrivez votre projet en quelques lignes : nous vous recontactons sous 24 h ouvrées avec une première estimation et des recommandations adaptées à votre activité.';
$reassurance = crescendo_landing('landing-form-reassurance');

if (empty($reassurance)) {
    $reassurance = array(
        array('text' => 'Premier échange gratuit et sans engagement'),
        array('text' => 'Réponse personnalisée sous 24 h ouvrées'),
        array('text' => 'Devis clair : achat ou formule tout compris'),
        array('text' => 'Interlocuteur unique du cadrage à la mise en ligne'),
        array('text' => 'Agence basée à Nantes — projets partout en France'),
    );
}

$steps = array(
    array(
        'title' => 'Vous décrivez votre besoin',
        'text' => 'Quelques informations sur votre activité, vos objectifs et votre calendrier.',
    ),
    array(
        'title' => 'Nous analysons votre projet',
        'text' => 'Un échange pour cadrer le périmètre et vous orienter vers la bonne formule.',
    ),
    array(
        'title' => 'Vous recevez une estimation',
        'text' => 'Budget indicatif, délais et prochaines étapes — sans pression commerciale.',
    ),
);
?>
<section class="landing-form" id="contact-bas">
    <div class="container landing-form__inner">
        <div class="landing-form__content">
            <p class="landing-form__eyebrow">Estimation gratuite</p>
            <h2 class="landing-form__title"><?php echo esc_html($title); ?></h2>
            <?php if ($intro) : ?>
                <p class="landing-form__text"><?php echo esc_html($intro); ?></p>
            <?php endif; ?>

            <?php if (!empty($reassurance)) : ?>
                <ul class="landing-form__points">
                    <?php foreach ($reassurance as $point) : ?>
                        <?php $line = is_array($point) ? ($point['text'] ?? '') : $point; ?>
                        <?php if ($line) : ?><li><?php echo esc_html($line); ?></li><?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="landing-form__steps">
                <h3 class="landing-form__steps-title">Comment ça se passe ?</h3>
                <ol class="landing-form__steps-list">
                    <?php foreach ($steps as $index => $step) : ?>
                        <li class="landing-form__step">
                            <span class="landing-form__step-index" aria-hidden="true"><?php echo esc_html(sprintf('%02d', $index + 1)); ?></span>
                            <span class="landing-form__step-body">
                                <strong><?php echo esc_html($step['title']); ?></strong>
                                <?php echo esc_html($step['text']); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>

        <div class="landing-form__form-wrap">
            <?php
            crescendo_render_contact_form(array_merge(
                crescendo_get_landing_contact_form_args(array(
                    'variant' => 'compact',
                    'show_besoin' => true,
                )),
                array(
                    'wrapper_class' => 'landing-form__form',
                )
            ));
            ?>
        </div>
    </div>
</section>
