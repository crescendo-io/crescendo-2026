<?php
/**
 * Cookie consent banner — RGAA / CNIL oriented.
 * GA4 loads only after analytics consent.
 */
$privacyUrl = function_exists('crescendo_nav_url')
    ? crescendo_nav_url('politique-de-confidentialite')
    : home_url('/politique-de-confidentialite/');
?>
<div
    id="cookie-consent"
    class="cookie-consent"
    hidden
    data-cookie-consent
>
    <div class="cookie-consent__backdrop" data-cookie-backdrop aria-hidden="true"></div>

    <div
        class="cookie-consent__dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cookie-consent-title"
        aria-describedby="cookie-consent-desc"
        tabindex="-1"
        data-cookie-dialog
    >
        <div class="cookie-consent__panel" data-cookie-panel="banner">
            <h2 id="cookie-consent-title" class="cookie-consent__title">Gestion des cookies</h2>
            <p id="cookie-consent-desc" class="cookie-consent__text">
                Nous utilisons des cookies nécessaires au fonctionnement du site et, avec votre accord,
                des cookies de mesure d’audience (Google Analytics) pour améliorer nos services.
                Vous pouvez accepter, refuser ou personnaliser votre choix.
                Plus d’informations dans notre
                <a href="<?php echo esc_url($privacyUrl); ?>">politique de confidentialité</a>.
            </p>

            <div class="cookie-consent__actions">
                <button type="button" class="btn btn--outline cookie-consent__btn" data-cookie-action="refuse">
                    Tout refuser
                </button>
                <button type="button" class="btn btn--outline cookie-consent__btn" data-cookie-action="customize">
                    Personnaliser
                </button>
                <button type="button" class="btn cookie-consent__btn cookie-consent__btn--accept" data-cookie-action="accept">
                    Tout accepter
                </button>
            </div>
        </div>

        <div class="cookie-consent__panel" data-cookie-panel="prefs" hidden>
            <div class="cookie-consent__prefs-head">
                <h2 id="cookie-prefs-title" class="cookie-consent__title">Personnaliser les cookies</h2>
                <button
                    type="button"
                    class="cookie-consent__close"
                    data-cookie-action="back"
                    aria-label="Retour à la bannière cookies"
                >
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <p class="cookie-consent__text">
                Activez uniquement les catégories souhaitées. Les cookies nécessaires ne peuvent pas être désactivés.
            </p>

            <ul class="cookie-consent__categories">
                <li class="cookie-consent__category">
                    <div class="cookie-consent__category-main">
                        <div>
                            <h3 class="cookie-consent__category-title">Cookies nécessaires</h3>
                            <p class="cookie-consent__category-text">
                                Indispensables au fonctionnement du site (sécurité, préférences de consentement).
                            </p>
                        </div>
                        <span class="cookie-consent__status" aria-hidden="true">Toujours actif</span>
                        <input
                            type="checkbox"
                            id="cookie-cat-necessary"
                            checked
                            disabled
                            aria-label="Cookies nécessaires, toujours activés"
                        >
                    </div>
                </li>
                <li class="cookie-consent__category">
                    <div class="cookie-consent__category-main">
                        <div>
                            <label class="cookie-consent__category-title" for="cookie-cat-analytics">
                                Mesure d’audience
                            </label>
                            <p class="cookie-consent__category-text" id="cookie-cat-analytics-desc">
                                Google Analytics (GA4) pour comprendre l’usage du site. Déposé uniquement si vous acceptez.
                            </p>
                        </div>
                        <input
                            type="checkbox"
                            id="cookie-cat-analytics"
                            class="cookie-consent__switch"
                            data-cookie-category="analytics"
                            aria-describedby="cookie-cat-analytics-desc"
                        >
                    </div>
                </li>
            </ul>

            <div class="cookie-consent__actions">
                <button type="button" class="btn btn--outline cookie-consent__btn" data-cookie-action="refuse">
                    Tout refuser
                </button>
                <button type="button" class="btn cookie-consent__btn cookie-consent__btn--accept" data-cookie-action="save">
                    Enregistrer mes choix
                </button>
            </div>
        </div>
    </div>
</div>
