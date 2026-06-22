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

git pull origin "${BRANCH:-main}"

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
