# Rapport audit SEO — Crescendo Studio (préproduction)

**URL analysée :** https://preprod.2026.crescendo-studio.io/  
**Date :** 24 juillet 2026  
**Périmètre :** thème `crescendo-2026`, JSON `content-import/`, code PHP SEO custom  
**Hors périmètre modifié :** réglage `noindex` préproduction (déjà géré dans WordPress)

---

## Synthèse exécutive

Le site repose sur un **SEO 100 % custom** dans le thème (aucun Yoast / Rank Math actif). L’architecture est saine : canonical unique, schema JSON-LD par type de page, sitemap WordPress natif filtré (`inc/sitemap-noise.php`).

État global après corrections précédentes : **~48/54 pages sans issue**. Il reste surtout des sujets **stratégiques** (cannibalisation home / agence, similarité pages locales) et des **contenus éditoriaux** à valider avant modification.

---

## 1. URL de préproduction codées en dur

### Recherche `preprod.2026.crescendo-studio.io`

| Zone | Résultat |
|------|----------|
| PHP thème | **0 occurrence** |
| JS / CSS | **0 occurrence** |
| JSON content-import | **0 occurrence** |
| Base WordPress | Non accessible depuis le repo — **à vérifier en BDD** (options, menus WP, contenus éditoriaux) |

### Occurrences `crescendo-studio.io` (domaine production)

Présentes dans les champs **`seo.canonical`** des JSON d’import (~50 fichiers) et dans `inc/seo-helpers.php` (migration one-shot).

**Impact runtime : faible.** Au rendu, la canonical effective est **`get_permalink()`**, pas le champ ACF importé. Sur la préprod, la canonical affichée doit donc pointer vers `preprod.2026.crescendo-studio.io`.

**Recommandation (validation requise) :** remplacer les canonical JSON par des placeholders ou supprimer le champ ; s’appuyer uniquement sur `home_url()` / `get_permalink()` à l’import.

### Fonctions dynamiques déjà utilisées

- `home_url()` — nav, schema, canonical fallback
- `get_permalink()` — canonical runtime toutes pages
- `crescendo_nav_url()` — wrappe `home_url()`

---

## 2. Erreurs de villes — incohérences détectées

### Critique — corrigée

| Fichier | Problème | Correction |
|---------|----------|------------|
| `template-parts/local/block-toc.php` | Sommaire hardcodé « Enjeux digitaux à **Saint-Nazaire** » sur **toutes** les pages locales | Label dynamique via `local-city-name` → « Enjeux digitaux à {ville} » |

**Effet :** Saint-Herblain (et les 6 autres communes) affichaient « Saint-Nazaire » dans le sommaire alors que le H2 JSON était correct.

### Légitime (non corrigé)

| Contexte | Exemple | Verdict |
|----------|---------|---------|
| Zone d’intervention | Liste Rezé, Orvault, Carquefou dans une page Saint-Herblain | OK — maillage géo |
| Base agence | « Basés à Nantes » sur pages locales | OK — ancrage agence |
| Saint-Nazaire | 14 mentions de « Nantes » (distance 60 km, intervention depuis Nantes) | OK — contenu éditorial riche |

### Pages locales — similarité de contenu

| Paire | Similarité (hors nom de ville) |
|-------|-------------------------------|
| Bouguenais ↔ Rezé | **86 %** |
| Bouguenais ↔ Orvault | **85 %** |
| Carquefou ↔ Orvault | **85 %** |
| Saint-Herblain ↔ Saint-Sébastien | **82 %** |
| Saint-Nazaire | Contenu unique (référence qualité) | — |

**Recommandation :** différencier progressivement les 6 pages « template » (contexte local réel, typologies d’entreprises, quartiers/zones d’activité) — sans inventer de faits.

---

## 3. Cannibalisation `/` vs `/services/agence-web-nantes/`

### Comparaison actuelle

| Élément | `/` (accueil) | `/services/agence-web-nantes/` |
|---------|---------------|--------------------------------|
| **Title** | Agence web Nantes — WordPress & CRM \| Crescendo | Agence web Nantes — WordPress dès 350€/mois \| Crescendo |
| **H1** | Votre agence web WordPress & CRM à Nantes | Agence web WordPress à Nantes |
| **Intention** | Marque + agence globale | Choisir une agence locale |
| **Schema** | Organization + LocalBusiness + WebSite | Service |
| **Liens menu header** | Logo → `/` ; section « Nantes & région » → page service | Présente dans dropdown locales **et** services |
| **Backlinks internes** | Logo, footer | Menu (2×), footer, locales, JSON |

### Scénario A — Fusion (recommandé)

Aligné avec l’objectif : **`/` = agence web Nantes**.

1. Conserver `/` comme URL principale.
2. Enrichir l’accueil avec les blocs utiles de la page service (méthode, preuves, FAQ agence).
3. Mettre à jour les liens internes « Agence web Nantes » → `/` (menu, JSON, cartes).
4. **301** `/services/agence-web-nantes/` → `/` (après validation).
5. Canonical auto-référente sur `/`.

