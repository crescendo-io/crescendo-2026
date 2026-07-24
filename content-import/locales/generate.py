#!/usr/bin/env python3
"""Generate local page JSON imports for Crescendo Studio."""
from __future__ import annotations

import json
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent.parent
OUT = Path(__file__).resolve().parent
BASE = "https://crescendo-studio.io"

CITIES = {
    "saint-herblain": {
        "slug": "agence-web-saint-herblain",
        "city_name": "Saint-Herblain",
        "title": "Agence web à Saint-Herblain",
        "h1": "Agence web à Saint-Herblain",
        "keyword": "agence web saint-herblain",
        "menu_order": 30,
        "nearby": [
            ("Nantes", "/"),
            ("Orvault", "/agence-web-orvault/"),
            ("Rezé", "/agence-web-reze/"),
            ("Carquefou", "/agence-web-carquefou/"),
            ("Bouguenais", "/agence-web-bouguenais/"),
            ("Saint-Sébastien-sur-Loire", "/agence-web-saint-sebastien-sur-loire/"),
        ],
        "sections": [
            ("Une agence web au cœur de la 2e ville de Loire-Atlantique", "<p>Saint-Herblain, avec plus de 47 000 habitants, est la deuxième commune de Loire-Atlantique. Entre Atlantis, Exponantes et les zones tertiaires de la route de Vannes, le tissu économique herblinois mêle grandes enseignes, PME et commerces de proximité.</p><p>Crescendo Studio accompagne ces acteurs avec des sites WordPress sur mesure, optimisés pour « agence web Saint-Herblain » et les requêtes associées.</p>"),
            ("Sites web pour les entreprises du nord-ouest nantais", "<p>Commerces d'Atlantis, PME industrielles, professions libérales, artisans : chaque profil exige une approche différente. Notre location à <strong>350€/mois</strong> sans frais de création convient aux TPE herblinoises.</p>"),
            ("SEO local Saint-Herblain : être visible dans la métropole", "<p>Nous structurons votre site avec des pages géolocalisées, schema.org LocalBusiness et une fiche Google Business Profile optimisée pour capter la demande locale.</p>"),
        ],
        "facts": [
            "2e ville de Loire-Atlantique avec plus de 47 000 habitants",
            "Centre commercial Atlantis, l'un des plus grands de l'Ouest",
            "Tramway ligne 3 reliant Nantes en 15 minutes",
            "Zones tertiaires le long de la route de Vannes",
        ],
        "faqs": [
            ("Intervenez-vous en présentiel à Saint-Herblain ?", "Oui. Rendez-vous à Atlantis ou en centre-ville herblinois, visio pour le suivi courant."),
            ("Mon commerce est à Atlantis : le SEO peut-il cibler cette zone ?", "Absolument. Pages optimisées pour « commerce Atlantis » et requêtes de proximité."),
            ("Quel budget pour un site web à Saint-Herblain ?", "350€/mois tout inclus, sans frais de création. Maquette gratuite en 48h."),
        ],
    },
    "reze": {
        "slug": "agence-web-reze",
        "city_name": "Rezé",
        "title": "Agence web à Rezé",
        "h1": "Agence web à Rezé",
        "keyword": "agence web rezé",
        "menu_order": 31,
        "nearby": [
            ("Nantes", "/"),
            ("Bouguenais", "/agence-web-bouguenais/"),
            ("Saint-Sébastien-sur-Loire", "/agence-web-saint-sebastien-sur-loire/"),
            ("Saint-Herblain", "/agence-web-saint-herblain/"),
            ("Orvault", "/agence-web-orvault/"),
            ("Carquefou", "/agence-web-carquefou/"),
        ],
        "sections": [
            ("Accompagner les entreprises de Rezé", "<p>Rezé compte près de 43 000 habitants, de Pont-Rousseau à Trentemoult. Crescendo Studio crée des sites WordPress optimisés pour « agence web Rezé » et les variantes géolocalisées.</p>"),
            ("Un tissu PME et artisanal qui a besoin de visibilité", "<p>Artisans, restaurants de Trentemoult, cabinets médicaux, PME industrielles : notre location à <strong>350€/mois</strong> est adaptée aux TPE réziennes.</p>"),
            ("SEO local Rezé : capter la clientèle de la rive sud", "<p>Nous construisons des pages dédiées pour « plombier Rezé », « restaurant Trentemoult » et les requêtes sud Loire.</p>"),
        ],
        "facts": [
            "Près de 43 000 habitants, 3e commune de la métropole",
            "Quartier de Trentemoult face à l'Île de Nantes",
            "Tramway ligne 3 et accès rapide au centre nantais",
            "Zones d'activité Blordière et périphérique sud",
        ],
        "faqs": [
            ("Ciblez-vous aussi les recherches liées à Trentemoult ?", "Oui. Pages spécifiques pour Trentemoult en plus de Rezé si votre activité y est implantée."),
            ("Puis-je toucher des clients à Nantes depuis Rezé ?", "Oui. Un site bien référencé vous positionne sur Rezé ET sur Nantes sud."),
            ("Combien coûte un site internet pour une TPE à Rezé ?", "350€/mois en location tout inclus, sans frais de création."),
        ],
    },
    "orvault": {
        "slug": "agence-web-orvault",
        "city_name": "Orvault",
        "title": "Agence web à Orvault",
        "h1": "Agence web à Orvault",
        "keyword": "agence web orvault",
        "menu_order": 32,
        "nearby": [
            ("Nantes", "/"),
            ("Saint-Herblain", "/agence-web-saint-herblain/"),
            ("Carquefou", "/agence-web-carquefou/"),
            ("Rezé", "/agence-web-reze/"),
            ("Bouguenais", "/agence-web-bouguenais/"),
            ("Saint-Sébastien-sur-Loire", "/agence-web-saint-sebastien-sur-loire/"),
        ],
        "sections": [
            ("Agence web pour les entreprises d'Orvault", "<p>Orvault, 27 000 habitants au nord de Nantes, combine centre-bourg animé et zones commerciales de la route de Rennes.</p>"),
            ("Commerces, professions libérales et PME", "<p>Médecins, commerces, artisans, services aux particuliers : le site web est souvent le premier contact avant le bouche-à-oreille.</p>"),
            ("Visibilité locale et connexion avec la métropole", "<p>Busway ligne 4, route de Rennes : nous optimisons Orvault et les quartiers nord de Nantes.</p>"),
        ],
        "facts": [
            "Environ 27 000 habitants au nord de la métropole",
            "Zones commerciales le long de la route de Rennes",
            "Busway ligne 4 vers Nantes centre",
            "Ville résidentielle avec nombreuses maisons individuelles",
        ],
        "faqs": [
            ("Mon activité cible les familles d'Orvault : le site peut-il refléter cela ?", "Oui. Ton, visuels et contenus adaptés à votre cible locale."),
            ("Intervenez-vous pour les entreprises de la route de Rennes ?", "Absolument. SEO pour « route de Rennes Orvault » et requêtes de proximité."),
            ("Quel délai pour un site web à Orvault ?", "Maquette gratuite en 48h, mise en ligne en 4 à 6 semaines."),
        ],
    },
    "carquefou": {
        "slug": "agence-web-carquefou",
        "city_name": "Carquefou",
        "title": "Agence web à Carquefou",
        "h1": "Agence web à Carquefou",
        "keyword": "agence web carquefou",
        "menu_order": 33,
        "nearby": [
            ("Nantes", "/"),
            ("Saint-Herblain", "/agence-web-saint-herblain/"),
            ("Orvault", "/agence-web-orvault/"),
            ("Rezé", "/agence-web-reze/"),
            ("Bouguenais", "/agence-web-bouguenais/"),
            ("Saint-Sébastien-sur-Loire", "/agence-web-saint-sebastien-sur-loire/"),
        ],
        "sections": [
            ("Sites web pour l'écosystème économique de Carquefou", "<p>Carquefou est un pôle économique majeur à l'est de Nantes : Atlanpole, zones industrielles, PME et startups.</p>"),
            ("Industrie, tech et services : des besoins web variés", "<p>Catalogues B2B, landing pages startup, galeries artisans : nous adaptons chaque projet.</p>"),
            ("SEO est nantais : dominer les recherches de votre secteur", "<p>Requêtes locales et métier combinées pour toucher Carquefou et toute la métropole.</p>"),
        ],
        "facts": [
            "Technopole Atlanpole et pôle d'innovation",
            "Zones industrielles Géraudière et Landreau",
            "Environ 20 000 habitants et milliers d'emplois locaux",
            "Accès A11 et N844",
        ],
        "faqs": [
            ("Accompagnez-vous les startups d'Atlanpole ?", "Oui. Site MVP rapide, location 350€/mois pour préserver la trésorerie."),
            ("Notre PME exporte : le site peut-il être multilingue ?", "Absolument. Versions anglais ou multilingues selon vos marchés."),
            ("Connaissez-vous le tissu économique carquefoulais ?", "Oui. Industrie, tech et services B2B de l'est nantais."),
        ],
    },
    "bouguenais": {
        "slug": "agence-web-bouguenais",
        "city_name": "Bouguenais",
        "title": "Agence web à Bouguenais",
        "h1": "Agence web à Bouguenais",
        "keyword": "agence web bouguenais",
        "menu_order": 34,
        "nearby": [
            ("Rezé", "/agence-web-reze/"),
            ("Saint-Sébastien-sur-Loire", "/agence-web-saint-sebastien-sur-loire/"),
            ("Nantes", "/"),
            ("Saint-Herblain", "/agence-web-saint-herblain/"),
            ("Orvault", "/agence-web-orvault/"),
            ("Carquefou", "/agence-web-carquefou/"),
        ],
        "sections": [
            ("Agence web pour les entreprises de Bouguenais", "<p>Bouguenais, 20 000 habitants au sud-est de Nantes, doit sa visibilité à l'aéroport Nantes Atlantique.</p>"),
            ("Logistique, services aéroportuaires et commerces", "<p>Transport, hôtellerie, restauration, artisans : des profils distincts liés à la zone aéroportuaire.</p>"),
            ("SEO local Bouguenais : l'aéroport comme repère", "<p>Requêtes « près aéroport Nantes », « 44340 » et visibilité métropolitaine élargie.</p>"),
        ],
        "facts": [
            "Proximité de l'aéroport Nantes Atlantique",
            "Environ 20 000 habitants au sud-est",
            "Tissu logistique, transport et services aéroportuaires",
            "Accès rapide périphérique sud",
        ],
        "faqs": [
            ("Mon activité est liée à l'aéroport : pouvez-vous cibler ces recherches ?", "Oui. Contenus optimisés pour la zone aéroportuaire Bouguenais."),
            ("Intervenez-vous sur place à Bouguenais ?", "Oui, à 15 minutes de Nantes via le périphérique sud."),
            ("Quel type d'entreprise accompagnez-vous ?", "TPE et PME : logistique, artisanat, commerce, restauration, services B2B."),
        ],
    },
    "saint-sebastien-sur-loire": {
        "slug": "agence-web-saint-sebastien-sur-loire",
        "city_name": "Saint-Sébastien-sur-Loire",
        "title": "Agence web à Saint-Sébastien-sur-Loire",
        "h1": "Agence web à Saint-Sébastien-sur-Loire",
        "keyword": "agence web saint-sébastien",
        "menu_order": 35,
        "nearby": [
            ("Nantes", "/"),
            ("Rezé", "/agence-web-reze/"),
            ("Bouguenais", "/agence-web-bouguenais/"),
            ("Saint-Herblain", "/agence-web-saint-herblain/"),
            ("Orvault", "/agence-web-orvault/"),
            ("Carquefou", "/agence-web-carquefou/"),
        ],
        "sections": [
            ("Création de sites web à Saint-Sébastien-sur-Loire", "<p>26 000 habitants en rive sud, centre commercial Beaulieu et accès direct au centre nantais via tramway.</p>"),
            ("Commerces, professions libérales et services", "<p>Enseignes de Beaulieu, restaurants, cabinets, artisans : une diversité d'activités en rive sud.</p>"),
            ("SEO rive sud : être trouvé par les habitants et les Nantais", "<p>Double audience Sébastiennolais et Nantais : pack local Google optimisé.</p>"),
        ],
        "facts": [
            "26 000 habitants en rive sud de la Loire",
            "Centre commercial Beaulieu, pôle majeur de l'agglomération",
            "Tramway ligne 3 et ponts vers Nantes",
            "Quartiers Chézine, Monière et centre-ville",
        ],
        "faqs": [
            ("Mon commerce est à Beaulieu : le SEO peut-il cibler cette zone ?", "Oui. Optimisation pour Beaulieu et Saint-Sébastien simultanément."),
            ("Puis-je attirer des clients depuis Nantes centre ?", "Oui. SEO métropolitain sud Loire pour toucher les Nantais."),
            ("Quel budget pour un site à Saint-Sébastien-sur-Loire ?", "350€/mois en location tout inclus, maquette gratuite en 48h."),
        ],
    },
}

