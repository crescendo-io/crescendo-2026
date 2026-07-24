#!/usr/bin/env python3
"""Audit internal links vs expected site structure."""
from __future__ import annotations

import re
import sys
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
BASE = "https://crescendo-studio.io"

SERVICES = {
    "creation-site-web-nantes","creation-site-vitrine-nantes",
    "creation-site-ecommerce-nantes","creation-site-wordpress","refonte-site-wordpress",
    "location-site-internet","crm-sur-mesure-nantes","agence-seo-nantes","maintenance-wordpress",
}
SECTEURS = {
    "creation-site-artisan-nantes","creation-site-coiffeur-nantes","creation-site-avocat-nantes",
    "creation-site-immobilier-nantes","creation-site-restaurant-nantes","creation-site-startup-nantes",
    "creation-site-b2b-nantes","creation-site-coach-nantes","creation-site-architecte-nantes",
    "creation-site-therapeute-nantes","creation-site-association-nantes","creation-site-btp-nantes",
    "creation-site-paysagiste-nantes","creation-site-electricien-nantes","creation-site-plombier-nantes",
    "creation-site-industrie-nantes","creation-site-cabinet-rh-nantes",
}
LOCALES = {
    "agence-web-bouguenais","agence-web-carquefou","agence-web-orvault","agence-web-saint-nazaire",
    "agence-web-saint-herblain","agence-web-reze","agence-web-saint-sebastien-sur-loire",
}
PROJETS = {
    "atelier-gambetta","bag-x-pro","be-focus","car-design","cma-associes","ludovic-geheniaux",
    "maison-jaden","padam-immo","vanetty-music","ta-kife",
}
SOCLE = {"", "services", "secteurs", "contact", "realisations", "a-propos", "mentions-legales", "politique-de-confidentialite", "plan-du-site"}


def is_valid(rel: str) -> bool:
    if rel in SOCLE or rel in LOCALES:
        return True
    if rel.startswith("services/") and rel.split("/", 1)[1] in SERVICES:
        return True
    if rel.startswith("secteurs/") and rel.split("/", 1)[1] in SECTEURS:
        return True
    if rel.startswith("realisations/") and rel.split("/", 1)[1] in PROJETS:
        return True
    if rel.startswith("#") or rel.startswith("mailto:"):
        return True
    return False


def main() -> int:
    errors = []
    for path in (ROOT / "content-import").rglob("*.json"):
        if "_schema" in path.name or "node_modules" in str(path):
            continue
        for match in re.finditer(r'"(?:url|canonical)"\s*:\s*"([^"]+)"', path.read_text(encoding="utf-8")):
            url = match.group(1)
            if url.startswith("http"):
                rel = url.replace(BASE, "").strip("/")
            else:
                rel = url.strip("/")
            if not rel or rel.startswith("#") or rel.startswith("mailto:"):
                continue
            if not is_valid(rel):
                errors.append((str(path.relative_to(ROOT)), url))

    if errors:
        print(f"Found {len(errors)} invalid internal URLs:")
        for file_path, url in errors[:50]:
            print(f"  {url}  ->  {file_path}")
        if len(errors) > 50:
            print(f"  ... and {len(errors) - 50} more")
        return 1

    print("OK — no invalid internal URLs detected in JSON imports.")
    return 0


if __name__ == "__main__":
    sys.exit(main())