**Risque :** perte d’URL profonde `/services/` dans le silo — compensable par breadcrumb et maillage.

### Scénario B — Repositionnement (alternatif)

Conserver `/services/agence-web-nantes/` avec intention **« choisir son agence web à Nantes »** (comparatif, méthode, équipe) ; l’accueil cible **« Crescendo Studio — agence web Nantes »** (marque + offre globale).

Déjà partiellement en place (H1 différenciés). Renforcer :
- Accueil → promesse marque, fourchette services, CTA maquette
- Page service → parcours client, méthode, tarifs agence, FAQ choix prestataire

**Recommandation : Scénario A** si la page service n’apporte pas de contenu unique suffisant vs l’accueil (similarité élevée des promesses).

> ⛔ Redirection / fusion **non appliées** — en attente validation.

---

## 4. Cannibalisation pages métiers (artisan vs plombier / électricien / paysagiste)

### Page artisan — passages à généraliser (proposition)

| Emplacement | Texte actuel | Proposition |
|-----------|--------------|-------------|
| `meta_description` | « plombier, électricien, menuisier » | « artisans du bâtiment et du service » |
| `secteur-hero-intro` | « plombier, électricien, menuisier » | « artisan du bâtiment ou du service » |
| Bénéfice SEO | « plombier Nantes », « électricien Nantes » | « vos services et zones d’intervention sur les recherches locales » |
| FAQ Google | « plombier Nantes », « électricien Saint-Herblain » | Formulation générique + liens vers pages métier |

### Maillage à renforcer (proposition)

Ajouter dans `secteur-related-sectors` ou contenu éditorial :

- « création de site internet pour plombier » → `/secteurs/creation-site-plombier-nantes/`
- « site web professionnel pour électricien » → `/secteurs/creation-site-electricien-nantes/`
- « création de site pour paysagiste » → `/secteurs/creation-site-paysagiste-nantes/`

### Similarité inter-pages métiers

| Paire | Similarité |
|-------|------------|
| plombier ↔ électricien | 31 % |
| plombier ↔ paysagiste | 36 % |
| paysagiste ↔ BTP | 42 % |

Pas de duplication massive — les pages métier sont suffisamment distinctes structurellement ; vigilance sur les FAQ générées par script.

> ⛔ Modifications contenu artisan **non appliées** — en attente validation.

---

## 5. H1, titles, meta descriptions

### Correction appliquée

| Page | Avant | Après |
|------|-------|-------|
| `/services/agence-seo-nantes/` H1 | Développez votre visibilité grâce au référencement naturel | **Agence SEO à Nantes : développez durablement votre visibilité** |

Fichier : `content-import/services/SEO.json`

### Tableau pages à surveiller

| Page | Problème | Action |
|------|----------|--------|
| `/` vs `/services/agence-web-nantes/` | Titles proches (même requête) | Fusion ou repositionnement |
| Locales Bouguenais–Rezé–Orvault | Meta descriptions quasi identiques (template) | Réécriture locale |
| `/services/agence-web-nantes/` | Présente 2× dans menu (services + locales) | Simplifier menu (cf. §11) |

### Mécanisme technique

- **1 seul `<title>`** : `pre_get_document_title` par type de page
- **1 seule meta description** : `crescendo_print_seo_head_meta()` priority 1
- **1 seul H1** : vérifié par template (hero block)
- **WP canonical core** : désactivé

---

## 6. Canonical

| Source | État |
|--------|------|
| WordPress core | Désactivé (`crescendo_disable_wp_canonical`) |
| Plugin SEO | Absent |
| Thème | **1 canonical** via `crescendo_print_seo_head_meta()` |
| Runtime | `crescendo_normalize_canonical(get_permalink())` |
| JSON import | Champ `*-seo-canonical` stocké en ACF mais **non lu au rendu** |

### Points d’attention

- Canonical JSON en dur `https://crescendo-studio.io/...` — **non bloquant** en préprod (runtime = permalink)
- Risque post-migration prod : si slug WP ≠ URL attendue, le runtime reste cohérent
- Archives / blog : canonical via fallback + noindex

---

## 7. Sitemap XML

| Élément | Détail |
|---------|--------|
| Générateur | **WordPress natif** (`wp-sitemaps.xml`) |
| Plugin SEO | Aucun |
| Filtres thème | Posts, catégories, tags exclus ; provider **users** désactivé (`wp_sitemaps_add_provider`) |
| Hello World | Mis en corbeille au init |
| Archives auteur | noindex + exclus du sitemap (après fix provider users) |

### À contrôler en préprod

- [ ] `/wp-sitemap-users-1.xml` absent ou vide
- [ ] Pas de `/author/admin/`
- [ ] ~54 URLs pages publiées

---

## 8. Maillage interne

### Pages prioritaires — liens entrants

