<?php
$siteEtatOptions = crescendo_get_contact_site_etat_options();
$charteOptions = crescendo_get_contact_charte_options();
$contenuOptions = crescendo_get_contact_contenu_options();
$budgetOptions = crescendo_get_contact_budget_options();
$delaiOptions = crescendo_get_contact_delai_options();
?>
<div id="crescendo-contact-modal" class="crescendo-contact-modal" aria-hidden="true">
    <div class="crescendo-contact-modal__overlay" data-contact-modal-close></div>
    <div
        class="crescendo-contact-modal__dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="crescendo-contact-modal-title"
    >
        <button type="button" class="crescendo-contact-modal__close" data-contact-modal-close aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
        </button>

        <div class="crescendo-contact-modal__header">
            <p class="crescendo-contact-modal__eyebrow">Étape 2 · Votre projet</p>
            <h2 id="crescendo-contact-modal-title" class="crescendo-contact-modal__title">Précisez votre projet</h2>
            <p class="crescendo-contact-modal__intro">
                Ces informations nous permettent de préparer un échange pertinent et une maquette adaptée à votre activité.
            </p>
        </div>

        <div class="crescendo-contact-modal__body">
            <form class="crescendo-contact-modal__form home-form__fields" novalidate enctype="multipart/form-data">
                <input type="hidden" name="action" value="crescendo_contact_step2">
                <input type="hidden" name="lead_id" value="">
                <input type="hidden" name="lead_key" value="">
                <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="crescendo-contact-form__honeypot" aria-hidden="true">

                <div class="home-form__full crescendo-contact-modal__section">
                    <h3 class="crescendo-contact-modal__section-title">Prestations souhaitées</h3>
                </div>

                <?php crescendo_render_prestation_tags(array(
                    'legend' => '',
                    'hint' => '',
                    'required' => false,
                )); ?>

                <div class="home-form__full crescendo-contact-modal__section">
                    <h3 class="crescendo-contact-modal__section-title">Entreprise & site actuel</h3>
                </div>

                <label>
                    <span>Secteur d'activité</span>
                    <input type="text" name="secteur_activite" placeholder="Ex. : BTP, immobilier, coaching…">
                </label>

                <label>
                    <span>Site web actuel (URL)</span>
                    <input type="url" name="site_existant" placeholder="https://">
                </label>

                <label class="home-form__full">
                    <span>Situation du site existant</span>
                    <select name="site_etat">
                        <?php foreach ($siteEtatOptions as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <div class="home-form__full crescendo-contact-modal__section">
                    <h3 class="crescendo-contact-modal__section-title">Identité visuelle & fichiers</h3>
                </div>

                <label class="home-form__full">
                    <span>Charte graphique / identité visuelle</span>
                    <select name="charte">
                        <?php foreach ($charteOptions as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="home-form__full">
                    <span>Logo, couleurs, typos existants</span>
                    <textarea name="charte_details" rows="3" placeholder="Décrivez ou listez les éléments de votre identité visuelle…"></textarea>
                </label>

                <label class="home-form__full crescendo-contact-form__file">
                    <span>Logo (PNG, JPG, SVG, PDF — max 5 Mo)</span>
                    <input type="file" name="logo" accept=".png,.jpg,.jpeg,.webp,.svg,.pdf,image/*,application/pdf">
                </label>

                <label class="home-form__full crescendo-contact-form__file">
                    <span>Autres fichiers (charte, brochure, visuels… — max 5 Mo chacun, 5 fichiers)</span>
                    <input type="file" name="attachments[]" multiple accept=".png,.jpg,.jpeg,.webp,.svg,.pdf,.doc,.docx,image/*,application/pdf">
                </label>

                <div class="home-form__full crescendo-contact-modal__section">
                    <h3 class="crescendo-contact-modal__section-title">Contenu & objectifs</h3>
                </div>

                <label class="home-form__full">
                    <span>Objectifs principaux du site</span>
                    <textarea name="objectifs" rows="3" placeholder="Visibilité locale, génération de leads, prise de RDV, vente en ligne…"></textarea>
                </label>

                <label>
                    <span>Pages ou sections prévues</span>
                    <input type="text" name="pages" placeholder="Ex. : Accueil, Services, À propos, Contact…">
                </label>

                <label>
                    <span>Contenu rédactionnel</span>
                    <select name="contenu_pret">
                        <?php foreach ($contenuOptions as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="home-form__full">
                    <span>Fonctionnalités souhaitées</span>
                    <textarea name="fonctionnalites" rows="3" placeholder="Formulaire, CRM, réservation, espace client, multilingue, paiement en ligne…"></textarea>
                </label>

                <div class="home-form__full crescendo-contact-modal__section">
                    <h3 class="crescendo-contact-modal__section-title">Budget & planning</h3>
                </div>

                <label>
                    <span>Budget envisagé</span>
                    <select name="budget">
                        <?php foreach ($budgetOptions as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    <span>Délai souhaité</span>
                    <select name="delai">
                        <?php foreach ($delaiOptions as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="home-form__full">
                    <span>Sites de référence / inspiration</span>
                    <textarea name="references" rows="2" placeholder="URLs ou noms de sites que vous appréciez…"></textarea>
                </label>

                <label class="home-form__full">
                    <span>Autres précisions</span>
                    <textarea name="commentaires" rows="3" placeholder="Contraintes, outils déjà utilisés, interlocuteurs…"></textarea>
                </label>

                <div class="home-form__full crescendo-contact-form__feedback" role="status" aria-live="polite" hidden></div>

                <div class="home-form__full crescendo-contact-modal__actions">
                    <button type="button" class="btn btn--outline" data-contact-modal-close>Plus tard</button>
                    <button type="submit" class="btn btn--primary crescendo-contact-form__submit">Envoyer les précisions</button>
                </div>
            </form>
        </div>
    </div>
</div>
