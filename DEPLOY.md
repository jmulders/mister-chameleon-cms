# Deploy (Ploi)

The canonical deploy script lives in [`deploy.sh`](deploy.sh) — paste it into
**Ploi → Application → Deploy Script** (or call it from there). Read that file's
comments for the details; this doc explains the model and the one-time setup.

## Content vs. platform-code split (why the CP can't clobber `main` anymore)

The CP is Ploi-hosted and has Statamic's git-automation enabled, so editors' saves
are versioned in git. Two things used to go wrong, both now fixed structurally:

1. **The CP committed platform-managed code.** `config/statamic/git.php` tracked
   `resources/fieldsets`, `resources/blueprints` and `resources/addons` alongside
   content. Every "Content saved" event committed + pushed the *drifted* working-copy
   fieldsets, so a stale fieldset got baked into the repo → the CP strips `type` from
   replicator items on the next save → corrupted content + a broken live preview
   (which then fell back to the homepage).
2. **The CP pushed to `main`.** A CP push could overwrite / force-remove a commit
   that had been merged to `main` via PR (this is what removed the `locatie-test`
   entry, `6599328`).

The fix:

| Concern | Fix | Where |
|---|---|---|
| CP must not version platform code | `paths` = **content + forms only** (no fieldsets/blueprints/addons) | `config/statamic/git.php` |
| CP must not write `main` | CP pushes to a **disposable `cms-content` branch**; built-in push hardcoded `false` | `config/statamic/git.php` |
| Deploy must serve CP content without merging into `main` | `reset --hard origin/main`, then **overlay** content paths from `cms-content` | `deploy.sh` |

`main` is now written **only by PRs** (platform code *and* any reviewed content).
The platform-managed `resources/fieldsets`, `resources/blueprints`, `resources/views`
stay authoritative from those PRs — regenerate them with `php please mc:sync` **on a
dev machine** and commit the result; they bake into the image.

> **`mc:sync` is intentionally NOT run on deploy.** It fetched the manifest from the
> platform on every deploy and, under `set -euo pipefail`, aborted the whole deploy
> whenever the platform was briefly unreachable (the "Fetching build manifest…" hang).
> Fieldsets are committed to the repo instead. To refresh them: run `mc:sync` locally,
> commit, open a PR, redeploy.

## One-time setup (Jasper)

Do this **once**, in order. Ploi keeps deploying `main` — no deploy-branch change.

1. **Create the `cms-content` branch** from the current `main` so the first CP push
   has a base and the deploy's overlay has something to read:
   ```bash
   git fetch origin
   git push origin origin/main:refs/heads/cms-content
   ```
2. **Ploi → Environment:** set
   ```
   STATAMIC_GIT_PUSH=false
   ```
   (and optionally `STATAMIC_GIT_CONTENT_BRANCH=cms-content` — that is the default).
   `STATAMIC_GIT_PUSH=true` from the old setup **must be turned off** — otherwise
   Statamic *also* pushes to `main` again. The deploy key already has write access
   (it pushed `main` before), so it can push `cms-content` with no key change.
3. **GitHub → repo → Settings → Branches:** protect `main` (require a PR, disallow
   force-push). This is the backstop that makes the split enforceable, not just
   convention.
4. **Deploy once** (Ploi → Deploy) to pick up the new `deploy.sh` + `git.php`.

## One-time reset (heals the current corruption / preview-fallback)

If the live CP currently shows corrupted blocks or the live preview shows the
homepage, run this **once on Ploi** (Application → Commands, in the app root) to
drop the drifted working copy and rebuild the index. After the one-time setup above,
the deploy does the first two steps every run, so this is only needed to heal state
that already drifted before the fix shipped:

```bash
git fetch origin
git reset --hard origin/main        # authoritative platform code + fieldsets
php please stache:refresh           # rebuild the content index (clear + warm)
php please cache:clear              # clear the app cache
php artisan optimize:clear
```

Then reload the CP and the Live Preview. The preview target must be `/mc-live-preview`
(refresh:true) — if it still loads the homepage, check the collection's
`preview_targets` URL in `resources/blueprints`/collection config does not point at `/`.
(The platform side of the preview — the draft provider in `app/(site)/mc-preview` —
was ruled out as the cause: it renders the draft blocks regardless of slug; the
fallback to the homepage only triggers when the CP's `mc-live-preview-data` endpoint
returns an empty slug, i.e. exactly the fieldset-drift symptom this fix removes.)

## Add-on install

`mister-chameleon/statamic` is pinned to `^1.1` in `composer.json` and resolved
through the VCS repository at the bottom of that file (`no-api: true`, so
Composer reads git refs directly rather than the GitHub API). Git tags are what
that constraint matches — `v1.1.0` today — so a rollout installs a **known
version**, not whatever `main` happened to be that morning.

**No credentials are needed.** `jmulders/mister-chameleon-statamic` is a public
repository, so Ploi's `composer install --no-dev` clones it anonymously over
HTTPS. Verified by resolving in a clean directory with `COMPOSER_AUTH={}` and no
`GITHUB_TOKEN`:

```
- Locking mister-chameleon/statamic (v1.1.0)
```

There is therefore no GitHub token to set in the Ploi environment, and no
Packagist entry to maintain.

Two things to keep in mind:

- **Releasing a new add-on version is a tag, not a push.** Merging to the
  add-on's `main` changes nothing here until `vX.Y.Z` is tagged and pushed. Then
  `composer update mister-chameleon/statamic` picks it up, within `^1.1`.
- **If the add-on repo is ever made private,** this breaks on the next deploy
  with a clone/authentication failure. The fix is a GitHub token with `repo`
  scope in the Ploi environment as `COMPOSER_AUTH`
  (`{"github-oauth":{"github.com":"<token>"}}`), not a change here.

## Required env (Ploi → Environment)

- `APP_URL`                      = this CMS host (e.g. https://…ams1-t.preview.ploi.it)
- `MISTER_CHAMELEON_API_URL`     = the platform (https://www.misterchameleon.nl)
- `MISTER_CHAMELEON_TENANT_KEY`  = the tenant's siteKey (Admin → Tenant → Snippet)
- `MC_PREVIEW_FRONTEND_URL`      = the platform (https://www.misterchameleon.nl)
- `STATAMIC_GIT_ENABLED=true`, `STATAMIC_GIT_PUSH=false` (see one-time setup)
- `STATAMIC_GIT_SSH_KEY`         = private half of the write-enabled deploy key
- `STATAMIC_SITE_URL`            = this instance's public frontend URL (rewrites sites.yaml)

If the host changes (Ploi infra migration), update `APP_URL` here AND
`STATAMIC_API_URL` on the platform (Vercel) + the tenant's `statamicBaseUrl`
in the DB, then redeploy the platform.
