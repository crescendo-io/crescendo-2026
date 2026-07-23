#!/usr/bin/env python3
"""Set service pages parent + update internal service URLs across content-import."""
from __future__ import annotations

import json
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
SERVICES_DIR = ROOT / "content-import" / "services"
BASE = "https://crescendo-studio.io"

SERVICE_SLUGS = [
    "agence-web-nantes",
    "creation-site-web-nantes",
    "creation-site-vitrine-nantes",
    "creation-site-ecommerce-nantes",
    "creation-site-wordpress",
    "refonte-site-wordpress",
    "location-site-internet",
    "crm-sur-mesure-nantes",
    "agence-seo-nantes",
    "maintenance-wordpress",
]

SERVICE_FILES = [
    "agence-web-nantes.json",
    "creation-site-web-nantes.json",
    "creation-site-vitrine-nantes.json",
    "creation-site-ecommerce-nantes.json",
    "creation-site-wordpress.json",
    "refonte-site-wordpress.json",
    "location-site-internet.json",
    "crm-sur-mesure-nantes.json",
    "SEO.json",
    "maintenance.json",
]

URL_REPLACEMENTS = [
    (f"{BASE}/agence-web-nantes/", f"{BASE}/services/agence-web-nantes/"),
    (f"{BASE}/creation-site-web-nantes/", f"{BASE}/services/creation-site-web-nantes/"),
    (f"{BASE}/creation-site-vitrine-nantes/", f"{BASE}/services/creation-site-vitrine-nantes/"),
    (f"{BASE}/creation-site-ecommerce-nantes/", f"{BASE}/services/creation-site-ecommerce-nantes/"),
    (f"{BASE}/creation-site-wordpress/", f"{BASE}/services/creation-site-wordpress/"),
    (f"{BASE}/refonte-site-wordpress/", f"{BASE}/services/refonte-site-wordpress/"),
    (f"{BASE}/location-site-internet/", f"{BASE}/services/location-site-internet/"),
    (f"{BASE}/crm-sur-mesure-nantes/", f"{BASE}/services/crm-sur-mesure-nantes/"),
    (f"{BASE}/agence-seo-nantes/", f"{BASE}/services/agence-seo-nantes/"),
    (f"{BASE}/maintenance-wordpress/", f"{BASE}/services/maintenance-wordpress/"),
    ("/agence-web-nantes/", "/services/agence-web-nantes/"),
    ("/creation-site-web-nantes/", "/services/creation-site-web-nantes/"),
    ("/creation-site-vitrine-nantes/", "/services/creation-site-vitrine-nantes/"),
    ("/creation-site-ecommerce-nantes/", "/services/creation-site-ecommerce-nantes/"),
    ("/creation-site-wordpress/", "/services/creation-site-wordpress/"),
    ("/refonte-site-wordpress/", "/services/refonte-site-wordpress/"),
    ("/location-site-internet/", "/services/location-site-internet/"),
    ("/crm-sur-mesure-nantes/", "/services/crm-sur-mesure-nantes/"),
    ("/agence-seo-nantes/", "/services/agence-seo-nantes/"),
    ("/maintenance-wordpress/", "/services/maintenance-wordpress/"),
]


def update_service_json(path: Path) -> None:
    data = json.loads(path.read_text(encoding="utf-8"))
    slug = data["page"]["slug"]

    data["page"]["parent"] = "services"
    if "seo" in data and "canonical" in data["seo"]:
        data["seo"]["canonical"] = f"{BASE}/services/{slug}/"

    path.write_text(json.dumps(data, ensure_ascii=False, indent=2) + "\n", encoding="utf-8")
    print(f"Updated service JSON: {path.name}")


def replace_urls_in_file(path: Path) -> bool:
    text = path.read_text(encoding="utf-8")
    original = text

    for old, new in URL_REPLACEMENTS:
        text = text.replace(old, new)

    if text != original:
        path.write_text(text, encoding="utf-8")
        return True

    return False


def main() -> None:
    for filename in SERVICE_FILES:
        path = SERVICES_DIR / filename
        if path.exists():
            update_service_json(path)

    updated_files = 0
    for path in ROOT.rglob("*"):
        if not path.is_file():
            continue
        if path.suffix not in {".json", ".py", ".php"}:
            continue
        if path.name == "migrate-service-urls.py":
            continue
        if replace_urls_in_file(path):
            updated_files += 1
            print(f"Updated links: {path.relative_to(ROOT)}")

    print(f"Done. {updated_files} files with updated links.")


if __name__ == "__main__":
    main()
