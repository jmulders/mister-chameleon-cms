#!/usr/bin/env bash
# Ploi deploy script for a Mister Chameleon Statamic instance.
# Paste this into Ploi → Application → Deploy Script (or call it from there).
#
# Why mc:sync runs every deploy: the platform owns the content-block fieldsets;
# a stale/missing fieldset makes the CP strip `type` from replicator items on
# save, which corrupts content and breaks the site/nav. Regenerating them every
# deploy keeps them in sync.
set -euo pipefail

cd "${SITE_DIRECTORY:-.}"

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
