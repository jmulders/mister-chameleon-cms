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

# Pull the platform-managed fieldsets/blocks (resolves the tenant by
# MISTER_CHAMELEON_TENANT_KEY against MISTER_CHAMELEON_API_URL).
php please mc:sync

php please cache:clear
php please stache:refresh

# Restart the queue/horizon if you run one:
# php artisan queue:restart

echo "✅ Deploy complete."
