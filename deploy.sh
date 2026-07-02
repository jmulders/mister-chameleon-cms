#!/usr/bin/env bash
# Ploi deploy script for a Mister Chameleon Statamic instance.
# Paste this into Ploi → Application → Deploy Script (or call it from there).
#
# Statamic Git push-back: when STATAMIC_GIT_SSH_KEY is set (the PRIVATE half of a
# write-enabled deploy key) this script installs it and switches the git remote
# to SSH, so the CP's content edits (Sites / nav / branding) push back to GitHub
# and survive the next redeploy. Without it, CP edits live only in the ephemeral
# container and revert on deploy.
set -euo pipefail

cd "${SITE_DIRECTORY:-.}"

# ── Write deploy key for Statamic Git push-back ──────────────────────────────
# STATAMIC_GIT_SSH_KEY = the PRIVATE half of a deploy key with WRITE access on
# this repo (add the PUBLIC half in GitHub → repo → Settings → Deploy keys, with
# "Allow write access" checked). We write it to ~/.ssh, trust github.com, and
# switch the remote to SSH so this pull AND Statamic's runtime pushes authenticate.
if [ -n "${STATAMIC_GIT_SSH_KEY:-}" ]; then
  mkdir -p ~/.ssh && chmod 700 ~/.ssh
  printf '%s\n' "$STATAMIC_GIT_SSH_KEY" > ~/.ssh/id_ed25519
  chmod 600 ~/.ssh/id_ed25519
  ssh-keyscan -t ed25519,rsa github.com >> ~/.ssh/known_hosts 2>/dev/null || true
  git remote set-url origin "${STATAMIC_GIT_REMOTE:-$(git remote get-url origin | sed -E 's#https://github.com/#git@github.com:#')}"
fi

# Discard any local rewrite of sites.yaml from a previous deploy so `git pull`
# never conflicts (the per-instance URL is re-applied below from the env var).
git checkout -- resources/sites.yaml 2>/dev/null || true

# Discard any local drift in fieldsets/blueprints so `git pull` can always bring
# in the committed versions. These are platform-owned code (never edited on the
# container), but an old `mc:sync` run may have left replicator-vs-grid drift in
# the working copy that otherwise blocks the pull — which manifests as a CP 500
# ("Undefined array key \"type\"") when a grid field is still defined as a
# replicator in the stale working copy.
git checkout -- resources/fieldsets resources/blueprints 2>/dev/null || true

git pull origin "${BRANCH:-main}"

# ── Per-instance public site URL ─────────────────────────────────────────────
# resources/sites.yaml is shared across all tenants (one repo) and hard-codes the
# nl site URL. Statamic v6 doesn't interpolate env in sites.yaml, so we rewrite it
# here from STATAMIC_SITE_URL — giving each instance its OWN public frontend URL
# (permalinks, "Visit URL", og:url) without a separate repo. Statamic Git only
# tracks content/, so this working-copy change is never pushed back.
#   steunles        → STATAMIC_SITE_URL=https://www.steunles.nl
#   misterchameleon → STATAMIC_SITE_URL=https://www.misterchameleon.nl  (or unset)
if [ -n "${STATAMIC_SITE_URL:-}" ]; then
  # Set the nl site's URL (the FIRST `url:` line) to STATAMIC_SITE_URL,
  # regardless of its current committed value. The previous version replaced a
  # hard-coded "https://www.misterchameleon.nl" literal, which silently did
  # NOTHING once the committed value had drifted (e.g. to steunles.nl) — leaving
  # the wrong public host, which the Live Preview then loaded → wrong tenant.
  sed -i "0,/^[[:space:]]*url:/ s#^\([[:space:]]*url:\).*#\1 '${STATAMIC_SITE_URL}'#" resources/sites.yaml
  echo "→ sites.yaml nl URL set to ${STATAMIC_SITE_URL}"
fi

composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# NOTE: `php please mc:sync` is intentionally NOT run here.
# The platform fieldsets + blueprints are committed in this repo
# (resources/fieldsets, resources/blueprints) and bake into the image, so the
# deploy does NOT depend on the platform (MISTER_CHAMELEON_API_URL) being
# reachable. Running mc:sync fetched the manifest from www.misterchameleon.nl on
# every deploy and — because of `set -euo pipefail` above — aborted the entire
# deploy whenever the platform was briefly unavailable (e.g. mid-redeploy),
# which is exactly the "Fetching build manifest …" hang.
# To refresh fieldsets, update them in the repo and redeploy.

php please cache:clear
# stache:refresh = clear + warm in one, so the content index is pre-built at
# deploy time instead of lazily on the first visitor request (which would give a
# slow / briefly empty first hit — the nav flap we want to avoid).
php please stache:refresh
php artisan optimize:clear

# Restart the queue/horizon if you run one:
# php artisan queue:restart

echo "✅ Deploy complete."
