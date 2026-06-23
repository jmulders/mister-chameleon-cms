#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# Download neutral placeholder images into the Statamic asset container, so a
# freshly-seeded tenant shows POPULATED media blocks (showcase + any media block)
# instead of empty image slots.
#
# Source of images:
#   • UNSPLASH_ACCESS_KEY set → Unsplash API (a fresh random image per category).
#   • otherwise               → Lorem Picsum (Unsplash-sourced, NO key required).
#
# The filenames here MATCH the asset references in seed/content (home.md,
# showcase.md). Run at provisioning / deploy — e.g. add to the Ploi
# "Init container commands":
#
#     bash seed/download-placeholders.sh
#
# Idempotent (skips files that already exist) and NON-FATAL (a failed download
# never breaks the deploy — the block just renders without that image).
# ─────────────────────────────────────────────────────────────────────────────
set -uo pipefail

ASSETS_DIR="${1:-public/assets}"
mkdir -p "$ASSETS_DIR"
KEY="${UNSPLASH_ACCESS_KEY:-}"

# filename | unsplash-query | width | height
ITEMS=(
  "placeholder-wide-1.jpg|abstract|1200|675"
  "placeholder-wide-2.jpg|texture|1200|675"
  "placeholder-avatar-1.jpg|portrait|400|400"
  "placeholder-avatar-2.jpg|portrait|400|400"
  "placeholder-avatar-3.jpg|portrait|400|400"
  "placeholder-logo-1.jpg|minimal|300|300"
  "placeholder-logo-2.jpg|pattern|300|300"
  "placeholder-logo-3.jpg|geometric|300|300"
  "placeholder-logo-4.jpg|monochrome|300|300"
)

# Query the Unsplash API for one random image URL (echoes the URL or fails).
fetch_unsplash_url() {
  local q="$1" w="$2" h="$3" json url
  json="$(curl -fsSL --max-time 10 \
    "https://api.unsplash.com/photos/random?query=${q}&orientation=squarish&client_id=${KEY}" 2>/dev/null)" || return 1
  url="$(printf '%s' "$json" \
    | grep -oE '"regular":"[^"]+"' | head -1 \
    | sed -e 's/"regular":"//' -e 's/"$//' -e 's/\\u0026/\&/g')"
  [ -n "$url" ] || return 1
  printf '%s&w=%s&h=%s&fit=crop' "$url" "$w" "$h"
}

for item in "${ITEMS[@]}"; do
  IFS='|' read -r file q w h <<< "$item"
  dest="$ASSETS_DIR/$file"
  if [ -f "$dest" ]; then echo "→ $file (bestaat al)"; continue; fi

  url=""
  if [ -n "$KEY" ]; then url="$(fetch_unsplash_url "$q" "$w" "$h" || true)"; fi
  if [ -z "$url" ]; then url="https://picsum.photos/seed/${file%.jpg}/${w}/${h}.jpg"; fi

  if curl -fsSL --max-time 20 -o "$dest" "$url"; then
    echo "→ $file"
  else
    echo "⚠ overslaan (download mislukt): $file"
    rm -f "$dest"
  fi
done

echo "✅ Placeholder-afbeeldingen klaar in $ASSETS_DIR"
exit 0