| Page | Sources actuelles | Manques |
|------|-------------------|---------|
| `/` | Logo, schema | Renforcer ancres « agence web Nantes » depuis locales |
| `/services/location-site-internet/` | Cartes services, JSON | OK |
| `/services/crm-sur-mesure-nantes/` | Nav, footer | OK |
| `/services/agence-seo-nantes/` | Locales (Saint-Nazaire) | Renforcer depuis accueil |

### Liens cassés corrigés (session précédente)

- `/services/maintenance/` → `/services/maintenance-wordpress/`

### Audit JSON

`python3 content-import/audit-sitemap.py` → **OK**

---

## 9. Mega-menu — proposition (sans modification design)

### État actuel (fallback PHP)

| Zone | Liens |
|------|-------|
| Dropdown Services | **10** |
| Dropdown Secteurs | **17** |
| Dropdown Nantes & région | **8** |
| Dropdown Réalisations | **11** |
| Liens top-level | À propos, Contact |
| **Total enfants** | **46** |

Note : si menu WP `menu-header` assigné en admin, les chiffres peuvent différer.

### Structure proposée

**Services (6)** : création · location · WordPress · SEO · maintenance · CRM  
**Secteurs (5 + hub)** : artisans · professions libérales · PME/B2B · immobilier · e-commerce · *Tous les secteurs*  
**Villes (4 + hub)** : Nantes · Saint-Herblain · Rezé · Saint-Nazaire · *Toutes les zones*  
**Réalisations** : hub + 3–4 projets phares  

Footer conserve la liste complète.

> ⛔ Restructuration menu **non appliée**.

---

## 10. Données structurées

| Type page | Schema présent | Doublon plugin |
|-----------|---------------|----------------|
| Home | Organization, LocalBusiness, WebSite | Non |
| Service | Service, FAQPage | Non |
| Secteur | Service, FAQPage | Non |
| Local | Organization, LocalBusiness, Service, BreadcrumbList, FAQPage | Non |
| Projet | Article, BreadcrumbList | Non |

Pas d’AggregateRating, pas de faux avis. Syntaxe JSON-LD via `crescendo_print_json_ld()`.

---

## 11. Images & OG

| Élément | État |
|---------|------|
| OG default | `assets/images/og-default.jpg` (1200×630) présent dans le thème |
| Meta OG dimensions | Ajoutées si fallback |
| Si favicon encore servi en préprod | Vérifier déploiement du fichier `og-default.jpg` sur le serveur |

---

## 12. Performances (observations code)

- Scripts modulaires par page (`data-module`) — à auditer chargement conditionnel
- CSS compilé unique `assets/css/app.css`
- Polices : à vérifier dans SCSS
- Images hero : dimensions partiellement définies (logo header OK)

Propositions ciblées sans implémentation : `defer` JS non critique, lazy-load below fold, audit poids `og-default.jpg` (~1,7 Mo — **à compresser**).

---

## Modifications automatiques sûres — appliquées

| Fichier | Modification |
|---------|--------------|
| `template-parts/local/block-toc.php` | Sommaire « Enjeux digitaux » dynamique par ville |
| `content-import/services/SEO.json` | H1 SEO corrigé |
| `web/.../content-import/services/SEO.json` | Miroir synchronisé |

## Modifications nécessitant validation

| Sujet | Type |
|-------|------|
| 301 `/services/agence-web-nantes/` → `/` | Redirection |
| Fusion contenu home + page agence | Contenu |
| Généralisation page artisan | Contenu |
| Différenciation 6 pages locales | Contenu |
| Restructuration mega-menu | Navigation |
| Compression OG image | Asset |
| Canonical JSON → dynamique à l’import | Code import |
| Réimport JSON modifiés | WP-CLI |

---

## Fichiers de référence créés

- `docs/seo-map.md` — cartographie intentions par URL
- `docs/seo-audit-report.md` — ce rapport

---

## Tests à effectuer

### WordPress (préprod)

```bash
cd /Users/b.vidal/var/www/crescendo-2026/web
wp crescendo import-service wp-content/themes/crescendo-2026/content-import/services/SEO.json
```

- [ ] Sommaire Saint-Herblain → « Enjeux digitaux à Saint-Herblain »
- [ ] H1 page SEO → « Agence SEO à Nantes : développez durablement votre visibilité »
- [ ] View-source : 1 canonical, 1 title, 1 meta description
- [ ] `/wp-sitemap.xml` sans users
- [ ] OG image = `.../assets/images/og-default.jpg`

### Post-production

- [ ] Canonicals en `https://crescendo-studio.io/...`
- [ ] Re-crawl sitemap
- [ ] Search Console : pages indexées vs sitemap

---

## Commande WP-CLI réimport SEO (local)

```bash
cd /Users/b.vidal/var/www/crescendo-2026/web
wp crescendo import-service wp-content/themes/crescendo-2026/content-import/services/SEO.json
```
