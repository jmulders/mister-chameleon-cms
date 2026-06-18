# Deploy (Ploi)

Set the Ploi deploy script to (after `git pull` + `composer install`):

```bash
# Regenerate the platform-managed Statamic fieldsets every deploy.
# Without this, a stale/missing fieldset makes the CP strip `type` from
# replicator items on save → corrupts content + breaks the site/nav.
php please mc:sync

php please cache:clear
php please stache:refresh
```

## Required env (Ploi → Environment)

- `APP_URL`                      = this CMS host (e.g. https://…ams1-t.preview.ploi.it)
- `MISTER_CHAMELEON_API_URL`     = the platform (https://www.misterchameleon.nl)
- `MISTER_CHAMELEON_TENANT_KEY`  = the tenant's siteKey (Admin → Tenant → Snippet)
- `MC_PREVIEW_FRONTEND_URL`      = the platform (https://www.misterchameleon.nl)

If the host changes (Ploi infra migration), update `APP_URL` here AND
`STATAMIC_API_URL` on the platform (Vercel) + the tenant's `statamicBaseUrl`
in the DB, then redeploy the platform.
