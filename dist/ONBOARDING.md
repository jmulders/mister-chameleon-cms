# Onboard an existing (external) Statamic site — checklist

Get Mister Chameleon personalisation live on a Statamic site that was **not**
built on the platform. Two editions are available; pick one:

- **Server-side (recommended):** `adaptive-slots-php/` — a Composer addon with a
  `{{ mc:slot }}` tag. Personalised HTML is server-rendered (no flash, best SEO,
  multiple slots per type). Requires installing a PHP addon.
- **Client-side:** `adaptive-slots/` — a fieldset + Antlers partial + a `<script>`
  snippet that swaps content in the browser. No PHP; SEO sees the fallback.

Total time: ~15 minutes.

---

## Part A — Platform (one-time, in the Mister Chameleon dashboard)

1. **Have a tenant for this site.** Create one if it doesn't exist. The tenant's
   CMS provider can stay "mock"/headless-off — you are only using the decision
   engine, not platform hosting.

2. **Generate the site key.** Open the tenant's **Snippet** page
   (`/admin/tenants/<tenant>/snippet`) → generate the site key and **enable** the
   integration. Copy the `sk_live_…` key.

3. **Configure the personalisation.** In the tenant's rules/variants, author the
   Hero / Proof / CTA (etc.) variants and the rules that pick them. This is what
   the decide endpoint returns.
   - No variants yet? That's fine — decide returns empty and the site shows the
     author's fallback copy. Personalisation switches on the moment you add
     variants.

4. **Check the subscription is active.** A `past_due` subscription makes decide
   return empty slots (fallbacks render), so billing must be current for
   personalisation to fire.

---

## Part B — The Statamic site

### B1 — Server-side edition

1. Copy `adaptive-slots-php/` into the project, e.g. `addons/adaptive-slots/`.
2. Register + install via Composer (in the site's `composer.json`):
   ```json
   "repositories": [{ "type": "path", "url": "./addons/adaptive-slots" }]
   ```
   then `composer require misterchameleon/adaptive-slots:*` (Statamic
   auto-discovers it).
3. `php artisan vendor:publish --tag=mister-chameleon-config`
4. In `.env`: `MC_SITE_KEY=sk_live_…` (optionally `MC_DECIDE_CACHE_TTL=30`).
5. Add slots to templates:
   ```antlers
   {{ mc:slot type="hero" }}
     <h1>{{ title ?? 'Default heading' }}</h1>
     <p>{{ subtitle ?? 'Default subtitle.' }}</p>
     <a href="{{ cta_href ?? '/signup' }}">{{ cta_label ?? 'Start' }}</a>
   {{ /mc:slot }}
   ```
   Or install the Context Slot page-builder block (README → "Native page-builder
   block") so authors edit slots in the CP.

### B2 — Client-side edition (alternative, no PHP)

1. Copy the fieldset + partials from `adaptive-slots/` (see its README).
2. Add the `mc_context_slot` block to your page-builder blueprint and render it
   with the partial.
3. Put `{{ partial:mc_snippet }}` in your `<head>` and set the site key there.

---

## Part C — Validate

Follow `adaptive-slots-php/TESTING.md`:

- **Fallback path** (unset the key): view page source → default copy is in the
  HTML, `personalised: false`, no errors.
- **Personalised path** (key set + variants configured): view source → the
  platform copy is already in the server HTML (server-side edition) or swaps in
  the browser (client-side), `personalised: true`.
- Change `?utm_source=` or the path and confirm the copy adapts to your rules.

---

## Notes

- **Returning-visitor signals** need the `mc_session_id` cookie. The client
  snippet sets/manages it; on a pure server-side install, also load the client
  snippet once (or set the cookie yourself) if you rely on returning-visitor
  rules.
- **Domain-agnostic:** the decide endpoint sends `CORS: *` and is keyed only by
  the site key, so it works from any domain.
- **Multiple sites:** to distribute the PHP addon beyond one project, publish it
  to Packagist or a private Composer repository instead of a path repo.

## Done-when

- [ ] Site key generated + snippet enabled for the tenant
- [ ] Variants/rules authored (or intentionally left as fallback-only)
- [ ] Subscription active
- [ ] Addon installed + site key set on the Statamic site
- [ ] At least one `{{ mc:slot }}` / Context Slot on a page
- [ ] Fallback + personalised paths both verified via TESTING.md
