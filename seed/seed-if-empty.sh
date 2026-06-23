#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# Seed the neutral starter pages ONLY on a fresh instance.
#
# Safe to run on EVERY deploy: it is a no-op the moment any content exists, so it
# can never overwrite an existing tenant's pages. New tenants get the neutral
# placeholder seed; existing tenants are left completely untouched.
#
# Wire this into the Ploi "Init container commands" (instead of a raw
# `cp -R seed/content/. content/`):
#
#     bash seed/seed-if-empty.sh
# ─────────────────────────────────────────────────────────────────────────────
set -uo pipefail

# Presence of the home page is our "already seeded / live content" marker.
MARKER="content/collections/pages/nl/home.md"

if [ -e "$MARKER" ]; then
  echo "→ content/ already present — seed skipped (existing tenant untouched)."
else
  echo "→ fresh instance detected — seeding neutral starter pages."
  mkdir -p content
  cp -R seed/content/. content/
  echo "→ seeded: home.md, showcase.md, contact.md"
fi

# Placeholder images are additive + idempotent (they never overwrite), so they
# run regardless — keeping media blocks populated on fresh AND existing instances
# without touching any text content.
bash seed/download-placeholders.sh || true

echo "✅ Seed check complete."
