#!/usr/bin/env python3
"""Génère les fiches projet JSON dans content-import/projets/."""

import json
from pathlib import Path

OUT = Path(__file__).parent
BASE = "https://crescendo-studio.io/realisations"
GALLERY_SLOTS = 4

PROJECTS = [
    {
        "slug": "atelier-gambetta",
        "title": "Atelier Gambetta",
        "client_name": "Atelier Gambetta",
        "client_url": "https://www.ateliergambetta.com/",
        "sector": "Branding & design",
        "year": "2024",
        "tags": "Refonte · WordPress · Portfolio · CRM",
        "tech": "WordPress · ACF · Pipedrive",
        "has_crm": True,
        "focus": "refonte site atelier gambetta",
        "intro": "Refonte du site portfolio de l'Atelier Gambetta : mise en valeur des réalisations branding, parcours devis simplifié et connexion CRM pour qualifier les demandes entrantes.",
        "challenge": "<p>L'Atelier Gambetta avait besoin d'un site à la hauteur de ses créations : portfolio visuel impactant, navigation fluide entre les projets et un système de capture de leads plus fiable que les échanges email dispersés.</p><p>Le site existant ne reflétait plus le positionnement premium du studio et ne permettait pas de suivre efficacement les prospects.</p>",
        "solution": "<p>Nous avons conçu une refonte WordPress sur mesure avec une grille portfolio optimisée, des pages projet structurées et un formulaire de devis connecté à Pipedrive.</p><p>Performance, SEO et expérience mobile ont été priorisés pour soutenir la notoriété de l'agence auprès de ses clients B2B.</p>",
        "results": [
            {"value": "+40%", "label": "Demandes de devis qualifiées"},
            {"value": "< 2s", "label": "Temps de chargement"},
            {"value": "100%", "label": "Sur mobile"},
            {"value": "CRM", "label": "Leads synchronisés"},
        ],
        "listing_text": "Site portfolio connecté à un CRM pour suivre les demandes de devis et qualifier les prospects entrants depuis le site.",
        "listing_tags": "WordPress · CRM · Portfolio",
    },
    {
        "slug": "be-focus",
        "title": "Be Focus",
        "client_name": "Be Focus",
        "client_url": "https://www.befocus.fr/",
        "sector": "Formation professionnelle",
        "year": "2024",
        "tags": "Refonte · WordPress · Réservation · Paiement",
        "tech": "WordPress · WooCommerce · Calendly",
        "has_crm": True,
        "focus": "refonte site be focus formation",
        "intro": "Refonte du site Be Focus : catalogue de formations, parcours d'inscription simplifié et prise de rendez-vous intégrée pour convertir les visiteurs en participants.",
        "challenge": "<p>Be Focus proposait des formations professionnelles via un site vieillissant, peu lisible sur mobile et sans tunnel d'inscription optimisé. Les prospects abandonnaient avant de s'inscrire.</p>",
        "solution": "<p>Refonte complète avec architecture de contenu repensée, fiches formation SEO, système de réservation et paiement en ligne. Design épuré orienté conversion.</p>",
        "results": [
            {"value": "+55%", "label": "Inscriptions en ligne"},
            {"value": "Top 3", "label": "Google sur requêtes clés"},
            {"value": "48h", "label": "Mise en ligne sessions"},
            {"value": "CRM", "label": "Suivi automatisé"},
        ],
        "listing_text": "Plateforme de formation avec prise de rendez-vous, catalogue de sessions et parcours d'inscription simplifié.",
        "listing_tags": "WordPress · Réservation · Paiement",
    },
    {
        "slug": "bag-x-pro",
        "title": "Bag X Pro",
        "client_name": "Bag X Pro",
        "client_url": "https://bag-x-pro.com/",
        "sector": "Industrie B2B",
        "year": "2023",
        "tags": "Refonte · Catalogue · Devis en ligne · SEO",
        "tech": "WordPress · ACF · Formulaires avancés",
        "has_crm": False,
        "focus": "refonte site bag x pro",
        "intro": "Refonte du site Bag X Pro : catalogue produits technique, demandes de devis qualifiées et structure SEO pour capter les requêtes métier B2B en Loire-Atlantique.",
        "challenge": "<p>Bag X Pro, acteur industriel B2B, avait un site peu adapté à son catalogue technique. Les visiteurs ne trouvaient pas les références produits et les demandes de devis restaient non qualifiées.</p>",
        "solution": "<p>Nous avons structuré un catalogue filtrable, des fiches produit optimisées SEO et un formulaire de devis intelligent qui oriente le prospect vers le bon interlocuteur.</p>",
        "results": [
            {"value": "+30%", "label": "Devis qualifiés / mois"},
            {"value": "x2", "label": "Trafic organique"},
            {"value": "B2B", "label": "Parcours adapté"},
            {"value": "SEO", "label": "Requêtes métier"},
        ],
        "listing_text": "Site B2B avec catalogue technique, demandes de devis qualifiées et structure SEO pensée pour capter des requêtes métier.",
        "listing_tags": "Catalogue produits · Devis · SEO",
    },
    {
        "slug": "maison-jaden",
        "title": "Maison Jaden",
        "client_name": "Maison Jaden",
        "client_url": "https://maison-jaden.com/",
        "sector": "Construction de maisons",
        "year": "2024",
        "tags": "Refonte · WordPress · CRM · SEO local",
        "tech": "WordPress · CRM sur mesure · SEO local",
        "has_crm": True,
        "focus": "refonte site maison jaden",
        "intro": "Refonte du site Maison Jaden : génération de leads pour un constructeur de maisons individuelles, avec tunnel de devis et CRM connecté pour le suivi commercial.",
        "challenge": "<p>Maison Jaden voulait un site capable de générer des demandes de devis qualifiées sur la métropole nantaise, tout en centralisant le suivi des prospects dans un CRM dédié.</p>",
        "solution": "<p>Site vitrine orienté conversion avec pages géolocalisées, simulateur de demande de devis, intégration CRM native et contenu SEO local (Nantes, Saint-Herblain, Rezé…).</p>",
        "results": [
            {"value": "+60%", "label": "Leads mensuels"},
            {"value": "CRM", "label": "Suivi automatisé"},
            {"value": "Top 5", "label": "SEO local Nantes"},
            {"value": "4 sem.", "label": "Délai de livraison"},
        ],
        "listing_text": "Site vitrine orienté génération de leads avec formulaires CRM, pages secteur géolocalisées et tunnel de devis optimisé.",
        "listing_tags": "WordPress · CRM · SEO local · Devis en ligne",
    },
    {
        "slug": "ludovic-geheniaux",
        "title": "Ludovic Géhéniaux",
        "client_name": "Ludovic Géhéniaux",
        "client_url": "https://ludovicgeheniaux.com/",
        "sector": "Artisan coloriste",
        "year": "2023",
        "tags": "Refonte · Vitrine · Réservation · SEO local",
        "tech": "WordPress · Booking · Galerie",
        "has_crm": False,
        "focus": "refonte site ludovic geheniaux",
        "intro": "Refonte du site de Ludovic Géhéniaux, coloriste à Nantes : vitrine premium, galerie de réalisations et prise de rendez-vous en ligne pour développer la clientèle locale.",
        "challenge": "<p>Artisan coloriste reconnu, Ludovic Géhéniaux avait besoin d'un site vitrine élégant reflétant son savoir-faire, avec une galerie de colorations et un système de réservation simple.</p>",
        "solution": "<p>Design sur mesure mettant en avant les réalisations, pages services structurées, formulaire de rendez-vous et référencement local sur Nantes et sa métropole.</p>",
        "results": [
            {"value": "+45%", "label": "Prises de RDV en ligne"},
            {"value": "Top 3", "label": "Coloriste Nantes"},
            {"value": "Mobile", "label": "First design"},
            {"value": "Galerie", "label": "Portfolio intégré"},
        ],
        "listing_text": "Site vitrine pour un artisan coloriste avec prise de rendez-vous, galerie de réalisations et référencement local.",
        "listing_tags": "Vitrine · Réservation · SEO local",
    },
    {
        "slug": "vanetty-music",
        "title": "Vanetty Music",
        "client_name": "Vanetty Music",
        "client_url": "https://vanettymusic.com/",
        "sector": "Musique & événementiel",
        "year": "2024",
        "tags": "Refonte · WordPress · Vitrine · Booking",
        "tech": "WordPress · Audio · Formulaires",
        "has_crm": False,
        "focus": "refonte site vanetty music",
        "intro": "Refonte du site Vanetty Music : vitrine artistique, mise en avant des prestations DJ/musique et parcours de contact optimisé pour les demandes d'événements.",
        "challenge": "<p>Vanetty Music avait besoin d'un site immersif capable de présenter son univers musical, ses prestations événementielles et de faciliter les demandes de booking.</p>",
        "solution": "<p>Refonte WordPress avec identité visuelle forte, intégration média, pages prestations claires et formulaire de demande d'événement structuré pour qualifier les leads.</p>",
        "results": [
            {"value": "+35%", "label": "Demandes booking"},
            {"value": "Immersif", "label": "Expérience media"},
            {"value": "Mobile", "label": "Optimisé"},
            {"value": "SEO", "label": "Visibilité locale"},
        ],
        "listing_text": "Site vitrine artistique avec présentation des prestations musicales et parcours de demande d'événement optimisé.",
        "listing_tags": "WordPress · Vitrine · Booking",
    },
    {
        "slug": "cma-associes",
        "title": "CM&A Associés",
        "client_name": "CM&A Associés",
        "client_url": "https://www.cm-associes.com/",
        "sector": "Cabinet d'avocats",
        "year": "2023",
        "tags": "Refonte · WordPress · Vitrine institutionnelle",
        "tech": "WordPress · ACF · SEO",
        "has_crm": False,
        "focus": "refonte site cm&a avocats",
        "intro": "Refonte du site CM&A Associés : site institutionnel pour un cabinet d'avocats avec pages d'expertise, présentation des associés et formulaire de contact qualifiant.",
        "challenge": "<p>Le cabinet CM&A Associés souhaitait moderniser son site pour renforcer sa crédibilité, clarifier ses domaines d'expertise et améliorer la qualification des demandes entrantes.</p>",
        "solution": "<p>Architecture de contenu repensée, design sobre et professionnel, pages expertise SEO et formulaire de contact avec champs qualifiants (domaine, urgence, description).</p>",
        "results": [
            {"value": "+25%", "label": "Contacts qualifiés"},
            {"value": "E-E-A-T", "label": "Crédibilité renforcée"},
            {"value": "Expertise", "label": "Pages structurées"},
            {"value": "RGPD", "label": "Conformité intégrée"},
        ],
        "listing_text": "Site institutionnel pour un cabinet d'avocats avec pages d'expertise, présentation des associés et formulaire qualifiant.",
        "listing_tags": "WordPress · Vitrine · Expertise",
    },
    {
        "slug": "car-design",
        "title": "Car Design France",
        "client_name": "Car Design France",
        "client_url": "http://cardesignfrance.com/",
        "sector": "Automobile & design",
        "year": "2023",
        "tags": "Refonte · WordPress · Portfolio · Vitrine",
        "tech": "WordPress · Galerie · SEO",
        "has_crm": False,
        "focus": "refonte site car design france",
        "intro": "Refonte du site Car Design France : vitrine premium pour un acteur du design automobile, avec portfolio visuel et pages services orientées conversion.",
        "challenge": "<p>Car Design France avait besoin d'un site capable de valoriser ses réalisations dans l'univers automobile, avec une navigation visuelle forte et une présentation claire des services.</p>",
        "solution": "<p>Refonte WordPress sur mesure avec galerie haute qualité, pages services dédiées, design premium sombre et SEO ciblant les requêtes design automobile en France.</p>",
        "results": [
            {"value": "Premium", "label": "Identité visuelle"},
            {"value": "Portfolio", "label": "Galerie optimisée"},
            {"value": "SEO", "label": "Visibilité métier"},
            {"value": "Mobile", "label": "Responsive"},
        ],
        "listing_text": "Site vitrine premium pour le design automobile avec portfolio visuel et pages services structurées.",
        "listing_tags": "WordPress · Portfolio · Vitrine",
    },
    {
        "slug": "padam-immo",
        "title": "Padam Immo",
        "client_name": "Padam Immo",
        "client_url": "https://www.padamimmo.fr/",
        "sector": "Immobilier",
        "year": "2024",
        "tags": "Refonte · WordPress · SEO local · Vitrine premium",
        "tech": "WordPress · SEO local · Cartes",
        "has_crm": False,
        "focus": "refonte site padam immo",
        "intro": "Refonte du site Padam Immo : vitrine immobilière premium avec mise en avant des biens, pages quartier SEO et design renforçant la crédibilité de l'agence.",
        "challenge": "<p>Padam Immo voulait un site à l'image de son positionnement haut de gamme, capable de mettre en valeur les biens, de ranker sur les requêtes locales et de générer des contacts qualifiés.</p>",
        "solution": "<p>Refonte WordPress avec fiches biens optimisées, pages quartier géolocalisées, design premium et parcours de contact simplifié pour les acquéreurs et vendeurs.</p>",
        "results": [
            {"value": "+50%", "label": "Contacts vendeurs"},
            {"value": "Top 5", "label": "SEO local agence"},
            {"value": "Premium", "label": "Design haut de gamme"},
            {"value": "Quartiers", "label": "Pages geo SEO"},
        ],
        "listing_text": "Site vitrine immobilier avec mise en avant des biens, pages quartier optimisées SEO et design premium.",
        "listing_tags": "WordPress · SEO local · Vitrine premium",
    },
    {
        "slug": "ta-kife",
        "title": "Ta Kifé",
        "client_name": "Ta Kifé (Takifé)",
        "client_url": "https://takife.com/",
        "sector": "Événementiel & marketing",
        "year": "2024",
        "tags": "Refonte · WordPress · Vitrine · Conversion",
        "tech": "WordPress · ACF · SEO · Formulaires",
        "has_crm": False,
        "focus": "refonte site ta kifé takifé",
        "intro": "Refonte du site Ta Kifé (Takifé), l'agence du kiff : vitrine immersive pour présenter l'offre événementielle B2B et B2C, renforcer l'identité de marque et fluidifier les demandes de contact.",
        "challenge": "<p>Takifé avait besoin d'un site à la hauteur de son positionnement : une agence qui crée des expériences mémorables. L'ancien site ne mettait pas assez en valeur les réalisations, l'approche 360° (stratégie, création, production) et les formats d'événements proposés.</p><p>Les prospects peinaient à comprendre rapidement l'offre et à initier un échange qualifié.</p>",
        "solution": "<p>Nous avons conçu une refonte WordPress sur mesure avec une direction visuelle énergique, des pages offre structurées (B2B, collaborateurs, B2C), une mise en avant des cas clients et un parcours de contact optimisé pour les demandes de devis événementiel.</p><p>Performance, SEO et expérience mobile ont été priorisés pour soutenir la notoriété de l'agence auprès des marques en quête d'activation terrain.</p>",
        "results": [
            {"value": "+40%", "label": "Demandes de contact"},
            {"value": "360°", "label": "Offre mise en avant"},
            {"value": "Mobile", "label": "Expérience optimisée"},
            {"value": "SEO", "label": "Visibilité renforcée"},
        ],
        "listing_text": "Refonte vitrine pour une agence événementielle : identité forte, offres B2B/B2C structurées et parcours de contact optimisé.",
        "listing_tags": "WordPress · Vitrine · Événementiel",
    },
]


