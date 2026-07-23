#!/usr/bin/env python3
"""Set service pages parent + update internal service URLs across content-import.

Idempotent: never produces /services/services/ paths.
"""
from __future__ import annotations

import json
import re
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


def ensure_services_prefix(path: str) -> str:
    """Turn /slug/ into /services/slug/ without double-prefixing."""
    return re.sub(
        r"(?<!/services)/(?:" + "|".join(re.escape(s) for s in SERVICE_SLUGS) + r")/",
        lambda m: "/services/" + m.group(0).lstrip("/"),
        path,
    )


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

    # Fix any already-broken doubles first.
    text = text.replace("/services/services/", "/services/")

    for slug in SERVICE_SLUGS:
        # Absolute prod URLs at root → under /services/
        text = re.sub(
            rf"{re.escape(BASE)}/(?!services/){re.escape(slug)}/",
            f"{BASE}/services/{slug}/",
            text,
        )
        # Relative root paths → under /services/ (not already prefixed)
        text = re.sub(
            rf"(?<!/services)/{re.escape(slug)}/",
            f"/services/{slug}/",
            text,
        )

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
        if "vendor" in path.parts or "node_modules" in path.parts:
            continue
        if replace_urls_in_file(path):
            updated_files += 1
            print(f"Updated links: {path.relative_to(ROOT)}")

    print(f"Done. {updated_files} files with updated links.")


if __name__ == "__main__":
    main()
