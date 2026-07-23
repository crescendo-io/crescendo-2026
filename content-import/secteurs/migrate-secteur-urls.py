#!/usr/bin/env python3
"""Set secteur pages parent + update internal secteur URLs across content-import."""
from __future__ import annotations

import json
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SECTEURS_DIR = ROOT / "content-import" / "secteurs"
BASE = "https://crescendo-studio.io"

SECTOR_SLUGS = [
    "creation-site-artisan-nantes",
    "creation-site-coiffeur-nantes",
    "creation-site-avocat-nantes",
    "creation-site-immobilier-nantes",
    "creation-site-restaurant-nantes",
    "creation-site-startup-nantes",
    "creation-site-b2b-nantes",
    "creation-site-coach-nantes",
    "creation-site-architecte-nantes",
    "creation-site-therapeute-nantes",
    "creation-site-association-nantes",
    "creation-site-btp-nantes",
    "creation-site-paysagiste-nantes",
    "creation-site-electricien-nantes",
    "creation-site-plombier-nantes",
    "creation-site-industrie-nantes",
    "creation-site-cabinet-rh-nantes",
]


def normalize_secteur_urls(text: str) -> str:
    text = text.replace("/secteurs/", "/secteurs/")
    text = text.replace(f"{BASE}/secteurs/", f"{BASE}/secteurs/")

    for slug in SECTOR_SLUGS:
        text = text.replace(f"{BASE}/{slug}/", f"{BASE}/secteurs/{slug}/")
        text = re.sub(rf"(?<!/secteurs/)/{re.escape(slug)}/", f"/secteurs/{slug}/", text)

    return text


def update_secteur_json(path: Path) -> None:
    if path.name in {"_schema.json", "secteurs.json"}:
        return

    data = json.loads(path.read_text(encoding="utf-8"))
    if "page" not in data or "slug" not in data["page"]:
        return

    slug = data["page"]["slug"]
    data["page"]["parent"] = "secteurs"
    if "seo" in data and "canonical" in data["seo"]:
        data["seo"]["canonical"] = f"{BASE}/secteurs/{slug}/"

    path.write_text(json.dumps(data, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
    print(f"Updated secteur JSON: {path.name}")


def replace_urls_in_file(path: Path) -> bool:
    text = path.read_text(encoding="utf-8")
    updated = normalize_secteur_urls(text)

    if updated != text:
        path.write_text(updated, encoding="utf-8")
        return True

    return False


def main() -> None:
    for path in SECTEURS_DIR.glob("*.json"):
        update_secteur_json(path)

    updated_files = 0
    for path in ROOT.rglob("*"):
        if not path.is_file():
            continue
        if path.suffix not in {".json", ".py", ".php"}:
            continue
        if path.name in {"migrate-secteur-urls.py", "migrate-service-urls.py"}:
            continue
        if replace_urls_in_file(path):
            updated_files += 1
            print(f"Updated links: {path.relative_to(ROOT)}")

    print(f"Done. {updated_files} files with updated links.")


if __name__ == "__main__":
    main()