def build_project(p, order):
    return {
        "version": "1.0",
        "page": {
            "title": p["title"],
            "slug": p["slug"],
            "parent": "realisations",
            "status": "publish",
            "menu_order": order,
            "content": "",
        },
        "seo": {
            "meta_title": f"Refonte {p['title']} · Étude de cas | Crescendo Studio",
            "meta_description": (lambda s: (s if len(s)<=155 else s[:155].rsplit(" ",1)[0].rstrip(" ,;:") + "."))(p["intro"]),
            "focus_keyword": p["focus"],
            "canonical": f"{BASE}/{p['slug']}/",
            "noindex": False,
        },
        "fields": {
            "project-hero-eyebrow": "Étude de cas · Refonte",
            "project-hero-title": f"Refonte du site {p['title']}",
            "project-hero-intro": p["intro"],
            "project-client-name": p["client_name"],
            "project-client-url": p["client_url"],
            "project-sector": p["sector"],
            "project-year": p["year"],
            "project-tags": p["tags"],
            "project-tech-tags": p["tech"],
            "project-has-crm": p["has_crm"],
            "project-gallery-title": "Aperçu du site refondu",
            "project-gallery-intro": "Ajoutez vos captures d'écran au format 16:9 (1920×1080 recommandé). Chaque image remplace automatiquement un emplacement vide.",
            "project-gallery-slots": GALLERY_SLOTS,
            "project-gallery": [],
            "project-challenge-title": "Le contexte",
            "project-challenge-text": p["challenge"],
            "project-solution-title": "Notre approche",
            "project-solution-text": p["solution"],
            "project-results-title": "Résultats",
            "project-results": p["results"],
            "project-cta-title": "Un projet de refonte similaire ?",
            "project-cta-text": "Parlons de votre site. Nous vous proposons une maquette gratuite en 48h pour valider la direction avant de démarrer.",
            "project-cta-button": {
                "title": "Demander ma maquette gratuite",
                "url": "/contact/",
                "target": "",
            },
        },
    }


