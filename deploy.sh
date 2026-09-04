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

# ── Content / platform-code split ────────────────────────────────────────────
# `main` = authoritative platform code + reviewed content (PRs only). The CP's
# "Content saved" pushes go to a DISPOSABLE `cms-content` branch (see
# config/statamic/git.php), NEVER to `main`. So the deploy:
#   1. hard-resets the working tree to the clean `main` tip — this both drops the
#      CP's local content commit (it lives safely on cms-content) AND discards any
#      drift in sites.yaml / fieldsets / blueprints, so no `git pull` merge/conflict
#      can ever block a deploy or resurrect a stale replicator-vs-grid fieldset
#      (the CP 500 "Undefined array key \"type\"");
#   2. overlays the CP's latest content snapshot from cms-content on top.
BRANCH="${BRANCH:-main}"
CONTENT_BRANCH="${STATAMIC_GIT_CONTENT_BRANCH:-cms-content}"

git fetch origin --prune
git reset --hard "origin/${BRANCH}"

# Overlay CP-authored content (content + forms + assets + users) from the
# cms-content branch WITHOUT switching branches and WITHOUT touching the
# platform-managed fieldsets/blueprints/addons. `git checkout <ref> -- <paths>`
# only updates/adds the listed paths; it never deletes files that exist in the
# working tree but not in that snapshot, so a content entry merged to `main` via
# PR is preserved even if an older CP snapshot didn't have it.
#
# Done per-path on purpose: a single multi-path checkout aborts entirely if ANY
# path is absent from the snapshot (e.g. storage/forms or public/assets before the
# first submission/upload), which would silently apply NO content. Each path is
# independent and no-ops if missing (or before cms-content exists at all).
# NOTE: this list must mirror the tracked `paths` in config/statamic/git.php
# (content-only) — anything the CP commits but the deploy doesn't overlay is lost.
if git rev-parse --verify -q "origin/${CONTENT_BRANCH}" >/dev/null; then
  for p in content users resources/forms resources/users resources/preferences.yaml storage/forms public/assets; do
    git checkout "origin/${CONTENT_BRANCH}" -- "$p" 2>/dev/null \
      && echo "→ overlaid ${p} from ${CONTENT_BRANCH}" || true
  done
else
  echo "→ no ${CONTENT_BRANCH} branch yet (using main's content)"
fi

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