SHARED_SECTORS = [
    ("Artisan", "/secteurs/creation-site-artisan-nantes/"),
    ("Avocat", "/secteurs/creation-site-avocat-nantes/"),
    ("Restaurant", "/secteurs/creation-site-restaurant-nantes/"),
    ("Immobilier", "/secteurs/creation-site-immobilier-nantes/"),
    ("Startup", "/secteurs/creation-site-startup-nantes/"),
    ("PME", "/services/creation-site-web-nantes/"),
]

PRICING_TABLE = [
    {"label": "Investissement initial", "col1": "0€", "col2": "3 000 – 8 000€"},
    {"label": "Mensualité", "col1": "350€", "col2": "150–250€"},
    {"label": "Création incluse", "col1": "✓", "col2": "✓"},
    {"label": "Maintenance & sécurité", "col1": "Incluse", "col2": "Sur devis"},
    {"label": "Évolutions", "col1": "Incluses", "col2": "Sur devis"},
    {"label": "Total sur 5 ans", "col1": "~21 000€", "col2": "~25 000€+"},
]


def build_city(city_key: str, cfg: dict) -> dict:
    city = cfg["city_name"]
    slug = cfg["slug"]
    return {
        "version": "1.0",
        "page": {
            "title": cfg["title"],
            "slug": slug,
            "status": "publish",
            "menu_order": cfg["menu_order"],
        },
        "seo": {
            "meta_title": f"Agence web {city} — Site sur mesure dès 350€/mois | Crescendo",
            "meta_description": f"Agence web à {city} : création de site WordPress sur mesure, SEO local, maintenance incluse. Maquette gratuite en 48h. Location dès 350€/mois.",
            "focus_keyword": cfg["keyword"],
            "canonical": f"{BASE}/{slug}/",
            "noindex": False,
        },
        "fields": {
            "local-city-name": city,
            "local-hero-eyebrow": f"Agence web · {city}",
            "local-hero-title": cfg["h1"],
            "local-hero-intro": f"Vous cherchez une agence web à {city} ? Crescendo Studio crée des sites WordPress sur mesure pour les TPE, PME et indépendants de la métropole nantaise — location dès 350€/mois sans frais de création.",
            "local-hero-cta-primary": {"title": "Demander ma maquette gratuite", "url": "#contact", "target": ""},
            "local-hero-cta-secondary": {"title": "Voir nos réalisations", "url": "/realisations/", "target": ""},
            "local-hero-note": "Maquette gratuite en 48h",
            "local-benefits": [
                {"title": "Agence nantaise", "text": f"Basés à Nantes, nous intervenons régulièrement à {city}."},
                {"title": "SEO local", "text": f"Visible sur « agence web {city} » et requêtes associées."},
                {"title": "Site dès 350€/mois", "text": "Location tout inclus, zéro frais de création."},
                {"title": "WordPress sur mesure", "text": "Design premium, rapide et évolutif."},
            ],
            "local-sections": [{"title": t, "text": html} for t, html in cfg["sections"]],
            "local-facts-title": f"{city} en bref",
            "local-facts": [{"text": f} for f in cfg["facts"]],
            "local-pain-title": f"Pourquoi les entreprises de {city} perdent des clients en ligne",
            "local-pain-items": [
                {"title": "Invisible sur Google", "text": f"Vos concurrents nantais apparaissent avant vous sur « agence web {city} » et les requêtes locales."},
                {"title": "Site obsolète ou absent", "text": "Une fiche Facebook ou un site daté ne convertit pas les prospects qui comparent en ligne."},
                {"title": "Pas de SEO local", "text": f"Sans pages géolocalisées et fiche Google optimisée, vous n'existez pas pour les habitants de {city}."},
                {"title": "Budget bloqué", "text": "3 000 à 8 000€ d'investissement initial : difficile à justifier pour une TPE locale."},
            ],
            "local-solution-title": f"Un site web professionnel pour votre entreprise à {city}",
            "local-solution-text": f"Crescendo Studio conçoit des sites WordPress sur mesure pour les entreprises de {city} et de la métropole nantaise. Design premium, SEO local intégré, maintenance incluse en location.",
            "local-solution-price": "350€/mois",
            "local-solution-price-label": "Location tout inclus · zéro frais de création",
            "local-solution-usps": [
                {"title": "Maquette 48h", "text": "Direction créative gratuite avant engagement."},
                {"title": "SEO local", "text": f"Pages et balisage optimisés pour {city} et environs."},
                {"title": "Accompagnement de proximité", "text": "Agence nantaise réactive, rendez-vous sur place ou visio."},
            ],
            "local-features-title": "Ce que votre site professionnel doit inclure",
            "local-features-items": [
                {"title": "Design sur mesure", "text": "Image premium adaptée à votre secteur et votre clientèle locale."},
                {"title": "SEO local intégré", "text": f"Structure, contenu et schema.org pour {city}."},
                {"title": "Formulaire de contact", "text": "Capture des demandes avec notification email."},
                {"title": "Mobile first", "text": "80 % des recherches locales se font sur smartphone."},
                {"title": "Performance & sécurité", "text": "Site rapide, HTTPS, sauvegardes incluses en location."},
                {"title": "Évolutions incluses", "text": "Maintenance et mises à jour dans l'abonnement mensuel."},
            ],
            "local-case-title": "Exemple de réalisation en Loire-Atlantique",
            "local-case-project-title": "Maison Jaden",
            "local-case-project-tags": "WordPress · Devis · SEO local",
            "local-case-project-points": [
                {"text": "Site vitrine pour constructeur de maisons à Nantes"},
                {"text": "Formulaire de devis connecté au CRM"},
                {"text": "Référencement local sur 12 communes"},
            ],
            "local-case-project-url": "/realisations/maison-jaden/",
            "local-pricing-title": f"Combien coûte un site web à {city} ?",
            "local-pricing-price": "350€",
            "local-pricing-price-suffix": "/mois",
            "local-pricing-cta": {"title": "Demander ma maquette gratuite", "url": "#contact", "target": ""},
            "local-pricing-col1-label": "Location 350€/mois",
            "local-pricing-col2-label": "Achat classique",
            "local-pricing-features": [
                {"text": "Création sur mesure incluse"},
                {"text": "Hébergement premium"},
                {"text": "Maintenance & mises à jour"},
                {"text": "SEO local de base"},
                {"text": "Support réactif"},
            ],
            "local-pricing-table": PRICING_TABLE,
            "local-area-title": f"Agence web {city} et communes voisines",
            "local-area-text": f"Nous accompagnons les entreprises de {city} et des communes limitrophes de la métropole nantaise.",
            "local-area-cities": [{"name": name, "url": url} for name, url in cfg["nearby"] if name != city],
            "local-area-see-all": {"title": "Voir toutes nos zones", "url": "/services/creation-site-web-nantes/", "target": ""},
            "local-faq-eyebrow": "Questions fréquentes",
            "local-faq-title": f"Tout savoir sur la création de site à {city}",
            "local-faq-items": [{"question": q, "answer": a} for q, a in cfg["faqs"]],
            "local-related-title": "Nos solutions par secteur d'activité",
            "local-related-sectors": [{"title": t, "url": u} for t, u in SHARED_SECTORS],
            "local-final-cta-title": f"Prêt à lancer votre projet web à {city} ?",
            "local-final-cta-text": "Recevez une maquette gratuite sous 48h. Sans engagement.",
            "local-final-cta-points": [
                {"text": "Maquette personnalisée sous 48h"},
                {"text": "Formule location sans investissement initial"},
                {"text": f"Accompagnement local à {city}"},
            ],
            "local-final-form-job-label": "Votre activité",
            "local-final-reassurance": [
                {"text": "Sans engagement"},
                {"text": "Réponse sous 24h"},
                {"text": "Agence nantaise"},
            ],
        },
    }


def main() -> None:
    OUT.mkdir(parents=True, exist_ok=True)
    for key, cfg in CITIES.items():
        path = OUT / f"{cfg['slug']}.json"
        path.write_text(json.dumps(build_city(key, cfg), ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
        print(f"Wrote {path.name}")


if __name__ == "__main__":
    main()