def build_listing():
    projects = []
    for p in PROJECTS:
        projects.append({
            "title": p["title"],
            "category": p["sector"],
            "tags": p["listing_tags"],
            "text": p["listing_text"],
            "url": f"/realisations/{p['slug']}/",
            "has_crm": p["has_crm"],
        })
    return projects


def main():
    listing_path = OUT.parent / "realisations" / "realisations.json"
    theme_projets = Path(__file__).resolve().parents[2] / "web/wp-content/themes/crescendo-2026/content-import/projets"
    theme_projets.mkdir(parents=True, exist_ok=True)

    for i, p in enumerate(PROJECTS, 1):
        data = build_project(p, i * 10)
        json_str = json.dumps(data, ensure_ascii=False, indent=2) + "\n"
        path = OUT / f"{p['slug']}.json"
        path.write_text(json_str, encoding="utf-8")
        (theme_projets / f"{p['slug']}.json").write_text(json_str, encoding="utf-8")
        print(f"Wrote {path.name}")

    listing_path = OUT.parent / "realisations" / "realisations.json"
    if listing_path.exists():
        data = json.loads(listing_path.read_text(encoding="utf-8"))
        data["fields"]["realisations-projects"] = build_listing()
        listing_path.write_text(
            json.dumps(data, ensure_ascii=False, indent=2) + "\n",
            encoding="utf-8",
        )
        print(f"Updated {listing_path}")


if __name__ == "__main__":
    main()
