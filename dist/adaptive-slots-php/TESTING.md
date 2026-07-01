# Adaptive Slots — end-to-end validation

A 5-minute smoke test to confirm the add-on works on a Statamic site, covering
both the **fallback** path (platform absent) and the **personalised** path.

## 0. Prerequisites

- Add-on installed and `php artisan vendor:publish --tag=mister-chameleon-config` run.
- A test page/template you can edit.

## 1. Prove the raw decision (independent of Statamic)

Confirm the platform returns slots for your site key. From any machine:

```bash
curl -s -X POST https://app.misterchameleon.com/api/snippet/decide \
  -H 'Content-Type: application/json' \
  -d '{"siteKey":"sk_live_YOUR_KEY","context":{"path":"/","utm_source":"google","locale":"nl"}}'
```

Expected (example):

```json
{ "slots": {
  "hero-title": "Slimmer converteren met Google Ads",
  "hero-subtitle": "Een boodschap afgestemd op je campagne.",
  "hero-cta-label": "Plan een demo",
  "hero-cta-href": "/demo"
} }
```

If you get `{"slots":{}}` or a 403, the site key isn't provisioned/enabled yet —
fix that first (dashboard → Setup → Snippet). An empty map is the **fallback**
case and is expected to render your defaults (step 3).

## 2. Add a slot to a template

```antlers
{{ mc:slot type="hero" }}
  <section class="hero">
    <p class="eyebrow">{{ tag ?? 'Adaptieve websites' }}</p>
    <h1 data-test="hero-title">{{ title ?? 'Standaard kop' }}</h1>
    <p data-test="hero-sub">{{ subtitle ?? 'Standaard subtekst.' }}</p>
    <a data-test="hero-cta" href="{{ cta_href ?? '/signup' }}">{{ cta_label ?? 'Start gratis' }}</a>
    <!-- personalised flag for debugging: {{ personalised }} -->
  </section>
{{ /mc:slot }}
```

## 3. Test the FALLBACK path (no personalisation)

Temporarily unset the key so the tag fails open:

```
MC_SITE_KEY=
```

Load the page and **view source** (not devtools — raw HTML, to prove SSR):

- `data-test="hero-title"` shows **"Standaard kop"**
- the comment shows `personalised: false`
- Page renders normally, no errors, no delay.

This is what bots and no-JS visitors see. ✅ SEO-safe.

## 4. Test the PERSONALISED path

Restore the key:

```
MC_SITE_KEY=sk_live_YOUR_KEY
```

Reload and **view source** again. With the example decision from step 1:

- `data-test="hero-title"` shows **"Slimmer converteren met Google Ads"** —
  already in the server HTML, no flash, no JS swap.
- the comment shows `personalised: true`
- Change the request context and watch it adapt, e.g. append `?utm_source=linkedin`
  or hit a different `path` — the returned copy should differ per your rules.

## 5. (Optional) Page-builder block

If you installed the Context Slot block (see README → "Native page-builder
block"): add one to a page, set slot type = Hero and author fallback copy, then
repeat steps 3–4. The authored copy is the fallback; the platform value wins when
present. You can place several slots of different types on one page.

## 6. (Optional) Caching

Set `MC_DECIDE_CACHE_TTL=30` and reload the same page twice within 30s: the
second load should not produce a second outbound call to `/api/snippet/decide`
(check your platform/decide logs or a local HTTP debugger). Different visitors
(different `mc_session_id`) still get distinct results — the session id is part
of the cache key.

## Pass criteria

| Check | Fallback (no key) | Personalised (key set) |
|---|---|---|
| Slot content in raw HTML source | default copy | platform copy |
| `{{ personalised }}` | `false` | `true` |
| Page errors / blank slots | none | none |
| Visible flash / layout shift | none | none |
